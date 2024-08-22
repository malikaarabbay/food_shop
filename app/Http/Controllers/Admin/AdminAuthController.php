<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    /**
     * Display a admin login page.
     *
     * @return View
     */
    function index() : View
    {
        return view('admin.auth.login');
    }
}
