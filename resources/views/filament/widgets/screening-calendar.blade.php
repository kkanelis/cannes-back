<x-filament::widget>
    <div class="p-4 bg-black text-white" style="width: 1200px; height: 1200px;">
        <div class="flex justify-between items-center mb-8">
            <button wire:click="previousWeek" class="px-4 py-2 text-sm font-medium text-white hover:text-gray-300">
                &lt; Previous Week
            </button>
            <h2 class="text-xl font-bold">
                {{ $week->startOfWeek()->format('j. ') }}  - {{ $week->endOfWeek()->format('j. F') }}
            </h2>
            <button wire:click="nextWeek" class="px-4 py-2 text-sm font-medium text-white hover:text-gray-300">
                Next Week &gt;
            </button>
        </div>
        
        <div class="grid grid-cols-7 gap-px bg-gray-800">
            @foreach($days as $day)
                <div class="border-t border-l border-gray-800">
                    <div class="p-2 bg-black">
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $loop->iteration + 1 }}</div>
                            <div class="text-sm text-gray-400">{{ $day }}</div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-800">
                        @if($screenings->has($day))
                            @foreach($screenings->get($day) as $screening)
                                @php
                                    $color = $getScreeningColor($screening);
                                    $bgColor = match($color) {
                                        'red' => 'bg-red-950 hover:bg-red-900',
                                        'yellow' => 'bg-yellow-950 hover:bg-yellow-900',
                                        'blue' => 'bg-blue-950 hover:bg-blue-900',
                                        default => 'bg-black hover:bg-gray-900'
                                    };
                                    $borderColor = match($color) {
                                        'red' => 'border-red-800',
                                        'yellow' => 'border-yellow-800',
                                        'blue' => 'border-blue-800',
                                        default => 'border-gray-800'
                                    };
                                    $textColor = match($color) {
                                        'red' => 'text-red-200',
                                        'yellow' => 'text-yellow-200',
                                        'blue' => 'text-blue-200',
                                        default => 'text-gray-400'
                                    };
                                @endphp
                                <div 
                                    wire:click="editScreening({{ $screening->id }})"
                                    class="p-3 border cursor-pointer transition-colors duration-150 {{ $bgColor }} {{ $borderColor }}"
                                >
                                    <div class="font-bold text-sm mb-1 {{ $textColor }}">{{ $screening->cinema->name }}</div>
                                    <div class="text-sm {{ $textColor }}">{{ $screening->movie->title }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($screening->starts_at)->format($timeFormat) }} - 
                                        {{ \Carbon\Carbon::parse($screening->ends_at)->format($timeFormat) }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="h-16"></div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::widget>