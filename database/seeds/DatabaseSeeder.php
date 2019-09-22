<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagsTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(XlsStatusesTableSeeder::class);
    }
}
