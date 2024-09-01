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

        $arSelect = ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE'];

        $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

        while ($item = $res->GetNext()) {
            $imageId = $item['PREVIEW_PICTURE']; 
            if ($imageId) {
                $item['IMAGE_SRC'] = CFile::GetPath($imageId);
            } else {
                $item['IMAGE_SRC'] = '/local/components/example/serviceslist/images/default.jpg'; 
            }

            $this->arResult['SERVICES'][] = $item; 
        }

        $this->includeComponentTemplate();
    }
}
?>
