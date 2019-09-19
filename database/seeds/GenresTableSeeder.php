<?php

use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Genre::insert([

            [
                'name' => 'Romance',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Adventure',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Fantasy',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Action',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Comedy',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Fantasy',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Historical',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Horror',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
