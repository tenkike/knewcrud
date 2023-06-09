<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Crud\PageAdmin;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title= "Dashboard";
        return view('admin.dashboard', compact('title'));
    }
}
