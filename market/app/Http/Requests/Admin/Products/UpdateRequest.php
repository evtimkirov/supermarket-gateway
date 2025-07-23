<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|unique:products,name,' . $this->route('product')->id,
            'price' => 'required|numeric',
            'promotion.quantity' => 'nullable|integer|min:0',
            'promotion.total' => 'nullable|numeric|min:0',
            'promotion_id' => 'nullable|exists:promotions,id',
        ];
    }
}
