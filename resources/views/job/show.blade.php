<x-layout>
    <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index'), $work->title => '#']" />
    <x-job-card :work="$work">
        {{-- so, antara job dgn work tu, :job/work(variable) untuk paggil collection instance mcm work->desc tu  --}}
        {{-- kalau $work tu pulak dia variable dari controller apa yg kita define kat function tu --}}
        <p class="mb-4 text-sm text-slate-500">
            {!! nl2br(e($work->description)) !!}
        </p>

        {{-- kalau kat model aku define $job sbb ikut route model binding kat dan variable apa yg pass dekat view.blade tu
             controller, tapi yg ni dia follow dari policy dan ('apply', $work) tu dari policy
        aku define $work --}}
        @can('apply', $work)
            <x-link-button :href="route('job.application.create', $work)">
                Apply
            </x-link-button>
        @else
            <div class="text-center text-sm font-medium text-slate-500">
                You have already applied
            </div>
        @endcan

    </x-job-card>

    <x-card class="mb-4">
        <h2 class="mb-4 text-lg font-medium">
            More {{ $work->employer->company_name }} Jobs
        </h2>
        <div class="text-sm text-slate-500">
            @foreach ($work->employer->works as $otherWork)
                <div class="mb-4 flex justify-between">
                    <div class="text-slate-700">
                        <a href="{{ route('jobs.show', $otherWork) }}">
                            {{ $otherWork->title }}
                        </a>
                        <div class="text-xs">
                            {{ $otherWork->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="text-xs">
                        ${{ number_format($otherWork->salary) }}
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>

</x-layout>
