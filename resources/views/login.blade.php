<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Cadastro</title>

    @vite('resources/css/app.css')
</head>

<body>
    <x-header />

    <!-- Container Principal -->
    <div class="relative mx-auto flex h-[calc(100vh-5em)] w-screen max-w-[2000px] justify-between overflow-y-hidden">
        <div
            class="absolute top-0 left-0 flex min-h-[calc(100vh-5em)] w-[50%] items-center justify-center max-lg:w-full">
            <div class="max-h-[calc(100vh-5em)] w-full max-w-[24.5em] overflow-y-auto px-[1em] py-[2em]">
                <h1>Login</h1>
                <p>Bem-Vindo de volta!</p>
            </div>
        </div>
        <div class="absolute top-0 h-full w-[50%] p-[1em] max-lg:hidden right-0 pl-0">
            <div class="relative flex size-full items-center justify-center rounded-[2em] overflow-hidden bg-gray-950 ">
                <img src="background-banner.png" class="size-[60em] object-cover" alt="">
            </div>
        </div>
    </div>

</body>

</html>