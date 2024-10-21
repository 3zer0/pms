<?php

namespace App\Traits;

trait ResponseTrait
{
    public function successResponse($message = "Successful", $data = null)
    {
        return response([
            'success' => true,
            'status'  => 'success',
            'message' => $message,
            'errors'  => null,
            'data'    => $data,
        ])->header('Content-type', 'application/json');
    }

    public function errorResponse($message = 'Data is invalid', $errors)
    {
        return response([
            'success' => false,
            'status'  => 'failed',
            'message' => $message,
            'errors'  => $errors,
            'data'    => null,
        ])->header('Content-type', 'application/json');
    }

    public function jsonResponse($data = null)
    {
        return response([
            'data' => $data
        ])->header('Content-type', 'application/json');
    }

    public function validationError($validator)
    {
        $errMsg = [];
        foreach ($validator->errors()->all() as $key => $error) {
            $errMsg[] = $error;
        }

        return $this->errorResponse('Validation Error!', implode('<br>-', $errMsg));
    }
}
