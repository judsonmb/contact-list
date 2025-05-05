<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'postal_code' => 'required|string',
            'state'       => 'required|string',
            'city'        => 'required|string',
            'district'    => 'required|string',
            'address'     => 'required|string',
            'number'      => 'required|numeric',
            'name'        => 'required|string',
            'email'       => 'required|email|unique:contacts,email',
            'phone'       => 'required|numeric',
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
            'postal_code.required' => 'O campo CEP é obrigatório.',
            'postal_code.string'   => 'O campo CEP deve ser uma string válida.',
            'state.required'       => 'O campo Estado é obrigatório.',
            'state.string'         => 'O campo Estado deve ser uma string válida.',
            'city.required'        => 'O campo Cidade é obrigatório.',
            'city.string'          => 'O campo Cidade deve ser uma string válida.',
            'district.required'    => 'O campo Bairro é obrigatório.',
            'district.string'      => 'O campo Bairro deve ser uma string válida.',
            'address.required'     => 'O campo Endereço é obrigatório.',
            'address.string'       => 'O campo Endereço deve ser uma string válida.',
            'number.required'      => 'O campo Número é obrigatório.',
            'number.numeric'        => 'O campo Número deve ser um número válido.',
            'name.required'        => 'O campo Nome é obrigatório.',
            'name.string'          => 'O campo Nome deve ser uma string válida.',
            'email.required'       => 'O campo Email é obrigatório.',
            'email.email'          => 'O campo Email deve ser um e-mail válido.',
            'email.unique'         => 'Este e-mail já está em uso. Escolha outro.',
            'phone.required'       => 'O campo Telefone é obrigatório.',
            'phone.numeric'         => 'O campo Telefone deve ser conter só números.',
        ];
    }
}
