<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('systems')->insertOrIgnore([
            'id' => 1,
            'name' => 'Windows 10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('systems')->insertOrIgnore([
            'id' => 2,
            'name' => 'Ubuntu 20.04',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }

}
