<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// Создаем массив с данными формы
$formFields = [
    'medicine_name' => [
        'label' => 'Имя',
        'type' => 'text',
        'name' => 'form_text_74',
        'value' => '',
        'required' => true,
    ],
    'medicine_company' => [
        'label' => 'Компания',
        'type' => 'text',
        'name' => 'form_text_75',
        'value' => '',
        'required' => true,
    ],
    'medicine_phone' => [
        'label' => 'Телефон',
        'type' => 'text',
        'name' => 'form_text_119',
        'value' => '',
        'required' => true,
    ],
    'medicine_email' => [
        'label' => 'Email',
        'type' => 'email',
        'name' => 'form_email_76',
        'value' => '',
        'required' => true,
    ],
    'medicine_message' => [
        'label' => 'Сообщение',
        'type' => 'textarea',
        'name' => 'form_textarea_120',
        'value' => '',
        'required' => false,
    ],
];

if ($arResult["isFormErrors"] == "Y"):?>
    <?=$arResult["FORM_ERRORS_TEXT"];?>
<?endif;?>
<?=$arResult["FORM_NOTE"]?>
<?if ($arResult["isFormNote"] != "Y") { ?>
    <?=$arResult["FORM_HEADER"]?>
    <html lang="ru">
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.604825ed.ico" type="image/x-icon">
        <link href="/local/templates/site/components/bitrix/from.result.new/template1/css/common.css" rel="stylesheet">
    </head>
    <body>
    <div class="contact-form">
        <div class="contact-form__head">
            <div class="contact-form__head-title">Связаться</div>
            <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
                ваших требований
            </div>
        </div>
        <form class="contact-form__form" action="<?=$arResult['FORM_ACTION']?>" method="POST">
            <?=bitrix_sessid_post()?>
            <div class="contact-form__form-inputs">
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_name">
                        <div class="input__label-text">Ваше имя*</div>
                        <input class="input__input" type="text" id="medicine_name" name="form_text_74" 
                               value="<?=$formFields['medicine_name']['value']?>" required="">
                        <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                    </label>
                </div>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_company">
                        <div class="input__label-text">Компания/Должность*</div>
                        <input class="input__input" type="text" id="medicine_company" name="form_text_75" 
                               value="<?=$formFields['medicine_company']['value']?>" required="">
                        <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                    </label>
                </div>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_email">
                        <div class="input__label-text">Email*</div>
                        <input class="input__input" type="email" id="medicine_email" name="form_email_76" 
                               value="<?=$formFields['medicine_email']['value']?>" required="">
                        <div class="input__notification">Неверный формат почты</div>
                    </label>
                </div>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_phone">
                        <div class="input__label-text">Номер телефона*</div>
                        <input class="input__input" type="tel" id="medicine_phone" 
                               data-inputmask="'mask': '+79999999999', 'clearIncomplete': 'true'" maxlength="12"
                               x-autocompletetype="phone-full" name="form_text_119" 
                               value="<?=$formFields['medicine_phone']['value']?>" required="">
                    </label>
                </div>
            </div>
            <div class="contact-form__form-message">
                <div class="input">
                    <label class="input__label" for="medicine_message">
                        <div class="input__label-text">Сообщение</div>
                        <textarea class="input__input" id="medicine_message" name="form_textarea_120" 
                                  required=""><?=$formFields['medicine_message']['value']?></textarea>
                        <div class="input__notification"></div>
                    </label>
                </div>
            </div>
            <div class="contact-form__bottom">
                <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                    ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                    данных&raquo;.
                </div>
                <button class="form-button contact-form__bottom-button" data-success="Отправлено"
                        data-error="Ошибка отправки" type="submit" name="web_form_submit"
                        value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>">
                    <div class="form-button__title">Оставить заявку</div>
                </button>
            </div>
        </form>
        <p>
            <?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
        </p>
        <?=$arResult["FORM_FOOTER"]?>
    </div>
    </body>
    </html>
<?php
} // endif (isFormNote)
?>