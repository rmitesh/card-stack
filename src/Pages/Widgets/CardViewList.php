<?php

namespace Rmitesh\CardStack\Pages\Widgets;

use App\Models\Project;
use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Widgets\TableWidget as PageWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rmitesh\CardStack\Models\Card;

class CardViewList extends PageWidget
{    
	public $tableHeading;

	public $tableHeadingId;

	public $record;

	public $card;

	public function mount(): void
	{
	    $card = Card::findOrFail($this->record);

	    $this->card = $card;
	}

	protected function getTableHeading(): string | Htmlable | Closure | null
	{
	    return $this->tableHeading;
	}

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No items found';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Click on "Add Item" add new';
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
        	// 
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            //
        ];
    }
}