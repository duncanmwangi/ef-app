<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\User;

class PasswordController extends Controller
{
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('common.password.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'currentPassword' => 'required|min:5|max:30|password',
            'newPassword' => 'required|min:5|max:30',
            'confirmPassword' => 'required|same:newPassword|min:5|max:255',
        ],
        [
            'password' => 'Current password is incorrect.'
        ]);


        $user = auth()->user();
        $user->password = bcrypt($validatedData['newPassword']);
        $user->save();

        return back()->with('success', 'Your password was changed successfully.');
    }

}
