<div class="overflow-x-auto">
    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700">Nr</th>
                <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700">Godziny</th>
                @foreach ($weekDays as $day)
                    <th class="border border-gray-300 px-4 py-2 bg-gray-100 dark:bg-gray-700">{{ $polishDays[$day] }}</th>
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
                                <x-schedule-cell :schedule="$weeklySchedule[$day][$timeSlot->id]" />
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
