<?php

use App\Models\BloomsTaxonomy;
use Illuminate\Database\Seeder;

/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

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
