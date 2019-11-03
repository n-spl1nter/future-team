<?php

use Illuminate\Database\Seeder;

class OrganizationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgTypes = [
            [
                'value_ru' => 'Правительственная',
                'value_en' => 'Правительственная',
            ],
            [
                'value_ru' => 'Фонд',
                'value_en' => 'Фонд',
            ],
            [
                'value_ru' => 'Молодежная',
                'value_en' => 'Молодежная',
            ],
            [
                'value_ru' => 'Научная',
                'value_en' => 'Научная',
            ],
            [
                'value_ru' => 'Студенческая',
                'value_en' => 'Студенческая',
            ],
            [
                'value_ru' => 'Коммерческая',
                'value_en' => 'Коммерческая',
            ],
            [
                'value_ru' => 'Добровольческая',
                'value_en' => 'Добровольческая',
            ],
            [
                'value_ru' => 'СМИ',
                'value_en' => 'СМИ',
            ],
        ];
        \App\Entities\OrganizationType::insert($orgTypes);
    }
}
