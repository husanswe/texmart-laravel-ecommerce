<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class ProductVariantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required(),
                
                TextInput::make('sku')
                    ->unique()
                    ->maxLength(255)
                    ->required(),
                
                TextInput::make('price')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('stock')
                    ->integer()
                    ->minValue(0)
                    ->required(),
            ]);
    }
}
