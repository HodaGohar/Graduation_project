<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Exception;

trait HandlesApiExceptions{
    public function HandleApiExceptions(callable $callback){
        try{
            return $callback();
        }catch(ValidationException $e){
            return response()->json([
                'message' => 'Validate error',
                'errors' => $e->errors(),
            ],422);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Something went wrong. Please try again.',
               'errors' => $e->getMessage()
            ] , 500);
        }
    }
}
