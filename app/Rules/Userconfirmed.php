<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;



class Userconfirmed implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        $arr[0]=$value;
//        $arr[1]=$value;
//        dd($arr);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
