<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        $this->descriptiveResponseMethods();
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;

        Response::macro('ok', function ($data = []) use ($instance) {
            return $instance->handleSuccessResponse($data, 200);
        });

        Response::macro('created', function ($data = []) use ($instance) {
            return $instance->handleSuccessResponse($data, 201);
        });

        Response::macro('noContent', function () use ($instance) {
            return $instance->handleSuccessResponse(status: 204);
        });

        Response::macro('badRequest', function ($message = 'Validation Failure', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 400);
        });

        Response::macro('unauthorized', function ($message = 'Unauthorized', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 401);
        });

        Response::macro('forbidden', function ($message = 'Access denied', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 403);

        });

        Response::macro('notFound', function ($message = 'Resource not found.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 404);
        });

        Response::macro('internalServerError', function ($message = 'Internal Server Error.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 500);
        });
    }

    public function handleSuccessResponse($data = [], $status)
    {
        $response = [
            'status' => $status,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return Response::json($response, $status);
    }

    public function handleErrorResponse($message, $errors, $status)
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if (count($errors)) {
            $response['errors'] = $errors;
        }

        return Response::json($response, $status);
    }
}
