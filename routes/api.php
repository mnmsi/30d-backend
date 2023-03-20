<?php

use App\Http\Controllers\BaseUserController;
use App\Http\Controllers\ContentCategoryController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\HadithContentController;
use App\Http\Controllers\MetalPriceConverterController;
use App\Http\Controllers\MollePaymentController;
use App\Http\Controllers\NamazDataFormationController;
use App\Http\Controllers\NewsPortalController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\ZakatCalculatorController;
use App\Http\Controllers\ContentController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/prayer-time/specific-day', [NamazDataFormationController::class, 'prayerTimeForSpecificDay']);
Route::get('/monthly-event', [NamazDataFormationController::class, 'eachMonthAllEventList']);
Route::get('/metal-price-update', [MetalPriceConverterController::class, 'saveMetalCurrentPriceIntoDB']);
Route::post('/total-neshab-amount', [ZakatCalculatorController::class, 'zakatCalculation']);
Route::post('/register', [BaseUserController::class, 'register']);
Route::post('/content-type', [ContentTypeController::class, 'insert']);
Route::post('/content-category', [ContentCategoryController::class, 'insert']);

Route::get('content', [ContentController::class, 'getContentByType']);
Route::get('/content/with-category', [ContentController::class, 'contentWithCategory']);
Route::get('/specific-content/{id}', [ContentController::class, 'contentSpecificDetails']);
Route::get('/news-list', [NewsPortalController::class, 'getAllNewsList']);
Route::get('/news-list/{id}', [NewsPortalController::class, 'getSingleNewsWithId']);

Route::get('/quran-ul-karim-all-chapter', [QuranController::class, 'getListOfQuranChapter']);
Route::get('/verse-chapter', [QuranController::class, 'getSpecificChapter']);

Route::get('/hadith-small-list', [HadithContentController::class, 'hadithGet']);

Route::get('/rules/{slug}', [RulesController::class, 'getAllActiveRules']);

Route::post('/payment-history', [PaymentHistoryController::class, 'insert']);
Route::post('/mollie-payment', [MollePaymentController::class, 'test']);
Route::post('/mollie-webhook', [MollePaymentController::class, 'webHook']);
Route::get('/mollie-success', [MollePaymentController::class, 'success']);
Route::get('/ramadan-calendar', [NamazDataFormationController::class, 'ramadanCalenderFormation']);
Route::get('/test-content/{id}',[ContentController::class, 'onlyContent']);
