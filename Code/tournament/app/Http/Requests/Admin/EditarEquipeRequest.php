<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditarEquipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $equipe = \Route::current()->getParameter('equipe');
        
        return [
            'nome' => 'required|unique:equipes,nome,' . $equipe->id,
            'escola_id' => 'required',
            'presente' => 'required|integer'
        ];
    }
}
