@props(['value'])

<<<<<<< Updated upstream
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
=======
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
>>>>>>> Stashed changes
    {{ $value ?? $slot }}
</label>
