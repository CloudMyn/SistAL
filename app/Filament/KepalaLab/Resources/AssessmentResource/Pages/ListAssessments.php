<?php

namespace App\Filament\KepalaLab\Resources\AssessmentResource\Pages;

use App\Filament\KepalaLab\Resources\AssessmentResource;
use App\Filament\Resources\AssesstmentResource\Widgets\AssestmentChart;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssessments extends ListRecords
{
    protected static string $resource = AssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            AssestmentChart::class
        ];
    }
}
