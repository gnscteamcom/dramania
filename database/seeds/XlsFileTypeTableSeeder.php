<?php

use Illuminate\Database\Seeder;

class XlsFileTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\XlsFileType::insert([
            [
                'id' => 1,
                'name' => 'SERIES',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'MOVIES',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
