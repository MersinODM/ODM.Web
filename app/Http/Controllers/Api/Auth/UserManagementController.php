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

namespace App\Http\Controllers\Api\Auth;

use App\Events\NewUserReqReceived;
use App\Events\ResetPasswordEvent;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseContents;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Rules\Recaptcha;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends ApiController
{

    /**
     * Kullanıcı açma isteğini işleyecek fonksiyon
     * @param Request $request
     * @param Recaptcha $recaptcha
     * @return JsonResponse
     */
    public function registerRequest(Request $request, Recaptcha $recaptcha)
    {
        //Doğrulama apisine gelen veri doğrrulana için gönderidiliyor
        //Doğruılama geçilemezse bu fonksiyon otomatik geriye dönüyor
        //Yani bir sonraki satırdaki işleme geçmiyor
        $validationResult =  $this->apiValidator($request, [
            'email' => 'required|string|email|max:255',
            "full_name" => "required",
            "inst_id" => "required",
            "branch_id" => "required",
            "phone" => "required",
//            'recaptcha' => ['required', $recaptcha]
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        // Kullanıcı için hem pasiflerde hemde aktiflerde arama yapılacaktır
        // aramaya telefonda eklenmiştir.
        $req = User::withTrashed()
            ->where("email", $request->input("email"))
            ->orWhere("phone", $request->input("phone"))
            ->first();

        if ($req) {
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                ResponseKeys::MESSAGE => "Bu mail adresiyle ve telefonla halihazırda bir hesabınız veya daha önce bir istek yapılmış veya varolan kaydınız pasif hale getirilmiş olabilir lütfen yöneticilerden yardım isteyiniz."
            ], 409);
        }


        $requestedUser = $request->only("full_name", "inst_id", "branch_id", "email", "phone");
        try {
            DB::beginTransaction();
            $model = new User($requestedUser);
            $model->save();
            $model->assign('teacher');

            $model->lessons()
                ->attach($model->branch_id, ['is_main' => true]);

            //Burada kullanıca şifre oluşturma maili atılıyor
            event(new NewUserReqReceived($model));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Kullanıcı oluşturma isteğiniz tarafımıza ulaştı ve size bir e-posta attık lütfen e-postaadresinizi kontrol etmeyi unutmayınız."
            ], 201);
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_ERROR,
                ResponseKeys::MESSAGE => "Kullanıcı oluşturma işlmei alınamadı!",
                "exception" => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Yeni kayıt isteği yapan sistem kullanıcısına onay verecek fonksiyon
     * @param $id
     * @return JsonResponse
     */
    public function confirmNewUserReq($id)
    {
        try {
            DB::beginTransaction();
            User::find($id)->update([
                "activator_id" => Auth::id()
            ]);
            $newUserReq = User::find($id);
            $newUserReq->lessons()
                ->updateExistingPivot($newUserReq->branch_id, ['creator_id' => Auth::id()]);
            //Bu sırada kullanıcıya şifre email olarak atıldı.
            //Bu işlem normalde java gibi dillerde asenkron yapılabilirdi
            event(new ResetPasswordEvent($newUserReq));
            DB::commit();
            return response()->json([ResponseKeys::MESSAGE => "Kullanıcı kayıt isteği onaylandı."], 200);
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([ResponseKeys::MESSAGE => "Kullanıcı kayıt onayı yapılamadı!",
                ResponseKeys::EXCEPTION => $exception->getMessage()], 500);
        }
    }

    /**
     * Kullanıcı güncelleme api fonk.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id) {
        $validationResult = $this->apiValidator($request, [
            'branch_id' => 'required',
            "inst_id" => "required",
            "full_name" => "required",
            "phone" => "required",
            "email" => "required",
            "role" => "required"
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $data = $request->only("branch_id",
            "inst_id",
            "full_name",
            "phone",
            "email");
        $role = $request->input("role");
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->retract($user->getRoles());
            $user->update($data);
            $user->assign($role);
            DB::commit();
            return response()->json([
                ResponseKeys::MESSAGE => "Kullanıcı güncelleme başarılı olmuştur."
            ]);
        }
        catch (Exception $exception) {
            DB::rollBack();
            return response()->json([ResponseKeys::MESSAGE=> "Kullanıcı güncelleme başarısız oldu!",
                ResponseKeys::EXCEPTION => $this->apiException($exception)], 500);
        }
    }

    /*
     * Bu fonksiyon kullanıcıyı tekrar aktifleştirmrk için kullanılacak
     */
    public function reactivate($id)
    {
        try {
            DB::beginTransaction();
            User::withTrashed()
                ->where('id', $id)
                ->restore();
            DB::commit();
            return response()->json([
                ResponseKeys::MESSAGE => "Kullanıcı başarıyla aktifleştirildi"]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([ResponseKeys::MESSAGE=> "Kullanıcı aktifleştirilemedi!",
                ResponseKeys::EXCEPTION => $this->apiException($exception)], 500);
        }
    }

    /**
     * Kullanıcı silme işlemi bu işlem hard delete değil soft delete işlemidir.
     * Yani silinen kullanıcı users tablosu içinde var olmaya devam edecektir.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function delete($id) {
        try{
            DB::beginTransaction();
            $user = User::find($id);
            $user->delete();
            DB::commit();
            return response()->json([ResponseKeys::MESSAGE => "Kullanıcı pasif hale getirildi"]);
        }
        catch (Exception $exception) {
            DB::rollBack();
            return response()->json([ResponseKeys::MESSAGE=> "Kullanıcı pasifleştirilemedi!",
                ResponseKeys::EXCEPTION => $this->apiException($exception)], 500);
        }
    }
}
