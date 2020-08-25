<?php
/*
 *
 *  * This file is part of the GPLv3 distribution (https://github.com/electropsycho/ODM.Web)
 *  * Copyright (c) 2015 Hakan GÜLEN
 *  *
 *  * This program is free software: you can redistribute it and/or modify
 *  * it under the terms of the GNU General Public License as published by
 *  * the Free Software Foundation, version 3.
 *  *
 *  * This program is distributed in the hope that it will be useful, but
 *  * WITHOUT ANY WARRANTY; without even the implied warranty of
 *  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *  * General Public License for more details.
 *  *
 *  * You should have received a copy of the GNU General Public License
 *  * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseContents;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ValidationTrait;
    /**
     * @param Request $request
     * @param $props
     * @return \Illuminate\Support\MessageBag|null
     */
    public function apiValidator(Request $request, $props): ?\Illuminate\Support\MessageBag
    {

        $validator = Validator::make($request->all(), $props, $this->MESSAGES, $this->ATTRIBUTES);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return null;
    }

    public function apiException($exception)
    {
        return [
            ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
            ResponseKeys::MESSAGE => ResponseContents::EXCEPTION_MESSAGE,
            ResponseKeys::EXCEPTION => $exception->getMessage()
        ];
    }
}
