<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffpanelController extends Controller
{
    public function index() {
        return view('staff.index');
    }
}
