<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['WEB_FORM_ID']) && $_POST['WEB_FORM_ID'] == 3) {
    // Подключаем модуль
    if (CModule::IncludeModule("form")) {
        $formId = 3; // ID вашей формы
        $result = new CFormResult();
        
        // Подготовка данных
        $arFields = array(
            "medicine_name" => $_POST['medicine_name'],
            "medicine_company" => $_POST['medicine_company'],
            "medicine_email" => $_POST['medicine_email'],
            "medicine_phone" => $_POST['medicine_phone'],
            "medicine_message" => $_POST['medicine_message'],
        );

        // Сохранение результата
        $result->Add($formId, $arFields);
        
        // Перенаправление или вывод сообщения об успешной отправке
        LocalRedirect('/thank-you/'); 
    }
}
?>