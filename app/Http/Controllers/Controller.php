<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    //kena guna ni utk request nnti(policy)
    use AuthorizesRequests;
}