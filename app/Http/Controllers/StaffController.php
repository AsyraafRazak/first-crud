<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    // Show all staff
    public function index()
    {
        $staffs = Staff::latest()->get();

        return view('staffs.index', compact('staffs'));
    }
}
