# Filament Card Stack

![Black Flatlay Photo Motivational Finance Quote Facebook Cover (1)](https://github.com/rmitesh/card-stack/assets/48554454/e114a6e4-adee-4951-85a8-7bae1c8344e7)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rmitesh/card-stack.svg?style=flat-square)](https://packagist.org/packages/rmitesh/card-stack)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/rmitesh/card-stack/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/rmitesh/card-stack/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rmitesh/card-stack/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/rmitesh/card-stack/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rmitesh/card-stack.svg?style=flat-square)](https://packagist.org/packages/rmitesh/card-stack)

Design for Multi-purpose usage, and also second option of the KanBan Board

Want to see how it's works...? Let's go though below details

## Installation

You can install the package via composer:

```bash
composer require rmitesh/card-stack
```
You can publish the config file with:

```bash
php artisan vendor:publish --tag="card-stack-config"
```
You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="card-stack-migrations"
php artisan migrate
```
Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="card-stack-views"
```

This is the contents of the published config file:

```php
<?php

return [
	'models' => [
		'card' => Rmitesh\CardStack\Models\Card::class,
	],

	'table_names' => [
		'cards' => 'cards',
	],

	'table_column_names' => [
		/**
		 * "cards" table schema
		 */
		'cards' => [
			'user_id' => 'user_id',

			'name' => 'name',

			'color' => 'color',

			'position' => 'position',
		],

	],

];
```
## Usage

> Note: Make sure you have create full resource, not `--simple` resource.

Create a custom resource page
```bash
php artisan make:filament-page ViewPlan --resource=PlanResource
```

Then, register route for this page in `PlanResource` file and for redirection create a new `Action`.
```php
public static function getPages(): array
{
    return [
        'view' => Pages\ViewPlan::route('/{record}/view'),
    ];
}
```

```php
public static function table(Table $table): Table
{
	return $table
		->actions([
			Tables\Actions\Action::make('View')
			    ->icon('heroicon-o-x-eye')
			    ->color('secondary')
			    ->url(fn (Model $record) => route('filament.resources.plans.view', ['record' => $record])),
		])
}
```

You can give any route name as per your specification.
> You can find you routes for the view using `php artisan route:list`.

In `PlanResource/Pages/ViewPlan` file, use `CardView` trait
```php
use Rmitesh\CardStack\Resources\Pages\Concerns\CardView;

class ViewPlan extends Page
{
    use CardView;
}
```

Replace the view file located in `resources/views/filament/resources/YOUR RESOURCE/pages/` with following:

```html
<x-card-stack::card-view :cards="$cards" :record="$record">
</x-card-stack::card-view>
```

Now, create a custom widget `PlanListView` without any resource and extends with `CardViewList`
```bash
php artisan make:filament-widget PlanListView
```

```php
<?php

namespace App\Filament\Widgets;

use Rmitesh\CardStack\Pages\Widgets\CardViewList;
use Illuminate\Database\Eloquent\Builder;

class PlanListView extends CardViewList
{
    protected function getTableQuery(): Builder
    {
        // Your eloquest query
    }
}
```

> `$tableHeadingId` and `$tableHeading` variables are holding the each card's id and name. So if you want to display items based on card id then you can use `$tableHeadingId` variable in your eloquent condition.


then add `getHeaderWidgets()` function in you ViewPlan class.
```php
protected function getHeaderWidgets(): array
{
    return [
        PlanListView::class,
    ];
}
```

and here we are good to go!... 🚀🚀🚀

### Extending and customizing CardViewList page.

#### Add Table Columns
To add column in the cards, you can use `getTableColumns()` function in your custom widget class.
```php
protected function getTableColumns(): array
{
    return [
        Tables\Columns\TextColumn::make('name'),
    ];
}
```

#### Add Table Actions
To add table actions in the cards, you can use `getTableActions()` function in your custom widget class.
```php
protected function getTableActions(): array
{
    return [
    	// 
    ];
}
```

#### Add Header Actions
To add table header actions in the cards, you can use `getTableHeaderActions()` function in your custom widget class.
```php
protected function getTableHeaderActions(): array
{
    return [
    	// 
    ];
}
```

### Example

Let's take a typical example
- You are creating montly plans for a work. and you want to manage task list with cards.

Created some Cards
![image](https://github.com/rmitesh/card-stack/assets/48554454/aebac353-2112-4257-be95-e9ed610bb4ae)

In your plan view screen will be look like this.
![image](https://github.com/rmitesh/card-stack/assets/48554454/1ca91a33-e706-4570-bffd-42855f757121)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mitesh Rathod](https://github.com/rmitesh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
