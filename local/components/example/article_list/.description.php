<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("EXAMPLE_ARTICLE_LIST_COMPONENT"),
    "DESCRIPTION" => Loc::getMessage("EXAMPLE_ARTICLE_LIST_COMPONENT_DESCRIPTION"),
    "COMPLEX" => "N",
    "PATH" => [
        "ID" => "example",
        "NAME" => Loc::getMessage("EXAMPLE_ARTICLE_LIST_NAME"),
    ],
];
?>