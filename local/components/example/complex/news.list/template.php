<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<h1><?= GetMessage("EXAMPLE_COMPLEX_NEWS_LIST_TITLE") ?></h1>
<div class="news-categories">
    <a href="/news"><?= GetMessage("EXAMPLE_COMPLEX_NEWS_LIST_ALL_CATEGORIES") ?></a>
    <?php foreach ($arResult["CATEGORIES"] as $category): ?>
        <a href="/news?category=<?= $category["ID"] ?>"><?= $category["NAME"] ?></a>
    <?php endforeach; ?>
</div>
<div class="news-list">
    <?php foreach ($arResult["NEWS_LIST"] as $news): ?>
        <div class="article-card">
            <div class="article-card__title"><?= $news["NAME"] ?></div>
            <div class="article-card__date"><?= $news["DATE_ACTIVE_FROM"] ?></div>
            <div class="article-card__content">
                <div class="article-card__image sticky">
                    <img src="<?= $news["PREVIEW_PICTURE"] ?>" alt="" data-object-fit="cover"/>
                </div>
                <div class="article-card__text">
                    <div class="block-content" data-anim="anim-3">
                        <p><?= $news["PREVIEW_TEXT"] ?></p>
                    </div>
                    <a class="article-card__button" href="<?= $news["DETAIL_PAGE_URL"] ?>"><?= GetMessage("EXAMPLE_COMPLEX_NEWS_LIST_DETAIL_LINK") ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>