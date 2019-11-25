<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Branch::firstOrCreate([
      "name" => "Türkçe",
    ]);

    Branch::firstOrCreate([
      "name" => "Matematik"
    ]);

    Branch::firstOrCreate([
      "name" => "Fen Bilimleri"
    ]);

    Branch::firstOrCreate([
      "name" => "İngilizce"
    ]);
  }
}
