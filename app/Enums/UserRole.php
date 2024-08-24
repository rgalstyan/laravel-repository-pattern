<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: int {
    case ADMIN = 1;
    case USER = 2;

    public function label(): string {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string {
        return match ($value) {
            UserRole::ADMIN => 'Admin user',
            UserRole::USER => 'User'
        };
    }
}