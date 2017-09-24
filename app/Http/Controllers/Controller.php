<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        var_dump((new Search('super "power" or magic'))->perform());
    }
}
