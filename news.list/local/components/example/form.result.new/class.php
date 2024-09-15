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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid()) {
            $this->processForm();
        }

        $this->includeComponentTemplate();
    }

    protected function processForm()
    {
        // Логирование входящих данных
        $incomingData = $_POST; // Входящие данные
        $logEntryIn = date('Y-m-d H:i:s') . " IN:\n" . json_encode($incomingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntryIn, FILE_APPEND);

        // Проверяем, что веб-форма выбрана
        if (empty($this->arParams['WEB_FORM_ID'])) {
            return;
        }

        // Проверяем, что все обязательные поля заполнены
        $requiredFields = ['medicine_name', 'medicine_company', 'medicine_email', 'medicine_phone'];
        foreach ($requiredFields as $field) {
            if (empty($incomingData[$field])) {
                $outgoingData = [
                    'status' => 'error',
                    'message' => "Поле '{$field}' обязательно для заполнения."
                ];
                // Логируем ошибку
                $logEntryError = date('Y-m-d H:i:s') . " ERROR:\n" . json_encode($outgoingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n";
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntryError, FILE_APPEND);
                return;
            }
        }

        // Подготовка массива значений ответов без префиксов
        $arValues = [
            "medicine_name" => $incomingData['medicine_name'],
            "medicine_company" => $incomingData['medicine_company'],
            "medicine_email" => $incomingData['medicine_email'],
            "medicine_phone" => $incomingData['medicine_phone'],
            "medicine_message" => $incomingData['medicine_message'],
        ];

        // Логирование массива значений перед добавлением
        $logEntryValues = date('Y-m-d H:i:s') . " VALUES:\n" . json_encode($arValues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntryValues, FILE_APPEND);

        // Создаем новый результат формы
        $resultId = CFormResult::Add($this->arParams['WEB_FORM_ID'], $arValues);

        if ($resultId) {
            // Успешно добавлено
            $outgoingData = [
                'status' => 'success',
                'message' => 'Форма успешно обработана. ID результата: ' . $resultId
            ];
        } else {
            // Ошибка при добавлении
            global $APPLICATION;
            $error = $APPLICATION->GetException();
            $errorMessage = $error ? $error->GetString() : 'Неизвестная ошибка при добавлении результата.';
            
            // Логируем ошибку с дополнительной информацией
            $logEntryError = date('Y-m-d H:i:s') . " ERROR:\n" . json_encode(['status' => 'error', 'message' => $errorMessage, 'arValues' => $arValues], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n";
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntryError, FILE_APPEND);

            $outgoingData = [
                'status' => 'error',
                'message' => 'Ошибка при обработке формы: ' . $errorMessage
            ];
        }

        // Логирование исходящих данных
        $logEntryOut = date('Y-m-d H:i:s') . " OUT:\n" . json_encode($outgoingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\nAR_VALUES:\n" . json_encode($arValues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n________\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntryOut, FILE_APPEND);
    }
}
?>