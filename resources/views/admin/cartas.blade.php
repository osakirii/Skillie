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
            <h2 class="text-lg font-semibold mb-3">Create Carta</h2>
            <form method="POST" action="{{ route('admin.cartas.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @csrf
                <x-input name="nome" label="Nome" placeholder="Nome da carta" :value="old('nome')" />
                <x-input name="desc" label="Descrição" placeholder="Descrição curta" :value="old('desc')" />
                <x-input name="imagem" label="Imagem (URL)" placeholder="https://..." :value="old('imagem')" />
                <div class="md:col-span-3">
                    <x-button type="submit">Create</x-button>
                </div>
            </form>
        </section>

        <section>
            <h2 class="mb-4 text-lg font-semibold">Cards</h2>
            @if($cartas->isEmpty())
                <div class="text-sm text-gray-500">No cartas yet</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($cartas as $c)
                        <div class="flex flex-col">
                            <x-carta-item :nome="$c->nome" :imagem="$c->imagem" :efeitos="$c->efeitos" :desc="$c->desc" />
                            <div class="mt-2 flex justify-end">
                                <form method="POST" action="{{ route('admin.cartas.destroy', $c) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete carta #{{ $c->id }}?')" class="text-sm px-3 py-1 border border-red-600 text-red-600 rounded-md">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
</body>
</html>
