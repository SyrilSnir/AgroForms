<?php


class AuthorizationCest 
{
    public function ensureErrorLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('form button[name=login-button]');
        sleep(1);
        $I->fillField('#loginform-login', 'wrong_user'); 
        $I->fillField('#loginform-password', 'wrong_password'); 
        sleep(1);
        $I->click('form button[name=login-button]');  
        sleep(1.5);
        $I->canSee('Неверное имя пользователя или пароль');        
    }
}
