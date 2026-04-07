@props([
    'title',
    'description' => null,
    'wrapperClass' => 'text-center mb-12 sm:mb-16',
    'titleClass' => 'text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4',
    'descriptionClass' => 'text-base sm:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto',
])

<div class="{{ $wrapperClass }}">
    <h2 class="{{ $titleClass }}">
        {{ $title }}
    </h2>

    @if($description)
    <p class="{{ $descriptionClass }}">
        {{ $description }}
    </p>
    @endif
</div>
