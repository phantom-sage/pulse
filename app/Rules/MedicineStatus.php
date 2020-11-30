<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MedicineStatus implements Rule
{
    /**
     * @var $amount
     */
    private $amount;


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
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
        return ($this->amount > 0) ? $value === 'Available' : $value === 'N/A';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute and amount should be consist with each other.';
    }
}
