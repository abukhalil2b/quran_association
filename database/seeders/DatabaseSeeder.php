<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
  //   	User::truncate();
		// User::create([
		// 	'name' => 'إدارة البرنامج',
		// 	'email' => 'abukhalil2b@gmail.com',
		// 	'userType' => 'superadmin',
		// 	'password' => Hash::make('11112222'),
		// ]);
        
  //       $this->call(SowarTableSeeder::class);
  //       $this->call(PageTableSeeder::class);
        $this->call(JuzTableSeeder::class);
    }
}
