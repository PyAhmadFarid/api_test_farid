<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Product;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'user_name' => 'ucok',
            'email' => 'ucok@gmail.com',
            'password' => Hash::make('qwe'),
            'role'=>'admin'
        ]);

        $user = User::create([
            'user_name' => 'a_farid',
            'email' => 'farid@gmail.com',
            'password' => Hash::make('qwe'),
            'role'=>'customer'
        ]);

        Customer::create([
            'full_name' => 'ahmad farid',
            'id_user' => $user->id,
            'birth_date' => '2000-08-19',
            'address' => 'gresik',
            'gender' => 'M',
        ]);


        Product::factory(100)->create();
    }
}
