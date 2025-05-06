<?php

namespace A21ns1g4ts\FilamentBrlMoneyField\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyField
 */
class FilamentBrlMoneyField extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyField::class;
    }
}
