<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PoTrackingController extends Controller
{
    public function add(): View
    {
        return view('po_tracking.add');
    }

}
