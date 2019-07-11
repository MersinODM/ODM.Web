<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $bouncer = Bouncer::create();

      $bouncer->role()->firstOrCreate([
        "name" => "admin",
        "title" => "Yönetici Rolü"
      ]);

      $bouncer->role()->firstOrCreate([
        "name" => "school-manager",
        "title" => "Okul Müdürü Rolü"
      ]);

//      $bouncer->role()->firstOrCreate([
//        "name" => "teacher",
//        "title" => "Öğretmen Rolü"
//      ]);

      $bouncer->role()->firstOrCreate([
        "name" => "teacher",
        "title" => "Öğretmen Rolü"
      ]);

      $bouncer->allow("admin")->everything();
    }
}
