<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeSlotResource\Pages;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimeSlotResource extends Resource
{
    protected static ?string $model = TimeSlot::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Plan Lekcji';
    protected static ?string $modelLabel = 'Godzina lekcyjna';
    protected static ?string $pluralModelLabel = 'Godziny lekcyjne';
    protected static ?string $navigationLabel = 'Godziny lekcyjne';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TimePicker::make('start_time')
                    ->label('Godzina rozpoczęcia')
                    ->seconds(false)
                    ->required(),
                    
                Forms\Components\TimePicker::make('end_time')
                    ->label('Godzina zakończenia')
                    ->seconds(false)
                    ->required()
                    ->after('start_time'),
                    
                Forms\Components\TextInput::make('period_number')
                    ->label('Numer lekcji')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(15),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('period_number')
            ->columns([
                Tables\Columns\TextColumn::make('period_number')
                    ->label('Numer lekcji')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Godziny')
                    ->formatStateUsing(fn (TimeSlot $record): string => $record->getFormattedTimeAttribute())
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
            'index' => Pages\ListTimeSlots::route('/'),
            'create' => Pages\CreateTimeSlot::route('/create'),
            'edit' => Pages\EditTimeSlot::route('/{record}/edit'),
        ];
    }
}
