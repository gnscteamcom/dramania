<?php

use Illuminate\Database\Seeder;

class XlsStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\XlsStatus::insert([
            [
                'id' => 1,
                'status_name' => 'DRAFT',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'status_name' => 'ACTIVE',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 3,
                'status_name' => 'DELETED',
                'created_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 4,
                'status_name' => 'UPDATED',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
