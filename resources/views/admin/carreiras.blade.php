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
                                            <x-input name="estresse_inicial" label="Estresse" type="number" :value="old('estresse_inicial', 0)" min="-10" max="10" />
                                            <x-input name="dinheiro_inicial" label="Dinheiro" type="number" :value="old('dinheiro_inicial', 0)" min="-10" max="10" />
                                            <x-input name="reputacao_inicial" label="Reputação" type="number" :value="old('reputacao_inicial', 0)" min="-10" max="10" />
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
                                <style>
                                    /* constrain situacoes list height to the parent area and enable scrolling */
                                    #situacoes-container {
                                        max-height: 35rem; /* adjust to taste */
                                        overflow-y: auto;
                                    }
                                </style>
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
                                        <label class="block text-sm text-gray-700">Nome da Situação</label>
                                        <input type="text" name="__NAME__" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" placeholder="O que aconteceu agora?"/>
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-700">Descrição</label>
                                        <textarea name="desc" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" rows="2" placeholder="Descreva um pouco do que aconteceu...">{{ old('desc') }}</textarea>
                                     </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm text-gray-700">Carta 1</label>
                                            <select name="__DEC1__" class="dec1-select mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                                <option value="">—</option>
                                                @foreach($cartas as $ct)
                                                    <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700">Carta 2</label>
                                            <select name="__DEC2__" class="dec2-select mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
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
                    <article class="border border-gray-100 rounded-md p-4 mb-4 carreira-item" 
                             data-id="{{ $carreira->id }}"
                             data-nome="{{ htmlspecialchars($carreira->nome, ENT_QUOTES) }}"
                             data-desc="{{ htmlspecialchars($carreira->desc ?? '', ENT_QUOTES) }}"
                             data-imagem="{{ htmlspecialchars($carreira->imagem ?? '', ENT_QUOTES) }}"
                             data-categoria="{{ $carreira->categoria }}"
                             data-estresse="{{ (int)($carreira->estresse_inicial ?? 0) }}"
                             data-dinheiro="{{ (int)($carreira->dinheiro_inicial ?? 0) }}"
                             data-reputacao="{{ (int)($carreira->reputacao_inicial ?? 0) }}">
                        <div class="flex items-start justify-between cursor-pointer">
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
                                    <li class="flex items-center justify-between bg-gray-50 rounded-md p-2 situacao-item" 
                                        data-carreira-id="{{ $carreira->id }}"
                                        data-id="{{ $s->id }}"
                                        data-nome="{{ htmlspecialchars($s->nome, ENT_QUOTES) }}"
                                        data-desc="{{ htmlspecialchars($s->desc ?? '', ENT_QUOTES) }}"
                                        data-dec1="{{ $s->decisao1_id }}"
                                        data-dec2="{{ $s->decisao2_id }}">
                                        <div class="cursor-pointer">
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
                    </article>
                @empty
                    <p class="text-sm text-gray-500">No carreiras yet</p>
                @endforelse
            </div>
    </main>
    <!-- Edit Carreira Modal -->
    <div id="carreira-edit-modal" class="fixed w-auto inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h3 class="text-lg font-semibold">Editar Carreira</h3>
                <button id="close-carreira-edit" class="border border-red-600 rounded-md text-red-600 bg-white px-2 py-1">×</button>
            </div>
            <div class="p-4">
                <form id="carreira-edit-form" method="POST" action="" class="bg-white rounded-lg shadow p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <x-input id="edit-car-nome" name="nome" label="Carreira" placeholder="Nome da carreira" required/>

                            <div>
                                <label class="block text-sm text-gray-700">Descrição</label>
                                <textarea id="edit-car-desc" name="desc" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" rows="6"></textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <x-input id="edit-car-imagem" name="imagem" label="Imagem (URL)" placeholder="https://..." />
                                </div>
                                <div>
                                    <select id="edit-car-categoria" name="categoria" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                                        <option value="" disabled>Selecione a Categoria</option>
                                        <option value="Humanas">Humanas</option>
                                        <option value="Exatas">Exatas</option>
                                        <option value="Biologicas">Biológicas</option>
                                    </select>
                                </div>
                                <div class="">
                                    <p>Atributos Iniciais</p>
                                        <div class="flex flex-row gap-6" id="edit-atributos-iniciais">
                                            <x-input id="edit-estresse-inicial" name="estresse_inicial" label="Estresse" type="number" min="-10" max="10" />
                                            <x-input id="edit-dinheiro-inicial" name="dinheiro_inicial" label="Dinheiro" type="number" min="-10" max="10" />
                                            <x-input id="edit-reputacao-inicial" name="reputacao_inicial" label="Reputação" type="number" min="-10" max="10" />
                                        </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <x-button type="submit">Salvar</x-button>
                            </div>
                        </div>
                        <!-- Right: Situacoes manager inside edit modal -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-md font-semibold">Situações</h3>
                                <button type="button" id="modal-add-situacao" class="inline-flex items-center px-3 py-1 border rounded-md bg-white text-main">+ Adicionar</button>
                            </div>

                            <div id="modal-situacoes-container" class="space-y-4">
                                <!-- situacoes for this carreira will be cloned here when opening the modal -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const addBtn = document.getElementById('add-situacao');
            const container = document.getElementById('situacoes-container');
            const template = document.getElementById('situacao-template').innerHTML;
            let idx = 0;

            // helper: ensure two selects don't allow the same selected value
            function syncPair(a, b){
                // enable all options first
                Array.from(b.options).forEach(o => o.disabled = false);
                const val = a.value;
                if (val) {
                    const opt = b.querySelector('option[value="' + val + '"]');
                    if (opt) opt.disabled = true;
                }
            }

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

                // attach distinct-selection handlers for the two selects in this block
                const sel1 = wrapper.querySelector('.dec1-select');
                const sel2 = wrapper.querySelector('.dec2-select');
                if (sel1 && sel2) {
                    sel1.addEventListener('change', function(){ syncPair(sel1, sel2); });
                    sel2.addEventListener('change', function(){ syncPair(sel2, sel1); });
                    // initial sync in case prefill
                    syncPair(sel1, sel2);
                    syncPair(sel2, sel1);
                }

                container.appendChild(wrapper);
                idx++;
            }

            addBtn?.addEventListener('click', function(){ addSituacao(); });
        })();
    </script>
    <script>
        (function(){
            const modal = document.getElementById('carreira-edit-modal');
            const closeBtn = document.getElementById('close-carreira-edit');
            const form = document.getElementById('carreira-edit-form');

            function openEdit(data, sourceEl){
                form.action = '/admin/carreiras/' + data.id;
                document.getElementById('edit-car-nome').value = data.nome || '';
                document.getElementById('edit-car-desc').value = data.desc || '';
                document.getElementById('edit-car-imagem').value = data.imagem || '';
                document.getElementById('edit-car-categoria').value = data.categoria || '';
                document.getElementById('edit-estresse-inicial').value = data.estresse ?? 0;
                document.getElementById('edit-dinheiro-inicial').value = data.dinheiro ?? 0;
                document.getElementById('edit-reputacao-inicial').value = data.reputacao ?? 0;

                // populate situacoes inside modal by cloning the situacao items from the source article
                const modalContainer = document.getElementById('modal-situacoes-container');
                modalContainer.innerHTML = '';
                if (sourceEl) {
                    const situacoes = sourceEl.querySelectorAll('.situacao-item');
                    situacoes.forEach(function(s){
                        // clone the node so forms/actions remain intact
                        const clone = s.cloneNode(true);
                        // remove existing event listeners (none) and set up modal-specific click handler
                        clone.addEventListener('click', function(ev){
                            ev.stopPropagation();
                            if (ev.target.closest('form')) return; // ignore delete clicks
                            const d = {
                                carreiraId: clone.dataset.carreiraId,
                                id: clone.dataset.id,
                                nome: clone.dataset.nome,
                                desc: clone.dataset.desc,
                                dec1: clone.dataset.dec1,
                                dec2: clone.dataset.dec2,
                            };
                            if (window.openSituacaoModal) window.openSituacaoModal(d);
                        });

                        // make sure delete form inside the clone still works by leaving it as-is
                        modalContainer.appendChild(clone);
                    });
                }

                // wire the modal Add button to open situacao modal in create mode
                const addBtn = document.getElementById('modal-add-situacao');
                if (addBtn) {
                    addBtn.onclick = function(){
                        // open situacao modal in create mode (no id)
                        const d = { carreiraId: data.id };
                        if (window.openSituacaoModal) window.openSituacaoModal(d);
                    };
                }

                modal.classList.remove('hidden'); modal.classList.add('flex');
            }

            function close(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }
            closeBtn?.addEventListener('click', close);
            modal?.addEventListener('click', function(e){ if (e.target === modal) close(); });

            document.querySelectorAll('.carreira-item').forEach(function(el){
                el.addEventListener('click', function(e){
                    if (e.target.closest('form')) return;
                    const data = {
                        id: el.dataset.id,
                        nome: el.dataset.nome,
                        desc: el.dataset.desc,
                        imagem: el.dataset.imagem,
                        categoria: el.dataset.categoria,
                        estresse: el.dataset.estresse,
                        dinheiro: el.dataset.dinheiro,
                        reputacao: el.dataset.reputacao,
                    };
                    openEdit(data, el);
                });
            });
        })();
    </script>
    <!-- Edit Situacao Modal -->
    <div id="situacao-edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-lg mx-4">
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h3 class="text-lg font-semibold">Editar Situação</h3>
                <button id="close-situacao-edit" class="text-gray-600 px-2 py-1">×</button>
            </div>
            <div class="p-4">
                <form id="situacao-edit-form" method="POST" action="" class="grid grid-cols-1 gap-3">
                    @csrf
                    <x-input id="edit-sit-nome" name="nome" label="Nome" />
                    <div>
                        <label class="block text-sm text-gray-700">Descrição</label>
                        <textarea id="edit-sit-desc" name="desc" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" rows="4"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm text-gray-700">Carta 1</label>
                            <select id="edit-sit-dec1" name="decisao1_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                <option value="">—</option>
                                @foreach($cartas as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Carta 2</label>
                            <select id="edit-sit-dec2" name="decisao2_id" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                <option value="">—</option>
                                @foreach($cartas as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="flex items-center gap-3">
                            <form id="situacao-delete-form" method="POST" action="" style="display:none">
                                @csrf
                                <button id="situacao-delete-btn" type="submit" onclick="return confirm('Delete this situacao?')" class="text-xs px-3 py-1 border border-red-600 text-red-600 rounded-md">Delete</button>
                            </form>
                            <x-button type="submit">Salvar Situação</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const modal = document.getElementById('situacao-edit-modal');
            const closeBtn = document.getElementById('close-situacao-edit');
            const form = document.getElementById('situacao-edit-form');

            function openSituacao(data){
                // if data.id is present -> edit mode, otherwise create mode
                const isEdit = !!data.id;
                const base = '/admin/carreiras/' + data.carreiraId + (isEdit ? '/situacoes/' + data.id : '/situacoes');
                form.action = base;
                const deleteForm = document.getElementById('situacao-delete-form');
                if (deleteForm && isEdit) deleteForm.action = base;

                document.getElementById('edit-sit-nome').value = data.nome || '';
                document.getElementById('edit-sit-desc').value = data.desc || '';
                const dec1 = document.getElementById('edit-sit-dec1');
                const dec2 = document.getElementById('edit-sit-dec2');
                if (dec1 && dec2) {
                    dec1.value = data.dec1 || '';
                    dec2.value = data.dec2 || '';

                    // sync so they cannot be the same
                    function sync(){
                        Array.from(dec2.options).forEach(o => o.disabled = false);
                        if (dec1.value) {
                            const opt = dec2.querySelector('option[value="' + dec1.value + '"]');
                            if (opt) opt.disabled = true;
                        }

                        Array.from(dec1.options).forEach(o => o.disabled = false);
                        if (dec2.value) {
                            const opt2 = dec1.querySelector('option[value="' + dec2.value + '"]');
                            if (opt2) opt2.disabled = true;
                        }
                    }

                    // remove previous listeners by cloning selects (simple reset)
                    const dec1New = dec1.cloneNode(true);
                    const dec2New = dec2.cloneNode(true);
                    dec1.parentNode.replaceChild(dec1New, dec1);
                    dec2.parentNode.replaceChild(dec2New, dec2);

                    dec1New.addEventListener('change', sync);
                    dec2New.addEventListener('change', sync);
                    sync();
                }

                // toggle method input for the main form and manage the delete form only in edit mode
                const methodInput = form.querySelector('input[name="_method"]');
                if (isEdit) {
                    if (methodInput) methodInput.value = 'PUT';
                    else {
                        const inp = document.createElement('input'); inp.type = 'hidden'; inp.name = '_method'; inp.value = 'PUT'; form.prepend(inp);
                    }

                    // ensure delete form has correct action and a _method=DELETE input
                    if (deleteForm) {
                        deleteForm.action = base;
                        let delMethod = deleteForm.querySelector('input[name="_method"]');
                        if (!delMethod) {
                            delMethod = document.createElement('input'); delMethod.type = 'hidden'; delMethod.name = '_method'; delMethod.value = 'DELETE'; deleteForm.prepend(delMethod);
                        } else {
                            delMethod.value = 'DELETE';
                        }
                        deleteForm.style.display = '';
                    }
                } else {
                    if (methodInput) methodInput.remove();
                    if (deleteForm) {
                        // remove any _method in delete form to avoid accidental DELETE to the create endpoint
                        const delMethod = deleteForm.querySelector('input[name="_method"]');
                        if (delMethod) delMethod.remove();
                        deleteForm.action = '';
                        deleteForm.style.display = 'none';
                    }
                }

                modal.classList.remove('hidden'); modal.classList.add('flex');
            }

            function close(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }
            closeBtn?.addEventListener('click', close);
            modal?.addEventListener('click', function(e){ if (e.target === modal) close(); });

            // bind existing situacao items on the page so they can open the edit modal too
            document.querySelectorAll('.situacao-item').forEach(function(el){
                el.addEventListener('click', function(e){
                    e.stopPropagation();
                    if (e.target.closest('form')) return; // ignore delete button clicks
                    const data = {
                        carreiraId: el.dataset.carreiraId,
                        id: el.dataset.id,
                        nome: el.dataset.nome,
                        desc: el.dataset.desc,
                        dec1: el.dataset.dec1,
                        dec2: el.dataset.dec2,
                    };
                    openSituacao(data);
                });
            });

            // expose for use by the carreira edit modal (create mode)
            window.openSituacaoModal = openSituacao;
        })();
    </script>
</body>
</html>
