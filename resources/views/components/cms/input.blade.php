<div>
    @if($label)
        <label class="block font-bold text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    @php
        $inputValue = old($name, $value);
        if (is_array($inputValue)) {
            $inputValue = implode(',', $inputValue);
        }
    @endphp

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $inputValue }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 border rounded-lg focus:ring-aqua focus:border-aqua'
        ]) }}
    />

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    @if($message)
        <label class="block font-base text-gray-600 mb-1">
            {{ $message }}
        </label>
    @endif
</div>
