<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentParameters = [
    'PARAMETERS' => [
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'WEB_FORM_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('WEB_FORM_ID'),
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],
    ]
];
?>