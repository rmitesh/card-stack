<?php

namespace Rmitesh\CardStack\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rmitesh\CardStack\CardStack
 */
class CardStack extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rmitesh\CardStack\CardStack::class;
    }
}
