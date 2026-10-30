<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;


class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'canceled' => 'Cancelled',
                    ])
                    ->required()

                    ->colors([
                        'pending' => 'warning',
                        'completed' => 'success',
                        'canceled' => 'danger',
                    ]),


                Select::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    ])
                    ->required()

                    ->colors([
                        'pending' => 'amber',
                        'paid' => 'success',
                        'unpaid' => 'danger',
                    ])
                    

            ]);

                
    }
}
