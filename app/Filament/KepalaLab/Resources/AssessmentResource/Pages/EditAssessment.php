<?php

namespace App\Filament\KepalaLab\Resources\AssessmentResource\Pages;

use App\Filament\KepalaLab\Resources\AssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssessment extends EditRecord
{
    protected static string $resource = AssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
