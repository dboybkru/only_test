<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Список статей"); 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/images/favicon.ico" type="image/x-icon">
    <link href="/local/components/example/article_list/templates/.default/css/common.css" rel="stylesheet"> <!-- Проверьте путь -->
</head>
<body>
<div id="barba-wrapper">
    <div class="article-list">
        <?php
        // Перебор и вывод статей
        foreach ($arResult['ARTICLES'] as $article) {
            echo '<a class="article-item article-list__item" href="' . $article['href'] . '" data-anim="anim-3">
                    <div class="article-item__background"><img src="' . $article['background'] . '" alt=""/></div>
                    <div class="article-item__wrapper">
                        <div class="article-item__title">' . $article['title'] . '</div>
                        <div class="article-item__content">' . $article['content'] . '</div>
                    </div>
                </a>';
        }
        ?>
    </div>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
</body>
</html>