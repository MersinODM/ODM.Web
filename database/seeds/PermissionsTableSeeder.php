<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class PermissionsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $bouncer = Bouncer::create();

    $bouncer->ability()->firstOrCreate([
      'name' => 'manage-user',
      'title' => 'Kullanıcı yönetimi yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'manage-exam',
      'title' => 'Sınav yönetimi yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'manage-question',
      'title' => 'Soru yönetimi yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'manage-branch',
      'title' => 'Branş/Ders yönetim yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'manage-learning-outcome',
      'title' => 'Kazanım yönetim yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'add-question',
      'title' => 'Soru ekleme yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'delete-question',
      'title' => 'Soru silme yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'edit-question',
      'title' => 'Soru düzenleme yetkisi',
    ]);

    $bouncer->ability()->firstOrCreate([
      'name' => 'elect-question',
      'title' => 'Soru oylama yetkisi',
    ]);
  }
}
