<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }} - {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </h2>
            <x-theme-toggle />
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(auth()->user()->isAdmin())
            <!-- Admin Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <x-stats-card title="Nauczyciele" :value="$stats['teachers']" icon="users" />
                <x-stats-card title="Uczniowie" :value="$stats['students']" icon="users" />
                <x-stats-card title="Klasy" :value="$stats['classes']" icon="academic-cap" />
                <x-stats-card title="Przedmioty" :value="$stats['subjects']" icon="book-open" />
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('Panel administracyjny') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Admin Quick Links -->
                        @foreach(['users' => 'Użytkownicy', 'classes' => 'Klasy', 'subjects' => 'Przedmioty', 'schedules' => 'Plan Lekcji', 'time-slots' => 'Godziny Lekcyjne'] as $resource => $label)
                            <a href="{{ route('filament.admin.resources.'.$resource.'.index') }}" 
                               class="block p-4 rounded-lg bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                <div class="text-lg font-semibold text-white">{{ $label }}</div>
                                <div class="text-sm text-blue-100">Zarządzaj zasobem</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        @elseif(auth()->user()->isTeacher())
            <!-- Teacher Schedule -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Mój Plan Lekcji') }}</h3>
                    </div>
                    @if(isset($weeklySchedule))
                        <x-schedule.weekly-table 
                            :weeklySchedule="$weeklySchedule"
                            :timeSlots="$timeSlots"
                            :weekDays="$weekDays"
                            :polishDays="$polishDays"
                            :showClass="true"
                        />
                    @else
                        <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                            <p class="mb-2">Nie masz jeszcze przypisanych lekcji w planie.</p>
                            <p class="text-sm">Skontaktuj się z administratorem systemu.</p>
                        </div>
                    @endif
                </div>
            </div>

        @else
            <!-- Student Schedule -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Plan Lekcji - Klasa {{ isset($class) ? $class->name : 'Brak przypisanej klasy' }}
                        </h3>
                    </div>
                    @if(isset($weeklySchedule))
                        <x-schedule.weekly-table 
                            :weeklySchedule="$weeklySchedule"
                            :timeSlots="$timeSlots"
                            :weekDays="$weekDays"
                            :polishDays="$polishDays"
                            :showTeacher="true"
                        />
                    @else
                        <div class="text-center py-8 text-gray-600 dark:text-gray-400">
                            <p class="mb-2">Nie jesteś przypisany do żadnej klasy.</p>
                            <p class="text-sm">Skontaktuj się z administratorem systemu.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
