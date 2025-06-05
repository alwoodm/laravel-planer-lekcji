<div class="overflow-x-auto overflow-y-hidden pb-2 relative">
    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700 shadow-lg">
        <thead>
            <tr>
                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 font-medium sticky left-0 z-10">Nr</th>
                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 font-medium sticky left-12 z-10">Godziny</th>
                @foreach ($weekDays as $day)
                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-white font-semibold bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-900">
                        {{ $polishDays[$day] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $timeSlot)
                <tr>
                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 font-bold text-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 sticky left-0 z-10">
                        {{ $timeSlot->period_number }}
                    </td>
                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 font-medium text-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 sticky left-12 z-10">
                        {{ $timeSlot->formatted_time }}
                    </td>
                    @foreach ($weekDays as $day)
                        <td class="border border-gray-200 dark:border-gray-700 p-1 min-w-[150px] md:min-w-[180px] relative">
                            @if (isset($weeklySchedule[$day][$timeSlot->id]))
                                <x-schedule-cell :schedule="$weeklySchedule[$day][$timeSlot->id]" />
                            @else
                                <div class="h-20 w-full bg-gray-50 dark:bg-gray-900 border border-dotted border-gray-300 dark:border-gray-700 rounded-sm"></div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
