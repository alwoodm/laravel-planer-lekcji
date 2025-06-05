@props(['schedule'])

<div class="h-full w-full p-2 transition-all duration-200 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md">
    <div class="font-semibold text-sm text-gray-900 dark:text-gray-100">
        {{ $schedule->subject->name }}
    </div>
    
    @if(isset($showTeacher) && $showTeacher)
        <div class="text-xs text-gray-600 dark:text-gray-400">
            {{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}
        </div>
    @endif
    
    @if(isset($showClass) && $showClass)
        <div class="text-xs text-gray-600 dark:text-gray-400">
            Klasa {{ $schedule->class->name }}
        </div>
    @endif
    
    @if($schedule->room)
        <div class="text-xs mt-1.5">
            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full px-2.5 py-0.5 inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                {{ $schedule->room }}
            </span>
        </div>
    @endif
</div>
