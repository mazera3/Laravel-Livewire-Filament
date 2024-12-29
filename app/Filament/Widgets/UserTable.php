<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UserTable extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(UserResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('name', 'aced')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                // TextColumn::make('document'),
                // TextColumn::make('phoneNumbers.full_number')
                //     ->label('Phone Number')
                //     ->searchable()
                //     ->sortable()
                //     ->listWithLineBreaks(),
                TextColumn::make('email_verified_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

}
