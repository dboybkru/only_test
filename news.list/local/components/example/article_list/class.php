<?php
use \Bitrix\Main\Loader;
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ExampleArticleList extends CBitrixComponent {
    public function executeComponent() {
        $this->arResult['ARTICLES'] = [
            [
                'href' => 'for-individuals.html',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-6.jpg', // Убедитесь, что путь правильный
                'title' => 'Для физических лиц',
                'content' => 'Лучшие решения для вашего дома: быстрый интернет, доступное кабельное TV, удобный домашний телефон.'
            ],
            [
                'href' => '#',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-3.jpg',
                'title' => 'Средний и малый бизнес',
                'content' => 'Быстро и качественно помогаем предпринимателям в решении бизнес-задач.'
            ],
            [
                'href' => 'for-state.html',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-4.jpg',
                'title' => 'Государственные заказчики',
                'content' => 'Решения для государственных структур, повышение безопасности и комфорта городской среды.'
            ],
            [
                'href' => 'for-federals.html',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-5.jpg',
                'title' => 'Федеральные клиенты',
                'content' => 'Повышаем эффективность бизнес-процессов за счет внедрения современных средств передачи и защиты данных.'
            ],
            [
                'href' => 'for-telecommunications.html',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-2.jpg',
                'title' => 'Операторы связи',
                'content' => 'Предлагаем партнерство и взаимовыгодное сотрудничество.'
            ],
            [
                'href' => 'innovative-projects.html',
                'background' => '/local/components/example/article_list/templates/.default/images/article-item-bg-1.jpg',
                'title' => 'Инновационные проекты',
                'content' => 'Предоставляем услуги широкополосного доступа в интернет и комплексные решения на базе технологий промышленного интернета вещей (IoT).'
            ]
        ];

        $this->includeComponentTemplate();
    }
}
?>