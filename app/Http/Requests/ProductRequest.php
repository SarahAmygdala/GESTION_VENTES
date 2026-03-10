<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        $id = $this->product ? $this->product->id : null;

        return [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'cost'          => 'nullable|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'min_stock'     => 'required|integer|min:0',
            'barcode'       => 'nullable|string|max:100|unique:products,barcode,' . $id,
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'active'        => 'nullable|boolean',
            'description'   => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Le nom du produit est obligatoire.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'price.required'       => 'Le prix de vente est obligatoire.',
            'stock.required'       => 'Le stock actuel est obligatoire.',
            'min_stock.required'   => 'Le stock minimum est obligatoire.',
            'barcode.unique'       => 'Ce code-barres est déjà utilisé.',
            'image.image'          => 'Le fichier doit être une image.',
        ];
    }
}
