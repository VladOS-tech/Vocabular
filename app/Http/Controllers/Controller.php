<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Общие методы для всех контроллеров
    protected function jsonResponse($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    protected function handleException(\Throwable $e)
    {
        return $this->jsonResponse([
            'error' => $e->getMessage()
        ], 500);
    }
}

