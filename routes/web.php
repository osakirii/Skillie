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

// Play a carreira (game view) - plural path
Route::get('/carreiras/{param}', function ($param) {
    // resolve carreira by id or slug-like param
    $carreira = null;
    if (ctype_digit((string)$param)) {
        $carreira = App\Models\Carreiras::with(['situacoes' => function($q){ $q->orderBy('id'); }, 'situacoes.decisao1', 'situacoes.decisao2'])->find($param);
    }

    if (! $carreira) {
        $name = str_replace('-', ' ', (string) $param);
        $carreira = App\Models\Carreiras::with(['situacoes' => function($q){ $q->orderBy('id'); }, 'situacoes.decisao1', 'situacoes.decisao2'])
            ->whereRaw('LOWER(nome) = ?', [mb_strtolower($name)])->first();
    }

    if (! $carreira) abort(404);
    $cartas = App\Models\Cartas::orderBy('id')->get();
    return view('play', compact('carreira','cartas'));
})->name('carreiras.play');

// Play a carreira (game view) - singular path used in links
Route::get('/carreira/{param}', function ($param) {
    $carreira = null;
    if (ctype_digit((string)$param)) {
        $carreira = App\Models\Carreiras::with(['situacoes' => function($q){ $q->orderBy('id'); }, 'situacoes.decisao1', 'situacoes.decisao2'])->find($param);
    }
    if (! $carreira) {
        $name = str_replace('-', ' ', (string) $param);
        $carreira = App\Models\Carreiras::with(['situacoes' => function($q){ $q->orderBy('id'); }, 'situacoes.decisao1', 'situacoes.decisao2'])
            ->whereRaw('LOWER(nome) = ?', [mb_strtolower($name)])->first();
    }
    if (! $carreira) abort(404);
    $cartas = App\Models\Cartas::orderBy('id')->get();
    return view('play', compact('carreira','cartas'));
});

// Save historico (requires auth) - plural path
Route::post('/carreiras/{param}', function (Illuminate\Http\Request $request, $param) {
    // resolve carreira by id or slug-like param
    $carreira = null;
    if (ctype_digit((string)$param)) {
        $carreira = App\Models\Carreiras::find($param);
    }
    if (! $carreira) {
        $name = str_replace('-', ' ', (string) $param);
        $carreira = App\Models\Carreiras::whereRaw('LOWER(nome) = ?', [mb_strtolower($name)])->first();
    }
    if (! $carreira) abort(404);

    $request->validate([
        'resultado' => 'required|string|max:255',
        'atributos_finais' => 'required|array',
    ]);

    $hist = App\Models\Historico::create([
        'resultado' => $request->input('resultado'),
        'data_jogo' => now(),
        'atributos_finais' => json_encode($request->input('atributos_finais')),
        'carreira_id' => $carreira->id,
        'user_id' => $request->user()?->id,
    ]);

    return response()->json(['ok' => true, 'id' => $hist->id]);
})->middleware('auth')->name('carreiras.play.save');

// Save historico (requires auth) - singular path
Route::post('/carreira/{param}', function (Illuminate\Http\Request $request, $param) {
    // resolve carreira by id or slug-like param
    $carreira = null;
    if (ctype_digit((string)$param)) {
        $carreira = App\Models\Carreiras::find($param);
    }
    if (! $carreira) {
        $name = str_replace('-', ' ', (string) $param);
        $carreira = App\Models\Carreiras::whereRaw('LOWER(nome) = ?', [mb_strtolower($name)])->first();
    }
    if (! $carreira) abort(404);

    $request->validate([
        'resultado' => 'required|string|max:255',
        'atributos_finais' => 'required|array',
    ]);

    $hist = App\Models\Historico::create([
        'resultado' => $request->input('resultado'),
        'data_jogo' => now(),
        'atributos_finais' => json_encode($request->input('atributos_finais')),
        'carreira_id' => $carreira->id,
        'user_id' => $request->user()?->id,
    ]);

    return response()->json(['ok' => true, 'id' => $hist->id]);
})->middleware('auth');

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

    // Delete a historico entry belonging to the authenticated user
    Route::delete('perfil/historico/{historico}', function (App\Models\Historico $historico, \Illuminate\Http\Request $request) {
        $user = $request->user();
        if (! $user || $historico->user_id !== $user->id) {
            abort(403);
        }

        $historico->delete();
        return redirect()->route('perfil')->with('status', 'Histórico removido com sucesso.');
    })->name('perfil.historico.destroy');
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

    // Update carta
    Route::put('/admin/cartas/{carta}', function (Illuminate\Http\Request $request, App\Models\Cartas $carta) {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'efeitos.estresse' => 'nullable|integer|min:-10|max:10',
            'efeitos.dinheiro' => 'nullable|integer|min:-10|max:10',
            'efeitos.reputacao' => 'nullable|integer|min:-10|max:10',
        ]);

        $carta->nome = $data['nome'];
        $carta->desc = $data['desc'] ?? null;
        $carta->imagem = $data['imagem'] ?? null;
        $carta->efeitos = [
            'estresse' => (int) ($data['efeitos']['estresse'] ?? 0),
            'dinheiro' => (int) ($data['efeitos']['dinheiro'] ?? 0),
            'reputacao' => (int) ($data['efeitos']['reputacao'] ?? 0),
        ];

        $carta->save();

        return redirect()->route('admin.cartas.index');
    })->name('admin.cartas.update');

    // Carreiras admin
    Route::post('/admin/carreiras', [CarreirasController::class, 'store'])->name('admin.carreiras.store');

    Route::delete('/admin/carreiras/{carreira}', function (App\Models\Carreiras $carreira) {
        $carreira->delete();
        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.destroy');

    // Update carreira
    Route::put('/admin/carreiras/{carreira}', function (Illuminate\Http\Request $request, App\Models\Carreiras $carreira) {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'categoria' => 'required|string|max:100',
            'estresse_inicial' => 'nullable|integer|min:-10|max:10',
            'dinheiro_inicial' => 'nullable|integer|min:-10|max:10',
            'reputacao_inicial' => 'nullable|integer|min:-10|max:10',
        ]);

        $carreira->nome = $data['nome'];
        $carreira->desc = $data['desc'] ?? null;
        $carreira->imagem = $data['imagem'] ?? null;
        $carreira->categoria = $data['categoria'];

        // update atributosIniciais JSON field using the numeric inputs
        $atributos = $carreira->atributosIniciais ?? ['estresse' => 0, 'dinheiro' => 0, 'reputacao' => 0];
        $atributos['estresse'] = (int) ($data['estresse_inicial'] ?? $atributos['estresse']);
        $atributos['dinheiro'] = (int) ($data['dinheiro_inicial'] ?? $atributos['dinheiro']);
        $atributos['reputacao'] = (int) ($data['reputacao_inicial'] ?? $atributos['reputacao']);
        $carreira->atributosIniciais = $atributos;

        $carreira->save();

        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.update');

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

    // Update situacao (nested under carreira)
    Route::put('/admin/carreiras/{carreira}/situacoes/{situacao}', function (Illuminate\Http\Request $request, App\Models\Carreiras $carreira, App\Models\Situacoes $situacao) {
        // ensure situacao belongs to carreira
        if ($situacao->carreira_id !== $carreira->id) {
            abort(404);
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'decisao1_id' => 'nullable|exists:cartas,id',
            'decisao2_id' => 'nullable|exists:cartas,id',
        ]);

        // server-side check: decisao1 and decisao2 must be different when both provided
        if (!empty($data['decisao1_id']) && !empty($data['decisao2_id']) && $data['decisao1_id'] == $data['decisao2_id']) {
            return redirect()->back()->withInput()->withErrors(['decisao2_id' => 'Decisão 1 e Decisão 2 devem ser cartas diferentes.']);
        }

        $situacao->nome = $data['nome'];
        $situacao->desc = $data['desc'] ?? null;
        $situacao->decisao1_id = $data['decisao1_id'] ?? null;
        $situacao->decisao2_id = $data['decisao2_id'] ?? null;
        $situacao->save();

        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.situacoes.update');

    // Create situacao for an existing carreira (used from carreira edit modal)
    Route::post('/admin/carreiras/{carreira}/situacoes', function (Illuminate\Http\Request $request, App\Models\Carreiras $carreira) {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'decisao1_id' => 'nullable|exists:cartas,id',
            'decisao2_id' => 'nullable|exists:cartas,id',
        ]);

        if (!empty($data['decisao1_id']) && !empty($data['decisao2_id']) && $data['decisao1_id'] == $data['decisao2_id']) {
            return redirect()->back()->withInput()->withErrors(['decisao2_id' => 'Decisão 1 e Decisão 2 devem ser cartas diferentes.']);
        }

        App\Models\Situacoes::create([
            'nome' => $data['nome'],
            'desc' => $data['desc'] ?? null,
            'carreira_id' => $carreira->id,
            'decisao1_id' => $data['decisao1_id'] ?? null,
            'decisao2_id' => $data['decisao2_id'] ?? null,
        ]);

        return redirect()->route('admin.carreiras.index');
    })->name('admin.carreiras.situacoes.store');
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