<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user1 = User::create(array(
      'name' => 'Alvaro García',
      'email' => 'alvarogarcia@itpsm.edu.sv',
      'email_verified_at' => now(),
      'password' => 'password', // password
      'remember_token' => Str::random(10),
      'system_reference_table'=>'admin'
    ));

    $user2 = User::create(array(
      'name' => 'Walter Ayala',
      'email' => 'walterayala@itpsm.edu.sv',
      'email_verified_at' => now(),
      'password' => 'password', // password
      'remember_token' => Str::random(10),
      'system_reference_table'=>'admin'
    ));

    User::create(array(
      'name' => 'Edwin Lovo',
      'email' => 'edwinlovo@itpsm.edu.sv',
      'email_verified_at' => now(),
      'password' => 'password', // password
      'remember_token' => Str::random(10),
      'system_reference_table'=>'admin'
    ));

    User::create(array(
      'name' => 'Francisco Molina',
      'email' => 'franciscomolina@itpsm.edu.sv',
      'email_verified_at' => now(),
      'password' => 'password', // password
      'remember_token' => Str::random(10),
      'system_reference_table'=>'admin'
    ));

    $user3 = User::create(array(
      'name' => 'Administracion',
      'email' => 'admin@itpsm.edu.sv',
      'email_verified_at' => now(),
      'password' => 'password', // password
      'remember_token' => Str::random(10),
      'system_reference_table'=>'admin'
    ));

    $user1->assignRole('admin');
    $user2->assignRole('admin');
    $user3->assignRole('admin');
  }
}
