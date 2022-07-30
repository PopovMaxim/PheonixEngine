<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class IExists implements Rule
{
    public $table;
    public $fail;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $fail)
    {
        $this->table = $table;
        $this->fail = $fail;
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
        $query = DB::table($this->table);
        
        $column = $query
            ->getGrammar()
            ->wrap($attribute);
        
        return $query
            ->whereRaw("lower({$column}) = lower(?)", [$value])
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->fail;
    }
}
