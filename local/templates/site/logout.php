<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выход");

// Выход из системы
global $USER;
if ($USER->IsAuthorized()) {
    $USER->Logout();
}

// Перенаправление на главную страницу
LocalRedirect("/");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>