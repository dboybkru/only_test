# News List Component

## Описание

Не до конца понял задание поэтому:
2 файла 
  1. template.php Является копией news.list (сделанный по урокам) из Demo интернет-магазина
  2. template_null.php Нулевой (базовый) шаблон с классом для стилизации, циклом по элементам массива и минимальными проверками

Компонент `news.list` в 1C-Bitrix предназначен для отображения списка новостей в виде карточек. Он предоставляет функциональность для отображения текста, изображений, видео и других медиа-контента, а также поддерживает возможности редактирования и удаления элементов для авторизованных пользователей.

## Изменения


Создал шаблон компонента servicelist ("Наши услуги") в/для 1C-Bitrix.
для создания шаблона нагло использовал "https://gdecider.github.io/articles_bx-component-creation.html" и документацию "https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=2829&LESSON_PATH=3913.4565.2829#template_search".
Дерево шаблона в структуре Битрикс:
/local/components/example/serviceslist/
├── /lang
│   └── /ru
│       └── .description.php
├── /templates
│   └── /.default
│       ├── template.php
│       ├── css
│       │       └── common.css
│       ├── fonts
│       │       ├── Gilroy-Bold.ttf
│       │       ├── Gilroy-Bold.woff
│       │       ├── Gilroy-Bold.woff2
│       │       ├── Gilroy-Extrabold.ttf
│       │       ├── Gilroy-Extrabold.woff
│       │       ├── Gilroy-Extrabold.woff2
│       │       ├── Gilroy-Light.ttf
│       │       ├── Gilroy-Light.woff
│       │       ├── Gilroy-Light.woff2
│       │       ├── Gilroy-Medium.ttf
│       │       ├── Gilroy-Medium.woff
│       │       ├── Gilroy-Medium.woff2
│       │       ├── Gilroy-Regular.ttf
│       │       ├── Gilroy-Regular.woff
│       │       ├── Gilroy-Regular.woff2
│       │       ├── GothamPro.ttf
│       │       ├── GothamPro.woff
│       │       └── GothamPro.woff2
│       └── images
│               ├── article-bg.png
│               ├── article-item-bg-1.jpg
│               ├── article-item-bg-2.jpg
│               ├── article-item-bg-3.jpg
│               ├── article-item-bg-4.jpg
│               ├── article-item-bg-5.jpg
│               └── article-item-bg-6.jpg
├── .description.php
├── .parameters.php
└── class.php

class.php - содержит логику компонента.
template.php - основной файл шаблона, в котором реализуется логика отображения контента компонента.

