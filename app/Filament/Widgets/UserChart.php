<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Usuários';
    protected static ?int $sort = 2;
    protected static bool $isLazy = false;


    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Usuários',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#ADFF2F',
                    'borderColor' => '#0000CD',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'O número de usuários registrados por mês!';
    }
}
