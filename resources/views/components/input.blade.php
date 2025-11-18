@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'icon' => null,        // raw SVG string or null
    'error' => null,       // validation message or null
    'rounded' => 'lg',     // sm, md, lg, full
    'id' => null,
])

@php
    // unique id if not provided
    $id = $id ?? ($name ? $name : 'input-'.uniqid());
    $hasIcon = !empty($icon);
    $isPassword = $type === 'password';
    // use app.css classes: .textfield-input with modifiers .icon and .pw
    $inputClasses = trim('textfield-input ' . ($hasIcon ? 'icon' : '') . ' ' . ($isPassword ? 'pw' : ''));
@endphp

<div class="textfield-component mb-4">
    @if($label)
        <label for="{{ $id }}" class="block mb-2 text-sm">{{ $label }}</label>
    @endif

    <div class="relative">
        {{-- left icon --}}
        @if($hasIcon)
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 fill-current pointer-events-none">
                {!! $icon !!}
            </span>
        @endif

        {{-- input --}}
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type === 'password' ? 'password' : $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        {{-- password toggle --}}
        @if($isPassword)
            <button
                type="button"
                class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-100 focus:outline-none"
                onclick="(function(){ const i=document.getElementById('{{ $id }}'); i.type = i.type === 'password' ? 'text' : 'password'; this.innerHTML = i.type === 'password' ? eyeIconHidden('{{ $id }}') : eyeIconShown('{{ $id }}'); })()"
                aria-label="toggle password"
            >
                {{-- initial eye (hidden) --}}
                <svg id="eye-{{ $id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        @endif
    </div>

    @if($error)
        <p class="mt-2 text-sm text-pink-400">{{ $error }}</p>
    @endif
</div>

{{-- small helper JS to keep eye svg toggles consistent between instances --}}
<script>
    // simple helpers to return svg strings (keeps Blade file pure and self-contained)
    function eyeIconHidden(id) {
        // when password is hidden (type=password) -> show closed-eye icon when toggled
        return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.223-3.804"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.223 6.223L17.777 17.777"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88A3 3 0 0114.12 14.12"/>
        </svg>`;
    }
    function eyeIconShown(id) {
        // when password is visible (type=text) -> show open-eye icon
        return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>`;
    }
</script>