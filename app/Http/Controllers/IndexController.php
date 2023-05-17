<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Resources\views\index;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
