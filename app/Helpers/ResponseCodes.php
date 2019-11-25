<?php

namespace App\Helpers;


class ResponseCodes
{
    // System and Generic Errors
    const INVALID_REQUEST = 1;
    const SESSION_ID_REQUIRED = 2;
    const NOT_FOUND = 3;
    const EXCEPTION_THROWN = 4;
    const INVALID_PARAM = 5;
    const INCOMPLETE_PARAM = 6;
    const ACTION_FAILED = 7;
    const RESOURCE_NOT_FOUND = 8;
    const FAILED_VALIDATION = 9;
    const RESOURCE_AUTHORISATION_ERROR = 10;
    const REQUEST_NOT_PERMITTED = 11;
    const ROUTE_NOT_FOUND = 12;
    const UNABLE_TO_PROCESS = 13;
    const TEST_MODE_ONLY = 14;

    // Other Errors
    const LOGIN_FAIL = 101;
    const USER_NOT_LOGGED_IN = 102;
    const INVALID_CONTACT_METHOD = 113;
    const INVALID_ADDRESS = 114;
    const ADDRESS_LABEL_EXIST = 115;
    const ADDRESS_NOT_SET = 116;
    const USER_WITH_EMAIL_EXIST = 130;
    const USER_NOT_EXIST = 131;
    const UNABLE_TO_VERIFY_CODE = 132;
    const PASSWORD_MISMATCH = 133;

    const ACTION_SUCCESSFUL = 200;
    const UNPROCESSABLE_ENTITY = 422;

    const PERMISSION_DENIED = 403;

}
