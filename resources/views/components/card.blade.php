@props(['title' => null, 'subtitle' => null])
<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow p-4']) }}>
    @if($title)
        <h3 class="text-lg font-medium">{{ $title }}</h3>
    @endif
    @if($subtitle)
        <div class="text-sm text-gray-500">{{ $subtitle }}</div>
    @endif
    <div class="mt-2">{{ $slot }}</div>
</div>
