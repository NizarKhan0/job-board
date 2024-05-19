<label class="mb-2 block text-sm font-medium text-slate-900" for="{{ $for }}">
    {{ $slot }}
    @if ($required)
        <span class="text-red-500">*</span>
    @endif
    {{-- <span>{{ $required ? '*' : '' }}</span> cara kedua --}}
</label>
