<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
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
                'language_name' => 'INDONESIA'
            ],
            [
                'id' => 2,
                'language_name' => 'ENGLISH'
            ]
        ]);
    }
}
