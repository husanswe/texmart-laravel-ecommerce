<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Concerns\CanBeSearchable;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->prelaod()
                    ->required(),

                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->prelaod()
                    ->required(),
                    
                TextInput::make('price')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                Textarea::make('description')
                    ->required(),
                ]);
    }
}
