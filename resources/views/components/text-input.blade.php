@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#5a8713] focus:ring-[#5a8713] rounded-md shadow-sm']) }}>
