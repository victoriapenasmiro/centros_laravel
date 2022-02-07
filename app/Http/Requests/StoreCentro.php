<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;

class StoreCentro extends FormRequest
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
        //recupero el lang.
        //importante para mostrar warnings de error en el idioma correspondiente
        $lang = $this->route('lang');
        abort_unless(Gate::allows('check-language', $lang), 403);

        //return ddd($this->getMethod());

        return [
            'nombre' => 'required',
            'cod_asd' => 'required',
            // 'descripcion' => 'required', --> campo nullable
            'fec_comienzo_actividad' => 'required',
            'opcion_radio' => 'required',
            'guarderia' => 'required',
            'categoria' => 'required',
            'ambitos' => 'required',
            'logo' => [
                $this->getMethod() == 'PUT' ? '' : 'required',
                'image',
            ]
        ];
    }

    //para modificar el mensaje completo de error
    //hay que indicar el mensaje por cada validación
    // public function messages()
    // {
    //     return [
    //         'file.required' => 'Logo obligatorio',
    //     ];
    // }

    //para modificar en los mensaje de error el nombre del campo que se mostrará
    public function attributes()
    {
        return ['file' => 'logo',];
    }
}
