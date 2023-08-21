<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Product;

class UniqueColor implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $color = request('color');
        $productName = request('name');

        $existingColor = Product::where('name', $productName)
                                  ->where('color', $color)
                                  ->first();

        if($existingColor !== null){
            $fail('This color already exists in this product');
        };
    }
}
