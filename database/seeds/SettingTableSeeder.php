<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::firstOrCreate(
          [
            "inst_name" => "Nevşehir Ölçme Değerlendirme Merkezi",
            "governor" => "Nevşehir Valiliği",
            "directorate" => "Nevşehir Milli Eğitim Müdürlüğü",
            "twitter_address" => "https://twitter.com/nevsehirodm",
            "web_address" => "https://nevsehirodm.meb.gov.tr/",
            "phone" => "0384 213 79 33 Dahili:178",
            "email" => "odm50@meb.gov.tr",
            "address" => "350 Evler Mah. Yeni Kayseri Cad. Hükümet Konağı Kat:2"
          ]);
    }
}
