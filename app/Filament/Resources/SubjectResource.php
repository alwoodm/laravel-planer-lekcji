<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Plan Lekcji';
    protected static ?string $modelLabel = 'Przedmiot';
    protected static ?string $pluralModelLabel = 'Przedmioty';
    protected static ?string $navigationLabel = 'Przedmioty';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nazwa')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('code')
                    ->label('Kod')
                    ->required()
                    ->maxLength(10)
                    ->formatStateUsing(fn ($state) => $state ? strtoupper($state) : '')
                    ->dehydrateStateUsing(fn ($state) => $state ? strtoupper($state) : ''),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('code')
                    ->label('Kod')
                    ->formatStateUsing(fn ($state) => $state ? strtoupper($state) : '')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('schedules_count')
                    ->label('Liczba lekcji')
                    ->counts('schedules')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
