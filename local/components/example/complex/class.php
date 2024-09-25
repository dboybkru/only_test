<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class ExampleComplexComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->arParams["NEWS_ID"] = intval($this->arParams["NEWS_ID"]);

        if ($this->arParams["NEWS_ID"] > 0) {
            $this->getNewsDetail();
            $this->includeComponentTemplate("news.detail");
        } else {
            $this->getNewsList();
            $this->includeComponentTemplate("news.list");
        }
    }

    private function getNewsList()
    {
        // Получаем список категорий
        $rsSections = CIBlockSection::GetList(
            array(),
            array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"]),
            false,
            array("ID", "NAME")
        );

        while ($arSection = $rsSections->GetNext()) {
            $this->arResult["CATEGORIES"][] = $arSection;
        }

        // Получаем список новостей
        $filter = array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "ACTIVE" => "Y");
        if (!empty($this->arParams["SECTION_ID"])) {
            $filter["SECTION_ID"] = $this->arParams["SECTION_ID"];
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
            $this->arResult["NEWS_LIST"][] = $arNews;
        }
    }

    private function getNewsDetail()
    {
        // Получаем информацию о новостном инфоблоке
        $iblockId = $this->arParams["IBLOCK_ID"];
        $newsId = $this->arParams["NEWS_ID"];
        
        // Получаем информацию о инфоблоке по ID
        $iblock = CIBlock::GetIBlock($iblockId);
        if (!$iblock) {
            // Обработка ошибки: инфоблок не найден
            ShowError("Инфоблок не найден.");
            return;
        }

        // Получаем новость по ID
        $rsNews = CIBlockElement::GetByID($newsId);
        if ($arNews = $rsNews->GetNext()) {
            $arNews["DETAIL_PICTURE"] = CFile::GetPath($arNews["DETAIL_PICTURE"]);
            $this->arResult["NEWS"] = $arNews;
        } else {
            // Обработка ошибки: новость не найдена
            ShowError("Новость не найдена.");
        }
    }
}