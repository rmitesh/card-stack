<?php

namespace Rmitesh\CardStack\Resources\Pages\Concerns;

use Filament\Pages\Actions;
use Illuminate\Support\Collection;
use Rmitesh\CardStack\Models\Card;
use Rmitesh\CardStack\Resources\CardResource;
use Rmitesh\CardStack\Pages\Widgets\CardViewList;

trait CardView
{
    public $cards = array();
    
    public $record;

    public function mount(): void
    {
        $this->cards = $this->getCards();
        
        parent::authorizeResourceAccess();
    }

    private function getCards(): Collection
    {
        return Card::select([
                'id', config('card-stack.table_column_names.cards.name'),
            ])
            ->oldest(config('card-stack.table_column_names.cards.position'))
            ->pluck(config('card-stack.table_column_names.cards.name'), 'id');
    }

	protected function getHeaderWidgets(): array
    {
        return [
            CardViewList::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('Add Card')
                ->form(CardResource::getForm())
                ->color('secondary')
                ->modalHeading('Create Card')
                ->action(function (array $data): void {

                    $data['user_id'] = auth()->id();
                    auth()->user()->cards()->create($data);

                    $this->redirect(
                        static::$resource::getUrl(
                            name: 'view',
                            params: [ 'record' => $this->record ]
                        )
                    );
                }),
        ];
    }
}