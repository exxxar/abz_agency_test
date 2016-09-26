<?php

use Illuminate\Database\Seeder;


class PersonalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $el_count = 1000;

        factory(App\Personal::class, $el_count)->create()->each(function() {
           factory(App\Personal::class)->make();
        });
    }
}
