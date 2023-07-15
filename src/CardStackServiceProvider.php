<?php

namespace Rmitesh\CardStack;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rmitesh\CardStack\Commands\CardStackCommand;

class CardStackServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('card-stack')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_card_stack_table')
            ->hasCommand(CardStackCommand::class);
    }
}
