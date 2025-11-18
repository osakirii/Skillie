<!-- HEADER -->
<header class="bg-white w-full py-[1.1em] px-[2em] h-[5em] shadow-xl/10 shadow-main">
    <!-- Container do HEADER -->
    <div class="container flex justify-between items-center">
        <!-- LOGO -->
        <a href="/">
            <img src="logo_skillie_vermelho.png" alt="" class="h-[3.25em]">
        </a>
        <!-- BOTÕES -->
        <div class="flex gap-[3rem] justify-center items-center">
            @if(Auth::check() && Auth::user()->is_admin == 1)
                <a class="text-header" href="/admin/carreiras">Editar Carreiras</a>
                <a class="text-header" href="/admin/cartas">Editar Cartas</a>
            @endif
            @auth
                <x-button variant="solid" href="/perfil">Perfil</x-button>
            @else
                <x-button variant="solid" href="/login">Login</x-button>
            @endauth
        </div>
    </div>
</header>