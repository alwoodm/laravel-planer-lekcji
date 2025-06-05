<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function beforeCreate(): void
    {
        $data = $this->form->getState();
        
        if (Schedule::hasConflict($data['user_id'], $data['time_slot_id'], $data['day_of_week'])) {
            Notification::make()
                ->title('Wykryto konflikt w planie')
                ->body('Nauczyciel ma już zaplanowane zajęcia w tym terminie.')
                ->danger()
                ->send();
            
            $this->halt();
        }
    }
}
