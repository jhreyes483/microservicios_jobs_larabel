<?php

namespace App\Http\Controllers\Order;

class UtilitiesOrders
{

    /**
     * @param array $platters
     * @return array
     */
    public function randomPlate(array $platters): array
    {
        $r =   $platters[ array_rand($platters)];
        return  $platters[ array_rand($platters)]  ??[];
    }

}
