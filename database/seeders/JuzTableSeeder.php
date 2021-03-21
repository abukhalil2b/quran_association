<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juz;
class JuzTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($juz=1; $juz <=30; $juz++) { 
        	Juz::create(['title'=>$juz]);
        }
    }
}
