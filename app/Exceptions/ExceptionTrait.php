<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if ($this->isModel($e)) {
            return $this->modelResponse($e);
        }
        if ($this->isHttp($e)) {
            return $this->httpResponse($e);
        }

        return parent::render($request, $exception);
    }

    private function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    private function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    private function modelResponse($e)
    {
        return response()->json([
            'errors' => 'Product Model not found'
        ], Response::HTTP_NOT_FOUND);
    }

    private function httpResponse($e)
    {
        return response()->json([
            'errors' => 'The url provided is not valid'
        ], Response::HTTP_NOT_FOUND);
    }
}
