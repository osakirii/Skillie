<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CarreirasController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/index', function () {
    return view('index');
})->name('home');

// Public JSON endpoint for carreiras (used by client-side search)
Route::get('/carreiras/json', function () {
    return App\Models\Carreiras::select('id', 'nome')->orderBy('nome')->get();
})->name('carreiras.json');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('perfil', '/perfil');

    Route::get('perfil', function () {
        return view('perfil');
    })->name('perfil');
    
    // perfil update (update user's name/email/password)
    Route::put('perfil', function (\Illuminate\Http\Request $request) {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'current_password' => 'required|string',
        ]);

        if (! \Illuminate\Support\Facades\Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Senha incorreta.'])->withInput();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
        }

        $user->save();

        return redirect()->back()->with('status', 'Perfil atualizado com sucesso.');
    })->name('perfil.update');

    // Account deletion (requires current password confirmation)
    Route::delete('perfil', function (\Illuminate\Http\Request $request) {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
        ]);

        if (! \Illuminate\Support\Facades\Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Senha incorreta.'])->withInput();
        }

        // Log out and delete account
        \Illuminate\Support\Facades\Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('perfil.destroy');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';

// Admin area - requires authenticated admin user
Route::middleware(['auth', \App\Http\Middleware\EnsureIsAdmin::class])->group(function () {
    // Admin entry - redirect to profile (no dedicated admin index page)
    Route::get('/admin', function () {
        return redirect()->route('perfil');
    })->name('admin.index');

    // Admin pages per-resource
    Route::get('/admin/cartas', function () {
        $cartas = App\Models\Cartas::orderBy('id', 'desc')->get();
        return view('admin.cartas', compact('cartas'));
    })->name('admin.cartas.index');

    Route::get('/admin/carreiras', function () {
        $carreiras = App\Models\Carreiras::with('situacoes')->orderBy('id', 'desc')->get();
        $cartas = App\Models\Cartas::orderBy('id', 'desc')->get();
        return view('admin.carreiras', compact('carreiras','cartas'));
    })->name('admin.carreiras.index');

    Route::post('/admin/cartas', function (Illuminate\Http\Request $request) {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'efeitos' => 'nullable|array',
        ]);

        App\Models\Cartas::create([
            'nome' => $data['nome'],
            'desc' => $data['desc'] ?? null,
            'imagem' => $data['imagem'] ?? null,
            'efeitos' => $data['efeitos'] ?? ['estresse' => 0, 'dinheiro' => 0, 'reputacao' => 0],
        ]);

        return redirect()->route('admin.cartas.index');
    })->name('admin.cartas.store');

    Route::delete('/admin/cartas/{carta}', function (App\Models\Cartas $carta) {
        $carta->delete();
        return redirect()->route('admin.cartas.index');
    })->name('admin.cartas.destroy');

    // Carreiras admin
    Route::post('/admin/carreiras', [CarreirasController::class, 'store'])->name('admin.carreiras.store');

    Route::delete('/admin/carreiras/{carreira}', function (App\Models\Carreiras $carreira) {
        $carreira->delete();
        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.destroy');

    // Situacoes admin: creation is handled during Carreiras creation.
    // Keep a nested destroy route so situacoes can be removed per-carreira.
    Route::delete('/admin/carreiras/{carreira}/situacoes/{situacao}', function (App\Models\Carreiras $carreira, App\Models\Situacoes $situacao) {
        // ensure situacao belongs to carreira for safety
        if ($situacao->carreira_id !== $carreira->id) {
            abort(404);
        }

        $situacao->delete();
        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.situacoes.destroy');
});

// Simple session login/register handlers for the custom front-end pages
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
})->name('login');

Route::get('/login', function () {
    return view('login');
})->name('login.form');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed|min:6',
    ]);

    $user = App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->intended(route('home'));
})->name('register');

Route::get('/register', function () {
    return view('register');
})->name('register.form');