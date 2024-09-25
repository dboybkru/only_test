<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?$APPLICATION->ShowTitle()?></title>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/style.css">
    <?$APPLICATION->ShowHead();?>
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <header>
        <h1>Добро пожаловать на сайт</h1>
        <nav>
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/about/">О нас</a></li>
                <li><a href="/contact/">Контакты</a></li>
                <?php if ($USER->IsAuthorized()): ?>
                    <li>Добро пожаловать, <?= $USER->GetFullName(); ?>!</li>
                    <li><a href="/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="/login.php">Войти</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>