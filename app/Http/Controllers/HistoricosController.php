<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use Illuminate\Http\Request;

class HistoricosController extends Controller
{
    public function index()
    {
        return response()->json(Historico::with(['carreira','user'])->get());
    }

    public function show(Historico $historico)
    {
        return response()->json($historico->load(['carreira','user']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'resultado' => 'required|string',
            'data_jogo' => 'required|date',
            'atributos_finais' => 'required|array',
            'carreira_id' => 'required|exists:carreiras,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $historico = Historico::create($data);

        return response()->json($historico, 201);
    }

    public function update(Request $request, Historico $historico)
    {
        $data = $request->validate([
            'resultado' => 'sometimes|required|string',
            'data_jogo' => 'sometimes|required|date',
            'atributos_finais' => 'sometimes|array',
            'carreira_id' => 'sometimes|required|exists:carreiras,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if (isset($data['atributos_finais'])) {
            $data['atributos_finais'] = array_merge($historico->atributos_finais ?? [], $data['atributos_finais']);
        }

        $historico->update($data);

        return response()->json($historico);
    }

    public function destroy(Historico $historico)
    {
        $historico->delete();
        return response()->json(null, 204);
    }
}
