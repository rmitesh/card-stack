<?php

namespace Rmitesh\CardStack\Resources\CardResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Rmitesh\CardStack\Resources\CardResource;

class ManageCards extends ManageRecords
{
    protected static string $resource = CardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data): Model {
                    $data['user_id'] = auth()->id();
                    return static::getModel()::create($data);
                })
                ->successNotificationTitle('Card has been created.'),
        ];
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No plan cards found';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Click on "Add card" add new';
    }
}
