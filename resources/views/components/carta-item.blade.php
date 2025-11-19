@props([
    'nome' => '',
    'imagem' => null,
    // efeitos can be array or JSON string: ['estresse'=>0,'dinheiro'=>0,'reputacao'=>0]
    'efeitos' => null,
    'desc' => null,
    'signOnly' => false,
])

@php
    // normalize efeitos
    if (is_string($efeitos) && $efeitos !== '') {
        $efeitosArr = json_decode($efeitos, true) ?: [];
    } elseif (is_array($efeitos)) {
        $efeitosArr = $efeitos;
    } else {
        $efeitosArr = [];
    }

    $est = $efeitosArr['estresse'] ?? 0;
    $din = $efeitosArr['dinheiro'] ?? 0;
    $rep = $efeitosArr['reputacao'] ?? 0;

@include('components._normalize_image')
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md overflow-hidden']) }}>
    <div class="px-4 py-3 border-b bg-main">
        <h4 class="text-lg font-semibold text-white">{{ $nome }}</h4>
    </div>

    <div class="p-4">
        <div class="rounded-lg overflow-hidden mb-3 bg-gray-100">
            <img src="{{ $imagem }}" alt="{{ $nome }}" class="w-full object-cover h-40" />
        </div>

        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-4 text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/></svg>
                    <span class="font-medium">@if($signOnly){{ $est > 0 ? '+' : ($est < 0 ? '-' : '') }}@else{{ $est >= 0 ? '+' . $est : $est }}@endif</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2 0-4 1-4 3v4h8v-4c0-2-2-3-4-3z"/></svg>
                    <span class="font-medium">@if($signOnly){{ $din > 0 ? '+' : ($din < 0 ? '-' : '') }}@else{{ $din >= 0 ? '+' . $din : $din }}@endif</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-medium">@if($signOnly){{ $rep > 0 ? '+' : ($rep < 0 ? '-' : '') }}@else{{ $rep >= 0 ? '+' . $rep : $rep }}@endif</span>
                </div>
            </div>
        </div>

        @if($desc)
            <div class="text-sm text-gray-600">{{ $desc }}</div>
        @endif
    </div>
</div>
