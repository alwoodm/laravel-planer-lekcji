<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Zarządzanie';
    protected static ?string $modelLabel = 'Użytkownik';
    protected static ?string $pluralModelLabel = 'Użytkownicy';
    protected static ?string $navigationLabel = 'Użytkownicy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('Imię')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('last_name')
                    ->label('Nazwisko')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                    
                Forms\Components\TextInput::make('password')
                    ->label('Hasło')
                    ->password()
                    ->required(fn (?User $record) => ! $record)
                    ->hiddenOn('edit')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state)),
                    
                Forms\Components\Select::make('role')
                    ->label('Rola')
                    ->options([
                        'admin' => 'Administrator',
                        'teacher' => 'Nauczyciel',
                        'student' => 'Uczeń',
                    ])
                    ->required(),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktywny')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Imię i nazwisko')
                    ->getStateUsing(function (User $record): string {
                        return "{$record->first_name} {$record->last_name}";
                    })
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('Adres email')
                    ->searchable(),
                    
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Rola')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrator',
                        'teacher' => 'Nauczyciel',
                        'student' => 'Uczeń',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'teacher',
                        'primary' => 'student',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Rola')
                    ->options([
                        'admin' => 'Administrator',
                        'teacher' => 'Nauczyciel',
                        'student' => 'Uczeń',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Wszystkie')
                    ->trueLabel('Aktywni')
                    ->falseLabel('Nieaktywni'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
