<div>
    <label class="block font-bold text-gray-700 mb-1">
        {{ $label }}
    </label>

    <select
        name="{{ $name }}"
        class="w-full px-4 py-2 border rounded-lg focus:ring-aqua focus:border-aqua"
    >
        <option value="">— Select —</option>

        @foreach ($options as $option)
            <option
                value="{{ $option[$valueKey] }}"
                @selected($option[$valueKey] == old($name, $selected))
            >
                {{ $option[$labelKey] }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
