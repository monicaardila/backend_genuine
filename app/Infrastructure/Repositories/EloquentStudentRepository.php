<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Student;
use App\Domain\Repositories\StudentRepositoryInterface;
use App\Application\DTOs\StudentDTO;
use App\Models\Student as StudentModel;

class EloquentStudentRepository implements StudentRepositoryInterface
{
    public function findAll(): array
    {
        $students = StudentModel::all();
        
        return $students->map(function ($student) {
            return new Student(
                id: $student->id,
                name: $student->name,
                email: $student->email,
                grade: $student->grade,
                createdAt: $student->created_at?->toISOString(),
                updatedAt: $student->updated_at?->toISOString()
            );
        })->toArray();
    }

    public function findById(int $id): ?Student
    {
        $student = StudentModel::find($id);
        
        if (!$student) {
            return null;
        }

        return new Student(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            grade: $student->grade,
            createdAt: $student->created_at?->toISOString(),
            updatedAt: $student->updated_at?->toISOString()
        );
    }

    public function create(StudentDTO $studentDTO): Student
    {
        $student = StudentModel::create([
            'name' => $studentDTO->name,
            'email' => $studentDTO->email,
            'grade' => $studentDTO->grade,
        ]);

        return new Student(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            grade: $student->grade,
            createdAt: $student->created_at?->toISOString(),
            updatedAt: $student->updated_at?->toISOString()
        );
    }

    public function update(int $id, StudentDTO $studentDTO): ?Student
    {
        $student = StudentModel::find($id);
        
        if (!$student) {
            return null;
        }

        $student->update([
            'name' => $studentDTO->name,
            'email' => $studentDTO->email,
            'grade' => $studentDTO->grade,
        ]);

        return new Student(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            grade: $student->grade,
            createdAt: $student->created_at?->toISOString(),
            updatedAt: $student->updated_at?->toISOString()
        );
    }

    public function delete(int $id): bool
    {
        $student = StudentModel::find($id);
        
        if (!$student) {
            return false;
        }

        return $student->delete();
    }

    public function findByEmail(string $email): ?Student
    {
        $student = StudentModel::where('email', $email)->first();
        
        if (!$student) {
            return null;
        }

        return new Student(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            grade: $student->grade,
            createdAt: $student->created_at?->toISOString(),
            updatedAt: $student->updated_at?->toISOString()
        );
    }
}
