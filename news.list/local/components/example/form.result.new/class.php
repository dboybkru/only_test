<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

class CFormResultNew extends CBitrixComponent
{
    public function executeComponent()
    {
        $this->log("Component execution started.");

        if (!Loader::includeModule('form')) {
            $this->log("Form module not installed.");
            throw new Exception(Loc::getMessage('FORM_MODULE_NOT_INSTALLED'));
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && check_bitrix_sessid()) {
            $this->log("Processing form submission.");
            $this->processForm();
        }

        $this->includeComponentTemplate();
    }

    protected function processForm()
    {
        $incomingData = $_POST;
        $this->log("Incoming request data: " . json_encode($incomingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (empty($this->arParams['WEB_FORM_ID'])) {
            $this->log("WEB_FORM_ID not specified.");
            return;
        }

        $formId = $this->arParams['WEB_FORM_ID'];

        // Получаем информацию о полях и вопросах формы
        $rsFields = CFormField::GetList($formId, 'ALL', $by = 's_id', $order = 'asc', [], $is_filtered);
        $questionIdMap = [];
        $fieldTypes = [];

        while ($arField = $rsFields->Fetch()) {
            $questionIdMap[$arField['SID']] = $arField['ID'];
            $this->log("Mapped SID: {$arField['SID']} to Question ID: {$arField['ID']}");
        }

        // Получаем информацию о типах ответов
        foreach ($questionIdMap as $sid => $questionId) {
            $rsAnswers = CFormAnswer::GetList($questionId, $by = "s_id", $order = "asc", [], $is_filtered);
            while ($arAnswer = $rsAnswers->Fetch()) {
                $fieldTypes[$sid] = $arAnswer['FIELD_TYPE'];
                $this->log("Question ID: {$questionId}, Answer Field Type: {$arAnswer['FIELD_TYPE']}");
            }
        }

        $this->log("Question IDs mapped successfully.");

        // Обязательные поля, включая medicine_phone
        $requiredFields = ['medicine_name', 'medicine_company', 'medicine_email', 'medicine_phone'];
        foreach ($requiredFields as $field) {
            if (empty($incomingData[$field])) {
                $outgoingData = [
                    'status' => 'error',
                    'message' => "Поле '{$field}' обязательно для заполнения."
                ];
                $this->log("Error: " . $outgoingData['message']);
                return;
            }
        }

        $this->log("All required fields are filled.");

        $resultId = CFormResult::Add($formId, [
            'NAME' => $incomingData['medicine_name'],
            'COMPANY' => $incomingData['medicine_company'],
            'EMAIL' => $incomingData['medicine_email'],
            'PHONE' => $incomingData['medicine_phone']
        ]);

        if ($resultId) {
            $this->log("Form result added successfully with ID: $resultId.");
        } else {
            $this->log("Failed to add form result.");
            return;
        }

        $outgoingData = [
            'status' => 'success',
            'message' => 'Форма успешно обработана.'
        ];

        // Установка ответов для результата формы
        foreach ($questionIdMap as $sid => $questionId) {
            if (isset($incomingData[$sid])) {
                $value = $incomingData[$sid];
                $fieldType = $fieldTypes[$sid] ?? 'unknown';
                $this->log("Setting field for SID: $sid with value: $value and field type: $fieldType");

                $setResult = CFormResult::SetField($resultId, $sid, [$questionId => $value]);
                if ($setResult) {
                    $this->log("Field for SID: $sid set successfully.");
                } else {
                    $this->log("Failed to set field for SID: $sid.");
                }
            }
        }

        $this->log("Answers set successfully.");
        $this->log("Outgoing response data: " . json_encode($outgoingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    protected function log($message)
    {
        $logEntry = date('Y-m-d H:i:s') . " " . $message . "\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_templ.txt', $logEntry, FILE_APPEND);
    }
}
?>