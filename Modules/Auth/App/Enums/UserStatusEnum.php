<?php

namespace Modules\Auth\App\Enums;

enum UserStatusEnum: string
{
    case Active    = 'active';
    case Inactive  = 'inactive';
    case Suspended = 'suspended';
    case Pending   = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::Active    => 'Active',
            self::Inactive  => 'Inactive',
            self::Suspended => 'Suspended',
            self::Pending   => 'Pending Verification',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Active    => 'bg-success',
            self::Inactive  => 'bg-secondary',
            self::Suspended => 'bg-danger',
            self::Pending   => 'bg-warning text-dark',
        };
    }

    public function canLogin(): bool
    {
        return $this === self::Active;
    }

    public static function options(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }
}
