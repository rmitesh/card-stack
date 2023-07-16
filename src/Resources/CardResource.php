<?php

namespace Rmitesh\CardStack\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Rmitesh\CardStack\Resources\CardResource\Pages;
use Rmitesh\CardStack\Resources\CardResource\RelationManagers;
use Rmitesh\CardStack\Models\Card;

class CardResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-document-add';

    protected static ?string $navigationGroup = null;

    public static function getModel(): string
    {
        return config('card-stack.models.card');
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()
            ->whereBelongsTo(auth()->user())
            ->oldest('position');
    }

    public static function getForm(): array
    {
        return [
            Forms\Components\TextInput::make(config('card-stack.table_column_names.name'))
                ->unique(ignoreRecord: true)
                ->autocomplete('off')
                ->placeholder('Name')
                ->required(),

            Forms\Components\ColorPicker::make(config('card-stack.table_column_names.color'))
                ->placeholder('Color')
                ->hex()
                ->required(),

            Forms\Components\TextInput::make(config('card-stack.table_column_names.position'))
                ->default(function () {
                    return static::getModel()::getNextPosition();
                })
                ->numeric()
                ->unique(ignoreRecord: true)
                ->autocomplete(false)
                ->required(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(config('card-stack.table_column_names.name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make(config('card-stack.table_column_names.color'))
                    ->sortable(),

                Tables\Columns\TextColumn::make(config('card-stack.table_column_names.position')),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime('dS F, Y h:i A'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCards::route('/'),
        ];
    }
}
