<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    public function index()
    {
        $title = 'Admin';

        return view('home', ['title' => $title]);
    }
}
