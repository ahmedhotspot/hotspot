<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,
            MenuSeeder::class,
            PagesSeeder::class,
            ServicesSeeder::class,
            BanksAndOffersSeeder::class,
            ContentSeeder::class,
            ContentBlocksSeeder::class,
        ]);
    }
}
