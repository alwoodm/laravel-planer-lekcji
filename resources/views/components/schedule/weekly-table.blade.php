@props([
    'weeklySchedule',
    'timeSlots',
    'weekDays',
    'polishDays',
    'showTeacher' => false,
    'showClass' => false
])

<div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
    <div class="overflow-x-auto overflow-y-hidden pb-2 max-w-full">
        <table class="w-full text-sm text-left border-collapse min-w-[1000px] md:min-w-[1200px] lg:min-w-[1400px] xl:min-w-[1600px]">
            <thead class="text-xs text-white uppercase bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-800 dark:to-blue-900">
                <tr>
                    <th scope="col" class="px-4 py-3 sticky left-0 bg-blue-600 dark:bg-blue-800 z-20">
                        Nr
                    </th>
                    <th scope="col" class="px-4 py-3 sticky left-16 bg-blue-600 dark:bg-blue-800 z-20 whitespace-nowrap">
                        Godziny
                    </th>
                    @foreach ($weekDays as $day)
                        <th scope="col" class="px-4 py-3 text-center min-w-[180px] md:min-w-[220px] lg:min-w-[250px] xl:min-w-[300px]">
                            {{ $polishDays[$day] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSlots as $timeSlot)
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <td class="px-4 py-2 sticky left-0 bg-gray-100 dark:bg-gray-800 font-medium z-10">
                            {{ $timeSlot->period_number }}
                        </td>
                        <td class="px-4 py-2 sticky left-16 bg-gray-100 dark:bg-gray-800 whitespace-nowrap z-10">
                            {{ $timeSlot->getFormattedTimeAttribute() }}
                        </td>
                        @foreach ($weekDays as $day)
                            <td class="p-2">
                                <x-schedule.lesson-cell 
                                    :schedule="$weeklySchedule[$day][$timeSlot->id] ?? null"
                                    :showTeacher="$showTeacher"
                                    :showClass="$showClass"
                                    class="w-full h-full"
                                />
                            </td>
                        @endforeach
                    </tr>
                @endforeach
        </tbody>
    </table>
</div>
