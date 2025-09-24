<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\StudentService;
use App\Application\DTOs\StudentDTO;
use App\Presentation\Requests\CreateStudentRequest;
use App\Presentation\Requests\UpdateStudentRequest;
use App\Presentation\Resources\StudentResource;
use App\Shared\Exceptions\StudentNotFoundException;
use App\Shared\Exceptions\StudentEmailAlreadyExistsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $students = $this->studentService->getAllStudents();
            
            return response()->json([
                'data' => StudentResource::collection($students),
                'message' => 'Students retrieved successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving students', ['error' => $e->getMessage()]);
            
            return response()->json([
                'message' => 'Error retrieving students'
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            // Handle JSON requests
            if ($request->isJson()) {
                $content = $request->getContent();
                // Fix UTF-8 encoding issues
                $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
                $data = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error', ['error' => json_last_error_msg()]);
                    return response()->json([
                        'message' => 'Invalid JSON data'
                    ], 400);
                }
            } else {
                $data = $request->all();
            }
            
            // Manual validation
            $validator = \Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'grade' => 'required|string|max:50',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.string' => 'El nombre debe ser una cadena de texto',
                'name.max' => 'El nombre no puede exceder los 255 caracteres',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe tener un formato válido',
                'email.unique' => 'El email ya está registrado',
                'grade.required' => 'El grado es obligatorio',
                'grade.string' => 'El grado debe ser una cadena de texto',
                'grade.max' => 'El grado no puede exceder los 50 caracteres',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $studentDTO = StudentDTO::fromArray($validator->validated());
            $student = $this->studentService->createStudent($studentDTO);
            
            Log::info('Student created successfully', ['student_id' => $student->id]);
            
            return response()->json([
                'data' => new StudentResource($student),
                'message' => 'Student created successfully'
            ], 201);
        } catch (StudentEmailAlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Log::error('Error creating student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'message' => 'Error creating student'
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $student = $this->studentService->getStudentById($id);
            
            return response()->json([
                'data' => new StudentResource($student),
                'message' => 'Student retrieved successfully'
            ], 200);
        } catch (StudentNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Log::error('Error retrieving student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'message' => 'Error retrieving student'
            ], 500);
        }
    }

    public function update(UpdateStudentRequest $request, int $id): JsonResponse
    {
        try {
            $studentDTO = StudentDTO::fromArray($request->validated());
            $student = $this->studentService->updateStudent($id, $studentDTO);
            
            Log::info('Student updated successfully', ['student_id' => $id]);
            
            return response()->json([
                'data' => new StudentResource($student),
                'message' => 'Student updated successfully'
            ], 200);
        } catch (StudentNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (StudentEmailAlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Log::error('Error updating student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'message' => 'Error updating student'
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->studentService->deleteStudent($id);
            
            Log::info('Student deleted successfully', ['student_id' => $id]);
            
            return response()->json([
                'message' => 'Student deleted successfully'
            ], 204);
        } catch (StudentNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (\Exception $e) {
            Log::error('Error deleting student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'message' => 'Error deleting student'
            ], 500);
        }
    }
}
