<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

class CFormResultNew extends CBitrixComponent
{
    public function executeComponent()
    {
        // Проверяем, что модуль веб-форм установлен
        if (!Loader::includeModule('form')) {
            throw new Exception(Loc::getMessage('FORM_MODULE_NOT_INSTALLED'));
        }

        // Получаем вопросы и поля веб-формы
        $this->arResult['FIELDS'] = $this->getFormFields($this->arParams['WEB_FORM_ID']);

        // Передаем параметры в шаблон
        $this->arResult['WEB_FORM_ID'] = $this->arParams['WEB_FORM_ID'];

        // Включаем шаблон
        $this->includeComponentTemplate();
    }

    protected function getFormFields($formId)
    {
        $fields = CFormField::GetList($formId, "s_sort", "asc", $by, $order);
        $formFields = [];

        while ($field = $fields->Fetch()) {
            $formFields[$field['SID']] = $field; // Сохраняем поле по SID
        }

        // Логируем данные вопросов и полей
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/form_fields.log', date('Y-m-d H:i:s') . " FORM FIELDS:\n" . json_encode($formFields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n", FILE_APPEND);
        
        return $formFields;
    }
}
?>