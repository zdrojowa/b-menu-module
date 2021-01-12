<?php

namespace Selene\Modules\MenuModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuUpdateRequest extends FormRequest
{
    public function rules() {
        return [
            'name' => 'required|unique:mongodb.menus,'.$this->menu->_id,
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
