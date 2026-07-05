<?php

namespace Modules\Auth\App\Enums;

enum AuthGuardEnum: string
{
    case Web = 'web';
    case Api = 'api';

    public function label(): string
    {
        return match ($this) {
            self::Web => 'Web (Session)',
            self::Api => 'API (Token)',
        };
    }
}
