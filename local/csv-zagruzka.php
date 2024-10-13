<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("csv Загрузка");
?><?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
if (!Loader::includeModule('iblock')) {
    die("Не удалось подключить модуль 'iblock'. Проверьте его установку и попробуйте снова.");
}

/**
 * Маппинг значений для списочных свойств
 */
$propertyMappings = array(
    'OFFICE' => array(
        'UST_ISHIM' => 'СВЕЗА Тюмень (Усть-Ишимский филиал )',
        'URAL' => 'СВЕЗА Уральский',
        'TYUMEN' => 'СВЕЗА Тюмень',
        'UST_IZHORA' => 'СВЕЗА Усть-Ижора',
        'NOVATOR' => 'СВЕЗА Новатор',
        'MANTUROVO' => 'СВЕЗА Мантурово',
        'KOSTROMA' => 'СВЕЗА Кострома',
        'TOP_SINYACHIHA' => 'СВЕЗА Верхняя Синячиха',
        'RESURS' => 'Свеза Ресурс'
    ),
    'LOCATION' => array(
        'MOSCOW' => 'Москва',
        'TUMEN' => 'Тюмень',
        'OMSK' => 'Усть-Ишим, Омская область',
        'PITER' => 'Санкт-Петербург',
        'EBURG' => 'Екатеринбург',
        'KOSTROMA' => 'Кострома',
        'MANTUROVO' => 'Мантурово, Костромская область',
        'NOVATOR' => 'Новатор, Вологодская область',
        'URALSI' => 'Уральский, Пермский край',
        'SINYACHIHA' => 'Верхняя Синячиха, Свердловская область',
        'GAMBURG' => 'Гамбург, Германия'
    ),
    'FIELD' => array(
        '1' => 'Производство',
        '2' => 'Продажи',
        '3' => 'Маркетинг',
        '4' => 'Экономика и финансы',
        '5' => 'Бухгалтерский учет',
        '6' => 'Управление персоналом',
        '7' => 'Закупки',
        '8' => 'Логистика и транспорт',
        '9' => 'Техническое развитие',
        '10' => 'Инвестиции',
        '11' => 'Информационные технологии',
        '12' => 'Отдел промышленной безопасности, охраны труда и экологии',
        '13' => 'АХО',
        '14' => 'Финансовый анализ',
        '15' => 'Персонал',
        '16' => 'Безопасность',
        '17' => 'Служба развития производственной системы',
        '18' => 'Технический департамент',
        '19' => 'Служба по энергообеспечению и инфраструктуре'
    ),
    'ACTIVITY' => array(
        'POLN' => 'Полная занятость',
        'VREMYAN' => 'Временная занятость',
        'CHATTICH' => 'Частичная занятость',
        'VECHER' => 'Вечерние часы',
        'NOCH' => 'В ночные часы',
        'VIHODN' => 'В выходные дни',
        'LETO' => 'На летний период',
        'PERIOD' => 'Период',
        'PRAKTIKA' => 'Проектная',
        'STAJER' => 'Стажировка',
        'DIPLOM_PRAKT' => 'Дипломная практика'
    ),
    'TYPE' => array(
        'WORKERS' => 'Рабочие',
        'SALES' => 'Продажи',
        'РСС' => 'Продажи' // Удалены дублирующиеся ключи
    ),
    'SCHEDULE' => array(
        'SMEN' => 'Сменный график',
        'POLN' => 'Полный день'
    ),
    'SALARY_TYPE' => array(
        'AFTER' => 'от',
        'BEFORE' => 'до',
        'EQUAL' => '=',
        'CONTRACT' => 'договорная'
    )
);

/**
 * Дополнительные Специфические Маппинги
 * Изменено на нижний регистр ключей для нечувствительного сопоставления
 */
$additionalMappings = array(
    'LOCATION' => array(
        'усть-ишим' => 'OMSK',
        'уральский' => 'URALSI',
        'новатор' => 'NOVATOR',
        'мантурово' => 'MANTUROVO',
        'верхняя синячиха' => 'SINYACHIHA',
        'тотьма' => null
    ),
    'FIELD' => array(
        'технология и качество' => '9',
        'начальный уровень, мало опыта' => '15',
        'развитие бизнеса' => '17',
        'строительство, недвижимость' => '18' 
    ),
    'SCHEDULE' => array( // Добавлено сопоставление для SCHEDULE
        'вахтовый метод' => 'SMEN'
    )
);

/**
 * Функция для получения ID варианта списка по значению (VALUE).
 */
function getEnumIDByValue($propertyCode, $value) {
    static $cache = array();
    $cacheKey = $propertyCode . '_' . $value;
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }

    $rsEnum = CIBlockPropertyEnum::GetList(
        array(),
        array(
            "PROPERTY_CODE" => $propertyCode,
            "VALUE" => $value
        )
    );
    if ($arEnum = $rsEnum->Fetch()) {
        $cache[$cacheKey] = $arEnum['ID'];
        return $arEnum['ID'];
    }
    $cache[$cacheKey] = null;
    return null;
}

/**
 * Функция для получения ID варианта списка по XML_ID.
 */
function getEnumIDByXML_ID($propertyCode, $xmlId) {
    static $cache = array();
    $cacheKey = $propertyCode . '_' . $xmlId;
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }

    $rsEnum = CIBlockPropertyEnum::GetList(
        array(),
        array(
            "PROPERTY_CODE" => $propertyCode,
            "XML_ID" => $xmlId
        )
    );
    if ($arEnum = $rsEnum->Fetch()) {
        $cache[$cacheKey] = $arEnum['ID'];
        return $arEnum['ID'];
    }
    $cache[$cacheKey] = null;
    return null;
}

/**
 * Функция для получения ID варианта списка с учетом маппинга.
 *
 * Сначала пытается найти по XML_ID, если не находит — пытается найти по VALUE.
 */
function getPropertyEnumID($propertyCode, $input, $mapping, $additionalMapping = array()) {
    // Стандартизация входных данных (удаление лишних пробелов и приведение к нижнему регистру)
    $input_clean = mb_strtolower(trim($input), 'UTF-8');

    // Проверка на наличие в дополнительных маппингах
    if (isset($additionalMapping[$propertyCode][$input_clean])) { // Исправлено обращение к дополнительным маппингам
        $mappedValue = $additionalMapping[$propertyCode][$input_clean];
        if ($mappedValue === null) {
            return null; // Устанавливаем значение как null
        } else {
            // Попытка получить по XML_ID
            $enumID = getEnumIDByXML_ID($propertyCode, $mappedValue);
            if ($enumID !== null) {
                return $enumID;
            }
            // Попытка получить по VALUE
            global $propertyMappings; // Добавлено для доступа к $propertyMappings внутри функции
            $standardValue = isset($propertyMappings[$propertyCode][$mappedValue]) ? $propertyMappings[$propertyCode][$mappedValue] : $mappedValue;
            $enumID = getEnumIDByValue($propertyCode, $standardValue);
            if ($enumID !== null) {
                return $enumID;
            }
            // Если не найдено, продолжить к обычному маппингу
        }
    }

    // Ищем соответствие в основном маппинге
    foreach ($mapping as $key => $value) {
        if (strcasecmp($input_clean, mb_strtolower($key, 'UTF-8')) == 0 || strcasecmp($input_clean, mb_strtolower($value, 'UTF-8')) == 0) {
            // Сначала пробуем найти по XML_ID
            $enumID = getEnumIDByXML_ID($propertyCode, $key);
            if ($enumID !== null) {
                return $enumID;
            }
            // Если не нашли по XML_ID, пробуем по VALUE
            $enumID = getEnumIDByValue($propertyCode, $value);
            if ($enumID !== null) {
                return $enumID;
            }
        }
    }

    // Если прямого совпадения не нашли, пытаемся найти максимально похожее
    $possibleMatches = array_values($mapping);
    $bestMatch = null;
    $highestSimilarity = 0;

    foreach ($possibleMatches as $possible) {
        similar_text(mb_strtolower($input_clean, 'UTF-8'), mb_strtolower($possible, 'UTF-8'), $percent);
        if ($percent > $highestSimilarity) {
            $highestSimilarity = $percent;
            $bestMatch = $possible;
        }
    }

    // Устанавливаем порог похожести, например, 70%
    if ($highestSimilarity >= 70 && $bestMatch !== null) {
        return getEnumIDByValue($propertyCode, $bestMatch);
    }

    // Логирование несопоставленных значений для отладки
    error_log("Не удалось сопоставить значение '$input_clean' для свойства '$propertyCode'.");

    // Если ничего не нашли
    return null;
}

/**
 * Функция для обработки строки заработной платы.
 */
function parseSalary($salary_raw) {
    // Массив для сопоставления входных значений с XML_ID вариантов списка
    $salary_type_mapping = array(
        'от' => 'AFTER',            // XML_ID варианта "ОТ"
        'до' => 'BEFORE',           // XML_ID варианта "ДО"
        '='  => 'EQUAL',            // XML_ID варианта "="
        'договорная' => 'CONTRACT'  // XML_ID варианта "Договорная"
    );

    $salary_type = '';
    $salary_value = '';

    $salary_raw = trim($salary_raw);

    if (empty($salary_raw)) {
        // Нет данных, устанавливаем "Договорная"
        $salary_type = 'CONTRACT';
    } else {
        $salary_lower = mb_strtolower($salary_raw, 'UTF-8');

        if ($salary_lower === 'договорная') {
            $salary_type = 'CONTRACT';
        } else {
            // Проверка на наличие ключевых слов
            if (preg_match('/^(от|до|=)\s+([\d\s]+)$/ui', $salary_raw, $matches)) {
                $input_type = mb_strtolower($matches[1], 'UTF-8'); // "от", "до" или "="
                $salary_type = isset($salary_type_mapping[$input_type]) ? $salary_type_mapping[$input_type] : '';
                $salary_value = str_replace(' ', '', $matches[2]); // Удаляем пробелы из числа
            } elseif (preg_match('/^([\d\s]+)$/u', $salary_raw, $matches)) {
                // Если перед числом нет ключевых слов, устанавливаем "="
                $salary_type = 'EQUAL';
                $salary_value = str_replace(' ', '', $matches[1]);
            } else {
                // Некорректный формат, устанавливаем "Договорная"
                $salary_type = 'CONTRACT';
            }
        }
    }

    return array('type' => $salary_type, 'value' => $salary_value);
}

/**
 * Функция для безопасной загрузки файла.
 */
function secureFileUpload($file, $uploadDir) {
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        error_log("Ошибка загрузки файла: " . $file['error']);
        return null;
    }

    // Проверка MIME-типа
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimeTypes = array(
        'text/csv',
        'text/plain',
        'application/csv',
        'application/vnd.ms-excel',
        'text/comma-separated-values',
        'application/octet-stream' // Иногда CSV может быть распознан как octet-stream
    );

    if (!in_array($mimeType, $allowedMimeTypes)) {
        error_log("Недопустимый тип файла: $mimeType");
        return null;
    }

    // Проверка расширения файла
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($fileExtension !== 'csv') {
        error_log("Недопустимое расширение файла: .$fileExtension");
        return null;
    }

    // Санитизация имени файла
    $safeFileName = preg_replace("/[^a-zA-Z0-9_\-\.]/", "_", basename($file['name']));
    $uploadFile = $uploadDir . $safeFileName;

    // Перемещение загруженного файла
    if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
        error_log("Не удалось переместить загруженный файл.");
        return null;
    }

    // Установка прав на файл
    chmod($uploadFile, 0644);

    return $uploadFile;
}

// Инициализация массивов для сообщений
$successMessages = array();
$errorMessages = array();

// Обработка формы при POST запросе
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    // Директория для загрузки CSV файлов
    $uploadDir = $_SERVER["DOCUMENT_ROOT"]."/local/csv/";

    // Создание директории, если не существует
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            die("Не удалось создать директорию для загрузки файлов.");
        }
    }

    // Безопасная загрузка файла
    $uploadFile = secureFileUpload($_FILES['csv_file'], $uploadDir);
    if ($uploadFile === null) {
        $errorMessages[] = "Ошибка при загрузке файла.";
    } else {
        // Обработка CSV файла
        $file = fopen($uploadFile, "r");
        if ($file !== FALSE) {
            // Чтение заголовков, если они есть (предполагается, что первый ряд - заголовки)
            $headers = fgetcsv($file, 1000, ",");

            $lineNumber = 1; // Для отслеживания номера строки

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $lineNumber++;

                // Проверка, что у нас достаточно полей
                if(count($data) < 15){
                    $errorMessages[] = "Недостаточно полей в строке $lineNumber.";
                    continue;
                }

                // Пропускаем строку, если первый столбец равен 1
                if(trim($data[0]) == '1'){
                    continue;
                }

                // Обработка Заработной платы
                $salary_raw = trim($data[7]);
                $salary_result = parseSalary($salary_raw);
                $salary_type_xml_id = $salary_result['type'];
                $salary_value = $salary_result['value'];

                // Обработка дополнительных списочных свойств
                $office_input = trim($data[1]);      // Комбинат/Офис (OFFICE)
                $location_input = trim($data[2]);    // Местоположение (LOCATION)
                $type_input = trim($data[8]);        // Тип вакансии (TYPE)
                $activity_input = trim($data[9]);    // Тип занятости (ACTIVITY)
                $schedule_input = trim($data[10]);   // График работы (SCHEDULE)
                $field_input = trim($data[11]);      // Сфера деятельности (FIELD)

                /**
                 * Обработка FIELD с учётом специального случая
                 */
                $field_id = null;
                if (strcasecmp($field_input, 'Строительство, Недвижимость') === 0) {
                    // Устанавливаем FIELD равным 18
                    $field_id = getEnumIDByValue('FIELD', 'Технический департамент'); // Исправлено на корректное значение
                } elseif (isset($additionalMappings['FIELD'][mb_strtolower($field_input, 'UTF-8')])) {
                    $field_code = $additionalMappings['FIELD'][mb_strtolower($field_input, 'UTF-8')];
                    if ($field_code === null || $field_code === '') {
                        $field_id = null;
                    } else {
                        $field_id = getEnumIDByValue('FIELD', $propertyMappings['FIELD'][$field_code] ?? '');
                        if ($field_id === null) {
                            $errorMessages[] = "Не удалось сопоставить FIELD в строке $lineNumber.";
                            continue;
                        }
                    }
                } else {
                    if (!empty($field_input)) {
                        // Обычное сопоставление через маппинг
                        $field_id = getPropertyEnumID('FIELD', $field_input, $propertyMappings['FIELD'], array());
                        if ($field_id === null) {
                            // Попытка сопоставить "Лесозаготовка" к "Производство"
                            if (mb_stripos($field_input, 'лесозаготовка', 0, 'UTF-8') !== false) {
                                $field_id = getEnumIDByValue('FIELD', 'Производство');
                            }
                            // Попытка сопоставить "Закупки и логистика" к "Закупки"
                            elseif (mb_stripos($field_input, 'закупки', 0, 'UTF-8') !== false) {
                                $field_id = getEnumIDByValue('FIELD', 'Закупки');
                            }
                            // Попытка сопоставить "Развитие бизнеса" к "Служба развития производственной системы"
                            elseif (mb_stripos($field_input, 'развитие бизнеса', 0, 'UTF-8') !== false) {
                                $field_id = getEnumIDByValue('FIELD', 'Служба развития производственной системы');
                            }

                            if ($field_id === null) {
                                $errorMessages[] = "Не удалось сопоставить FIELD '$field_input' в строке $lineNumber.";
                                continue;
                            }
                        }
                    } else {
                        $field_id = null;
                    }
                }

                /**
                 * Обработка LOCATION с учетом дополнительных условий и нечувствительного сопоставления
                 */
                $location_id = null;
                $location_input_clean = trim($location_input);
                $location_input_lower = mb_strtolower($location_input_clean, 'UTF-8');

                // Дополнительная отладка: логируем очищенное и приведенное значение
                // error_log("Обработка LOCATION: '$location_input_clean' => '$location_input_lower'");

                // Проверка на прямое соответствие 'тотьма'
                if ($location_input_lower === 'тотьма') {
                    // LOCATION остаётся незаполненным
                    $location_id = null;
                }
                // Проверка в дополнительных маппингах
                elseif (isset($additionalMappings['LOCATION'][$location_input_lower])) {
                    $mapped_location = $additionalMappings['LOCATION'][$location_input_lower];
                    if ($mapped_location === null) {
                        // LOCATION остаётся незаполненным при значении, например, 'Тотьма'
                        $location_id = null;
                    } else {
                        $location_id = getPropertyEnumID('LOCATION', $mapped_location, $propertyMappings['LOCATION'], array());
                        if ($location_id === null) {
                            $errorMessages[] = "Не удалось сопоставить LOCATION в строке $lineNumber.";
                            continue;
                        }
                    }
                } else {
                    // Обычное сопоставление через маппинг
                    if (!empty($location_input_clean)) {
                        $location_id = getPropertyEnumID('LOCATION', $location_input_clean, $propertyMappings['LOCATION'], array());
                        if ($location_id === null) {
                            $errorMessages[] = "Не удалось сопоставить LOCATION '$location_input_clean' в строке $lineNumber.";
                            continue;
                        }
                    } else {
                        $location_id = null;
                    }
                }

                /**
                 * Обработка OFFICE с учетом пустых значений
                 */
                $office_id = null;
                if (!empty($office_input)) {
                    $office_id = getPropertyEnumID('OFFICE', $office_input, $propertyMappings['OFFICE'], array());
                    if ($office_id === null) {
                        $errorMessages[] = "Не удалось сопоставить OFFICE '$office_input' в строке $lineNumber.";
                        continue;
                    }
                } else {
                    $office_id = null;
                }

                // Обработка пустого значения TYPE
                if (empty($type_input)) {
                    $errorMessages[] = "Пустое значение TYPE в строке $lineNumber.";
                    continue; // Или, при необходимости, установить значение по умолчанию
                }

                // Получение ID для TYPE
                $type_id = getPropertyEnumID('TYPE', $type_input, $propertyMappings['TYPE'], array());
                if ($type_id === null) {
                    $errorMessages[] = "Не удалось сопоставить TYPE '$type_input' в строке $lineNumber.";
                    continue;
                }

                // Получение ID для ACTIVITY
                $activity_id = getPropertyEnumID('ACTIVITY', $activity_input, $propertyMappings['ACTIVITY'], array());
                if ($activity_id === null) {
                    // Попытка сопоставить "Проектная" или "Временная работа" к "PRAKTIKA"
                    if (mb_stripos($activity_input, 'проектная', 0, 'UTF-8') !== false || mb_stripos($activity_input, 'временная', 0, 'UTF-8') !== false) {
                        $activity_id = getEnumIDByXML_ID('ACTIVITY', 'PRAKTIKA');
                    }

                    if ($activity_id === null) {
                        $errorMessages[] = "Не удалось сопоставить ACTIVITY '$activity_input' в строке $lineNumber.";
                        continue;
                    }
                }

                /**
                 * Обработка SCHEDULE с учетом дополнительных сопоставлений
                 */
                $schedule_id = null;
                $schedule_input_clean = trim($schedule_input);
                $schedule_input_lower = mb_strtolower($schedule_input_clean, 'UTF-8');

                // Проверка в дополнительных маппингах для SCHEDULE
                if (isset($additionalMappings['SCHEDULE'][$schedule_input_lower])) {
                    $mapped_schedule = $additionalMappings['SCHEDULE'][$schedule_input_lower];
                    if ($mapped_schedule === null) {
                        $schedule_id = null;
                    } else {
                        $schedule_id = getPropertyEnumID('SCHEDULE', $mapped_schedule, $propertyMappings['SCHEDULE'], array());
                        if ($schedule_id === null) {
                            $errorMessages[] = "Не удалось сопоставить SCHEDULE в строке $lineNumber.";
                            continue;
                        }
                    }
                } else {
                    // Обычное сопоставление через маппинг
                    if (!empty($schedule_input_clean)) {
                        $schedule_id = getPropertyEnumID('SCHEDULE', $schedule_input_clean, $propertyMappings['SCHEDULE'], array());
                        if ($schedule_id === null) {
                            $errorMessages[] = "Не удалось сопоставить SCHEDULE '$schedule_input_clean' в строке $lineNumber.";
                            continue;
                        }
                    } else {
                        $schedule_id = null;
                    }
                }

                // Получение ID для SALARY_TYPE
                $salary_type_id = getEnumIDByXML_ID('SALARY_TYPE', $salary_type_xml_id);
                if ($salary_type_id === null) {
                    $errorMessages[] = "Не удалось сопоставить SALARY_TYPE '$salary_type_xml_id' в строке $lineNumber.";
                    continue;
                }

                // Создание элемента инфоблока
                $elem = new CIBlockElement;

                // Подготовка свойств
                $properties = array(
                    "OFFICE" => $office_id,                     // Комбинат/Офис (Код: OFFICE) - Используем ID или null
                    "LOCATION" => $location_id,                 // Местоположение (Код: LOCATION) - Используем ID или null
                    "REQUIRE" => empty($data[4]) ? array() : array_map('trim', explode("•", $data[4])), // Требования к соискателю (Код: REQUIRE)
                    "DUTY" => empty($data[5]) ? array() : array_map('trim', explode("•", $data[5])),    // Основные обязанности (Код: DUTY)
                    "CONDITIONS" => empty($data[6]) ? array() : array_map('trim', explode("•", $data[6])), // Условия работы (Код: CONDITIONS)
                    "SALARY_TYPE" => $salary_type_id,          // Тип заработной платы (Код: SALARY_TYPE) - Используем ID
                    "SALARY_VALUE" => $salary_value,           // Значение заработной платы (Код: SALARY_VALUE)
                    "TYPE" => $type_id,                         // Тип вакансии (Код: TYPE) - Используем ID
                    "ACTIVITY" => $activity_id,                 // Тип занятости (Код: ACTIVITY) - Используем ID
                    "SCHEDULE" => $schedule_id,                 // График работы (Код: SCHEDULE) - Используем ID
                    "FIELD" => $field_id,                       // Сфера деятельности (Код: FIELD) - Используем ID или null
                    "EMAIL" => trim($data[12]),                 // Электронная почта (Код: EMAIL)
                    "DATE" => date('d.m.Y'),                    // Установка текущей даты
                );

                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => false, // Не используется раздел
                    "IBLOCK_ID" => 27, // Ваш ID инфоблока
                    "NAME" => trim($data[3]), // Название вакансии
                    "ACTIVE" => "Y",
                    "PROPERTY_VALUES" => $properties,
                );

                $ELEMENT_ID = $elem->Add($arLoadProductArray);
                if ($ELEMENT_ID) {
                    // Элемент успешно добавлен
                    $successMessages[] = "Строка $lineNumber: Вакансия '<strong>" . htmlspecialchars(trim($data[3])) . "</strong>' успешно добавлена. ID элемента: $ELEMENT_ID.";
                } else {
                    // Ошибка при добавлении элемента
                    $errorMessages[] = "Строка $lineNumber: Ошибка при добавлении элемента: " . htmlspecialchars($elem->LAST_ERROR);
                }

                // Опциональное логирование можно оставить, но оно не обязательно для отображения на экране
            }
            fclose($file);
        } else {
            $errorMessages[] = "Не удалось открыть загруженный файл.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Загрузка CSV файла</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            padding: 5px;
        }
        input[type="submit"] {
            padding: 7px 15px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .messages {
            margin-top: 20px;
        }
        .success {
            background-color: #e6ffed;
            border-left: 4px solid #28a745;
            padding: 10px;
            margin-bottom: 10px;
        }
        .error {
            background-color: #ffe6e6;
            border-left: 4px solid #dc3545;
            padding: 10px;
            margin-bottom: 10px;
        }
        .messages h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<h2>Загрузка CSV файла</h2>
<form enctype="multipart/form-data" method="POST" action="">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <label for="csv_file">Выберите CSV файл:</label>
    <input type="file" name="csv_file" id="csv_file" accept=".csv" required />
    <input type="submit" value="Загрузить" />
</form>

<?php if (!empty($successMessages) || !empty($errorMessages)): ?>
    <div class="messages">
        <?php if (!empty($successMessages)): ?>
            <div class="success">
                <h3>Успешно добавлено:</h3>
                <ul>
                    <?php foreach ($successMessages as $msg): ?>
                        <li><?php echo $msg; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMessages)): ?>
            <div class="error">
                <h3>Ошибки обработки:</h3>
                <ul>
                    <?php foreach ($errorMessages as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>