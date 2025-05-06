<?php

namespace A21ns1g4ts\FilamentBrlMoneyField;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentBrlMoneyFieldPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-brl-money-field';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
