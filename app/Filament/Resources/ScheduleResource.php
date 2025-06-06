<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Plan Lekcji';
    protected static ?string $modelLabel = 'Plan lekcji';
    protected static ?string $pluralModelLabel = 'Plany lekcji';
    protected static ?string $navigationLabel = 'Plan lekcji';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_id')
                    ->label('Klasa')
                    ->relationship('class', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                    
                Forms\Components\Select::make('subject_id')
                    ->label('Przedmiot')
                    ->relationship('subject', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                    
                Forms\Components\Select::make('user_id')
                    ->label('Nauczyciel')
                    ->options(function () {
                        return User::where('role', 'teacher')->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->preload()
                    ->searchable()
                    ->required(),
                    
                Forms\Components\Select::make('time_slot_id')
                    ->label('Godzina lekcyjna')
                    ->relationship('timeSlot', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getFormattedTimeAttribute())
                    ->preload()
                    ->searchable()
                    ->required(),
                    
                Forms\Components\Select::make('day_of_week')
                    ->label('Dzień tygodnia')
                    ->options([
                        'Monday' => 'Poniedziałek',
                        'Tuesday' => 'Wtorek',
                        'Wednesday' => 'Środa',
                        'Thursday' => 'Czwartek',
                        'Friday' => 'Piątek',
                    ])
                    ->required(),
                    
                Forms\Components\TextInput::make('room')
                    ->label('Sala')
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('class.name')
                    ->label('Klasa')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Przedmiot')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Nauczyciel')
                    ->formatStateUsing(fn ($record) => "{$record->teacher->first_name} {$record->teacher->last_name}")
                    ->sortable(['users.first_name', 'users.last_name'])
                    ->searchable(['users.first_name', 'users.last_name']),
                    
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('Dzień tygodnia')
                    ->formatStateUsing(function (string $state): string {
                        $polishDays = [
                            'Monday' => 'Poniedziałek',
                            'Tuesday' => 'Wtorek',
                            'Wednesday' => 'Środa',
                            'Thursday' => 'Czwartek',
                            'Friday' => 'Piątek'
                        ];
                        return $polishDays[$state] ?? $state;
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('timeSlot.period_number')
                    ->label('Lekcja')
                    ->sortable()
                    ->numeric(),
                    
                Tables\Columns\TextColumn::make('timeSlot.id')
                    ->label('Godziny')
                    ->formatStateUsing(fn ($record) => $record->timeSlot ? $record->timeSlot->getFormattedTimeAttribute() : '')
                    ->sortable(
                        query: fn ($query, $direction) => $query->join('time_slots', 'schedules.time_slot_id', '=', 'time_slots.id')
                            ->orderBy('time_slots.start_time', $direction)
                    ),
                    
                Tables\Columns\TextColumn::make('room')
                    ->label('Sala')
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->label('Klasa')
                    ->relationship('class', 'name')
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\SelectFilter::make('subject')
                    ->label('Przedmiot')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Nauczyciel')
                    ->options(function () {
                        $teachers = User::where('role', 'teacher')->get();
                        $options = [];
                        
                        foreach ($teachers as $teacher) {
                            $options[$teacher->id] = "{$teacher->first_name} {$teacher->last_name}";
                        }
                        
                        return $options;
                    }),
                    
                Tables\Filters\SelectFilter::make('day_of_week')
                    ->label('Dzień tygodnia')
                    ->options([
                        'Monday' => 'Poniedziałek',
                        'Tuesday' => 'Wtorek',
                        'Wednesday' => 'Środa',
                        'Thursday' => 'Czwartek',
                        'Friday' => 'Piątek',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
