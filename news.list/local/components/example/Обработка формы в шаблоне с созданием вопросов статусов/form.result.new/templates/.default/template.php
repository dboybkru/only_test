<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.604825ed.ico" type="image/x-icon">
    <link href="/local/components/example/form.result.new/templates/.default/css/common.css" rel="stylesheet">
</head>
<body>

<?php
// Блок обработки формы
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['WEB_FORM_ID']) && $_POST['WEB_FORM_ID'] == $arResult['WEB_FORM_ID']) {
    // Подключаем модуль форм
    if (CModule::IncludeModule("form")) {
        // ID веб-формы
        $FORM_ID = $arResult['WEB_FORM_ID'];

        // Проверяем наличие статуса
        $statusExists = false;
        $statusID = null;
        $dbStatus = CFormStatus::GetList($FORM_ID, $by = "s_sort", $order = "asc");
        while ($arStatus = $dbStatus->Fetch()) {
            if ($arStatus['SID'] === 'NEW') { // Проверяем наличие статуса с SID 'NEW'
                $statusExists = true;
                $statusID = $arStatus['ID']; // Сохраняем ID существующего статуса
                break;
            }
        }

        // Если статус не существует, создаем его
        if (!$statusExists) {
            $statusObj = new CFormStatus();
            $statusID = $statusObj->Set(array(
                "FORM_ID" => $FORM_ID,
                "SID" => "NEW",
                "TITLE" => "Новый",
                "ACTIVE" => "Y",
                "C_SORT" => 100,
            ));
        }

        // Проверка доступа к заполнению формы
        $permission = CForm::GetPermission($FORM_ID);
        if ($permission < 30) { // 30 - уровень доступа для записи
            $logMessage = date('Y-m-d H:i:s') . " ERROR: У пользователя нет доступа к заполнению формы (permission: $permission).\n";
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/access.log', $logMessage, FILE_APPEND);
            echo "У вас нет доступа к заполнению этой формы.";
            exit;
        } else {
            $logMessage = date('Y-m-d H:i:s') . " INFO: Доступ к заполнению формы подтвержден (permission: $permission).\n";
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/access.log', $logMessage, FILE_APPEND);
        }

        // Подготовка массива значений ответов
        $arValues = array(
            "medicine_name" => $_POST['medicine_name'], // "Ваше имя"
            "medicine_company" => $_POST['medicine_company'], // "Компания/Должность"
            "medicine_email" => $_POST['medicine_email'], // "Email"
            "medicine_phone" => $_POST['medicine_phone'], // "Номер телефона"
            "medicine_message" => $_POST['medicine_message'], // "Сообщение"
            "STATUS_ID" => $statusID // Применяем статус
        );

        // Проверка на заполненность полей
        $emptyFields = [];
        foreach ($arValues as $key => $value) {
            if (empty($value) && in_array($key, ['medicine_name', 'medicine_company', 'medicine_email', 'medicine_phone'])) {
                $emptyFields[] = $key;
            }
        }

        if (!empty($emptyFields)) {
            $logMessage = date('Y-m-d H:i:s') . " ERROR: Обязательные поля не заполнены: " . implode(', ', $emptyFields) . ".\n";
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/validation.log', $logMessage, FILE_APPEND);
            echo "Поле(я) '" . implode(', ', $emptyFields) . "' обязательно для заполнения.";
            exit;
        } else {
            $logMessage = date('Y-m-d H:i:s') . " INFO: Все обязательные поля заполнены.\n";
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/validation.log', $logMessage, FILE_APPEND);
        }

        // Массив с вопросами и их параметрами
        $fields = [
            [
                "SID" => "medicine_name",
                "TITLE" => "Ваше имя",
                "FIELD_TYPE" => "text",
                "REQUIRED" => "Y"
            ],
            [
                "SID" => "medicine_company",
                "TITLE" => "Компания/Должность",
                "FIELD_TYPE" => "text",
                "REQUIRED" => "Y"
            ],
            [
                "SID" => "medicine_email",
                "TITLE" => "Email",
                "FIELD_TYPE" => "text",
                "REQUIRED" => "Y"
            ],
            [
                "SID" => "medicine_phone",
                "TITLE" => "Номер телефона",
                "FIELD_TYPE" => "text",
                "REQUIRED" => "Y"
            ],
            [
                "SID" => "medicine_message",
                "TITLE" => "Сообщение",
                "FIELD_TYPE" => "text",
                "REQUIRED" => "N"
            ]
        ];

        // Проверяем и создаем вопросы
        foreach ($fields as $field) {
            $fieldExists = false;

            // Проверяем, существует ли вопрос
            $dbFields = CFormField::GetList($FORM_ID, "s_sort", "asc");
            while ($arField = $dbFields->Fetch()) {
                if ($arField['SID'] === $field['SID']) {
                    $fieldExists = true;
                    break;
                }
            }

            // Если вопроса нет, создаем его
            if (!$fieldExists) {
                $fieldObj = new CFormField();
                $fieldObj->Set(array(
                    "SID" => $field['SID'],
                    "FORM_ID" => $FORM_ID,
                    "TITLE" => $field['TITLE'],
                    "FIELD_TYPE" => $field['FIELD_TYPE'],
                    "ACTIVE" => "Y",
                    "REQUIRED" => $field['REQUIRED'],
                    "IN_RESULTS_TABLE" => "Y",
                    "IN_EXCEL_TABLE" => "Y",
                    "RESULTS_TABLE_TITLE" => $field['TITLE'],
                ));
            }
        }

        // Создаем новый результат
        if ($RESULT_ID = CFormResult::Add($FORM_ID, $arValues)) {
            // Успешно добавлено
            $successMessage = "Результат #" . $RESULT_ID . " успешно создан.";
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/success.log', date('Y-m-d H:i:s') . " SUCCESS: " . $successMessage . "\n", FILE_APPEND);
            LocalRedirect('/thank-you/'); // Укажите путь к странице благодарности
            exit; // Завершаем выполнение скрипта после перенаправления
        } else {
            // Ошибка при добавлении
            global $APPLICATION;
            $error = $APPLICATION->GetException();
            $errorMessage = $error ? $error->GetString() : 'Неизвестная ошибка при добавлении результата.';
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/error.log', date('Y-m-d H:i:s') . " ERROR: " . $errorMessage . "\n", FILE_APPEND);
        }
    }
}
?>

<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований
        </div>
    </div>
    <form class="contact-form__form" method="post" action="<?= POST_FORM_ACTION_URI ?>">
        <?= bitrix_sessid_post(); ?>
        
        <input type="hidden" name="WEB_FORM_ID" value="<?= htmlspecialchars($arResult['WEB_FORM_ID']) ?>">
        
        <div class="contact-form__form-inputs">
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_name">
                    <div class="input__label-text">Ваше имя*</div>
                    <input class="input__input" type="text" id="medicine_name" name="medicine_name" value="" required="">
                    <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                </label>
            </div>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_company">
                    <div class="input__label-text">Компания/Должность*</div>
                    <input class="input__input" type="text" id="medicine_company" name="medicine_company" value="" required="">
                    <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                </label>
            </div>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_email">
                    <div class="input__label-text">Email*</div>
                    <input class="input__input" type="email" id="medicine_email" name="medicine_email" value="" required="">
                    <div class="input__notification">Неверный формат почты</div>
                </label>
            </div>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_phone">
                    <div class="input__label-text">Номер телефона*</div>
                    <input class="input__input" type="text" id="medicine_phone"
                           data-inputmask="'mask': '+79999999999', 'clearIncomplete': 'true'" maxlength="12"
                           x-autocompletetype="phone-full" name="medicine_phone" value="" required="">
                </label>
            </div>
        </div>
        <div class="contact-form__form-message">
            <div class="input">
                <label class="input__label" for="medicine_message">
                    <div class="input__label-text">Сообщение</div>
                    <textarea class="input__input" id="medicine_message" name="medicine_message"></textarea>
                    <div class="input__notification"></div>
                </label>
            </div>
        </div>
        <div class="contact-form__bottom">
            <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                данных&raquo;.
            </div>
            <button class="form-button contact-form__bottom-button" type="submit" data-success="Отправлено"
                    data-error="Ошибка отправки">
                <div class="form-button__title">Оставить заявку</div>
            </button>
        </div>
    </form>
</div>
</body>
</html>