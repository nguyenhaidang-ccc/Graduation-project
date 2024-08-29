<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProductCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productCode = request('product_code'); 

        $existingProductCode = Product::where('product_code', $productCode)
                                      ->first();

        if ($existingProductCode !== null) {
            $fail('Product code already exists.'); 
        }
    }
    
}
