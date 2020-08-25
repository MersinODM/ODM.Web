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

namespace App\Http\Controllers\Api\Exam;


use App\Http\Controllers\ApiController;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExamQueryController extends ApiController
{
    public function getExams(Request $request) {
        $exams = DB::table('exams as e')
            ->join('users as u', 'e.creator_id', '=', 'u.id')
            ->join('exam_purposes as p', 'e.purpose_id', '=', 'p.id')
            ->select(
                'e.id',
                'e.creator_id',
                'e.code',
                'e.title',
                'p.purpose',
                'e.created_at',
                DB::raw('(case status 
                    when ' . Exam::CREATED . ' then "Oluşturulmuş"
                    when ' . Exam::PLANNED . ' then "Planlanmış"
                    when ' . Exam::CANCELED . ' then "İptal edilmiş"
                    when ' . Exam::COMPLETED . ' then "Tamamlanmış"
                    else "Belirsiz"
                    end) as status'),
                'e.class_level',
                'e.planned_date',
                'u.full_name'
            );
        return Datatables::of($exams)
            ->orderColumn('e.created_at', 'e.title')
            ->editColumn('created_at', static function ($a) {
                Carbon::setLocale("tr-TR");
                try {
                    $d = strtotime($a->created_at) > 0 ? with(new Carbon($a->created_at))->formatLocalized("%d.%m.%Y") : '';
                } catch (\Exception $e) {
                }
                return $d;
            })
            ->editColumn('planned_date', static function ($a) {
                Carbon::setLocale("tr-TR");
                try {
                    $d = strtotime($a->planned_date) > 0 ? with(new Carbon($a->planned_date))->formatLocalized("%d.%m.%Y %H:%m") : '';
                } catch (\Exception $e) {
                }
                return $d;
            })
            ->filterColumn('created_at', static function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(e.created_at,'%d.%m.%Y') like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('planned_date', static function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(e.planned_date,'%d.%m.%Y') like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }

    public function get(Request $request)
    {

        $validationResult = $this->apiValidator($request, [
            'id' => 'required_without:code', //Id alanı code alanı yokken zorunludur
            'code' => 'required_without:id', //Code alanı id alanı yokken zorunludur
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $id = $request->query("id");
        $code = $request->query("code");

        $exam = DB::table('exams as e')
            ->join('users as u', 'e.creator_id', '=', 'u.id')
            ->join('exam_purposes as p', 'e.purpose_id', '=', 'p.id')
            ->select(
                'e.id',
                'e.creator_id',
                'e.code',
                'e.title',
                'p.purpose',
                DB::raw('(case status 
                    when ' . Exam::CREATED . ' then "Oluşturulmuş"
                    when ' . Exam::PLANNED . ' then "Planlanmış"
                    when ' . Exam::CANCELED . ' then "İptal edilmiş"
                    when ' . Exam::COMPLETED . ' then "Tamamlanmış"
                    else "Belirsiz"
                    end) as status'),
                'class_level',
                'planned_date',
                DB::raw('IF(!ISNULL(date_of_occurrence), DATE_FORMAT(date_of_occurrence, "%d.%m.%Y %H:%i"), "Sınav kapatılmamış olabilir") as date_of_occurrence'),
                'description',
                'e.created_at',
                'u.full_name as creator'
            );

        if ($id && $code) {
            $exam->where('e.id', $id)
                ->where('e.code', $code);
        }

        if ($code) {
            $exam->where('e.code', $code);
//            return response()->json($exam->first());
        }

        if ($id) {
            $exam->where('e.id', $id);
//            return response()->json($exam->first());

        }
        return response()->json($exam->first());

//        return response()->json($exam->get());
    }
}
