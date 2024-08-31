<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ServicesList extends CBitrixComponent {

    private function _checkModules() {
        if (!Loader::includeModule('iblock')) {
            throw new \Exception('Модуль инфоблоков не загружен.');
        }

        return true;
    }

    public function onPrepareComponentParams($arParams) {
        return $arParams; 
    }

    public function executeComponent() {
        $this->_checkModules();

        $arFilter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
        ];
        $arSelect = ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT', 'PROPERTY_IMAGE']; 
        $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
        
        while ($item = $res->GetNext()) {
            $imageId = $item['PROPERTY_IMAGE_VALUE']; 
            $item['IMAGE_SRC'] = CFile::GetPath($imageId);
            $this->arResult['SERVICES'][] = $item;
        }

        $this->includeComponentTemplate();
    }
}
?>