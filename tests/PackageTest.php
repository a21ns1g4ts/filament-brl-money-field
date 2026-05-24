<?php

use A21ns1g4ts\FilamentBrlMoneyField\Facades\FilamentBrlMoneyField as FilamentBrlMoneyFieldFacade;
use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyField;
use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyFieldServiceProvider;

it('resolves the package facade root', function () {
    expect(FilamentBrlMoneyFieldFacade::getFacadeRoot())
        ->toBeInstanceOf(FilamentBrlMoneyField::class);
});

it('runs the package command', function () {
    $this->artisan('filament-brl-money-field')
        ->expectsOutput('All done')
        ->assertExitCode(0);
});

it('exposes service provider package metadata', function () {
    expect(FilamentBrlMoneyFieldServiceProvider::$name)
        ->toBe('filament-brl-money-field')
        ->and(FilamentBrlMoneyFieldServiceProvider::$viewNamespace)
        ->toBe('filament-brl-money-field');
});
