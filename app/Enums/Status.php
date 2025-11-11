<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case PENDING = 'pending';
    case CLONING = 'cloning';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CLONING => 'Cloning',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::CLONING => 'info',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
            default => 'default',
        };
    }
}
