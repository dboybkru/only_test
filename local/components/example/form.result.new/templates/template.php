<?php
// Обработка формы при отправке
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Здесь можно добавить логику обработки данных формы
    $name = htmlspecialchars($_POST['medicine_name']);
    $company = htmlspecialchars($_POST['medicine_company']);
    $email = htmlspecialchars($_POST['medicine_email']);
    $phone = htmlspecialchars($_POST['medicine_phone']);
    $message = htmlspecialchars($_POST['medicine_message']);

    // Например, можно отправить данные на почту или сохранить в базу данных
    // mail($to, $subject, $message); // Пример отправки почты
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Контактная форма</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.604825ed.ico" type="image/x-icon">
    <link href="css/common.css" rel="stylesheet">
</head>
<body>
<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований
        </div>
    </div>
    <form class="contact-form__form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                    <input class="input__input" type="tel" id="medicine_phone" data-inputmask="'mask': '+79999999999', 'clearIncomplete': 'true'" maxlength="12" x-autocompletetype="phone-full" name="medicine_phone" value="" required="">
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
            <button class="form-button contact-form__bottom-button" data-success="Отправлено" data-error="Ошибка отправки">
                <div class="form-button__title">Оставить заявку</div>
            </button>
        </div>
    </form>
</div>
</body>
</html>