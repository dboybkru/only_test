<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->SetTitle("Главная страница");?>

<!DOCTYPE html>
<html lang="ru">
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>