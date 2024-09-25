<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    "NAME" => GetMessage("EXAMPLE_COMPLEX_COMPONENT_NAME"),
    "DESCRIPTION" => GetMessage("EXAMPLE_COMPLEX_COMPONENT_DESCRIPTION"),
    "PATH" => array(
        "ID" => Loc::getMessage("EXAMPLE_COMPLEX_COMPONENT_PATH_ID"),
        "NAME" => GetMessage("EXAMPLE_COMPLEX_COMPONENT_PATH_NAME"),
    ),
);