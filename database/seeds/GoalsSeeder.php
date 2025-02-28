<?php

use Illuminate\Database\Seeder;

class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goals = [
            [
                'value_ru' => 'ЦУР 1. Ликвидация нищеты',
                'value_en' => 'ЦУР 1. Ликвидация нищеты',
            ],
            [
                'value_ru' => 'ЦУР 2. Ликвидация голода',
                'value_en' => 'ЦУР 2. Ликвидация голода',
            ],
            [
                'value_ru' => 'ЦУР 3. Хорошее здоровье и благополучие',
                'value_en' => 'ЦУР 3. Хорошее здоровье и благополучие',
            ],
            [
                'value_ru' => 'ЦУР 4. Качественное образование',
                'value_en' => 'ЦУР 4. Качественное образование',
            ],
            [
                'value_ru' => 'ЦУР 5. Гендерное равенство',
                'value_en' => 'ЦУР 5. Гендерное равенство',
            ],
            [
                'value_ru' => 'ЦУР 6. Чистая вода и санитария',
                'value_en' => 'ЦУР 6. Чистая вода и санитария',
            ],
            [
                'value_ru' => 'ЦУР 7. Доступная и чистая энергия',
                'value_en' => 'ЦУР 7. Доступная и чистая энергия',
            ],
            [
                'value_ru' => 'ЦУР 8. Достойная работа и экономический рост',
                'value_en' => 'ЦУР 8. Достойная работа и экономический рост',
            ],
            [
                'value_ru' => 'ЦУР 9. Индустриализация, инновации и инфраструктура',
                'value_en' => 'ЦЦУР 9. Индустриализация, инновации и инфраструктура',
            ],
            [
                'value_ru' => 'ЦУР 10. Снижение неравенства',
                'value_en' => 'ЦУР 10. Снижение неравенства',
            ],
            [
                'value_ru' => 'ЦУР 11. Устойчивые города и сообщества',
                'value_en' => 'ЦУР 11. Устойчивые города и сообщества',
            ],
            [
                'value_ru' => 'ЦУР 12. Рациональное потребление и производство',
                'value_en' => 'ЦУР 12. Рациональное потребление и производство',
            ],
            [
                'value_ru' => 'ЦУР 13. Срочные меры по борьбе с изменением климата',
                'value_en' => 'ЦУР 13. Срочные меры по борьбе с изменением климата',
            ],
            [
                'value_ru' => 'ЦУР 14. Рациональное использование ресурсов океана',
                'value_en' => 'ЦУР 14. Рациональное использование ресурсов океана',
            ],
            [
                'value_ru' => 'ЦУР 15. Рациональное использование экосистем суши',
                'value_en' => 'ЦУР 15. Рациональное использование экосистем суши',
            ],
            [
                'value_ru' => 'ЦУР 16. Мир, правосудие и сильные институты',
                'value_en' => 'ЦУР 16. Мир, правосудие и сильные институты',
            ],
            [
                'value_ru' => 'ЦУР 17. Глобальные партнерства в интересах развития',
                'value_en' => 'ЦУР 17. Глобальные партнерства в интересах развития',
            ],
        ];

        \App\Entities\Goal::insert($goals);
    }
}
