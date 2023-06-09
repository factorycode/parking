<?php

use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RecidentsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VisitorsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/**
 * ==============================
 *       @Router - login
 * ==============================
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginView'])->name('loginView');
    Route::get('/login2', [\App\Http\Controllers\AuthController::class, 'loginView2'])->name('loginView2');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'registerView'])->name('registerView');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/validate-property-code', [SearchController::class, 'validatePropertyCode'])->name('validate-property-code');

    /**
     * ==============================
     *       @Router - ForgotPassword
     * ==============================
     */
// Mostrar formulario de olvidó su contraseña
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Enviar correo con enlace de restablecimiento
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Mostrar formulario para restablecer contraseña
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Actualizar contraseña
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

    /**
     * ==============================
     *       @Router -  visitors
     * ==============================
     */
    Route::get('/visitors/{property_code}', [VisitorsController::class, 'index'])->name('visitors');
    Route::post('/visitors/addvisitors', [VisitorsController::class, 'addVisitors'])->name('visitors.addvisitors');
    //Route::get('/visitors', [VisitorsController::class, 'index'])->name('visitors.index');

    Route::post('/visitors/register-visitor-pass', [VisitorsController::class, 'registerVisitorPass'])->name('visitors.registerVisitorPass');
    Route::post('/register-vehicle', [VehiclesController::class, 'registerVehicle'])->name('visitors.registerResidentVehicle');

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'dashboardsCrmAnalytics'])->name('index');
    Route::get('/dashboards/crm-analytics', [HomeController::class, 'dashboardsCrmAnalytics'])->name('dashboards/crm-analytics');
    Route::get('/dashboards/orders', [HomeController::class, 'dashboardsOrders'])->name('dashboards/orders');
    Route::get('/dashboards/orders', [HomeController::class, 'dashboardsOrders'])->name('dashboards/orders');
    Route::get('/dashboards/crypto-2', [HomeController::class, 'dashboardsCrypto2'])->name('dashboards/crypto-2');
    Route::get('/dashboards/crypto-1', [HomeController::class, 'dashboardsCrypto1'])->name('dashboards/crypto-1');
    Route::get('/dashboards/banking-1', [HomeController::class, 'dashboardsBanking1'])->name('dashboards/banking-1');
    Route::get('/dashboards/banking-2', [HomeController::class, 'dashboardsBanking2'])->name('dashboards/banking-2');
    Route::get('/dashboards/personal', [HomeController::class, 'dashboardsPersonal'])->name('dashboards/personal');
    Route::get('/dashboards/cms-analytics', [HomeController::class, 'dashboardsCmsAnalytics'])->name('dashboards/cms-analytics');
    Route::get('/dashboards/influencer', [HomeController::class, 'dashboardsInfluencer'])->name('dashboards/influencer');
    Route::get('/dashboards/travel', [HomeController::class, 'dashboardsTravel'])->name('dashboards/travel');
    Route::get('/dashboards/teacher', [HomeController::class, 'dashboardsTeacher'])->name('dashboards/teacher');
    Route::get('/dashboards/education', [HomeController::class, 'dashboardsEducation'])->name('dashboards/education');
    Route::get('/dashboards/authors', [HomeController::class, 'dashboardsAuthors'])->name('dashboards/authors');
    Route::get('/dashboards/doctor', [HomeController::class, 'dashboardsDoctor'])->name('dashboards/doctor');
    Route::get('/dashboards/employees', [HomeController::class, 'dashboardsEmployees'])->name('dashboards/employees');
    Route::get('/dashboards/workspaces', [HomeController::class, 'dashboardsWorkspaces'])->name('dashboards/workspaces');
    Route::get('/dashboards/meetings', [HomeController::class, 'dashboardsMeetings'])->name('dashboards/meetings');
    Route::get('/dashboards/project-boards', [HomeController::class, 'dashboardsProjectBoards'])->name('dashboards/project-boards');
    Route::get('/dashboards/widget-ui', [HomeController::class, 'dashboardsWidgetUi'])->name('dashboards/widget-ui');
    Route::get('/dashboards/widget-contacts', [HomeController::class, 'dashboardsWidgetContacts'])->name('dashboards/widget-contacts');

    Route::get('/apps/chat', [HomeController::class, 'appsChat'])->name('apps/chat');
    Route::get('/apps/filemanager', [HomeController::class, 'appsFilemanager'])->name('apps/filemanager');
    Route::get('/apps/kanban', [HomeController::class, 'appsKanban'])->name('apps/kanban');
    Route::get('/apps/list', [HomeController::class, 'appsList'])->name('apps/list');
    Route::get('/apps/mail', [HomeController::class, 'appsMail'])->name('apps/mail');
    Route::get('/apps/nft-1', [HomeController::class, 'appsNft1'])->name('apps/nft1');
    Route::get('/apps/nft-2', [HomeController::class, 'appsNft2'])->name('apps/nft2');
    Route::get('/apps/pos', [HomeController::class, 'appsPos'])->name('apps/pos');
    Route::get('/apps/todo', [HomeController::class, 'appsTodo'])->name('apps/todo');
    Route::get('/apps/travel', [HomeController::class, 'appsTravel'])->name('apps/travel');
    /**
     * ==============================
     *       @Router - properties/
     * ==============================
     */

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::post('properties/store', [PropertyController::class, 'storeProperty'])->name('properties.store');
    Route::get('/addproperty', [PropertyController::class, 'create'])->name('addproperty');
    Route::get('/properties/list', [PropertyController::class, 'getDatos'])->name('properties.list');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::get('/properties/excel', [PropertyController::class, 'utiles_excel'])->name('utiles_excel');
    Route::get('properties/vehicles/{property_code}', [PropertyController::class, 'vehicles'])->name('properties.vehicles');
    Route::get('properties/users/{property_code}', [PropertyController::class, 'users'])->name('properties.users');
    Route::put('/properties/{property}/update-permit-status', [PropertyController::class, 'updatePermitStatus'])->name('properties.updatePermitStatus');
    Route::get('/properties/user/{property_code}', [PropertyController::class, 'adduser'])
        ->name('propertiesUser');

    /**
     * ==============================
     *       @Router - users/
     * ==============================
     */
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/adduser', [UsersController::class, 'create'])->name('adduser');
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::get('/user/edit/{property}', [UsersController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('/verificar-correo', [UsersController::class, 'verificarCorreo'])->name('verificar-correo');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/excel/{property_code}', [UsersController::class, 'list_users'])->name('list_users');
    Route::get('/users/excelusers', [UsersController::class, 'excel_users'])->name('excel_users');

    /**
     * ==============================
     *       @Router - Recidents/
     * ==============================
     */
    Route::get('/recidents', [RecidentsController::class, 'index'])->name('recidents');
    Route::get('/residents/{resident}/edit', [RecidentsController::class, 'edit'])->name('residents.edit');
    Route::post('/residents/{resident}/update', [RecidentsController::class, 'update'])->name('residents.update');
    Route::get('/residents/{resident}/print', [RecidentsController::class, 'print'])->name('residents.print');
    Route::post('/residents/{resident}/delete', [RecidentsController::class, 'destroy'])->name('residents.destroy');
    Route::post('import-csv', [RecidentsController::class, 'importCSV'])->name('importCSV');
    Route::get('/addresident', [RecidentsController::class, 'addResident'])->name('addresident');

    /**
     * ==============================
     *       @Router - vehicles/
     * ==============================
     */
    Route::get('/vehicles', [VehiclesController::class, 'index'])->name('vehicles');
    Route::get('/addvehicle/{property_code}', [VehiclesController::class, 'create'])->name('addvehicle');
    Route::post('/vehicles', [VehiclesController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{id}/edit/{property_code}', [VehiclesController::class, 'edit'])->name('edit.vehicle');
    Route::post('/update/{id}', [VehiclesController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}/properties/{property_code}', [VehiclesController::class, 'destroy'])->name('vehicles.destroy');
    Route::get('/vehicles/excel/{property_code}', [VehiclesController::class, 'listvehicles_excel'])->name('listvehicles_excel');
    Route::get('/vehicles/{vehicle}/show', [VehiclesController::class, 'show'])->name('vehicles.show');
    Route::get('/vehicles/excelvehicles', [VehiclesController::class, 'excel_vehicles'])->name('excel_vehicles');

    /**
     * ==============================
     *       @Router - visitors_pass/
     * ==============================
     */
    Route::get('/visitors_pass', [VisitorsController::class, 'show'])->name('visitors_pass');
    Route::get('/list-visitors/{property_code}', [VisitorsController::class, 'listVisitors'])->name('list.visitors');
    Route::get('/list-visitors/addtemporary/{property_code}', [VisitorsController::class, 'addTemporary'])->name('temporary.visitors.pass');
    Route::post('/visitors/add', [VisitorsController::class, 'storeTemporary'])->name('visitors.add');
    Route::get('/excelvisitors', [VisitorsController::class, 'excel_visitorspases'])->name('excel_visitorspases');
    Route::get('/excelvisitorsid/{property_code}', [VisitorsController::class, 'excel_visitorforid'])->name('excel_visitorforid');

    /**
     * ==============================
     *       @Router - documents/
     * ==============================
     */
    Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');

    /**
     * ==============================
     *       @Router - settings/
     * ==============================
     */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

});

/**
 * ==============================
 *       @Router - semails/
 * ==============================
 */

Route::get('/send-email/{id}/{property_code}/{email}', [EmailController::class, 'sendEmail'])->name('send.email');
