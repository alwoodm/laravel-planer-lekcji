<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function beforeSave(): void
    {
        $data = $this->form->getState();
        
        if (Schedule::hasConflict($data['user_id'], $data['time_slot_id'], $data['day_of_week'], $this->record->id)) {
            Notification::make()
                ->title('Wykryto konflikt w planie')
                ->body('Nauczyciel ma już zaplanowane zajęcia w tym terminie.')
                ->danger()
                ->send();
                
            $this->halt();
        }
    }
}
