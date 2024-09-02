# News List Component
Приложен Gif файл "Запись экрана с работой шаблона" коротенькая запись работы шаблона (как "Видимой области", так и "Страницы")

## Описание

Переделал шаблон `news.list` в 1C-Bitrix в шаблон компонента `article_list`.

Я создал шаблон компонента `serviceslist` ("Наши услуги") для 1C-Bitrix, нагло используя материалы из [gdecider](https://gdecider.github.io/articles_bx-component-creation.html) и документации [1C-Bitrix](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=2829&LESSON_PATH=3913.4565.2829#template_search).

## Структура проекта

```plaintext
/local/components/example/serviceslist/
├── lang/
│   └── ru/
│       └── .description.php
├── templates/
│   └── .default/
│       ├── template.php
│       ├── css/
│       │   └── common.css
│       ├── fonts/
│       │   ├── Gilroy-Bold.ttf
│       │   ├── Gilroy-Bold.woff
│       │   ├── Gilroy-Bold.woff2
│       │   ├── Gilroy-Extrabold.ttf
│       │   ├── Gilroy-Extrabold.woff
│       │   ├── Gilroy-Extrabold.woff2
│       │   ├── Gilroy-Light.ttf
│       │   ├── Gilroy-Light.woff
│       │   ├── Gilroy-Light.woff2
│       │   ├── Gilroy-Medium.ttf
│       │   ├── Gilroy-Medium.woff
│       │   ├── Gilroy-Medium.woff2
│       │   ├── Gilroy-Regular.ttf
│       │   ├── Gilroy-Regular.woff
│       │   ├── Gilroy-Regular.woff2
│       │   ├── GothamPro.ttf
│       │   ├── GothamPro.woff
│       │   └── GothamPro.woff2
│       └── images/
│           ├── article-bg.png
│           ├── article-item-bg-1.jpg
│           ├── article-item-bg-2.jpg
│           ├── article-item-bg-3.jpg
│           ├── article-item-bg-4.jpg
│           ├── article-item-bg-5.jpg
│           └── article-item-bg-6.jpg
├── .description.php
├── .parameters.php
└── class.php


Файлы компонента
class.php - содержит логику компонента.
template.php - основной файл шаблона, в котором реализуется логика отображения контента компонента.
