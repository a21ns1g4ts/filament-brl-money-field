<?php

use A21ns1g4ts\FilamentBrlMoneyField\FilamentBrlMoneyFieldPlugin;
use Filament\Panel;

it('exposes the Filament plugin id', function () {
    expect(FilamentBrlMoneyFieldPlugin::make()->getId())
        ->toBe('filament-brl-money-field');
});

it('registers and boots against a Filament 5 panel', function () {
    $panel = Panel::make()->id('admin');
    $plugin = FilamentBrlMoneyFieldPlugin::make();

    $plugin->register($panel);
    $plugin->boot($panel);

    expect($panel->getResources())->toBe([]);
});
