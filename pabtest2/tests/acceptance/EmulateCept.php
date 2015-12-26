<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Fill form');
$I->amOnPage('/reg.php');


$I->seeElement('input', ['name' => 'sbmt', 'id' => 'rg_sbmt1', ]);
$I->click('input#rg_sbmt1');
$I->seeElement('form', ['name' => 'MMform']);

$I->submitForm('*[name=MMform]', [
    'fio' => 'Иванов Иван Иванович',
    'phone' => '71111111111',
    'email' => 'ivani@mail.ru'
]);

