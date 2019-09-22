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
                'language_name' => 'INDONESIA',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'language_name' => 'ENGLISH',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
