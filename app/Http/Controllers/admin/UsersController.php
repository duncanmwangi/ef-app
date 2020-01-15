<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
//use App\Rules\emailAlreadyTaken;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $validator = Validator::make($request->all(), [
            'firstName' => 'nullable|max:50',
            'lastName' => 'nullable|max:50',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|max:50',
            'state' => 'nullable|max:5',
            'role' => "nullable|in:administrator,fund-manager,investor",
            'date_created_from' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
            'date_created_to' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
        ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $filterArray = [];

        $users = User::select('*');


        if ($validator->fails()) {
            redirect('admin.users.index')->withErrors($validator);
        }else{
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $state = $request->input('state');
            $role = $request->input('role');
            $date_created_from = $request->input('date_created_from');
            $date_created_to = $request->input('date_created_to');
            $sort = $request->input('sort');

            


            if(!empty($firstName)){
                $users->where('firstName','LIKE',"%$firstName%");
                $filterArray['firstName'] = $firstName;
            }
            if(!empty($lastName)){
                $users->where('lastName','LIKE',"%$lastName%");
                $filterArray['lastName'] = $lastName;
            }
            if(!empty($email)){
                $users->where('email','LIKE',"%$email%");
                $filterArray['email'] = $email;
            }
            if(!empty($phone)){
                $users->where('phone','LIKE',"%$phone%");
                $filterArray['phone'] = $phone;
            }

            if(!empty($state)){
                $users->where('state','LIKE',"$state");
                $filterArray['state'] = $state;
            }

            if(!empty($role)){
                $users->where('role',$role);
                $filterArray['role'] = $role;
            }
            

            if(!empty($date_created_from)){
                $users->where('created_at','>=',$date_created_from);
                $filterArray['date_created_from'] = $date_created_from;
            }


            if(!empty($date_created_to)){
                $users->where('created_at','<=',$date_created_to);
                $filterArray['date_created_to'] = $date_created_to;
            }

        }

        $sortable = ['id','-id','name','-name','email','-email','role','-role','phone','-phone','created_at','-created_at'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'name';

        $filterArray['sort'] = $sort;

        if($sort=='name'){
            $sort = 'firstName';
        }elseif($sort=='-name'){
            $sort = '-firstName';
        }

        $users = $users->orderBy(DB::raw($sort),'DESC')->paginate(env('ITEMS_PER_PAGE'));

        $data['users'] = $users;
        $data['filterArray'] = $filterArray;

        return view('admin.users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['fundManagers'] = User::allFundManagers();
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
                'role' => "required|in:investor,'fund-manager',administrator",
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
        }
        $data['fundManagers'] = User::allFundManagers();
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
                'role' => "required|in:investor,'fund-manager',administrator",
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

    public function jsonInvestors(User $user)
    {
        return json_encode($user->investors->map(function($u){ return ['id'=>$u->id,'name'=>$u->name]; }));
    }
}
