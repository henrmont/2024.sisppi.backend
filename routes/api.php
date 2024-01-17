<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\ExerciseYearController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationFormController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\SubgroupController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('permissions', [AuthController::class, 'permissions']);

});

Route::group(['middleware' => 'api', 'prefix' => 'account', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::post('create', [AccountController::class, 'create']);
    Route::get('get/{email}', [AccountController::class, 'getAccount']);

});

Route::group(['middleware' => 'api', 'prefix' => 'favorite', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/{id}', [FavoriteController::class, 'getFavorites']);
    Route::post('create', [FavoriteController::class, 'createFavorite']);

});

Route::group(['middleware' => 'api', 'prefix' => 'link', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('all', [LinkController::class, 'getLinks']);

});

Route::group(['middleware' => 'api', 'prefix' => 'notification', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('flash', [NotificationController::class, 'getFlashNotifications']);
    Route::get('unread', [NotificationController::class, 'getUnreadNotifications']);
    Route::get('read', [NotificationController::class, 'setReadNotifications']);
    Route::get('all', [NotificationController::class, 'getAllNotifications']);

});

Route::group(['middleware' => 'api', 'prefix' => 'users', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/users', [UserController::class, 'getUsers']);
    Route::get('get/users/without/role/{id}', [UserController::class, 'getUsersWithoutRole']);
    Route::get('get/users/without/permission/{id}', [UserController::class, 'getUsersWithoutPermission']);
    Route::get('get/user/{id}', [UserController::class, 'getUser']);
    Route::get('get/user/roles/{id}', [UserController::class, 'getUserRoles']);
    Route::post('create/user', [UserController::class, 'createUser']);
    Route::patch('update/user', [UserController::class, 'updateUser']);
    Route::delete('delete/user/{id}', [UserController::class, 'deleteUser']);
    Route::get('get/empty/manager', [UserController::class, 'getEmptyManagerUsers']);
    Route::get('change/empty/manager/{id}', [UserController::class, 'changeEmptyManagerUser']);
    Route::post('change/no/empty/manager', [UserController::class, 'changeNoEmptyManagerUser']);

});

Route::group(['middleware' => 'api', 'prefix' => 'counties', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/counties', [CountyController::class, 'getCounties']);
    Route::get('get/county/{id}', [CountyController::class, 'getCounty']);
    Route::post('create/county', [CountyController::class, 'createCounty']);
    Route::delete('delete/county/{id}', [CountyController::class, 'deleteCounty']);
    Route::patch('update/county', [CountyController::class, 'updateCounty']);

});

Route::group(['middleware' => 'api', 'prefix' => 'roles', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/roles', [RoleAndPermissionController::class, 'getRoles']);
    Route::get('get/permissions', [RoleAndPermissionController::class, 'getPermissions']);
    Route::get('get/without/permissions/{id}', [RoleAndPermissionController::class, 'getWithoutPermissions']);
    Route::get('get/role/{id}', [RoleAndPermissionController::class, 'getRole']);
    Route::get('get/permission/{id}', [RoleAndPermissionController::class, 'getPermission']);
    Route::post('create/role', [RoleAndPermissionController::class, 'createRole']);
    Route::post('add/user/role', [RoleAndPermissionController::class, 'addUserRole']);
    Route::delete('delete/user/role/{role}/{id}', [RoleAndPermissionController::class, 'deleteUserRole']);
    Route::patch('update/role', [RoleAndPermissionController::class, 'updateRole']);
    Route::delete('delete/role/{id}', [RoleAndPermissionController::class, 'deleteRole']);
    Route::post('add/user/permission', [RoleAndPermissionController::class, 'addUserPermission']);
    Route::delete('remove/user/permission/{permission}/{id}', [RoleAndPermissionController::class, 'removeUserPermission']);

});

Route::group(['middleware' => 'api', 'prefix' => 'exercise/years', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/exercise/years', [ExerciseYearController::class, 'getExerciseYears']);
    Route::post('create/exercise/year', [ExerciseYearController::class, 'createExerciseYear']);
    Route::patch('update/exercise/year', [ExerciseYearController::class, 'updateExerciseYear']);
    Route::delete('delete/exercise/year/{id}', [ExerciseYearController::class, 'deleteExerciseYear']);
    Route::get('validate/exercise/year/{id}', [ExerciseYearController::class, 'validateExerciseYear']);

});

Route::group(['middleware' => 'api', 'prefix' => 'competencies', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/competencies', [CompetenceController::class, 'getCompetencies']);
    Route::delete('delete/competence/{id}', [CompetenceController::class, 'deleteCompetence']);
    Route::get('validate/competence/{id}', [CompetenceController::class, 'validateCompetence']);

});

Route::group(['middleware' => 'api', 'prefix' => 'groups', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/groups', [GroupController::class, 'getGroups']);

});

Route::group(['middleware' => 'api', 'prefix' => 'subgroups', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/subgroups', [SubgroupController::class, 'getSubgroups']);

});

Route::group(['middleware' => 'api', 'prefix' => 'organization/forms', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/organization/forms', [OrganizationFormController::class, 'getOrganizationForms']);

});

Route::group(['middleware' => 'api', 'prefix' => 'procedures', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::post('import/procedures', [ProcedureController::class, 'importProcedures']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
