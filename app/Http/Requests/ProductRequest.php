<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET': {
                    return [
                        'limit' => 'nullable|numeric|min:1',
                        'page' => 'nullable|numeric|min:1'
                    ];
                }

            case 'POST': {
                    return [
                        'title' => 'required|string',
                        'count' => 'required|numeric|min:1',
                        'cost' => 'required|numeric|min:1'
                    ];
                }

            case 'PUT': {
                    return [
                        'title' => 'nullable|string',
                        'count' => 'nullable|numeric|min:1',
                        'cost' => 'nullable|numeric|min:1'
                    ];
                }
            default:
                break;
        }
    }
}
