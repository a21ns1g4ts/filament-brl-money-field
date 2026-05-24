<?php

use A21ns1g4ts\FilamentBrlMoneyField\BrlMoneyInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\MessageBag;
use Livewire\Component;
use Livewire\Livewire;

it('configures the Filament 5 text input for BRL money', function () {
    $input = BrlMoneyInput::make('price');

    expect($input)
        ->toBeInstanceOf(BrlMoneyInput::class)
        ->and($input->getPrefixLabel())->toBe('R$')
        ->and($input->getInputMode())->toBe('decimal')
        ->and($input->getExtraInputAttributes())->toHaveKeys([
            'x-init',
            'x-on:input',
            'x-on:blur',
        ]);
});

it('normalizes BRL money input for Filament dehydration', function (mixed $state, ?float $expected) {
    expect(BrlMoneyInput::make('price')->normalizeStateForDehydration($state))
        ->toBe($expected);
})->with([
    'empty string' => ['', null],
    'null string' => ['null', null],
    'undefined string' => ['undefined', null],
    'invalid text' => ['abc', null],
    'BRL formatted decimal' => ['1.234,56', 1234.56],
    'BRL thousands only' => ['1.234', 1234.0],
    'numeric string decimal' => ['1234.56', 1234.56],
    'float' => [1234.56, 1234.56],
]);

it('formats stored states for Filament hydration', function (mixed $state, string $expected) {
    expect(BrlMoneyInput::make('price')->formatStateForDisplay($state))
        ->toBe($expected);
})->with([
    'empty string' => ['', ''],
    'null string' => ['null', ''],
    'undefined string' => ['undefined', ''],
    'BRL formatted decimal' => ['1.234,56', '1.234,56'],
    'numeric string decimal' => ['1234.56', '1.234,56'],
    'float' => [1234.5, '1.234,50'],
]);

it('hydrates stored numeric states before the input mask runs', function () {
    Livewire::test(BrlMoneyInputFormTestComponent::class)
        ->assertSet('data.price', '34,00');
});

class BrlMoneyInputFormTestComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'price' => 34,
        ]);
    }

    public function getErrorBag()
    {
        return new MessageBag;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                BrlMoneyInput::make('price'),
            ])
            ->statePath('data');
    }

    public function render(): string
    {
        return <<<'HTML'
            <div></div>
        HTML;
    }
}

it('supports custom decimal places and dynamic decimal place fields', function () {
    $input = BrlMoneyInput::make('amount')
        ->decimalPlaces(3)
        ->decimalPlacesField(null);

    expect($input->getDecimalPlaces())
        ->toBe(3)
        ->and($input->getDecimalPlacesField())->toBe('')
        ->and($input->formatStateForDisplay(1234.5))->toBe('1.234,500');
});
