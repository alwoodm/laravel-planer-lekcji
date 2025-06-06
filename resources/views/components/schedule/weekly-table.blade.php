@props([
    'weeklySchedule',
    'timeSlots',
    'weekDays',
    'polishDays',
    'showTeacher' => false,
    'showClass' => false
])

<div class="relative overflow-hidden shadow-md sm:rounded-lg w-full">
    <div class="overflow-x-auto md:overflow-x-visible pb-2">
        <table class="w-full text-sm text-left border-collapse lg:table-fixed">
            <thead class="text-xs text-white uppercase bg-blue-600 dark:bg-blue-800">
                <tr>
                    <th scope="col" class="px-3 py-3 sticky left-0 bg-blue-600 dark:bg-blue-800 z-20 w-8">
                        Nr
                    </th>
                    <th scope="col" class="px-3 py-3 sticky left-12 bg-blue-600 dark:bg-blue-800 z-20 whitespace-nowrap w-20">
                        Godziny
                    </th>
                    @foreach ($weekDays as $day)
                        <th scope="col" class="px-2 py-3 text-center w-[18%] bg-blue-600 dark:bg-blue-800 font-bold">
                            {{ $polishDays[$day] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSlots as $timeSlot)
                    <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <td class="px-3 py-2 sticky left-0 bg-gray-100 dark:bg-gray-800 font-medium z-10 w-8 text-center text-gray-900 dark:text-gray-100">
                            {{ $timeSlot->period_number }}
                        </td>
                        <td class="px-3 py-2 sticky left-12 bg-gray-100 dark:bg-gray-800 whitespace-nowrap z-10 w-20 text-gray-900 dark:text-gray-100">
                            {{ $timeSlot->getFormattedTimeAttribute() }}
                        </td>
                        @foreach ($weekDays as $day)
                            <td class="p-2 h-[80px] md:h-[100px] lg:h-[120px]">
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
</div>
