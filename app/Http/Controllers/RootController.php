<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class RootController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:root']);
    }

    /**
     * Panel de control del root
     * GET /root
     */
    public function index()
    {
        return view('root.dashboard');
    }
}