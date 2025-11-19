<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jogar — {{ $carreira->nome ?? 'Carreira' }}</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <x-header />

    <style>
        /* small UI animations used during play */
        .card-hover { transition: transform .18s ease, box-shadow .18s ease; }
        .card-hover:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }

        .fade-transition { transition: opacity .22s ease, transform .22s ease; }
        .fade-hidden { opacity: 0; transform: translateY(6px); }
    </style>

    <main class="mx-auto max-w-4xl px-4 py-10">
        <section id="intro">
            <x-card :title="$carreira->nome" class="">
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-40 h-40 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                        @php $imagem = $carreira->imagem ?? null; @endphp
                        @include('components._normalize_image')
                        @if(!empty($image))
                            <img src="{{ $image }}" alt="{{ $carreira->nome }}" class="w-full h-full object-cover" />
                        @endif
                    </div>

                    <div class="flex-1">
                        <p class="text-sm text-gray-600">{{ $carreira->desc }}</p>

                        <div class="mt-4">
                            <h4 class="text-sm font-semibold">Atributos Iniciais</h4>
                            <div class="mt-2 flex gap-4 text-sm text-gray-700">
                                @php $init = $carreira->atributosIniciais ?? ['estresse'=>0,'dinheiro'=>0,'reputacao'=>0]; @endphp
                                <div class="flex items-center gap-2"><strong>Estresse</strong><span id="attr-estresse">{{ $init['estresse'] ?? 0 }}</span></div>
                                <div class="flex items-center gap-2"><strong>Dinheiro</strong><span id="attr-dinheiro">{{ $init['dinheiro'] ?? 0 }}</span></div>
                                <div class="flex items-center gap-2"><strong>Reputação</strong><span id="attr-reputacao">{{ $init['reputacao'] ?? 0 }}</span></div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-button id="start-game" variant="solid">Começar</x-button>
                        </div>
                    </div>
                </div>
            </x-card>
        </section>

        <section id="game" class="hidden mt-6">
            <!-- Situation info (wide) -->
            <x-card id="situation-info" class="mb-4">
                <div id="situation-meta" class="flex items-center justify-between mb-3">
                    <div class="text-sm text-gray-500">Situação <span id="current-index">0</span> / <span id="total-count">0</span></div>
                    <div class="text-sm text-gray-700">Atributos — Est: <span id="live-estresse"></span> · Din: <span id="live-dinheiro"></span> · Rep: <span id="live-reputacao"></span></div>
                </div>

                <h2 id="situation-title" class="text-lg font-semibold"></h2>
                <p id="situation-desc" class="mt-2 text-gray-600"></p>
            </x-card>

            <!-- Decisions (wide block below with two columns) -->
            <x-card class="p-4">
                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4" id="decisions">
                    <!-- decision cards will be rendered here -->
                </div>
            </x-card>

            {{-- server-side templates for decisions so we can reuse the carta component markup in JS --}}
            <div id="card-templates" class="hidden">
                @foreach($carreira->situacoes as $i => $s)
                    @php
                        $d1 = $s->decisao1;
                        $d2 = $s->decisao2;
                    @endphp
                    <template id="tmpl-s-{{ $i }}-d-1">
                        @if($d1)
                            <x-carta-item :nome="$d1->nome" :imagem="$d1->imagem" :efeitos="$d1->efeitos" :desc="$d1->desc" :signOnly="true" class="cursor-pointer" />
                        @else
                            <div class="bg-white rounded-xl shadow-md overflow-hidden opacity-50 cursor-not-allowed p-4"> <div class="p-4 text-sm text-gray-500">Vazio</div></div>
                        @endif
                    </template>
                    <template id="tmpl-s-{{ $i }}-d-2">
                        @if($d2)
                            <x-carta-item :nome="$d2->nome" :imagem="$d2->imagem" :efeitos="$d2->efeitos" :desc="$d2->desc" :signOnly="true" class="cursor-pointer" />
                        @else
                            <div class="bg-white rounded-xl shadow-md overflow-hidden opacity-50 cursor-not-allowed p-4"> <div class="p-4 text-sm text-gray-500">Vazio</div></div>
                        @endif
                    </template>
                @endforeach
            </div>

            <x-card id="end-screen" class="hidden mt-6">
                <h3 id="end-title" class="text-xl font-bold"></h3>
                <p id="end-desc" class="mt-2 text-gray-600"></p>
                <div class="mt-4">
                    <h4 class="font-semibold">Atributos finais</h4>
                    <ul class="text-sm text-gray-700">
                        <li>Estresse: <span id="final-estresse"></span></li>
                        <li>Dinheiro: <span id="final-dinheiro"></span></li>
                        <li>Reputação: <span id="final-reputacao"></span></li>
                    </ul>
                </div>
                <div class="mt-4">
                    <x-button id="save-result">Salvar Resultado</x-button>
                    <a href="{{ route('home') }}" class="ml-3 text-sm text-gray-600">Voltar</a>
                </div>
            </x-card>
        </section>

    </main>

    <script>
        (function(){
            const carreira = @json($carreira->load(['situacoes.decisao1','situacoes.decisao2']));
            const startBtn = document.getElementById('start-game');
            const intro = document.getElementById('intro');
            const game = document.getElementById('game');
            const totalCountEl = document.getElementById('total-count');
            const currentIndexEl = document.getElementById('current-index');
            const situationTitle = document.getElementById('situation-title');
            const situationDesc = document.getElementById('situation-desc');
            const decisions = document.getElementById('decisions');
            const liveEst = document.getElementById('live-estresse');
            const liveDin = document.getElementById('live-dinheiro');
            const liveRep = document.getElementById('live-reputacao');
            const finalEst = document.getElementById('final-estresse');
            const finalDin = document.getElementById('final-dinheiro');
            const finalRep = document.getElementById('final-reputacao');
            const endScreen = document.getElementById('end-screen');
            const endTitle = document.getElementById('end-title');
            const endDesc = document.getElementById('end-desc');
            const saveBtn = document.getElementById('save-result');

            let situacoes = (carreira.situacoes || []).slice();
            let idx = 0;
            // coerce initial attributes to numbers to avoid string concatenation
            const atributos = {
                estresse: Number(carreira.atributosIniciais?.estresse) || 0,
                dinheiro: Number(carreira.atributosIniciais?.dinheiro) || 0,
                reputacao: Number(carreira.atributosIniciais?.reputacao) || 0,
            };

            function renderAttributes(){
                liveEst.textContent = atributos.estresse;
                liveDin.textContent = atributos.dinheiro;
                liveRep.textContent = atributos.reputacao;
            }

            function renderSituation(i){
                const s = situacoes[i];
                currentIndexEl.textContent = i+1;
                totalCountEl.textContent = situacoes.length;
                situationTitle.textContent = s.nome || 'Situação';
                situationDesc.textContent = s.desc || '';
                decisions.innerHTML = '';
                // prepare for fade-in
                decisions.style.opacity = '0';
                const infoEl = document.getElementById('situation-info');
                if (infoEl) infoEl.style.opacity = '0';

                const decs = [s.decisao1, s.decisao2];
                decs.forEach(function(c, j){
                    // clone pre-rendered carta-item template for this situation/decision
                    const tmplId = `tmpl-s-${i}-d-${j+1}`;
                    const tmpl = document.getElementById(tmplId);
                    let node;
                    if (tmpl && tmpl.content && tmpl.content.firstElementChild) {
                        node = tmpl.content.firstElementChild.cloneNode(true);
                    } else {
                        node = document.createElement('div');
                        node.className = 'bg-white rounded-xl shadow-md overflow-hidden opacity-50 cursor-not-allowed p-4';
                        node.innerHTML = '<div class="p-4 text-sm text-gray-500">Vazio</div>';
                    }

                    // add card hover/transition class
                    node.classList.add('card-hover', 'fade-transition');

                    // attach click handler if decision exists
                    if (!c) {
                        node.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        node.addEventListener('click', function(){
                            // fade out current UI
                            decisions.style.transition = 'opacity .22s ease, transform .22s ease';
                            decisions.style.opacity = '0';
                            const info = document.getElementById('situation-info');
                            if (info) { info.style.transition = 'opacity .22s ease, transform .22s ease'; info.style.opacity = '0'; }

                            setTimeout(function(){
                                const efeitos = c?.efeitos || {estresse:0,dinheiro:0,reputacao:0};
                                const addEst = Number(efeitos.estresse) || 0;
                                const addDin = Number(efeitos.dinheiro) || 0;
                                const addRep = Number(efeitos.reputacao) || 0;
                                atributos.estresse = (Number(atributos.estresse) || 0) + addEst;
                                atributos.dinheiro = (Number(atributos.dinheiro) || 0) + addDin;
                                atributos.reputacao = (Number(atributos.reputacao) || 0) + addRep;
                                renderAttributes();

                                if (atributos.estresse <= -10 || atributos.dinheiro <= -10 || atributos.reputacao <= -10) {
                                    endGame('Derrota', 'Você atingiu -10 em um dos atributos.');
                                    return;
                                }

                                idx++;
                                if (idx >= situacoes.length) {
                                    endGame('Vitória', 'Você completou todas as situações.');
                                } else {
                                    // render next and fade in
                                    renderSituation(idx);
                                    // small delay to allow DOM updates
                                    setTimeout(function(){
                                        decisions.style.opacity = '1';
                                        if (info) info.style.opacity = '1';
                                    }, 40);
                                }
                            }, 220);
                        });
                    }

                    decisions.appendChild(node);
                });

                // animate in
                setTimeout(function(){
                    decisions.style.transition = 'opacity .22s ease, transform .22s ease';
                    decisions.style.opacity = '1';
                    if (infoEl) infoEl.style.transition = 'opacity .22s ease, transform .22s ease';
                    if (infoEl) infoEl.style.opacity = '1';
                }, 40);
            }

            function endGame(title, desc){
                endTitle.textContent = title;
                endDesc.textContent = desc;
                finalEst.textContent = atributos.estresse;
                finalDin.textContent = atributos.dinheiro;
                finalRep.textContent = atributos.reputacao;

                // hide situation info and show end screen
                document.getElementById('situation-info').style.display = 'none';
                // hide decisions card (it is the next sibling)
                const decisionsCard = document.querySelector('#decisions')?.closest('.bg-white, .rounded-lg, .card');
                // simpler: hide the decisions container
                const decisionsContainer = document.getElementById('decisions');
                if (decisionsContainer) decisionsContainer.style.display = 'none';
                endScreen.classList.remove('hidden');

                // automatically save historico (attempt). If user is not authenticated, server may redirect — handle gracefully.
                saveResultAutomatically();
            }

            startBtn?.addEventListener('click', function(){
                intro.classList.add('hidden');
                game.classList.remove('hidden');
                renderAttributes();
                if (situacoes.length === 0) {
                    endGame('Sem Situações', 'Esta carreira não tem situações definidas.');
                    return;
                }
                idx = 0;
                renderSituation(idx);
            });

            async function saveResultAutomatically(){
                const payload = {
                    resultado: endTitle.textContent + ': ' + endDesc.textContent,
                    atributos_finais: {
                        estresse: atributos.estresse,
                        dinheiro: atributos.dinheiro,
                        reputacao: atributos.reputacao,
                    }
                };

                try {
                    const res = await fetch('{{ route('carreiras.play.save', $carreira) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload),
                    });

                    // If server redirects to login (302), fetch will follow and return HTML; guard that by checking content-type
                    const contentType = res.headers.get('content-type') || '';
                    if (res.ok && contentType.includes('application/json')) {
                        const data = await res.json();
                        if (data.ok) {
                            if (saveBtn) { saveBtn.textContent = 'Salvo'; saveBtn.disabled = true; }
                            return data;
                        }
                    }

                    // if not ok, try to parse json errors or fall back to show a message
                    try { const body = await res.json(); console.warn('Save response', body); } catch(e){}
                    if (saveBtn) saveBtn.textContent = 'Erro ao salvar';
                } catch (err) {
                    console.error('Save failed', err);
                    if (saveBtn) saveBtn.textContent = 'Erro ao salvar';
                }
            }

            // also allow manual save button (in case automatic save failed or user wants retry)
            saveBtn?.addEventListener('click', function(){ saveResultAutomatically(); });
        })();
    </script>
</body>
</html>
