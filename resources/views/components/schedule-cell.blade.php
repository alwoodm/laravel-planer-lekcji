@php
    // Mapowanie przedmiotów na klasy kolorów
    $subjectColorMap = [
        'Matematyka' => [
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'hover' => 'hover:bg-blue-100 dark:hover:bg-blue-800/30'
        ],
        'MAT' => [
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'hover' => 'hover:bg-blue-100 dark:hover:bg-blue-800/30'
        ],
        'Polski' => [
            'border' => 'border-green-500',
            'bg' => 'bg-green-50 dark:bg-green-900/20',
            'hover' => 'hover:bg-green-100 dark:hover:bg-green-800/30'
        ],
        'POL' => [
            'border' => 'border-green-500',
            'bg' => 'bg-green-50 dark:bg-green-900/20',
            'hover' => 'hover:bg-green-100 dark:hover:bg-green-800/30'
        ],
        'Angielski' => [
            'border' => 'border-purple-500',
            'bg' => 'bg-purple-50 dark:bg-purple-900/20',
            'hover' => 'hover:bg-purple-100 dark:hover:bg-purple-800/30'
        ],
        'ANG' => [
            'border' => 'border-purple-500',
            'bg' => 'bg-purple-50 dark:bg-purple-900/20',
            'hover' => 'hover:bg-purple-100 dark:hover:bg-purple-800/30'
        ],
        'Historia' => [
            'border' => 'border-yellow-500',
            'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
            'hover' => 'hover:bg-yellow-100 dark:hover:bg-yellow-800/30'
        ],
        'HIST' => [
            'border' => 'border-yellow-500',
            'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
            'hover' => 'hover:bg-yellow-100 dark:hover:bg-yellow-800/30'
        ],
        'Geografia' => [
            'border' => 'border-orange-500',
            'bg' => 'bg-orange-50 dark:bg-orange-900/20',
            'hover' => 'hover:bg-orange-100 dark:hover:bg-orange-800/30'
        ],
        'GEO' => [
            'border' => 'border-orange-500',
            'bg' => 'bg-orange-50 dark:bg-orange-900/20',
            'hover' => 'hover:bg-orange-100 dark:hover:bg-orange-800/30'
        ],
        'Biologia' => [
            'border' => 'border-lime-500',
            'bg' => 'bg-lime-50 dark:bg-lime-900/20',
            'hover' => 'hover:bg-lime-100 dark:hover:bg-lime-800/30'
        ],
        'BIO' => [
            'border' => 'border-lime-500',
            'bg' => 'bg-lime-50 dark:bg-lime-900/20',
            'hover' => 'hover:bg-lime-100 dark:hover:bg-lime-800/30'
        ],
        'Fizyka' => [
            'border' => 'border-pink-500',
            'bg' => 'bg-pink-50 dark:bg-pink-900/20',
            'hover' => 'hover:bg-pink-100 dark:hover:bg-pink-800/30'
        ],
        'FIZ' => [
            'border' => 'border-pink-500',
            'bg' => 'bg-pink-50 dark:bg-pink-900/20',
            'hover' => 'hover:bg-pink-100 dark:hover:bg-pink-800/30'
        ],
        'Chemia' => [
            'border' => 'border-cyan-500',
            'bg' => 'bg-cyan-50 dark:bg-cyan-900/20',
            'hover' => 'hover:bg-cyan-100 dark:hover:bg-cyan-800/30'
        ],
        'CHEM' => [
            'border' => 'border-cyan-500',
            'bg' => 'bg-cyan-50 dark:bg-cyan-900/20',
            'hover' => 'hover:bg-cyan-100 dark:hover:bg-cyan-800/30'
        ],
    ];
    
    // Pobierz klasy koloru dla przedmiotu lub domyślne kolory
    $subjectName = $schedule->subject->name;
    $subjectCode = $schedule->subject->code;
    
    $colorScheme = $subjectColorMap[$subjectName] ?? $subjectColorMap[$subjectCode] ?? [
        'border' => 'border-gray-300',
        'bg' => 'bg-white dark:bg-gray-700',
        'hover' => 'hover:bg-gray-50 dark:hover:bg-gray-600'
    ];
@endphp

<div class="group h-full w-full">
    <div class="h-full p-3 border rounded-lg shadow-sm border-l-4 {{ $colorScheme['border'] }} {{ $colorScheme['bg'] }} {{ $colorScheme['hover'] }} transition-all duration-200">
        <div class="flex flex-col h-full">
            <div class="font-semibold text-sm text-gray-900 dark:text-gray-100 mb-1">
                {{ $schedule->subject->name }}
            </div>
            
            <div class="flex-grow">
                @if(isset($showTeacher) && $showTeacher)
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        <span class="inline-block align-middle mr-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        {{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}
                    </div>
                @endif
                
                @if(isset($showClass) && $showClass)
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        <span class="inline-block align-middle mr-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </span>
                        Klasa {{ $schedule->class->name }}
                    </div>
                @endif
            </div>
            
            @if($schedule->room)
                <div class="text-xs mt-2">
                    <span class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-full px-2.5 py-0.5 inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $schedule->room }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>
