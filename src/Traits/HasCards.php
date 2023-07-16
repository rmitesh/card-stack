<?php

namespace Rmitesh\CardStack\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCards
{
	public static function bootHasCards(): void
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->cards()->delete();
        });
    }

	public function cards(): HasMany
	{
	    return $this->hasMany(
	    	config('card-stack.models.card'),
	    	config('card-stack.table_column_names.user_id'),
	    	'id'
	    );
	}
}