<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = bcrypt('password'); // Default password
        $user->password = bcrypt($request->password); // Password from request
        $user->save();

        //return to $user index
        return redirect('users');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // update using model
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // return to user index
        return redirect('users');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('users');
    }
}
