<?php

class CompaniesCest
{
    public function ensureAddCompany(AcceptanceTester $I) 
    {
        $I->amOnPage('/');
        $I->fillField('#loginform-login', 'admin'); 
        $I->fillField('#loginform-password', '123'); 
        $I->click('form button[name=login-button]');  
        sleep(2.5);
        $I->click('Администрирование');     
        sleep(0.5);
        $I->click('Пользователи и роли');
        sleep(0.5);
        $I->click('Компании');
        sleep(0.5);
        $I->click('Новая компания');
        sleep(2.5); 
        $I->fillField('#companyform-name', 'Spec Master');
        $I->fillField('#companyform-fullname', 'Spec Master SuperCo');
        $I->fillField('#companyform-inn', '53456674567');
        $I->fillField('#companyform-kpp', '535345345345');
        $I->fillField('#companyform-phone', '999-99-99');
        $I->fillField('#companyform-fax', '999-99-99');
        $I->fillField('#companyform-site', 'preved.medved');
        sleep(.5);
        $I->click('Адрес');
        $I->fillField('#legaladdressform-index', '121355');      
        $I->fillField('#legaladdressform-address', 'ул. Пушкина, дом Колотушкина');      
        $I->fillField('#postaladdressform-index', '121355');      
        $I->fillField('#postaladdressform-address', 'ул. Пушкина, дом Колотушкина');          
        sleep(.5);
        $I->click('Контакты');        
        $I->fillField('#contactform-chiefposition', 'Помощник дворника');
        $I->fillField('#contactform-chieffio', 'Рулон Обоев');
        $I->fillField('#contactform-chiefphone', '999-99-99');
        $I->fillField('#contactform-chiefemail', 'rulon@mail.test');
        
        $I->fillField('#contactform-managerposition', 'Дворник');
        $I->fillField('#contactform-managerfio', 'Рекорд Надоев');
        $I->fillField('#contactform-manageremail', 'rekord@mail.test');
        $I->fillField('#contactform-managerphone', '999-99-99');
        $I->fillField('#contactform-managerfax', '999-99-99');                    
        sleep(.5);        
        $I->click('Банковские реквизиты');        
        $I->fillField('#bankdetailform-rsschet', '4254325455366747657565675');         
        $I->fillField('#bankdetailform-ksschet', '4254325455366747657565675');         
        $I->fillField('#bankdetailform-bik', '4254325455366747657565675');         
        $I->fillField('#bankdetailform-bankinfo', 'Банк такой-то');         
        sleep(3);
        //$I->click('Сохранить');
    }
}

