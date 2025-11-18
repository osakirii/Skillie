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