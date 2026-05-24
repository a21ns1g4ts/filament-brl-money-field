<?php

namespace A21ns1g4ts\FilamentBrlMoneyField;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

class BrlMoneyInput extends TextInput
{
    protected int | Closure $decimalPlaces = 2;

    protected ?string $decimalPlacesField = 'data.casas_decimais';

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->prefix('R$')
            ->mask(fn () => RawJs::make(<<<JS
                \$input => {
                    let decimals = {$this->getDecimalPlaces()};
                    if (typeof \$wire !== 'undefined' && '{$this->getDecimalPlacesField()}' !== '') {
                        let dynamicDecimals = \$wire.get('{$this->getDecimalPlacesField()}');
                        if (dynamicDecimals !== undefined && dynamicDecimals !== null) {
                            decimals = parseInt(dynamicDecimals);
                        }
                    }

                    if (!\$input || \$input === 'null' || \$input === 'undefined' || \$input === '') return '';
                    let value = String(\$input).replace(/\D/g, '');
                    if (value === '') return '';

                    value = (value / Math.pow(10, decimals)).toFixed(decimals) + '';
                    value = value.replace('.', ',');

                    let parts = value.split(',');
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    return parts.join(',');
                }
            JS))
            ->dehydrateStateUsing(fn ($state) => $this->normalizeStateForDehydration($state))
            ->formatStateUsing(fn ($state) => $this->formatStateForDisplay($state))
            ->afterStateHydrated(function (BrlMoneyInput $component, $state) {
                if (blank($state) || $state === 'null' || $state === 'undefined') {
                    $component->state('');
                }
            })
            ->afterStateUpdated(function (BrlMoneyInput $component, $state) {
                if (blank($state) || $state === 'null' || $state === 'undefined') {
                    $component->state('');
                }
            })
            ->extraInputAttributes([
                'x-init' => "\$nextTick(() => { if (\$el.value === 'null' || \$el.value === 'undefined') \$el.value = '' })",
                'x-on:input' => "if (\$el.value === 'null' || \$el.value === 'undefined') \$el.value = ''",
                'x-on:blur' => "if (\$el.value === 'null' || \$el.value === 'undefined') \$el.value = ''",
            ], merge: true)
            ->inputMode('decimal');
    }

    public function decimalPlacesField(?string $field): static
    {
        $this->decimalPlacesField = $field;

        return $this;
    }

    public function getDecimalPlacesField(): string
    {
        return $this->decimalPlacesField ?? '';
    }

    public function normalizeStateForDehydration(mixed $state): ?float
    {
        if (blank($state) || $state === 'null' || $state === 'undefined') {
            return null;
        }

        if (is_string($state)) {
            $state = trim($state);

            if (str_contains($state, ',')) {
                $state = str_replace('.', '', $state);
                $state = str_replace(',', '.', $state);
            } elseif (preg_match('/^\d{1,3}(\.\d{3})+$/', $state)) {
                $state = str_replace('.', '', $state);
            }
        }

        return is_numeric($state) ? (float) $state : null;
    }

    public function formatStateForDisplay(mixed $state): string
    {
        if (blank($state) || $state === 'null' || $state === 'undefined') {
            return '';
        }

        if (is_string($state) && str_contains($state, ',')) {
            $state = str_replace('.', '', $state);
            $state = str_replace(',', '.', $state);
        }

        return number_format((float) $state, $this->getDecimalPlaces(), ',', '.');
    }

    public function decimalPlaces(int | Closure $decimalPlaces): static
    {
        $this->decimalPlaces = $decimalPlaces;

        return $this;
    }

    public function getDecimalPlaces(): int
    {
        return (int) $this->evaluate($this->decimalPlaces);
    }
}
