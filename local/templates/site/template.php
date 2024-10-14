<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?$APPLICATION->ShowTitle()?></title>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/style.css">
    <?$APPLICATION->ShowHead();?>
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        nav {
            margin: 20px 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        .sidebar {
            width: 200px;
            background-color: #e9ecef;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .admin-menu {
            margin-top: 20px;
        }
    </style>
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
                    <li>Добро пожаловать, <?= htmlspecialchars($USER->GetFullName()); ?>!</li>
                    <li><a href="/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="/login.php">Войти</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="sidebar">
        <h2>Боковое меню</h2>
        <ul>
            <li><a href="/profile/">Мой профиль</a></li>
            <li><a href="/settings/">Настройки</a></li>
            <li><a href="/help/">Помощь</a></li>
            <?php if ($USER->IsAdmin()): ?>
                <li><a href="/admin/">Панель управления</a></li>
                <li><a href="/admin/users.php">Управление пользователями</a></li>
                <li><a href="/admin/settings.php">Настройки</a></li>
                <li><a href="/admin/content.php">Управление контентом</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="main-content">
        <main>
            <!-- Основное содержимое страницы -->
            <h2>Основной контент</h2>
            <p>Здесь будет размещен основной контент вашей страницы.</p>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?= date("Y") ?> Ваш сайт. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
