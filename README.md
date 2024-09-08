# News List Component
Приложен Gif файл "Запись экрана с работой шаблона" коротенькая запись работы шаблона (как "Видимой области", так и "Страницы")

## Описание

Переделал шаблон `news.list` в 1C-Bitrix в шаблон компонента `article_list`.

Cоздал шаблон компонента `article_list` дублирует serviceslist, но имеет свой массив данных из build для 1C-Bitrix.

Cоздал шаблон компонента `form.result.new` на базе build из задания, создал форму в 1C-Bitrix, применил шаблон к созданной форме..

Cоздал шаблон компонента `serviceslist` ("Наши услуги") для 1C-Bitrix, нагло используя материалы из [gdecider](https://gdecider.github.io/articles_bx-component-creation.html) и документации [1C-Bitrix](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=2829&LESSON_PATH=3913.4565.2829#template_search).

Файлы компонентов
class.php - содержит логику компонента.
template.php - основной файл шаблона, в котором реализуется логика отображения контента компонента.
