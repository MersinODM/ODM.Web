<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

namespace App\Http\Controllers\Api\Setting;


use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use Illuminate\Support\Facades\Artisan;

class MailSyncController extends ApiController
{
    public function executeMailQueue() {
        try {
            Artisan::call('queue:work', ['--stop-when-empty' => true]);
            //Aşağıdaki kod parçasına ulaşamdan çalışma kesiliyor
            $output = Artisan::output();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Mail seknronizasyonu tamamlandı."
            ]);
        }
        catch (\Exception $exception) {
            return response()->json($this->apiException($exception));
        }
    }
}