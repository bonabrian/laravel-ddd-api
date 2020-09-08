<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Interfaces\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ResponseTrait;
}
