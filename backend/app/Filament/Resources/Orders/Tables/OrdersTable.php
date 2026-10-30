<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable(),

                TextColumn::make('total_amount')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed', 'shipped' => 'success',
                        'cancelled', 'refunded' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'processing' => 'heroicon-m-arrow-path',
                        'completed', 'shipped' => 'heroicon-m-check-circle',
                        'cancelled', 'refunded' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                    })
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    // 
                ]),
            ]);
    }
}
