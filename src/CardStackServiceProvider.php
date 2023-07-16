<?php

namespace Rmitesh\CardStack;

use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Rmitesh\CardStack\Commands\CardStackCommand;
use Rmitesh\CardStack\Resources\CardResource;
use Rmitesh\CardStack\View\Components\CardView;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CardStackServiceProvider extends PackageServiceProvider
{
    protected array $resources = [
        CardResource::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'card-stack');

        Livewire::component('card-view-list', 'Rmitesh\\CardStack\\Pages\\Widgets\\CardViewList');
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('card-stack')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_cards_table')
            ->hasCommand(CardStackCommand::class)
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
}
