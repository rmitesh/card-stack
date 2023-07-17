<?php

namespace Rmitesh\CardStack;

use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Rmitesh\CardStack\Resources\CardResource;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

class CardStackServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        CardResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('card-stack')
            ->hasConfigFile()
            ->hasViews('card-stack')
            ->hasMigration('create_cards_table')
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('rmitesh/card-stack')
                    ->endWith(function(InstallCommand $command) {
                        $command->info('Make some awesome, happy coding!');
                    });
            });
    }

    public function packageBooted(): void
    {
        parent::packageBooted();
        
        Livewire::component('card-view-list', 'Rmitesh\\CardStack\\Pages\\Widgets\\CardViewList');
    }
}
