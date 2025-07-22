<?php

namespace App\Http\Requests\API;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductCalculationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku_string' => ['required', 'regex:/^[A-Z]+$/', function ($attribute, $value, $fail) {
                $skus = array_unique(str_split($value));
                $validSkus = Product::whereIn('name', $skus)->pluck('name')->toArray();

                $invalid = array_diff($skus, $validSkus);
                if (!empty($invalid)) {
                    $fail('Invalid SKU(s): ' . implode(', ', $invalid));
                }
            }],
        ];
    }
}
