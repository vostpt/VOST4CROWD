<?php
declare(strict_types=1);

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
