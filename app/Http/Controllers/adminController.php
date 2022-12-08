<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        return view('admin/admin_main');
    }

    public function report()
    {
        return view('admin/admin_report');
    }
}
