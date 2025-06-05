<div class="h-full w-full p-2 bg-white border rounded-sm shadow-sm">
    <div class="font-semibold text-sm">{{ $schedule->subject->name }}</div>
    @if(isset($showTeacher) && $showTeacher)
        <div class="text-xs text-gray-600">{{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}</div>
    @endif
    @if(isset($showClass) && $showClass)
        <div class="text-xs text-gray-600">{{ $schedule->class->name }}</div>
    @endif
    @if($schedule->room)
        <div class="text-xs bg-blue-100 text-blue-800 rounded-full px-2 py-1 mt-1 inline-block">
            Sala {{ $schedule->room }}
        </div>
    @endif
</div>
