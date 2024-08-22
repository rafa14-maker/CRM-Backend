<?php

use App\Http\Controllers\Admin\AccomodationController;
use App\Http\Controllers\Admin\DayItineraryController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\LeadSourceController;
use App\Http\Controllers\Admin\MailConfigController;
use App\Http\Controllers\Admin\MealPlanController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\Crm\Accomodation\BankController;
use App\Http\Controllers\Crm\Accomodation\TarifController;
use App\Http\Controllers\Crm\EventController;
use App\Http\Controllers\Crm\QueryController;
use App\Http\Controllers\Event\AccomodationController as EventAccomodationController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ReportController;
use App\Mail\InvoiceMail;
use App\Models\InvoiceTemplate;
use App\Models\Itinerary;
use App\Models\Permission;
use App\Models\QueryStatus;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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

//*====some code required later=======

// middleware('auth:sanctum')->
// Route::post('/user', function (Request $request) {
//     return $request;
//     return response()->json('success',201);
// });


// admin settings


Route::group(['prefix' => 'v1'], function () {


    Route::post('/login', [LoginController::class, 'loginVerify'])->name('login.verify');
    Route::get('/trigger',[LoginController::class,'triggerApp'])->name('trigger');
    /**
     * input void
     * output roles data from table
     */

    Route::get('/roles', function () {
        $roles = Role::all();
        return response()->json($roles);
    });

    Route::get('send-mail', function () {
        $invoice_temp = InvoiceTemplate::first();
        Mail::to('usmanelaahi@gmail.com')->send(new InvoiceMail($invoice_temp));
        return response()->json('success', 200);
    });

    // Route::get('/permissions', function () {
    //     $permissions = Permission::all();
    //     return response()->json($permissions);
    // });

    Route::get('/query-status', function () {
        $statuses = QueryStatus::all();
        return response()->json($statuses);
    });

    /**
     * Team Managmet Crud
     * Supplier Crud
     * Destination Crud
     */
    Route::apiResource('team', TeamController::class);
    Route::apiResource('permission', PermissionController::class);
    Route::apiResource('mail-config', MailConfigController::class);
    Route::apiResource('supplier', SupplierController::class);
    Route::apiResource('destination', DestinationController::class);
    Route::apiResource('accomodation', AccomodationController::class);
    Route::apiResource('mealplan', MealPlanController::class);
    Route::apiResource('roomtype', RoomTypeController::class);
    Route::apiResource('dayitinerary', DayItineraryController::class);
    Route::apiResource('vehicle', TransferController::class);
    Route::apiResource('driver', DriverController::class);
    Route::apiResource('leadsource', LeadSourceController::class);

    //CRM Queries 
    Route::apiResource('query', QueryController::class);

    //Clients
    Route::apiResource('client', ClientController::class);

    //Agents
    Route::apiResource('agent', AgentController::class);

    //Corporarte
    Route::apiResource('corporate', CorporateController::class);

    Route::apiResource('itinerary', ItineraryController::class);

    // accomodation sub controller 
    Route::apiResource('/accomodation-tariff', TarifController::class);
    Route::apiResource('/accomodation-bank', BankController::class);

    Route::apiResource('itinerary/events', EventController::class);


    // Route::name('event.')->apiResource('event/accomodation',EventAccomodationController::class);

    Route::get('/report', [ReportController::class, 'throwQuery']);

    Route::get('/reports/note', [ReportController::class, 'notes'])->name('report.notes.index');
    Route::post('/reports/note', [ReportController::class, 'storeNotes'])->name('report.notes.stores');

    Route::get('/reports/transaction', [ReportController::class, 'transactions'])->name('report.transactions.index');
    Route::post('/reports/transaction', [ReportController::class, 'storeTransactions'])->name('report.transactions.store');

    Route::get('/reports/tour-report', [ReportController::class, 'packages'])->name('report.package');
});
