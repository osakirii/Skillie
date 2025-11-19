<?php

namespace App\Http\Controllers;

use App\Models\Carreiras;
use App\Models\Situacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'categoria' => 'nullable|string|max:100',
            'atributosIniciais' => 'nullable|array',
            'imagem' => 'nullable|string|max:255',
            'situacoes' => 'sometimes|array',
            'situacoes.*.nome' => 'required_with:situacoes|string|max:255',
            'situacoes.*.desc' => 'nullable|string',
            'situacoes.*.decisao1_id' => 'nullable|exists:cartas,id',
            'situacoes.*.decisao2_id' => 'nullable|exists:cartas,id',
        ]);

        // Build atributosIniciais from form fields if provided (estresse_inicial, dinheiro_inicial, reputacao_inicial)
        if (empty($data['atributosIniciais'])) {
            $data['atributosIniciais'] = [
                'estresse' => (int) $request->input('estresse_inicial', 0),
                'dinheiro' => (int) $request->input('dinheiro_inicial', 0),
                'reputacao' => (int) $request->input('reputacao_inicial', 0),
            ];
        }

        // Use transaction to ensure carreira and situacoes are created atomically
        $carreira = null;
        DB::beginTransaction();
        try {
            $carreira = Carreiras::create([
                'nome' => $data['nome'],
                'desc' => $data['desc'] ?? null,
                'categoria' => $data['categoria'] ?? null,
                'atributosIniciais' => $data['atributosIniciais'],
                'imagem' => $data['imagem'] ?? null,
            ]);

            if (!empty($data['situacoes']) && is_array($data['situacoes'])) {
                foreach ($data['situacoes'] as $sit) {
                    // ensure required name present
                    if (empty($sit['nome'])) continue;

                    // ensure decisao1 and decisao2 are not the same (if both provided)
                    if (!empty($sit['decisao1_id']) && !empty($sit['decisao2_id']) && $sit['decisao1_id'] == $sit['decisao2_id']) {
                        DB::rollBack();
                        if ($request->wantsJson()) {
                            return response()->json(['error' => 'Decisão 1 e Decisão 2 devem ser cartas diferentes.'], 422);
                        }
                        return redirect()->back()->withInput()->withErrors(['situacoes' => 'Decisão 1 e Decisão 2 devem ser cartas diferentes.']);
                    }

                    Situacoes::create([
                        'nome' => $sit['nome'],
                        'desc' => $sit['desc'] ?? null,
                        'carreira_id' => $carreira->id,
                        'decisao1_id' => $sit['decisao1_id'] ?? null,
                        'decisao2_id' => $sit['decisao2_id'] ?? null,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Could not create carreira'], 500);
            }
            return redirect()->back()->withInput()->withErrors(['msg' => 'Não foi possível criar a carreira.']);
        }

        if ($request->wantsJson()) {
            return response()->json($carreira, 201);
        }

        return redirect()->route('admin.carreiras.index');
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
