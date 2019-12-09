<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Rules\emailAlreadyTaken;

use Image;

class ProfileController extends Controller
{
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();

        

        return view('common.profile.edit',['user'=>$user]);
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
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => ['required','email','max:50', new emailAlreadyTaken()],
            'phone' => 'required|max:50',
            'alternatePhone' => 'nullable|max:50',
            'street1' => 'required|max:50',
            'street2' => 'nullable|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zip' => 'required|max:50',
        ],
        [
            'password' => 'Current password is incorrect.'
        ]);


        $user = auth()->user();
        $user->firstName = $validatedData['firstName'];
        $user->lastName = $validatedData['lastName'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->alternatePhone = $validatedData['alternatePhone'];
        $user->street1 = $validatedData['street1'];
        $user->street2 = $validatedData['street2'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->zip = $validatedData['zip'];
        $user->save();

        return redirect()->route('common.profile.edit')->with('success', 'Your profile was updated successfully.');
    }
    

    public function picture(Request $request)
    {
        $validatedData = $request->validate([
            'profilePic' => 'required|image|mimes:jpeg,bmp,png|max:2048'
        ]);

        $user = auth()->user();

        $system_path = str_ireplace('storage/', 'public/', $user->avatarPath);

        $exists = Storage::disk('local')->exists($system_path);
        if($exists) Storage::delete($system_path);

        $image = $request->file('profilePic');
        $path = 'storage/avatars/'.$user->id.'-'.time().'.'.$image->extension();
        $img = Image::make($image->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($path));


        
        $user->avatarPath = $path;
        $user->save();

        return back()->with('success', 'Your profile picture was updated successfully.');
    }
}
