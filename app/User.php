<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role=='admin';
    }

    public function isRegionalFundManager()
    {
        return $this->role=='regional-fund-manager';
    }

    public function isFundManager()
    {
        return $this->role=='fund-manager';
    }

    public function isInvestor()
    {
        return $this->role=='investor';
    }
    public function getNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }
    public function getRoleNameAttribute()
    {
        return ucwords(str_ireplace('-', ' ', $this->role));
    }

    public function getAvatarSrcAttribute($value='')
    {
        $path = str_ireplace('storage/', 'public/', $this->avatarPath);
        
        $exists = Storage::disk('local')->exists($path);
        
        return $exists ?asset($this->avatarPath) : asset('assets/images/avatars/1.jpg');
    }

    public static function allRegionalFundManagers($value='')
    {
        return User::where('role','regional-fund-manager')->orderBy('firstName','ASC')->get();
    }


    //relation ships
    public function fundManagers()
    {
        return $this->hasMany('App\User','user_id')->where('role','fund-manager');
    }

    public function fundManager()
    {
        return $this->belongsTo('App\User','user_id')->where('role','fund-manager');
    }
    


    public function investors()
    {
        return $this->hasMany('App\User','user_id')->where('role','investor');
    }



    public function regionalFundManager()
    {
        return $this->belongsTo('App\User','user_id')->where('role','regional-fund-manager');
    }
    
    public function regionalFundManagers()
    {
        return $this->hasMany('App\User','user_id')->where('role','regional-fund-manager');
    }

    public function investments()
    {
        return $this->hasMany('App\Investment','user_id');
    }
    
    public function earnings()
    {
        return $this->hasManyThrough('App\Earning','App\Investment');
    }



    public function administrator()
    {
        return $this->belongsTo('App\User','user_id')->where('role','admin');
    }


    public static function get_user_id_given_role($request)
    {
        if($request->role=='administrator' || $request->role=='regional-fund-manager') return auth()->user()->id;
        if($request->role=='fund-manager') return $request->rfm;
        if($request->role=='investor') return $request->fm;
        return ;
    }

}
