@props([
    'as' => 'a',
    'href' => '#',
    'variant' => 'primary',
    'size' => 'md',
    'fullOnMobile' => false,
    'type' => 'button',
    'target' => null,
    'rel' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 sm:gap-3 rounded-lg transition-all duration-300 transform hover:scale-105';

    $variantClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-lg hover:shadow-xl',
        'success' => 'bg-green-500 hover:bg-green-600 text-white shadow-lg hover:shadow-xl',
        'light' => 'bg-white hover:bg-gray-100 text-blue-600 shadow-lg hover:shadow-xl',
        'neutral' => 'bg-gray-200 hover:bg-gray-300 text-gray-900 shadow-sm hover:shadow-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white',
        'warning' => 'bg-amber-600 hover:bg-amber-500 text-white shadow-sm hover:shadow-md',
        'subtle' => 'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100',
    ];

    $sizeClasses = [
        'xs' => 'px-3 py-1 text-xs font-semibold',
        'sm' => 'px-4 sm:px-6 py-2.5 text-sm font-semibold',
        'md' => 'px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-semibold',
        'lg' => 'px-7 sm:px-10 py-3.5 sm:py-5 text-base sm:text-xl font-bold',
    ];

    $resolvedVariant = $variantClasses[$variant] ?? $variantClasses['primary'];
    $resolvedSize = $sizeClasses[$size] ?? $sizeClasses['md'];
    $widthClasses = $fullOnMobile ? 'w-full sm:w-auto' : '';
@endphp

@if($as === 'button')
<button
    type="{{ $type }}"
    {{ $attributes->class(trim("$baseClasses $resolvedVariant $resolvedSize $widthClasses")) }}
>
    {{ $slot }}
</button>
@else
<a
    href="{{ $href }}"
    @if($target) target="{{ $target }}" @endif
    @if($rel) rel="{{ $rel }}" @endif
    {{ $attributes->class(trim("$baseClasses $resolvedVariant $resolvedSize $widthClasses")) }}
>
    {{ $slot }}
</a>
@endif
