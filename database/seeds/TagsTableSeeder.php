<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Tag::insert([
            [
                'id' => 1,
                'name' => 'NEWS',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'POPULAR',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 3,
                'name' => 'LATEST',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
