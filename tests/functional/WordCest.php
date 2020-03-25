<?php
/**
 * Author: yorks
 * Date: 25.03.2020
 */

use app\controllers\CategoryController;
use app\tests\fixtures\UserFixture;

class WordCest
{

    public function _fixtures()
    {
        return [
            'profiles' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'categories' => [
                'class' => \app\tests\fixtures\CategoryFixture::className(),
                'dataFile' => codecept_data_dir() . 'category.php'
            ],
            'words' => [
                'class' => \app\tests\fixtures\WordFixture::className(),
                'dataFile' => codecept_data_dir() . 'word.php'
            ],
        ];
    }

    public function _before(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
    }

    public function openCategoryPage(FunctionalTester $I)
    {
        $I->amOnPage(['category/get', 'id' => 1]);
        $I->see('Filled category 3');
    }

    public function addWordEmpty(FunctionalTester $I)
    {
        $I->amOnPage(['word/create', 'id' => 1]);
        $I->submitForm('#word-form', [
            'Word[word]' => '',
            'Word[translate]' => '',
        ]);

        $I->expectTo('see validations errors');
        $I->see('Word cannot be blank.');
        $I->see('Translate cannot be blank.');
    }

    public function addWordSuccess(FunctionalTester $I)
    {
        $I->amOnPage(['word/create', 'id' => 1]);
        $I->submitForm('#word-form', [
            'Word[word]' => 'One',
            'Word[translate]' => 'Один',
        ]);

        $I->see('One');
    }

}
