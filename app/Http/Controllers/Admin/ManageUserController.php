<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageUserController extends Controller
{
    //show all users
    public function show_all()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }


    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:60',
            'email' => 'required|email|max:160|unique:users,email,' . $user->id,
        ]);


        if ($request->email != $user->email && User::whereEmail($request->email)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }

        $user->update([
            'name'    => $request->name,
            'email'     => $request->email,
            'status'    => $request->status ? 1 : 0,
            'ev'        => $request->ev ? 1 : 0,
        ]);

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->route('admin.user.all')->withNotify($notify);
    }


}
