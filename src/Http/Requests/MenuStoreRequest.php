<?php

namespace Selene\Modules\MenuModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
{
    public function rules() {
        return [
            'name' => 'required|unique:mongodb.menus',
            'structure' => 'json'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane.',
            'name.unique' => 'Nazwa musi być unikalna.',
            'structure.json' => 'Wystąpił błąd, skontaktuj się z programistami.'
        ];
    }
}
