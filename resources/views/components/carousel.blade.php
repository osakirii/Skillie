@props(['id', 'title'])

<div class="relative mt-8 first:mt-0">
    <!-- Título-->
    <div class="text-h4 mb-4 w-full px-[5em]">{{ $title }}</div>

    <!-- Carrossel Container com Overlays -->
    <div class="relative -mx-[50vw] left-1/2 right-1/2 w-screen">
        <!-- Overlay Gradiente Esquerda -->
        <div
            class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent z-20 pointer-events-none">
        </div>

        <!-- Overlay Gradiente Direita -->
        <div
            class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white to-transparent z-20 pointer-events-none">
        </div>

        <!-- Botão Anterior -->
        <button onclick="scrollCarousel('{{ $id }}', -1)"
            class="absolute cursor-pointer left-[4em] top-1/2 -translate-y-1/2 z-30 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Carrossel -->
        <div id="{{ $id }}"
            class="flex gap-[1.5em] px-[max(1em,calc((100vw-1280px)/2))] py-[1em] w-full h-[30rem] overflow-y-visible overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide ">
            {{ $slot }}
        </div>

        <!-- Botão Próximo -->
        <button onclick="scrollCarousel('{{ $id }}', 1)"
            class="absolute cursor-pointer right-[4em] top-1/2 -translate-y-1/2 z-30 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>