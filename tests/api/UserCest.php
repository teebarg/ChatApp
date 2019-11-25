<?php

class UserCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function GetUsersTest(ApiTester $I)
    {
        $I->wantTo('I want to get Users');
        $I->expectTo("To see returned Users");

        $I->sendGET('user');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["status" => "success", "code" => 200, "data" => ["username" => "zwisozk"]]);
    }

    public function StoreUserTest(ApiTester $I)
    {
        $I->wantTo('I want to Store User');
        $I->expectTo("To see Stored User");

        $uId = uniqid();

        $data = [
            'username' => "Test_$uId",
            'email' => "test_$uId@test.com",
            'password' => uniqid("password")
        ];

        $I->sendPOST('user', $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 200
        $I->seeResponseIsJson();
        $I->grabResponse();
        $I->seeResponseContainsJson(["status" => "Success", "code" => 200]);
    }

    public function ShowUserTest(ApiTester $I)
    {
        $I->wantTo('I want to Show User');
        $I->expectTo("To see a User");


        $I->sendGET('user/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["status" => "Success", "code" => 200, "data" => ["username" => "ryan.murl"]]);
    }

    public function UpdateUserTest(ApiTester $I)
    {
        $I->wantTo('I want to Update User');
        $I->expectTo("To see Updated User");

        $data = [
            'email' => "test_78@test.com"
        ];

        $I->sendPUT('user/1', $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["status" => "Success", "code" => 200]);
    }

    public function DeleteUserTest(ApiTester $I)
    {
        $I->wantTo('I want to Delete User');
        $I->expectTo("To see Deleted User");

        $I->sendDELETE('user/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["status" => "Success", "code" => 200]);
    }
}
