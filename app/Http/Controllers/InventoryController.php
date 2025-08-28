<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Jobs\InventoryCreatedJob;
use \App\Notifications\StoreInventoryNotification;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // query all inventories from the table 'inventories' using model
        // $inventories = Inventory::all();
        $inventories = Inventory::latest()->get();

        // return to view with $inventories (resources/views/inventories/index.blade.php)
        return view('inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        //store in the table 'inventories' using model

        //POPO - plain old php object
        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->quantity = $request->quantity;
        $inventory->description = $request->description;
        $inventory->user_id = auth()->user()->id;
        $inventory->save();

        InventoryCreatedJob::dispatch($inventory);

        $user = auth()->user();
        $user->notify(new StoreInventoryNotification());

        //return to inventory index
        return redirect('inventories');
    }

    public function show(Inventory $inventory)
    {
        //Policy dijaga di controller function view
        $this->authorize('view', $inventory);

        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        //Policy dijaga di controller function view
        $this->authorize('update', $inventory);
        return view('inventories.edit', compact('inventory'));
    }


    //Request tu sebab dari form
    public function update(Request $request, Inventory $inventory)
    {
        // update using model
        $inventory->name = $request->name;
        $inventory->quantity = $request->quantity;
        $inventory->description = $request->description;
        $inventory->save();

        // return to inventory index
        return redirect('inventories');
    }

    public function destroy(Inventory $inventory)
    {
        $this->authorize('delete', $inventory);

        $inventory->delete();

        return redirect()->route('inventories.index');
    }
}
