<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;

use App\Events\NewUserReqReceived;
use App\Events\ResetPasswordEvent;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ResponseHelper;
use App\Rules\Recaptcha;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserManagementController extends ApiController
{

    /**
     * Kullanıcı açma isteğini işleyecek fonksiyon
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerRequest(Request $request, Recaptcha $recaptcha)
    {
        //Doğrulama apisine gelen veri doğrrulana için gönderidiliyor
        //Doğruılama geçilemezse bu fonksiyon otomatik geriye dönüyor
        //Yani bir sonraki satırdaki işleme geçmiyor
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            "full_name" => "required",
            "inst_id" => "required",
            "branch_id" => "required",
            "phone" => "required",
            'recaptcha' => ['required', $recaptcha]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $req = User::where("email", $request->input("email"))->first();

        if ($req) {
            return response()->json(['message' => "Bu mail adresiyle daha önce bir istek yapılmış."], 409);
        }

        DB::beginTransaction();
        try {
            $model = new User();
            $requestedUser = $request->only("full_name", "inst_id", "branch_id", "email", "phone");
            $model->fill($requestedUser);
            $model->save();
            $model->assign('teacher');

            //Burada kullanıca şifre oluşturma maili atılıyor
            event(new NewUserReqReceived($model));
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
                "exception" => $exception->getMessage()], 500);
        }
        return response()->json(["message" => "Kullanıcı açma isteğiniz alındı."], 201);
    }

    /**
     * Yeni kayıt isteği yapan sistem kullanıcısına onay verecek fonksiyon
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmNewUserReq(Request $request, $id)
    {

        DB::beginTransaction();
        try {
//      $newUserReqId = $id;
            User::find($id)->update([
                "activator_id" => Auth::id()
            ]);
            $newUserReq = User::find($id);
//      $newUserReq->activator_id = Auth::id();
//      $newUserReq->save();
            //TODO: Bu sırada kullanıcıya şifre email olarak atılacak önemli!!!
            //Bu işlem normalde java gibi dillerde asenkron yapılabilirdi ya da PHP 7 uyumlu laravel ile
            event(new ResetPasswordEvent($newUserReq));
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([ResponseHelper::MESSAGE => ResponseHelper::EXCEPTION_MESSAGE,
                ResponseHelper::EXCEPTION => $exception->getMessage()], 500);
        }
        return response()->json([ResponseHelper::MESSAGE => "Kullanıcı kayıt isteği onaylandı."], 200);
    }


    public function resetPassword(Request $request)
    {

        $validationResult = $this->apiValidator($request, [
            'token' => 'required',
            'email' => 'required|email|max:255',
            "password" => "required|confirmed|min:6",
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $broker = app('auth.password.broker');

        $user = $broker->getUser($credentials);
        if ($user == null) {
            return response()->json([ResponseHelper::MESSAGE => "Kullanıcı e-posta adresi bulunamadı!"], 404);
        }

        $isExist = $broker->tokenExists($user, $credentials["token"]);

        if ($isExist) {
            $result = $broker->reset($credentials, function ($user, $pass) {
                $user->password = Hash::make($pass);
                $user->activation_date = Carbon::now();
                $user->save();
            });
            if ($result == PasswordBroker::PASSWORD_RESET) {
                return response()->json([ResponseHelper::MESSAGE => "Şifreniz başarıyla değiştirildi!"], 200);
            }
            return response()->json([ResponseHelper::MESSAGE => "Şifreniz değiştirilemedi!"]);
        }
        return response()->json([ResponseHelper::MESSAGE => "Şifre değiştirme bağlantısının süresi geçmiş olabilir.\nŞifremi unuttum diyerek tekrar bağlantı alabilirsiniz!"], 404);
    }

    public function getUsers()
    {
        $res = DB::table('users')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->leftJoin('institutions', 'institutions.id', '=', 'users.inst_id')
            ->leftJoin(DB::raw('users as um'), 'users.activator_id', '=', 'um.id')
            ->select(
                'users.id',
                DB::raw('institutions.name as inst_name'),
                DB::raw('branches.name as branch_name'),
                'users.full_name',
                DB::raw('um.full_name as activator_name'),
                'users.created_at',
                'users.phone');

        return Datatables::of($res)
            ->orderColumn(
                "full_name",
                "branch_name",
                "inst_name",
                "created_at")
            ->editColumn('created_at', function ($a) {
                Carbon::setLocale("tr-TR");
                $d = strtotime($a->created_at) > 0 ? with(new Carbon($a->created_at))->formatLocalized("%d.%m.%Y") : '';
                return $d;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(users.created_at,'%d.%m.%Y') like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }

    public function getUser($id)
    {
        return User::with('branch', 'institution')->findOrFail($id);
    }

    public function forgetPassword(Request $request, Recaptcha $recaptcha)
    {
        $validationResult = $this->apiValidator($request, [
            'email' => 'required|email|max:255',
            'recaptcha' => ['required', $recaptcha]
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $email = $request->input("email");
        $user = User::where("email", $email)->first();
        if (isset($user)) {
            if (isset($user->activator_id)) {
                event(new ResetPasswordEvent($user));
                return response()->json([ResponseHelper::MESSAGE => "Size şifrenizi oluşturabileceğiniz bir mail gönderdik.\nİyi çalışmalar..."]);
            }
            return response()->json([ResponseHelper::MESSAGE => "Kaydınız henüz onaylanmadığı için şifremi unuttum kısmını kullanamazsınız!"]);
        }
        return response()->json([ResponseHelper::MESSAGE => "E-Posta adresiniz sistemde bulunamadı! Lütfen doğru e posta adresini gönderdiğinizden emin olunuz doğru gönderdiğinizi düşünüyorsanız sistem yönetininize başvurunuz. İyi çalışmalar.."]);
    }
}
