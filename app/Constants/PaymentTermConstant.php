<?php

namespace App\Constants;

class PaymentTermConstant extends BaseConstant
{
    const COD = 'COD';
    const ADVANCED_PAYMENT_100 = 'ADVANCED_PAYMENT_100';
    const DP_30_CBD_70 = 'DP_30_CBD_70';
    const DP_30_COD_70 = 'DP_30_COD_70';
    const COD_100 = 'COD_100';
    const DP_30_AFTER_RECEIVING_INVOICE_70 = 'DP_30_AFTER_RECEIVING_INVOICE_70';
    const CBD = 'CBD';
    const DP_50 = 'DP_50';

    public static function texts(): array
    {
        return [
            self::COD => '100%, 30 Days After Invoice Received',
            self::ADVANCED_PAYMENT_100 => '100% Advance Payment',
            self::DP_30_CBD_70 => '30% DP, 70% Before Delivery',
            self::DP_30_COD_70 => '30% DP, 70% COD',
            self::COD_100 => '100% COD',
            self::DP_30_AFTER_RECEIVING_INVOICE_70 => '30% DP, 70% 30 Days After Invoice Received',
            self::CBD => 'Cash Before Delivery',
            self::DP_50 => '50% - 50%',
        ];
    }
}
