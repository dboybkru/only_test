<?php
// Получаем список категорий
$rsSections = CIBlockSection::GetList(
    array(),
    array("IBLOCK_ID" => $arParams["IBLOCK_ID"]),
    false,
    array("ID", "NAME")
);

while ($arSection = $rsSections->GetNext()) {
    $arResult["CATEGORIES"][] = $arSection;
}

// Получаем список новостей
$filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
if (!empty($arParams["SECTION_ID"])) {
    $filter["SECTION_ID"] = $arParams["SECTION_ID"];
}

$rsNews = CIBlockElement::GetList(
    array("ACTIVE_FROM" => "DESC"),
    $filter,
    false,
    false,
    array("ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL")
);

while ($arNews = $rsNews->GetNext()) {
    $arNews["PREVIEW_PICTURE"] = CFile::GetPath($arNews["PREVIEW_PICTURE"]);
    $arResult["NEWS_LIST"][] = $arNews;
}