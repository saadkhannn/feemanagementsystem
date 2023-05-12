<?php

namespace Modules\Setups\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Designation;

class APIController extends Controller
{
    public function designations()
    {
        return Designation::where('status',1)->orderBy('name','asc')->get();
    }
}
