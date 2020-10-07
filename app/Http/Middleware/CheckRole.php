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


namespace App\Http\Middleware;

use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode( '|', $roles);
        foreach ($roles as $role) {
            if ($request->user()->isA($role)) {
                return $next($request);
            }
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_UNAUTHORIZED,
            ResponseKeys::MESSAGE => "Bu api'yi kullanmak için gerekli izne sahip değilsiniz!"
        ], 401);
    }

}