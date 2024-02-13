<?php

namespace App\Enums;

enum MortgagePurposes
{
    case MAIN_HOME;
    case SECONDARY_HOME;

    public static function options(): array
    {
        return [
            self::MAIN_HOME->name => 'primera-vivienda',
            self::SECONDARY_HOME->name => 'segunda-vivienda'
        ];
    }
}
