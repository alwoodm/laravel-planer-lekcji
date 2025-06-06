<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Plan lekcji') }} - Klasa {{ $class->name }}
            </h2>
            <div>
                <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">
                    Powrót do dashboardu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-weekly-schedule :weeklySchedule="$weeklySchedule" :timeSlots="$timeSlots" :weekDays="$weekDays" :polishDays="$polishDays" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
