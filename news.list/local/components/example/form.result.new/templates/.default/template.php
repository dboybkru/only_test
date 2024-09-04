<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Связаться</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="/local/components/example/webformintegration/templates/.default/images/favicon.604825ed.ico" type="image/x-icon">
    <link href="/local/components/example/webformintegration/templates/.default/css/common.css" rel="stylesheet">
</head>
<body>
    <div class="contact-form">
        <div class="contact-form__head">
            <div class="contact-form__head-title">Связаться</div>
            <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом ваших требований</div>
        </div>

        <form class="contact-form__form" method="POST" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data">
            <input type="hidden" name="WEB_FORM_ID" value="<?= htmlspecialchars($arParams['WEB_FORM_ID']) ?>">

            <div class="contact-form__form-inputs">
                <?php 
                $fields = [
                    ['label' => 'Ваше имя*', 'name' => 'form_text_1', 'type' => 'text', 'id' => 'medicine_name', 'required' => true],
                    ['label' => 'Компания/Должность*', 'name' => 'form_text_2', 'type' => 'text', 'id' => 'medicine_company', 'required' => true],
                    ['label' => 'Email*', 'name' => 'form_email_1', 'type' => 'email', 'id' => 'medicine_email', 'required' => true],
                    [
                        'label' => 'Номер телефона*',
                        'name' => 'form_text_3',
                        'type' => 'tel',
                        'id' => 'medicine_phone',
                        'required' => true,
                        'pattern' => '\+7[0-9]{10}', 
                        'notification' => 'Неверный формат номера, используйте +7XXXXXXXXXX (где X - цифры).'
                    ],
                ];
                foreach ($fields as $field): ?>
                    <div class="input contact-form__input">
                        <label class="input__label" for="<?= htmlspecialchars($field['id']) ?>">
                            <div class="input__label-text"><?= htmlspecialchars($field['label']) ?></div>
                            <input class="input__input"
                                   type="<?= htmlspecialchars($field['type']) ?>"
                                   id="<?= htmlspecialchars($field['id']) ?>"
                                   name="<?= htmlspecialchars($field['name']) ?>"
                                   value=""
                                   <?= $field['required'] ? 'required' : '' ?>
                                   <?= isset($field['pattern']) ? 'pattern="' . htmlspecialchars($field['pattern']) . '"' : '' ?>
                                   title="<?= isset($field['notification']) ? htmlspecialchars($field['notification']) : '' ?>">
                            <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="contact-form__form-message">
                <div class="input">
                    <label class="input__label" for="medicine_message">
                        <div class="input__label-text">Сообщение</div>
                        <textarea class="input__input" id="medicine_message" name="form_textarea_1" rows="4"></textarea>
                        <div class="input__notification"></div>
                    </label>
                </div>
            </div>
            
            <div class="contact-form__bottom">
                <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных данных&raquo;.</div>
                <button type="submit" class="form-button contact-form__bottom-button">
                    <div class="form-button__title">Оставить заявку</div>
                </button>
            </div>
        </form>

        <?php if (!empty($arResult['SUCCESS_MESSAGE'])): ?>
            <div class="success-message"><?= htmlspecialchars($arResult['SUCCESS_MESSAGE']) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>