<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Наши услуги</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">    
    <link href="/local/components/example/serviceslist/css/common.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Gilroy', sans-serif;
            margin: 0;
            padding: 0;
        }

        .article-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }

        .service-item {
            flex: 1 1 calc(33% - 20px);
            margin: 10px;
            overflow: hidden;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .service-item:hover {
            transform: scale(1.05);
        }

        .service-item__background {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .service-item__background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-item__wrapper {
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .service-item__title {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<div id="barba-wrapper">
    <div class="article-list">
        <?php if (!empty($arResult['SERVICES'])): ?>
            <?php foreach ($arResult['SERVICES'] as $service): ?>
                <div class="service-item">
                    <a href="<?= htmlspecialchars($service['DETAIL_PAGE_URL']) ?>" class="service-item__link">
                        <div class="service-item__background">
                            <img src="<?= htmlspecialchars($service['IMAGE_SRC']) ?>" alt="<?= htmlspecialchars($service['NAME']) ?>" />
                        </div>
                        <div class="service-item__wrapper">
                            <div class="service-item__title"><?= htmlspecialchars($service['NAME']) ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>Услуги не найдены.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
