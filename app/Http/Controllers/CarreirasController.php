<?php

namespace App\Http\Controllers;

use App\Models\Carreiras;
use Illuminate\Http\Request;

class CarreirasController extends Controller
{
    public function index()
    {
        return response()->json(Carreiras::all());
    }

    public function show(Carreiras $carreira)
    {
        return response()->json($carreira);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'atributosIniciais' => 'required|array',
            'imagem' => 'nullable|string|max:255',
        ]);

        $carreira = Carreiras::create($data);

        return response()->json($carreira, 201);
    }

    public function update(Request $request, Carreiras $carreira)
    {
        $data = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'atributosIniciais' => 'sometimes|array',
            'imagem' => 'nullable|string|max:255',
        ]);

        if (isset($data['atributosIniciais'])) {
            $data['atributosIniciais'] = array_merge($carreira->atributosIniciais ?? [], $data['atributosIniciais']);
        }

        $carreira->update($data);

        return response()->json($carreira);
    }

    public function destroy(Carreiras $carreira)
    {
        $carreira->delete();
        return response()->json(null, 204);
    }

    public function updateAttributes(Request $request, Carreiras $carreira)
    {
        $data = $request->validate([
            'atributosIniciais' => 'required|array',
        ]);

        $data['atributosIniciais'] = array_merge($carreira->atributosIniciais ?? [], $data['atributosIniciais']);

        $carreira->update($data);

        return response()->json($carreira);
    }
}
