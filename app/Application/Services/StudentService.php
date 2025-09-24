<?php

namespace App\Application\Services;

use App\Domain\Entities\Student;
use App\Domain\Repositories\StudentRepositoryInterface;
use App\Application\DTOs\StudentDTO;
use App\Shared\Exceptions\StudentNotFoundException;
use App\Shared\Exceptions\StudentEmailAlreadyExistsException;

class StudentService
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository
    ) {}

    public function getAllStudents(): array
    {
        return $this->studentRepository->findAll();
    }

    public function getStudentById(int $id): Student
    {
        $student = $this->studentRepository->findById($id);
        
        if (!$student) {
            throw new StudentNotFoundException("Student with ID {$id} not found");
        }

        return $student;
    }

    public function createStudent(StudentDTO $studentDTO): Student
    {
        // Verificar si el email ya existe
        $existingStudent = $this->studentRepository->findByEmail($studentDTO->email);
        if ($existingStudent) {
            throw new StudentEmailAlreadyExistsException("Email {$studentDTO->email} already exists");
        }

        return $this->studentRepository->create($studentDTO);
    }

    public function updateStudent(int $id, StudentDTO $studentDTO): Student
    {
        // Verificar si el estudiante existe
        $existingStudent = $this->studentRepository->findById($id);
        if (!$existingStudent) {
            throw new StudentNotFoundException("Student with ID {$id} not found");
        }

        // Verificar si el email ya existe en otro estudiante
        $studentWithEmail = $this->studentRepository->findByEmail($studentDTO->email);
        if ($studentWithEmail && $studentWithEmail->id !== $id) {
            throw new StudentEmailAlreadyExistsException("Email {$studentDTO->email} already exists");
        }

        $updatedStudent = $this->studentRepository->update($id, $studentDTO);
        if (!$updatedStudent) {
            throw new StudentNotFoundException("Failed to update student with ID {$id}");
        }

        return $updatedStudent;
    }

    public function deleteStudent(int $id): bool
    {
        // Verificar si el estudiante existe
        $existingStudent = $this->studentRepository->findById($id);
        if (!$existingStudent) {
            throw new StudentNotFoundException("Student with ID {$id} not found");
        }

        return $this->studentRepository->delete($id);
    }
}
