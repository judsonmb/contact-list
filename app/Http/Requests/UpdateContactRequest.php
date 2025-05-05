<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
            'postal_code' => 'sometimes|string',
            'state'       => 'sometimes|string',
            'city'        => 'sometimes|string',
            'district'    => 'sometimes|string',
            'address'     => 'sometimes|string',
            'number'      => 'sometimes|numeric',
            'name'        => 'sometimes|string',
            'email'       => [
                'sometimes',
                'email',
                Rule::unique('contacts')->ignore($this->route('contact')),
            ],
            'phone' => 'sometimes|numeric',
        ];
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'postal_code.string'   => 'O campo CEP deve ser uma string válida.',
            'state.string'         => 'O campo Estado deve ser uma string válida.',
            'city.string'          => 'O campo Cidade deve ser uma string válida.',
            'district.string'      => 'O campo Bairro deve ser uma string válida.',
            'address.string'       => 'O campo Endereço deve ser uma string válida.',
            'number.numeric'        => 'O campo Número deve ser um número válido.',
            'name.string'          => 'O campo Nome deve ser uma string válida.',
            'email.email'          => 'O campo Email deve ser um e-mail válido.',
            'email.unique'         => 'Este e-mail já está em uso. Escolha outro.',
            'phone.numeric'         => 'O campo Telefone deve ser conter só números.',
        ];
    }
}
