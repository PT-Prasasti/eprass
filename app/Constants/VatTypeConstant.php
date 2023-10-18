<?php

namespace App\Constants;

class VatTypeConstant extends BaseConstant
{
    const INCLUDE_11 = 'INCLUDE_11';
    const EXCLUDE_11 = 'EXCLUDE_11';

    public static function texts(): array
    {
        return [
            self::INCLUDE_11 => 'Include PPN 11%',
            self::EXCLUDE_11 => 'Exclude PPN 11%',
        ];
    }
}
