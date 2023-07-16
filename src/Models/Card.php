<?php 

namespace Rmitesh\CardStack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class Card extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guarded[] = $this->primaryKey;
        $this->table = config('card-stack.table_names.cards') ?: parent::getTable();
    }

    public static function getNextPosition(): int
    {
        $card = static::select('position')
            ->whereBelongsTo(auth()->user())
            ->latest('id')
            ->first();
        if ( $card ) {
            return $card->position + 1;
        }
        return 1;
    }

    /* Relationships */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
