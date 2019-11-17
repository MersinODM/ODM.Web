<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup
 *  geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *   Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\ApiController;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\Database\Role;
use Yajra\DataTables\DataTables;

class UserQueryController extends ApiController
{

    /**
     * Bütün kulanıcıları Jquery.Datatables() formatında gösteren api fonk.
     * @return mixed
     * @throws \Exception
     */
    public function getUsers()
    {
        $res = DB::table('users')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->leftJoin('institutions', 'institutions.id', '=', 'users.inst_id')
            ->leftJoin(DB::raw('users as um'), 'users.activator_id', '=', 'um.id')
            ->where("users.deleted_at", "=", null)
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

    /**
     * Bütün kulanıcıları Jquery.Datatables() formatında gösteren api fonk.
     * @return mixed
     * @throws \Exception
     */
    public function getPassiveUsers()
    {
        $res = DB::table('users')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->leftJoin('institutions', 'institutions.id', '=', 'users.inst_id')
            ->leftJoin(DB::raw('users as um'), 'users.activator_id', '=', 'um.id')
            ->where("users.deleted_at", "!=", null)
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

    /**
     * Kullanıcının rolünü getiren api fonk
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id)
    {
        $user = User::with('branch', 'institution')->find($id);
        if (isset($user))
            $user->role = $user->getRoles()->first();
//            $user->role = DB::table("roles")->where('name', $user->getRoles()[0])->select("id", "name", "title")->first();
        return response()->json($user);
    }
}