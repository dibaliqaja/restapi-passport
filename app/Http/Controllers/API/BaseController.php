<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @param [type] $result
     * @param [type] $message
     * @return Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success'   => true,
            'data'      => $result,
            'message'   => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @param [type] $error
     * @param array $errorMessages
     * @param integer $code
     * @return Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success'   => false,
            'message'   => $error
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
