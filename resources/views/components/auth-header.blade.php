@props(['title' => null, 'description' => null])

<div class="text-center">
    @if($title)
        <h1 class="text-2xl font-semibold">{{ $title }}</h1>
    @endif

    @if($description)
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $description }}</p>
    @endif

    {{ $slot }}
</div>
