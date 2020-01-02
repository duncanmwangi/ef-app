<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
//use App\Rules\emailAlreadyTaken;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('firstName','asc')
                ->paginate(env('ITEMS_PER_PAGE'));

        return view('admin.users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$user = new User::allRegionalFundManagers();
        $data['regionalFundManagers'] = User::allRegionalFundManagers();
        return view('admin.users.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
                [
                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'email' => 'required|email|max:50|unique:users',
                'phone' => 'required|max:50',
                'role' => "required|in:investor,'fund-manager','regional-fund-manager',administrator",
                'rfm' => 'required_if:role,investor,fund-manager',
                'fm' => 'required_if:role,investor',
                'alternatePhone' => 'nullable|max:50',
                'street1' => 'required|max:50',
                'street2' => 'nullable|max:50',
                'city' => 'required|max:50',
                'state' => 'required|min:1|max:50',
                'zip' => 'required|max:50',
                'password' => 'required|min:5|max:30',
                'cpassword' => 'required|min:5|max:30|same:password',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alternatePhone = $request->alternatePhone;
        $user->role = $request->role;
        $user->user_id = User::get_user_id_given_role($request);
        $user->street1 = $request->street1;
        $user->street2 = $request->street2;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->password = Hash::make($request->password);

        $user->save();
        return redirect()->route('admin.users.create')->withSuccess('User has been created successfully');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->isInvestor()){
            $data['fm'] = $user->user_id;
            $data['rfm'] = User::find($user->user_id)->user_id;
        }elseif($user->isFundManager()){
            $data['rfm'] = $user->user_id;
        }
        $data['regionalFundManagers'] = User::allRegionalFundManagers();
        $data['user'] = $user;
        return view('admin.users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate(
                [
                'firstName' => 'required|max:50',
                'lastName' => 'required|max:50',
                'email' => ['required','email','max:50',Rule::unique('users')->ignore($user->id)],
                'phone' => 'required|max:50',
                'role' => "required|in:investor,'fund-manager','regional-fund-manager',administrator",
                'rfm' => 'required_if:role,investor,fund-manager',
                'fm' => 'required_if:role,investor',
                'alternatePhone' => 'nullable|max:50',
                'street1' => 'required|max:50',
                'street2' => 'nullable|max:50',
                'city' => 'required|max:50',
                'state' => 'required|min:1|max:50',
                'zip' => 'required|max:50',
                'password' => 'nullable:min:5|max:30',
                'cpassword' => 'required_with:password|same:password',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alternatePhone = $request->alternatePhone;
        $user->role = $request->role;
        $user->user_id = User::get_user_id_given_role($request);
        $user->street1 = $request->street1;
        $user->street2 = $request->street2;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;

        if(!$request->password) $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('admin.users.edit',$user)->withSuccess('User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return redirect()->route('admin.users.index')->withError('Currently deleting users is disabled');
    }

    public function fieldNames()
    {
        return [
            'firstName'=> 'First Name',
            'lastName'=> 'Last Name',
            'email'=> 'Email Address',
            'phone'=> 'Phone',
            'role'=> 'User Role',
            'state'=> 'State',
            'street1'=> 'Street Address 1',
            'street2'=> 'Street Address 2',
            'city'=> 'City',
            'zip'=> 'Zip Code',
            'rfm'=> 'Regional Fund Manager',
            'fm'=> 'Fund Manager',
            'password'=> 'User Password',
            'cpassword'=> 'Confirm User Password',
        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }

    public function jsonFundManagers(User $user)
    {
        return json_encode($user->fundManagers->map(function($u){ return ['id'=>$u->id,'name'=>$u->name]; }));
    }
}
