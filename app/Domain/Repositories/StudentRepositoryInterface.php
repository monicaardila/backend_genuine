<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Student;
use App\Application\DTOs\StudentDTO;

interface StudentRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Student;
    public function create(StudentDTO $studentDTO): Student;
    public function update(int $id, StudentDTO $studentDTO): ?Student;
    public function delete(int $id): bool;
    public function findByEmail(string $email): ?Student;
}
