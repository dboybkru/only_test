<?php
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ExampleWebFormIntegration extends CBitrixComponent {
    private $_request;

    public function onPrepareComponentParams($arParams) {
        return $arParams;
    }

    public function executeComponent() {
        global $APPLICATION;
        $this->_request = Application::getInstance()->getContext()->getRequest();

        if ($this->_request->isPost() && $this->_request['medicine_name']) {
            $this->arResult['SUCCESS_MESSAGE'] = 'Ваша заявка отправлена!';
        }

        $this->includeComponentTemplate();
    }
}