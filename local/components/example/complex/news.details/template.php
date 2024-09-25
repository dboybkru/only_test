<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $arResult["NEWS"]["NAME"] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/favicon.604825ed.ico" type="image/x-icon">
    <link href="css/common.css" rel="stylesheet">
</head>
<body>
<div class="article-card">
    <div class="article-card__title"><?= $arResult["NEWS"]["NAME"] ?></div>
    <div class="article-card__date"><?= $arResult["NEWS"]["DATE_ACTIVE_FROM"] ?></div>
    <div class="article-card__content">
        <div class="article-card__image sticky">
            <img src="<?= $arResult["NEWS"]["DETAIL_PICTURE"] ?>" alt="" data-object-fit="cover"/>
        </div>
        <div class="article-card__text">
            <div class="block-content" data-anim="anim-3">
                <?= $arResult["NEWS"]["DETAIL_TEXT"] ?>
            </div>
            <a class="article-card__button" href="/news"><?= GetMessage("EXAMPLE_COMPLEX_NEWS_DETAIL_BACK_LINK") ?></a>
        </div>
    </div>
</div>
</body>
</html>