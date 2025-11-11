<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\ExecutionStatsWidget;
use App\Filament\Widgets\RepositoriesWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            ExecutionStatsWidget::class,
            RepositoriesWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
