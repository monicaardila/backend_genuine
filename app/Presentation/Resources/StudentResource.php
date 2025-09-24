<?php

namespace App\Presentation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Entities\Student;

class StudentResource extends JsonResource
{
    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function toArray(Request $request): array
    {
        /** @var Student $student */
        $student = $this->resource;

        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'grade' => $student->grade,
            'created_at' => $student->createdAt,
            'updated_at' => $student->updatedAt,
        ];
    }
}
