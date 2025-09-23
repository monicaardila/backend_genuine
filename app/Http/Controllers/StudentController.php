<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Obtener todos los estudiantes
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // Crear estudiante
    public function store(Request $request)
    {
        try {
            \Log::info('Intentando crear estudiante', $request->all());
            
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'grade' => 'required|string|max:50',
            ]);

            \Log::info('Datos validados', $validated);

            $student = Student::create($validated);

            \Log::info('Estudiante creado exitosamente', ['id' => $student->id, 'name' => $student->name]);

            return response()->json($student, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación al crear estudiante', [
                'errors' => $e->errors(),
                'data' => $request->all()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error inesperado al crear estudiante', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    // Mostrar estudiante por ID
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student, 200);
    }

    // Actualizar estudiante
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'grade' => 'sometimes|string|max:50',
        ]);

        $student->update($validated);

        return response()->json($student, 200);
    }

    // Eliminar estudiante
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204);
    }
}
