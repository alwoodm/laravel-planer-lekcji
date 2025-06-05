<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} - {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->isAdmin())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <x-stats-card title="Nauczyciele" value="{{ $stats['teachers'] }}" icon="users" />
                    <x-stats-card title="Uczniowie" value="{{ $stats['students'] }}" icon="users" />
                    <x-stats-card title="Klasy" value="{{ $stats['classes'] }}" icon="academic-cap" />
                    <x-stats-card title="Przedmioty" value="{{ $stats['subjects'] }}" icon="book-open" />
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Panel administracyjny') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="{{ route('filament.admin.resources.users.index') }}" class="bg-blue-600 text-white rounded-lg p-4 hover:bg-blue-700">
                                <div class="font-semibold text-lg">Zarządzaj użytkownikami</div>
                                <div class="text-sm">Dodawaj, edytuj i usuwaj użytkowników</div>
                            </a>
                            <a href="{{ route('filament.admin.resources.school-classes.index') }}" class="bg-blue-600 text-white rounded-lg p-4 hover:bg-blue-700">
                                <div class="font-semibold text-lg">Zarządzaj klasami</div>
                                <div class="text-sm">Dodawaj, edytuj i usuwaj klasy</div>
                            </a>
                            <a href="{{ route('filament.admin.resources.schedules.index') }}" class="bg-blue-600 text-white rounded-lg p-4 hover:bg-blue-700">
                                <div class="font-semibold text-lg">Zarządzaj planem lekcji</div>
                                <div class="text-sm">Twórz i edytuj plany lekcji</div>
                            </a>
                            <a href="{{ route('filament.admin.resources.subjects.index') }}" class="bg-blue-600 text-white rounded-lg p-4 hover:bg-blue-700">
                                <div class="font-semibold text-lg">Zarządzaj przedmiotami</div>
                                <div class="text-sm">Dodawaj i edytuj przedmioty</div>
                            </a>
                            <a href="{{ route('filament.admin.resources.time-slots.index') }}" class="bg-blue-600 text-white rounded-lg p-4 hover:bg-blue-700">
                                <div class="font-semibold text-lg">Zarządzaj godzinami lekcji</div>
                                <div class="text-sm">Konfiguruj godziny lekcyjne</div>
                            </a>
                        </div>
                    </div>
                </div>
            @elseif(auth()->user()->isTeacher())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ __('Mój plan lekcji') }}</h3>
                        </div>
                        @if(isset($teacher) && isset($weeklySchedule))
                            <x-weekly-schedule :weeklySchedule="$weeklySchedule" :timeSlots="$timeSlots" :weekDays="$weekDays" :polishDays="$polishDays" />
                        @else
                            <div class="text-center py-4">
                                <p>Nie masz jeszcze przypisanych lekcji w planie.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif(auth()->user()->isStudent())
                @if(isset($noClass) && $noClass)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="text-center py-4">
                                <div class="text-xl font-medium mb-2">Nie jesteś przypisany do żadnej klasy</div>
                                <p class="text-gray-500">Skontaktuj się z administratorem w celu przypisania do klasy.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">{{ __('Plan lekcji klasy') }} @if(isset($class)) {{ $class->name }} @endif</h3>
                            </div>
                            @if(isset($class) && isset($weeklySchedule))
                                <x-weekly-schedule :weeklySchedule="$weeklySchedule" :timeSlots="$timeSlots" :weekDays="$weekDays" :polishDays="$polishDays" />
                            @else
                                <div class="text-center py-4">
                                    <p>Twoja klasa nie ma jeszcze zdefiniowanego planu lekcji.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
