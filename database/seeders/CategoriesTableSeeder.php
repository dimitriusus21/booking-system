<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Парикмахерские услуги',
            'Косметология',
            'Маникюр и педикюр',
            'Массаж',
            'Фитнес и йога',
            'Образование и курсы',
            'Ремонт и обслуживание',
            'Фотография и видео',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category], // Ищем категорию по имени
                [
                    'slug' => Str::slug($category),
                    'updated_at' => now()
                ]
            );
        }
    }
}
