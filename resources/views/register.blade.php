<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    @vite('resources/css/app.css')
</head>

<body>
    <x-header />

    <div class="relative mx-auto flex h-[calc(100vh-5em)] w-screen max-w-[2000px] justify-between overflow-y-hidden">
                <div class="absolute top-0 h-full w-[50%] p-[1em] max-lg:hidden left-0 pr-0">
            <div class="relative flex size-full items-center justify-center rounded-[2em] overflow-hidden bg-gray-950 ">
                <img src="background-banner.png" class="size-[60em] object-cover" alt="">
            </div>
        </div>
        <div
            class="absolute top-0 right-0 flex min-h-[calc(100vh-5em)] w-[50%] items-center justify-center max-lg:w-full">
            
            <div class="max-h-[calc(100vh-5em)] w-full max-w-[24.5em] overflow-y-auto px-[1em] py-[2em]">
                <h1 class="text-3xl font-bold mb-2">Cadastro</h1>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <x-input name="name" label="Nome de usuário" type="text" placeholder="ex: Vovigdaa" :value="old('name')" />
                    <x-input name="email" label="Email" type="email" placeholder="ex: email@seudominio.com" :value="old('email')" />
                    <x-input name="password" label="Senha" type="password" placeholder="********" />
                    <x-input name="password_confirmation" label="Confirmar senha" type="password" placeholder="********" />

                    <br>
                    <div>
                        <x-button type="submit">Registrar</x-button>
                    </div>
                </form>
                <p>Já tem uma conta? <a href="/login" class="text-main hover:underline">Faça login</a></p>
            </div>
        </div>
    </div>

</body>

</html>
