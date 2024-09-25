<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<link href="/local/components/example/servicelist/templates/.default/css/common.css" rel="stylesheet">

<div class="article-list">
    <?php if (!empty($arResult['ARTICLES'])): ?>
        <?php foreach ($arResult['ARTICLES'] as $article): ?>
            <a class="article-item" href="<?= $article['href'] ?>">
                <div class="article-item__background">
                    <img src="<?= $article['background'] ?>" alt=""/>
                </div>
                <div class="article-item__wrapper">
                    <div class="article-item__title"><?= $article['title'] ?></div>
                    <div class="article-item__content"><?= $article['content'] ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Статьи не найдены.</p>
    <?php endif; ?>
</div>