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
            justify-content: space-around;
            padding: 20px;
        }

        .article-item {
            position: relative;
            width: calc(33% - 20px);
            margin: 10px;
            text-decoration: none;
            color: black;
            overflow: hidden;
            border-radius: 10px;
        }

        .article-item__background {
            position: relative;
            width: 100%;
            height: 200px;
            cursor: pointer; 
        }

        .article-item__background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-item__wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.7);
            transition: 0.3s;
        }

        .article-item__title {
            font-weight: bold;
            font-size: 1.2em;
        }

        .article-item__content {
            font-size: 0.9em;
            color: #666;
        }

        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.9); 
        }

        .modal-content {
            margin: auto;
            display: block;
            width: auto; 
            max-width: 90%;
        }

        .close {
            position: absolute;
            top: 10px; 
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="barba-wrapper">
    <div class="article-list">
        <?php if (!empty($arResult['SERVICES'])): ?>
            <?php foreach ($arResult['SERVICES'] as $service): ?>
                <a class="article-item article-list__item" href="<?= htmlspecialchars($service['DETAIL_PAGE_URL']) ?>" data-anim="anim-3">
                    <div class="article-item__background" onclick="openModal('<?= htmlspecialchars($service['IMAGE_SRC']) ?>')">
                        <img src="<?= htmlspecialchars($service['IMAGE_SRC']) ?>" alt="<?= htmlspecialchars($service['NAME']) ?>" />
                    </div>
                    <div class="article-item__wrapper">
                        <div class="article-item__title"><?= htmlspecialchars($service['NAME']) ?></div>
                        <div class="article-item__content"><?= htmlspecialchars($service['PREVIEW_TEXT']) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div>Услуги не найдены.</div>
        <?php endif; ?>
    </div>
</div>

<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
</div>

<script>
function openModal(imageSrc) {
    var modal = document.getElementById("myModal");
    var img = document.getElementById("img01");
    img.src = imageSrc;
    modal.style.display = "block";
}

function closeModal() {
    document.getElementById("myModal").style.display = "none";
}
</script>

</body>
</html>