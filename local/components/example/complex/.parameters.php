<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arCurrentValues */

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    return;
}

// Получаем типы инфоблоков
$arIBlockType = CIBlockParameters::GetIBlockTypes();

// Получаем инфоблоки
$arIBlock = [];
if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $iblockFilter = [
        'ACTIVE' => 'Y',
        'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
    ];
} else {
    $iblockFilter = [
        'ACTIVE' => 'Y',
    ];
}

$rsIBlock = CIBlock::GetList(["SORT" => "ASC"], $iblockFilter);
while ($arr = $rsIBlock->Fetch()) {
    $arIBlock[$arr["ID"]] = "[" . $arr["ID"] . "] " . $arr["NAME"];
}

// Получаем свойства инфоблока
$arProperty_LNS = [];
$arProperty = [];
if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $rsProp = CIBlockProperty::GetList(
        [
            "SORT" => "ASC",
            "NAME" => "ASC",
        ],
        [
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"],
        ]
    );
    while ($arr = $rsProp->Fetch()) {
        $arProperty[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
        if (in_array($arr["PROPERTY_TYPE"], ["L", "N", "S", "E"])) {
            $arProperty_LNS[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
        }
    }
}

// Группы пользователей
$arUGroupsEx = [];
$dbUGroups = CGroup::GetList();
while ($arUGroups = $dbUGroups->Fetch()) {
    $arUGroupsEx[$arUGroups["ID"]] = $arUGroups["NAME"];
}

// Параметры компонента
$arComponentParameters = [
    "GROUPS" => [
        "RSS_SETTINGS" => [
            "SORT" => 110,
            "NAME" => GetMessage("T_IBLOCK_DESC_RSS_SETTINGS"),
        ],
        "RATING_SETTINGS" => [
            "SORT" => 120,
            "NAME" => GetMessage("T_IBLOCK_DESC_RATING_SETTINGS"),
        ],
        "CATEGORY_SETTINGS" => [
            "SORT" => 130,
            "NAME" => GetMessage("T_IBLOCK_DESC_CATEGORY_SETTINGS"),
        ],
        "REVIEW_SETTINGS" => [
            "SORT" => 140,
            "NAME" => GetMessage("T_IBLOCK_DESC_REVIEW_SETTINGS"),
        ],
        "FILTER_SETTINGS" => [
            "SORT" => 150,
            "NAME" => GetMessage("T_IBLOCK_DESC_FILTER_SETTINGS"),
        ],
    ],
    "PARAMETERS" => [
        "IBLOCK_TYPE" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ],
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ],
        "NEWS_COUNT" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ],
        "USE_SEARCH" => [
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_SEARCH"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "USE_RSS" => [
            "PARENT" => "RSS_SETTINGS",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_RSS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "USE_RATING" => [
            "PARENT" => "RATING_SETTINGS",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_RATING"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "USE_CATEGORIES" => [
            "PARENT" => "CATEGORY_SETTINGS",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_CATEGORIES"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "USE_REVIEW" => [
            "PARENT" => "REVIEW_SETTINGS",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_REVIEW"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "USE_FILTER" => [
            "PARENT" => "FILTER_SETTINGS",
            "NAME" => GetMessage("T_IBLOCK_DESC_USE_FILTER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y",
        ],
        "SORT_BY1" => [
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
            "TYPE" => "LIST",
            "DEFAULT" => "ACTIVE_FROM",
            "VALUES" => [
                "ID" => GetMessage("T_IBLOCK_DESC_FID"),
                "NAME" => GetMessage("T_IBLOCK_DESC_FNAME"),
                "ACTIVE_FROM" => GetMessage("T_IBLOCK_DESC_FACT"),
                "SORT" => GetMessage("T_IBLOCK_DESC_FSORT"),
                "TIMESTAMP_X" => GetMessage("T_IBLOCK_DESC_FTSAMP"),
            ],
            "ADDITIONAL_VALUES" => "Y",
        ],
        "SORT_ORDER1" => [
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => [
                "ASC" => GetMessage('T_IBLOCK_DESC_ASC'),
                "DESC" => GetMessage('T_IBLOCK_DESC_DESC'),
            ],
            "ADDITIONAL_VALUES" => "Y",
        ],
        // Добавьте другие параметры, как в вашем оригинальном коде
    ],
];

// Добавьте дополнительные настройки, если необходимо