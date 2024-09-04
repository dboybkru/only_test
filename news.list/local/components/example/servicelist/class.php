<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CExampleArticleList extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        // Устанавливаем значения по умолчанию для параметров
        if (empty($arParams['IBLOCK_TYPE'])) {
            $arParams['IBLOCK_TYPE'] = 'shablon'; // Замените на тип инфоблока по умолчанию
        }
        if (empty($arParams['IBLOCK_ID'])) {
            $arParams['IBLOCK_ID'] = ''; // Здесь можно оставить пустым, если ID будет передан ниже
        }
        
        return $arParams;
    }

    public function executeComponent()
    {
        // Если ID инфоблока не задан, получаем его по типу
        if (empty($this->arParams['IBLOCK_ID'])) {
            $res = CIBlock::GetList([], ['IBLOCK_TYPE' => $this->arParams['IBLOCK_TYPE'], 'ACTIVE' => 'Y']);
            if ($iblock = $res->Fetch()) {
                $this->arParams['IBLOCK_ID'] = $iblock['ID'];
            }
        }

        // Загружаем элементы инфоблока
        if (!empty($this->arParams['IBLOCK_ID'])) {
            $this->loadArticles($this->arParams['IBLOCK_ID']);
        }

        $this->includeComponentTemplate();
    }

    private function loadArticles($iblockId)
    {
        $this->arResult['ARTICLES'] = [];
        $res = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
            false,
            false,
            ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT', 'DETAIL_PICTURE']
        );

        while ($item = $res->GetNext()) {
            $article = [
                'href' => $item['DETAIL_PAGE_URL'],
                'title' => $item['NAME'],
                'content' => $item['PREVIEW_TEXT'],
                'background' => !empty($item['DETAIL_PICTURE']) ? CFile::GetPath($item['DETAIL_PICTURE']) : '',
            ];
            $this->arResult['ARTICLES'][] = $article;
        }
    }
}
?>