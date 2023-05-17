<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class appController extends Controller
{
    public function app()
    {
        return view('/layouts/app');
        
    }
}
