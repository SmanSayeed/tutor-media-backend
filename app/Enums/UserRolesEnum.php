<?php

namespace App\Enums;

enum UserRolesEnum: string
{
    case ADMIN = 'admin';
    case TUTOR = 'tutor';
    case GUARDIAN = 'guardian';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::TUTOR => 'Tutor',
            self::GUARDIAN => 'Guardian',
        };
    }

    /**
     * Return the color associated with the given user status.
     *
     * @param  string  $status
     */
    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'success',
            self::TUTOR => 'warning',
            self::GUARDIAN => 'danger',
            default => 'success',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
