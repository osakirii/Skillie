<?php

namespace App\Http\Controllers;

use App\Models\Situacoes;
use Illuminate\Http\Request;

class SituacoesController extends Controller
{
    public function index()
    {
        return response()->json(Situacoes::with(['carreira','decisao1','decisao2'])->get());
    }

    public function show(Situacoes $situacao)
    {
        return response()->json($situacao->load(['carreira','decisao1','decisao2']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'carreira_id' => 'required|exists:carreiras,id',
            'decisao1_id' => 'nullable|exists:cartas,id',
            'decisao2_id' => 'nullable|exists:cartas,id',
        ]);

        $situacao = Situacoes::create($data);

        return response()->json($situacao, 201);
    }

    public function update(Request $request, Situacoes $situacao)
    {
        $data = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'carreira_id' => 'sometimes|required|exists:carreiras,id',
            'decisao1_id' => 'nullable|exists:cartas,id',
            'decisao2_id' => 'nullable|exists:cartas,id',
        ]);

        $situacao->update($data);

        return response()->json($situacao);
    }

    public function destroy(Situacoes $situacao)
    {
        $situacao->delete();
        return response()->json(null, 204);
    }

    public function getDecisions(Request $request, Situacoes $situacao)
    {
        return response()->json([
            'decisao1' => $situacao->decisao1,
            'decisao2' => $situacao->decisao2,
        ]);
    }
}
