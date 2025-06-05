@props([
    'schedule' => null,
    'showTeacher' => false,
    'showClass' => false
])

@if($schedule)
    <div class="h-full min-h-[100px] p-2 bg-white dark:bg-gray-700 rounded-lg shadow-sm border-l-4 
        hover:scale-[1.02] transition-all duration-200 ease-in-out w-full
        @switch($schedule->subject->code)
            @case('MAT')
                border-subject-math dark:border-subject-math-dark
                @break
            @case('POL')
                border-subject-polish dark:border-subject-polish-dark
                @break
            @case('ANG')
                border-subject-english dark:border-subject-english-dark
                @break
            @case('HIST')
                border-subject-history dark:border-subject-history-dark
                @break
            @case('GEO')
                border-subject-geography dark:border-subject-geography-dark
                @break
            @case('BIO')
                border-subject-biology dark:border-subject-biology-dark
                @break
            @case('CHEM')
                border-subject-chemistry dark:border-subject-chemistry-dark
                @break
            @case('FIZ')
                border-subject-physics dark:border-subject-physics-dark
                @break
            @default
                border-gray-300 dark:border-gray-600
        @endswitch">
        <div class="flex flex-col h-full">
            <div class="font-semibold text-sm text-gray-900 dark:text-gray-100">
                {{ $schedule->subject->name }}
            </div>
            @if($showTeacher)
                <div class="text-xs text-gray-600 dark:text-gray-300">
                    {{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}
                </div>
            @endif
            @if($showClass)
                <div class="text-xs text-gray-600 dark:text-gray-300">
                    Klasa {{ $schedule->class->name }}
                </div>
            @endif
            @if($schedule->room)
                <div class="mt-auto">
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full 
                        bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300">
                        Sala {{ $schedule->room }}
                    </span>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="h-full min-h-[100px] border-2 border-dashed border-gray-200 dark:border-gray-700 
        bg-gray-50 dark:bg-gray-900 rounded-lg"></div>
@endif
