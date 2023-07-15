<?php 

namespace Rmitesh\CardStack\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guarded[] = $this->primaryKey;
        $this->table = config('card-stack.table_names.cards') ?: parent::getTable();
    }
}