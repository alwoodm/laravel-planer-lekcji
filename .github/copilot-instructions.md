# GitHub Copilot Instructions - System Zarządzania Planem Lekcji

## Kontekst Projektu
Tworzysz system zarządzania planem lekcji dla szkół średnich w Polsce. System ma obsługiwać:
- Tworzenie i zarządzanie użytkownikami (administratorzy, nauczyciele, uczniowie)
- Zarządzanie klasami, przedmiotami i godzinami lekcyjnymi
- Tworzenie planów lekcji z wykrywaniem konfliktów
- Widoki tygodniowe dla klas i nauczycieli
- Panel administracyjny dla zarządzania systemem

## Stack Technologiczny
- **Backend**: Laravel 12
- **Frontend**: Blade templates + Tailwind CSS
- **Baza danych**: SQLite
- **Admin Panel**: Filament v3 (/admin)
- **Uwierzytelnianie**: Laravel Breeze
- **CSS Framework**: Tailwind CSS
- **Język**: Polski (UI, komentarze, nazwy zmiennych w języku angielskim)

## Struktura Bazy Danych

### Tabele Główne:

users: id, name, email, password, role(enum: admin,teacher,student), first_name, last_name, timestamps
classes: id, name, year_level, academic_year, timestamps
subjects: id, name, code, timestamps
time_slots: id, start_time, end_time, period_number, timestamps
schedules: id, class_id, subject_id, user_id(teacher), time_slot_id, day_of_week, room, timestamps
student_class_assignments: user_id, class_id, timestamps

text

### Relacje:
- User hasMany Schedule (jako nauczyciel)
- User belongsToMany Classes (jako uczeń)
- Schedule belongsTo User, Class, Subject, TimeSlot
- Class hasMany Schedule, belongsToMany Users (uczniowie)

## Konwencje Kodowania

### Nazewnictwo:
- **Modele**: PascalCase (User, SchoolClass, TimeSlot)
- **Kontrolery**: PascalCase + Controller (ScheduleController)
- **Metody**: camelCase (showMySchedule, hasConflict)
- **Zmienne**: camelCase ($weeklySchedule, $timeSlots)
- **Tabele**: snake_case liczba mnoga (time_slots, student_class_assignments)
- **Kolumny**: snake_case (first_name, day_of_week)

### Struktura Plików:

app/
├── Http/Controllers/
│ ├── DashboardController.php
│ ├── ScheduleController.php
│ └── AdminController.php
├── Models/
│ ├── User.php
│ ├── SchoolClass.php
│ ├── Subject.php
│ ├── TimeSlot.php
│ └── Schedule.php
└── Filament/Resources/
├── UserResource.php
├── SchoolClassResource.php
└── ...

text

## Wzorce i Najlepsze Praktyki

### Laravel:
- Używaj Eloquent relationships zamiast raw queries
- Eager loading dla relacji (with())
- Form Request Validation dla złożonych walidacji
- Resource Controllers dla RESTful operations
- Middleware dla autoryzacji ról
- Seeders dla danych testowych

### Filament:
- Resources dla zarządzania danymi
- Relation Managers dla related data
- Form components z proper validation
- Table filters i search
- Custom Pages tylko gdy konieczne
- Polish translations w resource labels

### Blade:
- Components dla reusable elements
- Layouts dla consistent structure  
- @csrf w każdym formularzu
- Proper escaping {{ }} vs {!! !!}
- Conditional rendering @if/@auth/@role

### Bezpieczeństwo:
- Role-based access control (admin, teacher, student)
- Middleware protection na sensitive routes
- Validation wszystkich inputs
- CSRF protection
- SQL injection prevention przez Eloquent

## Specyficzne Wymagania

### Dni Tygodnia:
Używaj zawsze enum: 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'

$weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$polishDays = [
'Monday' => 'Poniedziałek',
'Tuesday' => 'Wtorek',
'Wednesday' => 'Środa',
'Thursday' => 'Czwartek',
'Friday' => 'Piątek'
];

text

### Wykrywanie Konfliktów:

// Zawsze sprawdzaj konflikty przed zapisem
Schedule::hasConflict($teacherId, $timeSlotId, $dayOfWeek, $excludeId);

text

### Format Czasu:
- start_time/end_time jako TIME w bazie
- Wyświetlanie: "08:00 - 08:45"
- Period numbers: 1-7 (standardowe godziny lekcyjne)

### Role System:

// Helper methods w User model
public function isAdmin(): bool
public function isTeacher(): bool
public function isStudent(): bool

// Middleware usage
Route::middleware(['auth', 'role:admin'])->group(...)

text

## UI/UX Guidelines

### Responsive Design:
- Mobile-first approach
- Tabele z overflow-x-auto
- Grid layout dla kart i statystyk
- Responsive navigation

### Kolorystyka:
- Primary: Blue (Tailwind blue-600)
- Success: Green (green-500)
- Warning: Yellow (yellow-500)
- Error: Red (red-500)
- Neutral: Gray (gray-100, gray-600)

### Komponenty:
- Karty: bg-white rounded-lg shadow p-6
- Przyciski: consistent padding px-4 py-2 rounded
- Tabele: border-collapse border border-gray-300
- Flash messages: colored backgrounds z border

## Polish Localization

### Terminy:
- Plan lekcji = Schedule
- Klasa = Class
- Przedmiot = Subject  
- Nauczyciel = Teacher
- Uczeń = Student
- Godzina lekcyjna = Time Slot
- Sala = Room

### Labels w Filament:

protected static ?string $modelLabel = 'Użytkownik';
protected static ?string $pluralModelLabel = 'Użytkownicy';
protected static ?string $navigationLabel = 'Użytkownicy';

text

## Error Handling

### Validation Messages:

'class_id.required' => 'Klasa jest wymagana',
'subject_id.exists' => 'Wybrany przedmiot nie istnieje',
'conflict' => 'Konflikt w planie - nauczyciel ma już lekcję w tym czasie'

text

### Try-Catch:

try {
// Database operations
} catch (\Exception $e) {
return back()->withErrors(['error' => 'Wystąpił błąd: ' . $e->getMessage()]);
}

text

## Testing Considerations
- Factory definitions dla wszystkich modeli
- Feature tests dla kluczowych flows
- Unit tests dla konfliktów i business logic
- Database rollback między testami

## Performance Guidelines
- Indexy na foreign keys i często używanych polach
- Eager loading dla związanych danych
- Pagination dla długich list
- Cache dla statycznych danych (subjects, time_slots)

---

Zawsze kieruj się tymi instrukcjami przy generowaniu kodu. W przypadku wątpliwości, wybieraj rozwiązania zgodne z Laravel best practices i Keep It Simple principle.