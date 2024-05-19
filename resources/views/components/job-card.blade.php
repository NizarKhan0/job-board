<x-card class="mb-4">
    <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-medium">
            {{ $work->title }}
        </h2>
        <div class="text-slate-500">
            ${{ number_format($work->salary) }}
        </div>
    </div>

    <div class="mb-4 flex justify-between text-sm text-slate-500 items-center">
        <div class="flex space-x-4">
            <div>{{ $work->employer->company_name }}</div>
            <div>{{ $work->location }}</div>
        </div>
        <div class="flex space-x-1 text-xs">
            <x-tag>
                <a href="{{ route('jobs.index', ['experience' => $work->experience]) }}">
                    {{ Str::ucfirst($work->experience) }}
                </a>
            </x-tag>
            <x-tag>
                <a href="{{ route('jobs.index', ['category' => $work->category]) }}">
                    {{ $work->category }}
                </a>
            </x-tag>
        </div>
    </div>

    {{ $slot }}

</x-card>
