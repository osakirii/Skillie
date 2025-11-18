<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Carreiras & Situacoes</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-header />

    <main class="mx-auto max-w-5xl px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-extrabold text-main">Carreiras</h1>
        </div>

            <div class="rounded-lg shadow p-6 bg-main">
                <h2 class="text-lg font-semibold mb-4 text-center text-white">Criar Carreira</h2>

                <form method="POST" action="{{ route('admin.carreiras.store') }}" class="bg-white rounded-lg shadow p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left: Carreira form -->
                        <div class="space-y-4">
                            <x-input name="nome" label="Carreira" placeholder="Nome da carreira" :value="old('nome')" required/>

                            <div>
                                <label class="block text-sm text-gray-700">Descrição</label>
                                <textarea name="desc" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" rows="6">{{ old('desc') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <x-input name="imagem" label="Imagem (URL)" placeholder="https://..." :value="old('imagem')" />
                                </div>
                                <div>
                                    <select name="categoria" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                                        <option value="" disabled selected>Selecione a Categoria</option>
                                        <option value="Humanas" {{ old('categoria') == 'Humanas' ? 'selected' : '' }}>Humanas</option>
                                        <option value="Exatas" {{ old('categoria') == 'Exatas' ? 'selected' : '' }}>Exatas</option>
                                        <option value="Biologicas" {{ old('categoria') == 'Biologicas' ? 'selected' : '' }}>Biológicas</option>
                                    </select>
                                </div>
                                <div class="">
                                    <p>Atributos Iniciais</p>
                                        <div class="flex flex-row gap-6" id="atributos-iniciais">
                                            <style>
                                                /* limit numeric inputs to roughly two digits */
                                                #atributos-iniciais input[type="number"] {
                                                    width: 10ch;
                                                    min-width: 10ch;
                                                    max-width: 10ch;
                                                }
                                                #atributos-iniciais label{
                                                    color: var(--color-main);
                                                }
                                            </style>
                                            <x-input name="estresse_inicial" label="Estresse" type="number" :value="old('estresse_inicial', 0)" />
                                            <x-input name="dinheiro_inicial" label="Dinheiro" type="number" :value="old('dinheiro_inicial', 0)" />
                                            <x-input name="reputacao_inicial" label="Reputação" type="number" :value="old('reputacao_inicial', 0)" />
                                        </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <x-button type="submit">Criar Carreira</x-button>

                            </div>
                        </div>
                        <!-- Right: Situações manager -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-md font-semibold">Situações</h3>
                                <button type="button" id="add-situacao" class="inline-flex items-center px-3 py-1 border rounded-md bg-white text-main">+ Adicionar</button>
                            </div>

                            <div id="situacoes-container" class="space-y-4">
                                <!-- dynamic situacao blocks will be appended here -->
                            </div>

                            <template id="situacao-template">
                                <div class="border border-gray-200 rounded-md p-3 bg-gray-50 relative">
                                    <button type="button" class="remove-situacao absolute right-0 top-0 text-sm px-2 py-1 border rounded-md text-red-600 bg-white">×</button>

                                    <div class="mb-2">
                                        <label class="block text-sm text-gray-700">Descrição da Situação</label>
                                        <input type="text" name="__NAME__" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" placeholder="O que aconteceu agora?"/>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700">Carta 1</label>
                                            <select name="__DEC1__" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                                <option value="">—</option>
                                                @foreach($cartas as $ct)
                                                    <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700">Carta 2</label>
                                            <select name="__DEC2__" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                                <option value="">—</option>
                                                @foreach($cartas as $ct)
                                                    <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Carreiras Existentes</h2>

                @forelse($carreiras as $carreira)
                    <article class="border border-gray-100 rounded-md p-4 mb-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-medium">{{ $carreira->nome }} <span class="text-sm text-gray-400">(ID: {{ $carreira->id }})</span></h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $carreira->desc }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('admin.carreiras.destroy', $carreira) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete carreira #{{ $carreira->id }}?')" class="text-sm px-3 py-1 border border-red-600 text-red-600 rounded-md hover:bg-red-50">Delete</button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-semibold mb-2">Situações</h4>
                            <ul class="space-y-2">
                                @forelse($carreira->situacoes as $s)
                                    <li class="flex items-center justify-between bg-gray-50 rounded-md p-2">
                                        <div>
                                            <strong class="text-sm">{{ $s->nome }}</strong>
                                            <div class="text-xs text-gray-500">{{ $s->desc }}</div>
                                        </div>
                                        <div>
                                            <form method="POST" action="{{ route('admin.carreiras.situacoes.destroy', [$carreira, $s]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete situacao #{{ $s->id }}?')" class="text-xs px-2 py-1 border border-red-600 text-red-600 rounded-md">Delete</button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-500">No situacoes yet</li>
                                @endforelse
                            </ul>

                                        <div class="mt-4">
                                            <h5 class="text-sm font-medium mb-2">Situações Existentes</h5>
                                            <ul class="space-y-2">
                                                @forelse($carreira->situacoes as $s)
                                                    <li class="flex items-center justify-between bg-gray-50 rounded-md p-2">
                                                        <div>
                                                            <strong class="text-sm">{{ $s->nome }}</strong>
                                                            <div class="text-xs text-gray-500">{{ $s->desc }}</div>
                                                        </div>
                                                        <div>
                                                            <form method="POST" action="{{ route('admin.carreiras.situacoes.destroy', [$carreira, $s]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" onclick="return confirm('Delete situacao #{{ $s->id }}?')" class="text-xs px-2 py-1 border border-red-600 text-red-600 rounded-md">Delete</button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li class="text-sm text-gray-500">No situacoes yet</li>
                                                @endforelse
                                            </ul>
                                        </div>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">No carreiras yet</p>
                @endforelse
            </div>
    </main>
    <script>
        (function(){
            const addBtn = document.getElementById('add-situacao');
            const container = document.getElementById('situacoes-container');
            const template = document.getElementById('situacao-template').innerHTML;
            let idx = 0;

            function addSituacao(prefill){
                const html = template
                    .replace(/__NAME__/g, `situacoes[${idx}][nome]`)
                    .replace(/__DEC1__/g, `situacoes[${idx}][decisao1_id]`)
                    .replace(/__DEC2__/g, `situacoes[${idx}][decisao2_id]`);
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html;
                // attach remove handler
                const rem = wrapper.querySelector('.remove-situacao');
                rem.addEventListener('click', function(){ wrapper.remove(); });
                container.appendChild(wrapper);
                idx++;
            }

            addBtn?.addEventListener('click', function(){ addSituacao(); });
        })();
    </script>
</body>
</html>
