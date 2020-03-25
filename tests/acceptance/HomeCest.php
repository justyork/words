<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('site/index'));
        $I->see('LWords');

        $I->seeLink('Категории');
        $I->click('Категории');
        $I->wait(2); // wait for page to be opened

        $I->see('Список категорий');
    }
}
