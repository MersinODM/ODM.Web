<?php

use App\Models\BloomsTaxonomy;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $taxonimy = ["Bilgi", "Kavrama", "Uygulama", "Analiz", "Sentez", "Değerlendirme"];

    foreach ($taxonimy as $t) {
      $bt = BloomsTaxonomy::firstOrCreate(["content" => $t]);
      $bt->save();
    }
  }
}
