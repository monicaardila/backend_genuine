<?php

namespace App\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'grade' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede exceder los 255 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe tener un formato válido',
            'email.unique' => 'El email ya está registrado',
            'grade.required' => 'El grado es obligatorio',
            'grade.string' => 'El grado debe ser una cadena de texto',
            'grade.max' => 'El grado no puede exceder los 50 caracteres',
        ];
    }

    protected function prepareForValidation()
    {
        // Handle JSON requests properly
        if ($this->header('Content-Type') === 'application/json' || $this->isJson()) {
            $data = json_decode($this->getContent(), true);
            if (is_array($data)) {
                $this->merge($data);
            }
        }
    }
}
