<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cartas;
use Illuminate\Http\Request;

class CartasAdminController extends Controller
{
    public function index()
    {
        $cartas = Cartas::orderBy('id', 'desc')->get();
        return view('admin.index', compact('cartas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'efeitos.estresse' => 'nullable|integer',
            'efeitos.dinheiro' => 'nullable|integer',
            'efeitos.reputacao' => 'nullable|integer',
        ]);

        $efeitos = [
            'estresse' => $data['efeitos']['estresse'] ?? 0,
            'dinheiro' => $data['efeitos']['dinheiro'] ?? 0,
            'reputacao' => $data['efeitos']['reputacao'] ?? 0,
        ];

        $carta = Cartas::create([
            'nome' => $data['nome'],
            'desc' => $data['desc'] ?? null,
            'imagem' => $data['imagem'] ?? null,
            'efeitos' => $efeitos,
        ]);

        return redirect()->route('admin.index');
    }

    public function destroy(Cartas $carta)
    {
        $carta->delete();
        return redirect()->route('admin.index');
    }
}
