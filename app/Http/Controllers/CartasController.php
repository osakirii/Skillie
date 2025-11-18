<?php

namespace App\Http\Controllers;

use App\Models\Cartas;
use Illuminate\Http\Request;

class CartasController extends Controller
{
    public function index()
    {
        return response()->json(Cartas::all());
    }

    public function show(Cartas $carta)
    {
        return response()->json($carta);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'efeitos' => 'required|array',
            'efeitos.estresse' => 'nullable|integer',
            'efeitos.dinheiro' => 'nullable|integer',
            'efeitos.reputacao' => 'nullable|integer',
        ]);

        $carta = Cartas::create($data);

        return response()->json($carta, 201);
    }

    public function update(Request $request, Cartas $carta)
    {
        $data = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'imagem' => 'nullable|string|max:255',
            'efeitos' => 'sometimes|array',
            'efeitos.estresse' => 'nullable|integer',
            'efeitos.dinheiro' => 'nullable|integer',
            'efeitos.reputacao' => 'nullable|integer',
        ]);

        if (isset($data['efeitos'])) {
            $data['efeitos'] = array_merge($carta->efeitos ?? [], $data['efeitos']);
        }

        $carta->update($data);

        return response()->json($carta);
    }

    public function destroy(Cartas $carta)
    {
        $carta->delete();
        return response()->json(null, 204);
    }
}
