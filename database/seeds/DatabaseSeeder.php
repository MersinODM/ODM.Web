<?php

use App\Models\BloomsTaxonomy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(SettingTableSeeder::class);
      $this->call(BranchTableSeeder::class);
      $this->call(PermissionsTableSeeder::class);
      $this->call(RolesTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      $this->call(BloomsTaxonomy::class);
    }
}
