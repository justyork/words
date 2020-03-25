<?php
/**
 * Author: yorks
 * Date: 25.03.2020
 */

namespace unit\models;

use app\models\Word;
use app\tests\fixtures\UserFixture;

class WordTest extends \Codeception\Test\Unit
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

//
//    public function testAddWordCategory()
//    {
//
//    }
//
//    public function testAddWord()
//    {
//
//    }




}
