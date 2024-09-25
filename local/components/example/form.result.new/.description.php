<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("FORM_RESULT_NEW_COMPONENT"),
    "DESCRIPTION" => Loc::getMessage("FORM_RESULT_NEW_COMPONENT_DESCRIPTION"),
    "COMPLEX" => "N",
    "PATH" => [
        "ID" => Loc::getMessage("FORM_RESULT_NEW_PATH_ID"),
        "NAME" => Loc::getMessage("FORM_RESULT_NEW_PATH_NAME"),
    ],
];
?>