<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $statusRending = 4;
    public $statusInAction = 5;
    public $statusEnd = 7;

    public $typeJobPurchase = 1;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
