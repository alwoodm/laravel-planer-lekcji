<?php

namespace App\Filament\Resources\SchoolClassResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';
    protected static ?string $title = 'Uczniowie';
    protected static ?string $modelLabel = 'Uczeń';
    protected static ?string $pluralModelLabel = 'Uczniowie';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Uczeń')
                    ->options(
                        User::where('role', 'student')
                            ->get()
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Imię')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Nazwisko')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dodano')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Przypisz ucznia')
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->where('role', 'student')),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Usuń z klasy'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Usuń zaznaczonych'),
                ]),
            ]);
    }
}
