<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/index', function () {
    return view('index');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';

// Admin area - requires authenticated admin user
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Simple admin page — closures keep this minimal for testing
    Route::get('/admin', function () {
        $cartas = App\Models\Cartas::orderBy('id', 'desc')->get();
        return view('admin.index', compact('cartas'));
    })->name('admin.index');

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

        return redirect()->route('admin.index');
    })->name('admin.cartas.store');

    Route::delete('/admin/cartas/{carta}', function (App\Models\Cartas $carta) {
        $carta->delete();
        return redirect()->route('admin.index');
    })->name('admin.cartas.destroy');
});
