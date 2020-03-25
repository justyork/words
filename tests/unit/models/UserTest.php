<?php

namespace tests\unit\models;

use app\models\User;
use app\tests\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{

    protected $tester;
    public function _fixtures()
    {
        return [
            'profiles' => [
                'class' => UserFixture::className(),
                // fixture data located in tests/_data/user.php
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('user');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('user');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByEmail()
    {
        expect_that($user = User::findByEmail('user@mail.ru'));
        expect_not(User::findByEmail('not-user@mail.ru'));
    }

    /**
     * @depends testFindUserByEmail
     */
    public function testValidateUser($user)
    {
        $user = User::findByEmail('user@mail.ru');
        expect_that($user->validateAuthKey('dt_VSi4HEae_HD47Vp2FnV3LXvNMSumz'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin123'));
        expect_not($user->validatePassword('123456'));
    }

}
