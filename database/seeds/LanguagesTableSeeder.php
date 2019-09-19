<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Language::insert([
            [
                'id' => 1,
                'language_name' => 'KOREA',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'language_name' => 'JAPAN',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
