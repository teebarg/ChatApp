<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Helpers\ResponseHelper;

class BaseController extends Controller
{
    //
    /**
     * @param array $responseArray
     * @return \Illuminate\Http\Response
     */
    public function processError(array $responseArray)
    {
        $errorMessage = $responseArray['message'];
        $errorCode = $responseArray['code'];

        $data = array_key_exists('data', $responseArray) && is_array($responseArray['data'])
            ? $responseArray['data'] : [];

        $httpResponseCode = isset($responseArray['http_response_code']) ? $responseArray['http_response_code'] : 200;

        return $this->sendError($errorMessage, $errorCode, $data, $httpResponseCode);
    }

    /**
     * @param $message
     * @param $error_code
     * @param array $data
     * @param int $http_response_code
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $error_code, array $data = [], $http_response_code = 401)
    {
        return ResponseHelper::createErrorResponse($message, $error_code, $data, $http_response_code);
    }

    public function sendSuccess($message, array $data = [])
    {
        return ResponseHelper::createSuccessResponse($data, $message);
    }
}
