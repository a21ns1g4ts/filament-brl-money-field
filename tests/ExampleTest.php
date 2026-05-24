<?php

use A21ns1g4ts\FilamentBrlMoneyField\BrlMoneyInput;
use A21ns1g4ts\FilamentBrlMoneyField\Commands\FilamentBrlMoneyFieldCommand;
use A21ns1g4ts\FilamentBrlMoneyField\Facades\FilamentBrlMoneyField as FilamentBrlMoneyFieldFacade;
use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyField;
use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyFieldPlugin;
use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyFieldServiceProvider;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;

it('can instantiate the BRL money input', function () {
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

it('normalizes BRL money input for dehydration', function (mixed $state, ?float $expected) {
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

it('uses the dehydration callback configured on the field', function () {
    $input = BrlMoneyInput::make('price')->statePath('price');

    expect($input->getStateToDehydrate('1.234,56'))
        ->toBe(['price' => 1234.56]);
});

it('formats states for display', function (mixed $state, string $expected) {
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

it('allows decimal places and decimal places field to be customized', function () {
    $input = BrlMoneyInput::make('amount')
        ->decimalPlaces(3)
        ->decimalPlacesField(null);

    expect($input->getDecimalPlaces())
        ->toBe(3)
        ->and($input->getDecimalPlacesField())->toBe('')
        ->and($input->formatStateForDisplay(1234.5))->toBe('1.234,500');
});

it('exposes the filament plugin id', function () {
    $plugin = FilamentBrlMoneyFieldPlugin::make();

    expect($plugin->getId())
        ->toBe('filament-brl-money-field');
});

it('registers and boots the filament plugin against a panel', function () {
    $panel = Panel::make()->id('admin');
    $plugin = FilamentBrlMoneyFieldPlugin::make();

    $plugin->register($panel);
    $plugin->boot($panel);

    expect($panel->getResources())->toBe([]);
});

it('resolves the facade root', function () {
    expect(FilamentBrlMoneyFieldFacade::getFacadeRoot())
        ->toBeInstanceOf(FilamentBrlMoneyField::class);
});

it('runs the package command', function () {
    $this->artisan('filament-brl-money-field')
        ->expectsOutput('All done')
        ->assertExitCode(0);
});

it('exposes service provider package metadata', function () {
    $provider = new class(app()) extends FilamentBrlMoneyFieldServiceProvider
    {
        public function assetPackageName(): ?string
        {
            return $this->getAssetPackageName();
        }

        public function assets(): array
        {
            return $this->getAssets();
        }

        public function commands(): array
        {
            return $this->getCommands();
        }

        public function icons(): array
        {
            return $this->getIcons();
        }

        public function routes(): array
        {
            return $this->getRoutes();
        }

        public function scriptData(): array
        {
            return $this->getScriptData();
        }

        public function migrations(): array
        {
            return $this->getMigrations();
        }
    };

    expect($provider->assetPackageName())
        ->toBe('a21ns1g4ts/filament-brl-money-field')
        ->and($provider->commands())->toBe([FilamentBrlMoneyFieldCommand::class])
        ->and($provider->icons())->toBe([])
        ->and($provider->routes())->toBe([])
        ->and($provider->scriptData())->toBe([])
        ->and($provider->migrations())->toBe([])
        ->and($provider->assets())
        ->toHaveCount(2)
        ->sequence(
            fn ($asset) => $asset->toBeInstanceOf(Css::class),
            fn ($asset) => $asset->toBeInstanceOf(Js::class),
        );
});
