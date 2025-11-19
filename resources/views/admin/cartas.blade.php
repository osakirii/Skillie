<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Cartas</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-header />
    <main class="container" style="max-width:1000px;margin:2rem auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-extrabold text-main">Cartas</h1>
        </div>

        <section class="mb-6">
            <div class="flex items-center justify-center mb-3">
                <button id="add-carta-btn" class="inline-flex items-center px-3 py-1 border rounded-md bg-white text-main">+ Adicionar</button>
            </div>

            <!-- Modal: add carta -->
            <div id="carta-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
                    <div class="flex items-center justify-between px-4 py-3 border-b">
                        <h3 class="text-lg font-semibold">Adicionar Carta</h3>
                        <button id="close-carta-modal" class="text-gray-600 px-2 py-1">×</button>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('admin.cartas.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @csrf
                            <x-input name="nome" label="Nome" placeholder="Nome da carta" :value="old('nome')" />
                            <x-input name="desc" label="Descrição" placeholder="Descrição curta" :value="old('desc')" />
                            <x-input name="imagem" label="Imagem (URL)" placeholder="https://..." :value="old('imagem')" />

                            <div class="md:col-span-3">
                                <p class="mb-2">Atributos (efeitos)</p>
                                <div class="flex flex-row gap-6" id="carta-atributos">
                                    <x-input name="efeitos[estresse]" label="Estresse" type="number" :value="old('efeitos.estresse', 0)" min="-10" max="10" />
                                    <x-input name="efeitos[dinheiro]" label="Dinheiro" type="number" :value="old('efeitos.dinheiro', 0)" min="-10" max="10" />
                                    <x-input name="efeitos[reputacao]" label="Reputação" type="number" :value="old('efeitos.reputacao', 0)" min="-10" max="10" />
                                </div>
                            </div>

                            <div class="md:col-span-3 flex justify-end">
                                <x-button type="submit">Create</x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                (function(){
                    const openBtn = document.getElementById('add-carta-btn');
                    const modal = document.getElementById('carta-modal');
                    const closeBtn = document.getElementById('close-carta-modal');

                    function open(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
                    function close(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }

                    openBtn?.addEventListener('click', open);
                    closeBtn?.addEventListener('click', close);

                    // close when clicking backdrop
                    modal?.addEventListener('click', function(e){ if (e.target === modal) close(); });
                })();
            </script>
        </section>

        <section>
            <h2 class="mb-4 text-lg font-semibold">Cartas criadas</h2>
            @if($cartas->isEmpty())
                <div class="text-sm text-gray-500">No cartas yet</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($cartas as $c)
                        <div class="flex flex-col">
                            <div class="carta-card cursor-pointer" 
                                 data-id="{{ $c->id }}"
                                 data-nome="{{ htmlspecialchars($c->nome, ENT_QUOTES) }}"
                                 data-desc="{{ htmlspecialchars($c->desc ?? '', ENT_QUOTES) }}"
                                 data-imagem="{{ htmlspecialchars($c->imagem ?? '', ENT_QUOTES) }}"
                                 data-estresse="{{ (int)($c->efeitos['estresse'] ?? 0) }}"
                                 data-dinheiro="{{ (int)($c->efeitos['dinheiro'] ?? 0) }}"
                                 data-reputacao="{{ (int)($c->efeitos['reputacao'] ?? 0) }}">
                                <x-carta-item :nome="$c->nome" :imagem="$c->imagem" :efeitos="$c->efeitos" :desc="$c->desc" />
                            </div>

                            <div class="mt-2 flex justify-end">
                                <form method="POST" action="{{ route('admin.cartas.destroy', $c) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete carta #{{ $c->id }}?')" class="solid text-sm px-3 py-1 bg-red-600 text-white rounded-md">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    
    <!-- Edit Carta Modal -->
    <div id="carta-edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h3 class="text-lg font-semibold">Editar Carta</h3>
                <button id="close-carta-edit" class="text-gray-600 px-2 py-1">×</button>
            </div>
            <div class="p-4">
                <form id="carta-edit-form" method="POST" action="" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @csrf
                    @method('PUT')
                    <x-input id="edit-nome" name="nome" label="Nome" placeholder="Nome da carta" />
                    <x-input id="edit-desc" name="desc" label="Descrição" placeholder="Descrição curta" />
                    <x-input id="edit-imagem" name="imagem" label="Imagem (URL)" placeholder="https://..." />

                    <div class="md:col-span-3">
                        <p class="mb-2">Atributos (efeitos)</p>
                        <div class="flex flex-row gap-6" id="carta-edit-atributos">
                            <x-input id="edit-estresse" name="efeitos[estresse]" label="Estresse" type="number" min="-10" max="10" />
                            <x-input id="edit-dinheiro" name="efeitos[dinheiro]" label="Dinheiro" type="number" min="-10" max="10" />
                            <x-input id="edit-reputacao" name="efeitos[reputacao]" label="Reputação" type="number" min="-10" max="10" />
                        </div>
                    </div>

                    <div class="md:col-span-3 flex justify-end">
                        <x-button type="submit">Salvar</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function(){
            // open edit modal when a carta card is clicked
            const modal = document.getElementById('carta-edit-modal');
            const closeBtn = document.getElementById('close-carta-edit');
            const form = document.getElementById('carta-edit-form');

            function openEdit(data){
                form.action = '/admin/cartas/' + data.id;
                document.getElementById('edit-nome').value = data.nome || '';
                document.getElementById('edit-desc').value = data.desc || '';
                document.getElementById('edit-imagem').value = data.imagem || '';
                document.getElementById('edit-estresse').value = data.estresse ?? 0;
                document.getElementById('edit-dinheiro').value = data.dinheiro ?? 0;
                document.getElementById('edit-reputacao').value = data.reputacao ?? 0;
                modal.classList.remove('hidden'); modal.classList.add('flex');
            }

            function close(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }
            closeBtn?.addEventListener('click', close);
            modal?.addEventListener('click', function(e){ if (e.target === modal) close(); });

            document.querySelectorAll('.carta-card').forEach(function(el){
                el.addEventListener('click', function(e){
                    // ignore clicks originating from forms/buttons inside this card (like the delete button)
                    if (e.target.closest('form')) return;
                    const data = {
                        id: el.dataset.id,
                        nome: el.dataset.nome,
                        desc: el.dataset.desc,
                        imagem: el.dataset.imagem,
                        estresse: el.dataset.estresse,
                        dinheiro: el.dataset.dinheiro,
                        reputacao: el.dataset.reputacao,
                    };
                    openEdit(data);
                });
            });
        })();
    </script>
    </main>
</body>
</html>
