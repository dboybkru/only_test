<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");

// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["LOGIN"]) && !empty($_POST["PASSWORD"])) {
    $APPLICATION->AuthForm("", false);
}
?>

<h2>Форма авторизации</h2>
<form method="post" action="<?=POST_FORM_ACTION_URI?>">
    <div>
        <label for="LOGIN">Логин:</label>
        <input type="text" name="LOGIN" id="LOGIN" required>
    </div>
    <div>
        <label for="PASSWORD">Пароль:</label>
        <input type="password" name="PASSWORD" id="PASSWORD" required>
    </div>
    <div>
        <input type="submit" value="Войти">
    </div>
</form>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>