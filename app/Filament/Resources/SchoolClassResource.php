<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolClassResource\Pages;
use App\Filament\Resources\SchoolClassResource\RelationManagers\StudentsRelationManager;
use App\Models\SchoolClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolClassResource extends Resource
{
    protected static ?string $model = SchoolClass::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Plan Lekcji';
    protected static ?string $modelLabel = 'Klasa';
    protected static ?string $pluralModelLabel = 'Klasy';
    protected static ?string $navigationLabel = 'Klasy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nazwa')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Select::make('year_level')
                    ->label('Poziom')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                    ])
                    ->required(),
                    
                Forms\Components\TextInput::make('academic_year')
                    ->label('Rok akademicki')
                    ->placeholder('2024/2025')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('year_level')
                    ->label('Poziom')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('academic_year')
                    ->label('Rok akademicki')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('students_count')
                    ->label('Liczba uczniów')
                    ->counts('students')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchoolClasses::route('/'),
            'create' => Pages\CreateSchoolClass::route('/create'),
            'edit' => Pages\EditSchoolClass::route('/{record}/edit'),
        ];
    }
}
