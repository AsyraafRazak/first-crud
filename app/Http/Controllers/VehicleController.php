<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->name = $request->name;
        $vehicle->qty = $request->qty;
        $vehicle->save();

        //return to $vehicle index
        return redirect('vehicles');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }


    //Request tu sebab dari form
    public function update(Request $request, Vehicle $vehicle)
    {
        // update using model
        $vehicle->name = $request->name;
        $vehicle->quantity = $request->qty;
        $vehicle->save();

        // return to vehicle index
        return redirect('vehicles');
    }
}
