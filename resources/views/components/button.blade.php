@props([
    'type' => 'button',
    'variant' => 'solid',
    'disabled' => false,
    'loading' => false,
    'href' => null,
    'target' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'fullWidth' => false,
    'rounded' => true,
])

@php
    $tag = $href ? 'a' : 'button';
    
    // Define variant classes
    $variantClasses = [
        'solid' => 'bg-main transition-all duration-300 hover:bg-main-dark text-white',
        'outline' => 'text-main outline-main outline-[0.1em] hover:bg-main-dark hover:outline-main-dark transition-all duration-300 hover:text-white',
    ];
    
    
    $classes = [
        'text-bold  px-[1em] py-[0.25em] ',
        
        // Variants
        $variantClasses[$variant],
        
        // fullWidth
        $fullWidth ? 'w-full' : '',
        
        // Rounded
        $rounded ? 'rounded-[0.5em]' : 'rounded-lg',
        
        // Disabled state
        $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer',
        
        // Loading state
        $loading ? 'relative' : '',
    ];
    
    $attributes = $attributes->merge([
        'class' => implode(' ', array_filter($classes)),
        'disabled' => $tag === 'button' ? $disabled || $loading : null,
        'type' => $tag === 'button' ? $type : null,
        'href' => $tag === 'a' ? $href : null,
        'target' => $tag === 'a' ? $target : null,
    ]);
@endphp

<{{ $tag }} {{ $attributes }}>
    @if($loading)
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <div class="{{ $loading ? 'invisible' : '' }}">
    @endif
    
    @if($icon && $iconPosition === 'left')
        <span class="icon-left {{ $slot->isNotEmpty() ? 'mr-2' : '' }}">
            {!! $icon !!}
        </span>
    @endif
    
    {{ $slot }}
    
    @if($icon && $iconPosition === 'right')
        <span class="icon-right {{ $slot->isNotEmpty() ? 'ml-2' : '' }}">
            {!! $icon !!}
        </span>
    @endif
    
    @if($loading)
        </div>
    @endif
</{{ $tag }}>