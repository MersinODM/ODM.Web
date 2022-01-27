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
            "inst_name" => "KURUM ADI",
            "governor" => "VALİLİK",
            "directorate" => "MÜDÜRLÜK",
            "twitter_address" => "TWITTER",
            "web_address" => "KURUMSAL_ADRES,
            "phone" => "TELEFON",
            "email" => "EMAIL",
            "address" => "ADRES"
          ]);
    }
}
