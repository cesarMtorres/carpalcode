<?php

declare(strict_types=1);

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class RepositoriesWidget extends ChartWidget
{
    protected ?string $heading = 'Repositories Widget';

    protected function getData(): array
    {
        return [

        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
