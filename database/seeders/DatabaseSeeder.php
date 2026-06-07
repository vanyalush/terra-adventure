<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Hike;
use Illuminate\Database\Seeder;
use App\Models\HikeDate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Пешие', 'slug' => 'hiking'],
            ['name' => 'Лыжные', 'slug' => 'skiing'],
            ['name' => 'Конные', 'slug' => 'horse'],
            ['name' => 'Водные', 'slug' => 'water'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        Hike::create([
            'category_id' => 1,
            'name' => 'Карелия — Ладожские шхеры',
            'description' => 'Незабываемое путешествие по живописным шхерам Ладожского озера.',
            'route' => 'Сортавала → Импилахти',
            'distance_km' => 85,
            'duration_days' => 7,
            'min_age' => 14,
            'max_participants' => 12,
            'difficulty' => 'medium',
            'price' => 8500,
            'region' => 'Карелия',
        ]);

        Hike::create([
            'category_id' => 4,
            'name' => 'Сплав по реке Чусовая',
            'description' => 'Водный поход по одной из красивейших рек Урала.',
            'route' => 'Чусовой → Пермь',
            'distance_km' => 120,
            'duration_days' => 5,
            'min_age' => 12,
            'max_participants' => 8,
            'difficulty' => 'easy',
            'price' => 6200,
            'region' => 'Урал',
        ]);

        Hike::create([
            'category_id' => 3,
            'name' => 'Алтайские предгорья верхом',
            'description' => 'Конный поход по живописным предгорьям Алтая.',
            'route' => 'Барнаул → Белокуриха',
            'distance_km' => 200,
            'duration_days' => 10,
            'min_age' => 16,
            'max_participants' => 6,
            'difficulty' => 'hard',
            'price' => 14000,
            'region' => 'Алтай',
        ]);
        HikeDate::create([
            'hike_id' => 1,
            'start_date' => '2024-07-01',
            'end_date' => '2024-07-07',
            'spots_total' => 12,
            'spots_taken' => 5,
        ]);

        HikeDate::create([
            'hike_id' => 1,
            'start_date' => '2024-07-15',
            'end_date' => '2024-07-21',
            'spots_total' => 12,
            'spots_taken' => 12,
        ]);

        HikeDate::create([
            'hike_id' => 2,
            'start_date' => '2024-07-10',
            'end_date' => '2024-07-14',
            'spots_total' => 8,
            'spots_taken' => 2,
        ]);
        User::create([
            'name'     => 'Администратор',
            'email'    => 'admin@terra.ru',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Тестовый пользователь',
            'email'    => 'user@terra.ru',
            'password' => Hash::make('user123'),
            'role'     => 'user',
        ]);
    }
}


