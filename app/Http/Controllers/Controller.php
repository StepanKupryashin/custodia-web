<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function susscesResponse($res, $code = 200)
    {
        return response()->json(
            [
                'success' => true,
                'response' => $res
            ]
            ,
            $code
        );
    }
    public function failResponse($res, $code = 403)
    {
        return response()->json(
            [
                'success' => false,
                'message' => 'Invalid response',
                'response' => $res
            ]
            ,
            $code
        );
    }
}
