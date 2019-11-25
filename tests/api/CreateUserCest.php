<?php

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function createUserViaAPI(\ApiTester $I)
    {
//        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('auth/login', [
            'email' => 'test@email123.com',
            'password' => '111111w'
        ]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["status" => "Success"]);

    }
}
