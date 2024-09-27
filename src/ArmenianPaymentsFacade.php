<?php

namespace Vendor\ArmenianPayments;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vendor\ArmenianPayments\Skeleton\SkeletonClass
 */
class ArmenianPaymentsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'armenian-payments';
    }
}
