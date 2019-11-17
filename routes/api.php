<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
  'prefix' => 'auth'
], function ($router) {

    //Aşağıdakiler için doğrulama ihtiyacına gerek yok
    Route::post('register', 'Auth\UserManagementController@registerRequest');
    //  Route::put('password/reset', 'Auth\UserManagementController@resetPassword');
    Route::post('password/forget', 'Auth\PasswordController@forgetPassword');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('institutions', 'Inst\InstitutionController@findByNameInstitutions');
    Route::get('branches', 'Branch\BranchController@getBranches');

});

//Bütün doğrulanması gereken api istekleri bu grup altına yazılacak
//İstekler yapılırken http://tam_url/otomasyon/api/ nin arkasına ilgili istekler eklenecek
//TODO Swagger dökümantasyonu yapılabilir. Geliştircilerin hayatını kurtatır.
Route::group(['middleware' => ['jwt.auth']], function () {

    //Kullanıcı ve Rol yönetim route tanımnlamaları
    Route::put("users/{id}/confirm_req", "Auth\UserManagementController@confirmNewUserReq");
    Route::get("users/current/permissions", "Auth\PermissionController@getCurrentUserPermissions");
    Route::get("users/{id}", "Auth\UserQueryController@getUser");
    Route::put("users/{id}", "Auth\UserManagementController@update");
    Route::delete("users/{id}", "Auth\UserManagementController@delete");
    Route::post("users", "Auth\UserQueryController@getUsers");
    Route::post("users/passives", "Auth\UserQueryController@getPassiveUsers");
    Route::get("users/current/roles", "Auth\RoleController@getCurrentUserRoles");
    Route::get("users/{userId}/roles", "Auth\RoleController@getUserRoles");
    Route::get("roles", "Auth\RoleController@getAllRoles");

    //BranchService Api route tanımlamaları
    Route::post("branches", "Branch\BranchController@create");
    Route::put("branches/{id}", "Branch\BranchController@update");
    Route::delete("branches/{id}", "Branch\BranchController@delete");
    Route::get("branches/with_stats", "Branch\BranchController@getBranchesWithStats");
    Route::get("branches", "Branch\BranchController@getBranches");

    //Kazanım Api route tanımlamaları
    Route::post("learning_outcomes", "LO\LearningOutcomeController@create");
    Route::put("learning_outcomes/{id}", "LO\LearningOutcomeController@update");
    Route::delete("learning_outcomes/{id}", "LO\LearningOutcomeController@delete");
    Route::get("learning_outcomes/findByClassLevelAndLessonId", "LO\LearningOutcomeController@findByClassLevelAndLessonId");
    Route::post("learning_outcomes/find_by/content_lesson_id_class_level", "LO\LearningOutcomeController@findByContentAndLessonIdAndClassLevel");
    Route::get("learning_outcomes/find_by", "LO\LearningOutcomeController@findBy");
    Route::get("learning_outcomes/find_by/content", "LO\LearningOutcomeController@findByContentWithPaging");
    Route::get("learning_outcomes/last_saved/{size}", "LO\LearningOutcomeController@getLastSavedRecords");

    // Question Api route tanımlamaları
    Route::post("questions", "Question\QuestionController@create");
    Route::get("questions", "Question\QuestionController@findByContentAndClassLevelAndBranch");
    Route::get("questions/last_saved/{size}", "Question\QuestionController@getLastQuestions");
    Route::get("questions/{id}", "Question\QuestionController@findById");
    Route::get("questions/{id}/file", "Question\QuestionController@getFile");
    Route::post("questions/{id}/evaluations", "Question\QuestionEvalController@create");
    Route::get("questions/{id}/evaluations", "Question\QuestionEvalController@findByQuestionId");
    Route::post("questions/{id}/revisions", "Question\QuestionRevisionController@create");
    Route::get("questions/{id}/revisions", "Question\QuestionRevisionController@findByQuestionId");

    Route::get("stats/question_counts/total", "Stats\StatController@getQuestionCounts");
//  Route::get("stats/question_counts/by_lo/{lo_id}", "Stats\StatController@getQuestionCountByLO");
    Route::get("stats/classes", "Stats\StatController@getClasses");
    Route::get("stats/lo_count_by", "Stats\StatController@getQuestionCountByLO");


    //Birim api route tanımlamaları
    Route::get("units", "Inst\UnitController@getAllUnits");

    //Okul/Kurum api route tanımlamaları
    Route::post("institutions", "Inst\InstitutionController@create");
    Route::get("institutions", "Inst\InstitutionController@getInstitutions");
    Route::put("institutions/{id}", "Inst\InstitutionController@update");
    Route::delete("institutions/{id}", "Inst\InstitutionController@delete");

});
