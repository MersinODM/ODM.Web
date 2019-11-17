<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $adminUser = User::firstOrCreate(
      [
        "email" => "admin@admin.com",
        "full_name" => "admin",
        "phone" => "05554443322"
      ]);
    $adminUser->password = Hash::make("123456");
    $adminUser->activator_id = $adminUser->id;
    $adminUser->activation_date = Carbon::now();
    $adminUser->save();

    $adminUser->assign('admin');
  }
}
