<?php
/**
 * Author: yorks
 * Date: 25.03.2020
 */

use app\controllers\CategoryController;
use app\tests\fixtures\UserFixture;

class CategoryCest
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

    public function openCategoryPage(\FunctionalTester $I)
    {
        $I->amOnPage(['category/index']);
        $I->see('Category list');
    }

    public function openCreateCategoryPage(\FunctionalTester $I)
    {
        $I->amOnPage(['category/index']);
        $I->see('Create new');
        $I->click('Create new');
        $I->see('Create category');
    }

    public function createCategoryEmpty(FunctionalTester $I)
    {
        $I->amOnPage(['category/create']);
        $I->submitForm('#create-category-form', [
            'WordCategory[title]' => ''
        ]);
        $I->expectTo('see validations errors');
        $I->see('Title cannot be blank.');
    }
    public function createCategorySucceful(FunctionalTester $I)
    {
        $I->amOnPage(['category/create']);
        $I->submitForm('#create-category-form', [
            'WordCategory[title]' => 'New created category'
        ]);
        $I->see('New created category');
    }

    public function importWords(FunctionalTester $I)
    {
        $I->amOnPage(['category/import']);

        $I->submitForm('#import-form', [
            'WordImportForm[category_id]' => 2,
            'WordImportForm[row]' => 'Pen;Ручка
             Watermelon;Дыня'
        ]);
        $I->see('Empty category 2');
    }

    public function deleteCategory(FunctionalTester $I)
    {
        $I->amOnPage(['category/index']);
        $I->see('Empty category');
        $I->amOnPage(['category/delete', 'id' => 2]);
        $I->dontSee('Empty category');
    }

}
