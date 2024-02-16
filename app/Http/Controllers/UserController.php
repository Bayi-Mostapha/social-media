<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'image')->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
    
        $name = $validatedData['name'];
        $email = $validatedData['email'];
        $image = $user->image;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('users-images', 'public');
        }

        $user->update(compact('name', 'email', 'image'));
    
        return to_route('users.show', auth()->id())->with('success', 'Profile updated successfully');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        Auth::logout();
        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
