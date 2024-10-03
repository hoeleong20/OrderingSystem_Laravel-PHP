@props(['status'])

@if ($status)
<<<<<<< Updated upstream
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
=======
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
>>>>>>> Stashed changes
        {{ $status }}
    </div>
@endif
