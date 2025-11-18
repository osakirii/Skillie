<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skillie</title>

    @vite('resources/css/app.css')
</head>

<body>
    <!-- Page Container -->
    <div>
        <!-- HEADER -->
        <x-header />
        <!--CONTENT -->
        <div>
            <!-- IMAGEM SIGMAL DO ESCOLHA SUA CARREIRA UAU UAU COM OS CUBOS LÁ -->
            <div class="container flex flex-row justify-between items-center px-[8em] mt-[1.5em]">
                <div class="title flex flex-col gap-[1em] justify-center w-[38em]">
                    <div>
                        <div class="text-h1">Escolha sua carreira.</div>
                        <div class="text-h1 text-main">Planeje seu futuro.</div>
                    </div>

                    <p class="text-h3 text-bold text-wrap text-justify w-[22em]">Descubra seus objetivos, organize seus
                        passos e
                        transforme
                        seus sonhos profissionais em um plano real.</p>
                </div>
                <img src="quadrados.png" class="size-[34em]" alt="Vários quadrados amontoados">

            </div>
        <!-- Inline careers search input -->
        <div style="position:relative;max-width:1536px;margin:1rem auto;padding:0 0.5rem;display:flex;justify-content:center">
            <div style="width:min(900px,96%);">
                <div style="position:relative;">
                    <span style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--color-gray-500);pointer-events:none;">
                        <!-- search icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="height:20px;width:20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                    </span>
                    <input id="career-search-input" placeholder="Pesquisar carreiras" aria-label="Pesquisar carreiras"
                           class="textfield-input icon" />
                </div>
                <div id="career-results-panel" style="display:none;margin-top:.5rem;position:relative;z-index:40"></div>
            </div>
        </div>
            <!-- CARREIRAS -->
            <div class="w-full overflow-hidden">
                <!-- TECNOLOGIA -->
                <div class="container">
                    <x-carousel id="tech-carousel" title="Tecnologia">
                        <x-carousel-item title="Desenvolvedor Web"
                            description="Descrição Descrição Descrição Descrição Descrição Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400"
                            link="/carreira/desenvolvedor-web" />

                        <x-carousel-item title="Cientista de Dados" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400"
                            link="/carreira/cientista-dados" />

                        <x-carousel-item title="DevOps Engineer" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1667372393119-3d4c48d07fc9?w=400"
                            link="/carreira/devops" />

                        <x-carousel-item title="UI/UX Designer" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400"
                            link="/carreira/ui-ux-designer" />
                    </x-carousel>
                </div>

                <!-- ESPORTES -->
                <div class="container">
                    <x-carousel id="sport-carousel" title="Esportes">
                        <x-carousel-item title="Taekwondo" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=400"
                            link="/carreira/taekwondo" />

                        <x-carousel-item title="Karate" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1555597673-b21d5c935865?w=400"
                            link="/carreira/karate" />

                        <x-carousel-item title="Judo" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1583473848882-f9a5bc7fd2ee?w=400"
                            link="/carreira/judo" />

                        <x-carousel-item title="Brazilian Jiu-Jitsu" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=400"
                            link="/carreira/jiu-jitsu" />

                        <x-carousel-item title="Boxe Chinês" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=400"
                            link="/carreira/boxe-chines" />

                        <x-carousel-item title="Boxe Chinês" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=400"
                            link="/carreira/boxe-chines" />

                        <x-carousel-item title="Boxe Chinês" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=400"
                            link="/carreira/boxe-chines" />

                        <x-carousel-item title="Boxe Chinês" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=400"
                            link="/carreira/boxe-chines" />
                    </x-carousel>
                </div>

                <!-- EDUCAÇÃO -->
                <div class="container">
                    <x-carousel id="edu-carousel" title="Educação">
                        <x-carousel-item title="Professor" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400"
                            link="/carreira/professor" />

                        <x-carousel-item title="Pedagogo" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400"
                            link="/carreira/pedagogo" />
                    </x-carousel>
                </div>

                <!-- FINANCEIRO -->
                <div class="container">
                    <x-carousel id="fin-carousel" title="Financeiro">
                        <x-carousel-item title="Analista Financeiro" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400"
                            link="/carreira/analista-financeiro" />

                        <x-carousel-item title="Contador" description="Descrição Descrição Descrição"
                            image="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=400"
                            link="/carreira/contador" />
                    </x-carousel>
                </div>
            </div>
        </div>

        <script>
            function scrollCarousel(carouselId, direction) {
                const carousel = document.getElementById(carouselId);
                // Largura do card (20rem = 320px) + gap (1.5em ≈ 24px)
                const scrollAmount = 370; // 344px total
                carousel.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        </script>

        <!-- Careers search panel + script -->
        <style>
            .career-list { display:flex; flex-direction:column; gap:.5rem; margin-top:.25rem }
            .career-item { padding:.6rem; border-radius:.4rem; border:1px solid var(--color-gray-300); display:flex; justify-content:space-between; align-items:center; background: white }
            .career-item a { color: var(--color-main); font-weight:600; text-decoration:none }
            .fade-in { animation: fadeIn 220ms ease both }
            .fade-out { animation: fadeOut 220ms ease both }
            @keyframes fadeIn { from { transform: translateY(6px); opacity: 0 } to { transform: translateY(0); opacity:1 } }
            @keyframes fadeOut { from { transform: translateY(0); opacity:1 } to { transform: translateY(6px); opacity:0 } }
        </style>

        <script>
            (function(){
                const input = document.getElementById('career-search-input');
                const panel = document.getElementById('career-results-panel');
                let careers = [];
                let debounceTimer = null;

                async function fetchCareers(){
                    if (careers.length) return careers;
                    try{
                        const res = await fetch('{{ route('carreiras.json') }}');
                        if (!res.ok) throw new Error('Network');
                        careers = await res.json();
                        return careers;
                    }catch(e){
                        panel.innerHTML = '<div class="text-light">Erro ao carregar carreiras.</div>';
                        return [];
                    }
                }

                function renderList(list){
                    if (!list.length){ panel.innerHTML = '<div class="text-light">Nenhuma carreira encontrada.</div>'; panel.style.display = 'block'; return; }
                    panel.innerHTML = '';
                    const container = document.createElement('div');
                    container.className = 'career-list';
                    list.forEach(c => {
                        const el = document.createElement('div');
                        el.className = 'career-item fade-in';
                        const name = document.createElement('div');
                        name.innerHTML = `<a href="/carreira/${encodeURIComponent(c.nome.toLowerCase().replace(/\s+/g,'-'))}">${escapeHtml(c.nome)}</a>`;
                        el.appendChild(name);
                        container.appendChild(el);
                    });
                    panel.appendChild(container);
                    panel.style.display = 'block';
                }

                function escapeHtml(str){ return (str+'').replace(/[&<>"']/g, function(m){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];}); }

                function doFilter(q){
                    const ql = q.trim().toLowerCase();
                    if (!ql){ panel.style.display = 'none'; panel.innerHTML = ''; return; }
                    fetchCareers().then(list => {
                        const filtered = list.filter(c => c.nome.toLowerCase().includes(ql));
                        renderList(filtered);
                    });
                }

                input.addEventListener('input', function(){
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(()=> doFilter(this.value), 180);
                });

                // hide panel when clicking outside
                document.addEventListener('click', function(e){
                    if (!document.getElementById('career-results-panel').contains(e.target) && e.target !== input){
                        panel.style.display = 'none';
                    }
                });

                // allow focusing the input to fetch data
                input.addEventListener('focus', function(){ fetchCareers(); if (this.value) doFilter(this.value); });
            })();
        </script>

        <style>
            /* Esconder scrollbar mas manter funcionalidade */
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
</body>

</html>