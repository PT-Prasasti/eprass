<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PoTrackingController extends Controller
{
    public function index(): View
    {
        return view('po_tracking.index');
    }

    public function add(): View
    {
        return view('po_tracking.add');
    }

}
