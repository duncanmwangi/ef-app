<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class emailAlreadyTaken implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        return !User::where('email',$value)->where('id','<>',auth()->user()->id)->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute already taken';
    }
}
