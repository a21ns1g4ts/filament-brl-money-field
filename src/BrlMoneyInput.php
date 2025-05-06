<?php

namespace A21ns1g4ts\FilamentBrlMoneyField;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

class BrlMoneyInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->mask(RawJs::make(<<<'JS'
                $input => {
                    let value = $input.replace(/\D/g, '');
                    value = (value / 100).toFixed(2) + '';
                    value = value.replace('.', ',');
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    return value;
                }
            JS))
            ->dehydrateStateUsing(
                fn ($state) => $state ? str_replace(',', '.', str_replace('.', '', $state)) : null
            )
            ->inputMode('decimal');
    }
}
