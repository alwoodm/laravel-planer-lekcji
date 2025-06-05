<div class="w-full">
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full border-collapse border border-gray-300 min-w-[1000px]">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700">Nr</th>
                    <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700">Godziny</th>
                    @foreach ($weekDays as $day)
                        <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700 min-w-[180px]">{{ $polishDays[$day] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSlots as $timeSlot)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold text-center bg-gray-50 dark:bg-gray-800">
                            {{ $timeSlot->period_number }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 font-medium text-center bg-gray-50 dark:bg-gray-800">
                            {{ $timeSlot->formatted_time }}
                        </td>
                        @foreach ($weekDays as $day)
                            <td class="border border-gray-300 p-1">
                                @if (isset($weeklySchedule[$day][$timeSlot->id]))
                                    <div class="h-full w-full p-2 bg-white border rounded-sm shadow-sm">
                                        <div class="font-semibold text-sm">{{ $weeklySchedule[$day][$timeSlot->id]->subject->name }}</div>
                                        <div class="text-xs text-gray-600">{{ $weeklySchedule[$day][$timeSlot->id]->teacher->first_name }} {{ $weeklySchedule[$day][$timeSlot->id]->teacher->last_name }}</div>
                                        @if($weeklySchedule[$day][$timeSlot->id]->room)
                                            <div class="text-xs bg-blue-100 text-blue-800 rounded-full px-2 py-1 mt-1 inline-block">
                                                Sala {{ $weeklySchedule[$day][$timeSlot->id]->room }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="h-16 w-full"></div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-right">
        <a href="{{ route('schedules.class', $class->id) }}" class="text-blue-600 hover:text-blue-800 underline">
            Pełny plan lekcji
        </a>
    </div>
</div>
