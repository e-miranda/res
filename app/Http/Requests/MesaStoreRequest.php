<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MesaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // el middleware admin ya controla acceso
    }

    public function rules(): array
    {
        return [
            'numero' => 'required|integer|min:1',
            'capacidad' => 'required|integer|min:1|max:20',
            'estado' => 'required|in:libre,ocupada,reservada',
        ];
    }
}
