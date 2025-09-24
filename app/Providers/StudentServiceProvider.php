<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\StudentRepositoryInterface;
use App\Infrastructure\Repositories\EloquentStudentRepository;
use App\Application\Services\StudentService;

class StudentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar la interfaz del repositorio con su implementación
        $this->app->bind(
            StudentRepositoryInterface::class,
            EloquentStudentRepository::class
        );

        // Registrar el servicio de aplicación
        $this->app->singleton(StudentService::class, function ($app) {
            return new StudentService(
                $app->make(StudentRepositoryInterface::class)
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
