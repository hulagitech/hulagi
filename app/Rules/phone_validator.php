<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class phone_validator implements Rule
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
        $count=User::where('mobile',$value)->count();
        if($count<1){
         return $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This phone number is already taken';
    }
}
