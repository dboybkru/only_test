<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (CModule::IncludeModule("form")) {
    $GLOBALS['strError'] = '';

    // Параметры компонента
    $arDefaultComponentParameters = array(
        "WEB_FORM_ID" => $_REQUEST["WEB_FORM_ID"],
        "SEF_MODE" => "N",
        "IGNORE_CUSTOM_TEMPLATE" => "N",
        "USE_EXTENDED_ERRORS" => "N",
        "CACHE_TIME" => "3600",
    );

    foreach ($arDefaultComponentParameters as $key => $value) {
        if (!isset($arParams[$key])) {
            $arParams[$key] = $value;
        }
    }

    // Получение данных формы
    $formResult = CForm::GetByID($arParams["WEB_FORM_ID"]);
    if ($form = $formResult->Fetch()) {
        $arResult["arForm"] = $form;

        // Проверка и обработка отправки формы
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['WEB_FORM_ID'] == $arParams['WEB_FORM_ID'])) {
            $arResult["arrVALUES"] = $_POST;

            // Логирование отправленных данных
            $logData = "Отправленные данные формы:\n";
            foreach ($arResult["arrVALUES"] as $key => $value) {
                $logData .= "[$key] => " . $value . "\n";
            }
            $logData .= "-------------------------\n"; // Разделитель для разных отправок
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/log.txt", $logData, FILE_APPEND);

            // Проверка ошибок
            $arResult["FORM_ERRORS"] = CForm::Check($arParams["WEB_FORM_ID"], $arResult["arrVALUES"], false, "Y", $arParams['USE_EXTENDED_ERRORS']);

            if (empty($arResult["FORM_ERRORS"])) {
                if (check_bitrix_sessid()) {
                    // Добавление результата
                    $RESULT_ID = CFormResult::Add($arParams["WEB_FORM_ID"], $arResult["arrVALUES"]);
                    if ($RESULT_ID) {
                        // Успешно добавлено
                        $arResult["FORM_RESULT"] = 'addok';
                        // Перенаправление после успешной отправки
                        LocalRedirect($APPLICATION->GetCurPageParam("formresult=addok", array('formresult', 'WEB_FORM_ID')));
                    } else {
                        // Ошибка добавления
                        $arResult["FORM_ERRORS"][] = $GLOBALS["strError"];
                    }
                }
            }
        }

        // Формирование заголовка и подвала формы
        $arResult["FORM_HEADER"] = sprintf(
            "<form name=\"%s\" action=\"%s\" method=\"%s\" enctype=\"multipart/form-data\">",
            $arResult["arForm"]["SID"],
            POST_FORM_ACTION_URI,
            "POST"
        ) . bitrix_sessid_post() . '<input type="hidden" name="WEB_FORM_ID" value="' . $arParams['WEB_FORM_ID'] . '" />';

        $arResult["FORM_FOOTER"] = "</form>";

        // Включение шаблона
        $this->IncludeComponentTemplate();
    } else {
        ShowError("Форма не найдена.");
    }
} else {
    ShowError(GetMessage("FORM_MODULE_NOT_INSTALLED"));
}
?>