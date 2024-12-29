<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

//  Visão geral das estatísticas
class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    // Estatísticas de atualização ao vivo
    protected static ?string $pollingInterval = '10s';
    // Desativando o carregamento preguiçoso
    protected static bool $isLazy = false;
    // Adicionando um título e descrição
    // protected ?string $heading = 'Analytics';
    // protected ?string $description = 'An overview of some analytics.';

    protected function getHeading(): ?string
    {
        return 'Visão geral das estatísticas';
    }

    protected function getDescription(): ?string
    {
        return 'Uma visão geral de algumas análises.';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Usuários', User::count())
                ->description('Users Registred')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'), // success, gray, danger, info, primary, warning
            Stat::make('Posts Publication', User::count()) // Post::count()
                ->description('Posts Publication')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            Stat::make('Projects', User::count()) //Project::count()
                ->description('Projects Actives')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
        ];
    }
}
