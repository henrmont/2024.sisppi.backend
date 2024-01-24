<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\ExerciseYearController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FinancingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\IncentiveDestinationController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MinisterialOrdinaceController;
use App\Http\Controllers\MinisterialOrdinaceDestinationController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationFormController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProgramingController;
use App\Http\Controllers\ProgramingProcedureController;
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

Route::group(['middleware' => 'api', 'prefix' => 'favorites', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get', [FavoriteController::class, 'getFavorites']);
    Route::get('check/{id}', [FavoriteController::class, 'checkFavorite']);
    Route::get('add/{id}', [FavoriteController::class, 'addFavorite']);
    Route::get('remove/{id}', [FavoriteController::class, 'removeFavorite']);

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
    Route::get('validate/user/{id}', [UserController::class, 'validateUser']);
    Route::delete('delete/user/{id}', [UserController::class, 'deleteUser']);
    Route::get('get/empty/manager', [UserController::class, 'getEmptyManagerUsers']);
    Route::get('change/empty/manager/{id}', [UserController::class, 'changeEmptyManagerUser']);
    Route::post('change/no/empty/manager', [UserController::class, 'changeNoEmptyManagerUser']);

});

Route::group(['middleware' => 'api', 'prefix' => 'counties', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/counties', [CountyController::class, 'getCounties']);
    Route::get('get/county/{id}', [CountyController::class, 'getCounty']);
    Route::get('get/counties/without/ministerial/ordinace/{id}', [CountyController::class, 'getCountiesWithoutMinisterialOrdinace']);
    Route::get('get/counties/without/incentive/{id}', [CountyController::class, 'getCountiesWithoutIncentive']);
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
    Route::get('get/valid/exercise/years', [ExerciseYearController::class, 'getValidExerciseYears']);
    Route::post('create/exercise/year', [ExerciseYearController::class, 'createExerciseYear']);
    Route::patch('update/exercise/year', [ExerciseYearController::class, 'updateExerciseYear']);
    Route::delete('delete/exercise/year/{id}', [ExerciseYearController::class, 'deleteExerciseYear']);
    Route::get('validate/exercise/year/{id}', [ExerciseYearController::class, 'validateExerciseYear']);

});

Route::group(['middleware' => 'api', 'prefix' => 'competencies', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/competencies', [CompetenceController::class, 'getCompetencies']);
    Route::get('get/valid/competencies', [CompetenceController::class, 'getValidCompetencies']);
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

Route::group(['middleware' => 'api', 'prefix' => 'financings', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/financings', [FinancingController::class, 'getFinancings']);

});

Route::group(['middleware' => 'api', 'prefix' => 'modalities', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/modalities', [ModalityController::class, 'getModalities']);

});

Route::group(['middleware' => 'api', 'prefix' => 'procedures', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::post('import/procedures', [ProcedureController::class, 'importProcedures']);
    Route::get('get/procedures', [ProcedureController::class, 'getProcedures']);

});

Route::group(['middleware' => 'api', 'prefix' => 'programings', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/programings', [ProgramingController::class, 'getProgramings']);
    Route::post('create/programing', [ProgramingController::class, 'createPrograming']);
    Route::patch('update/programing', [ProgramingController::class, 'updatePrograming']);
    Route::delete('delete/programing/{id}', [ProgramingController::class, 'deletePrograming']);
    Route::get('validate/programing/{id}', [ProgramingController::class, 'validatePrograming']);

});

Route::group(['middleware' => 'api', 'prefix' => 'programing/procedures', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/programing/procedures/{id}', [ProgramingProcedureController::class, 'getProgramingProcedures']);
    Route::post('add/programing/procedure', [ProgramingProcedureController::class, 'addProgramingProcedure']);
    Route::patch('amount/programing/procedure', [ProgramingProcedureController::class, 'amountProgramingProcedure']);
    Route::patch('type/programing/procedure', [ProgramingProcedureController::class, 'typeProgramingProcedure']);
    Route::delete('remove/programing/procedure/{id}', [ProgramingProcedureController::class, 'removeProgramingProcedure']);

});

Route::group(['middleware' => 'api', 'prefix' => 'ministerial/ordinaces', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/ministerial/ordinaces', [MinisterialOrdinaceController::class, 'getMinisterialOrdinaces']);
    Route::post('create/ministerial/ordinace', [MinisterialOrdinaceController::class, 'createMinisterialOrdinace']);
    Route::patch('update/ministerial/ordinace', [MinisterialOrdinaceController::class, 'updateMinisterialOrdinace']);
    Route::delete('delete/ministerial/ordinace/{id}', [MinisterialOrdinaceController::class, 'deleteMinisterialOrdinace']);
    Route::get('validate/ministerial/ordinace/{id}', [MinisterialOrdinaceController::class, 'validateMinisterialOrdinace']);
    Route::patch('attach/ministerial/ordinace', [MinisterialOrdinaceController::class, 'attachMinisterialOrdinace']);

});

Route::group(['middleware' => 'api', 'prefix' => 'ministerial/ordinace/destinations', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/ministerial/ordinace/destinations/{id}', [MinisterialOrdinaceDestinationController::class, 'getMinisterialOrdinaceDestinations']);
    Route::post('add/ministerial/ordinace/destination', [MinisterialOrdinaceDestinationController::class, 'addMinisterialOrdinaceDestination']);
    Route::patch('value/ministerial/ordinace/destination', [MinisterialOrdinaceDestinationController::class, 'valueMinisterialOrdinaceDestination']);
    Route::delete('remove/ministerial/ordinace/destination/{id}', [MinisterialOrdinaceDestinationController::class, 'removeMinisterialOrdinaceDestination']);

});

Route::group(['middleware' => 'api', 'prefix' => 'incentives', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/incentives', [IncentiveController::class, 'getIncentives']);
    Route::post('create/incentive', [IncentiveController::class, 'createIncentive']);
    Route::patch('update/incentive', [IncentiveController::class, 'updateIncentive']);
    Route::delete('delete/incentive/{id}', [IncentiveController::class, 'deleteIncentive']);
    Route::get('validate/incentive/{id}', [IncentiveController::class, 'validateIncentive']);
    Route::patch('attach/incentive', [IncentiveController::class, 'attachIncentive']);

});

Route::group(['middleware' => 'api', 'prefix' => 'incentive/destinations', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/incentive/destinations/{id}', [IncentiveDestinationController::class, 'getIncentiveDestinations']);
    Route::post('add/incentive/destination', [IncentiveDestinationController::class, 'addIncentiveDestination']);
    Route::patch('value/incentive/destination', [IncentiveDestinationController::class, 'valueIncentiveDestination']);
    Route::delete('remove/incentive/destination/{id}', [IncentiveDestinationController::class, 'removeIncentiveDestination']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
