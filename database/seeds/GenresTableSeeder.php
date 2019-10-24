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
                'name' => 'Action',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Comedy',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Complete',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Crime',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Drama',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Family',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Fantasy',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'History',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Horror',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Medical',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'MelloDrama',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Mistery',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Ongoing',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Politik',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Romance',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'School',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Thriller',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'name' => 'Web Drama',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
