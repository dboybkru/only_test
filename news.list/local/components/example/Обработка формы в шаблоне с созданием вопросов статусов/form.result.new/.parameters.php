<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

// Инициализация локализации
// Loc::loadMessages(__FILE__);

// Проверяем, что модуль main установлен
if (!Loader::includeModule('main')) {
    throw new Exception(Loc::getMessage('MAIN_MODULE_NOT_INSTALLED'));
}

// Проверяем, что модуль веб-форм установлен
if (!Loader::includeModule('form')) {
    throw new Exception(Loc::getMessage('FORM_MODULE_NOT_INSTALLED'));
}

// Получаем список веб-форм
$webForms = [];
try {
    // Используем класс CForm для получения списка форм
    $dbForms = CForm::GetList($by = "s_sort", $order = "asc", ["ACTIVE" => "Y"], $is_filtered);
    
    while ($form = $dbForms->Fetch()) {
        $webForms[$form['ID']] = $form['NAME'];
    }

    if (empty($webForms)) {
        $webForms[0] = Loc::getMessage('NO_FORMS_FOUND'); // В случае пустого списка
    }
} catch (Exception $e) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/log_errors.txt', date('Y-m-d H:i:s') . " - Ошибка получения форм: " . $e->getMessage() . "\n", FILE_APPEND);
    $webForms[0] = 'Ошибка получения форм'; // Установить сообщение об ошибке в качестве варианта в выпадающем списке
}

// Параметры компонента
$arComponentParameters = [
    'PARAMETERS' => [
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'WEB_FORM_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('WEB_FORM_ID'),
            'TYPE' => 'LIST',
            'VALUES' => $webForms,
            'DEFAULT' => '',
            'REFRESH' => 'Y'
        ],
    ]
];
?>