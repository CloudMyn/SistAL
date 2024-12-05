<?php

namespace App\Filament\KepalaLab\Resources\ScheduleResource\Pages;

use App\Filament\KepalaLab\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchedules extends ListRecords
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}