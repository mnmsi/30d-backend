<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BaseUserController;
use App\Http\Controllers\EducativeController;
use App\Http\Controllers\HadithContentController;
use App\Http\Controllers\LifeStyleContentController;
use App\Http\Controllers\MollePaymentController;
use App\Http\Controllers\NewsPortalController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\PaymentHistoryController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [BaseUserController::class, 'logoutUser'])->name('logout');
    // all life-style route are mention bellow
    Route::prefix('life-style')->group(function () {
        Route::get('/', [LifeStyleContentController::class, 'index'])->name('life-style');
        Route::get('/lifeStyle-create-page', [LifeStyleContentController::class, 'lifeStyleCreatePageShow'])->name('life-style-create-page');
        Route::post('/create-life-style', [LifeStyleContentController::class, 'createLifeStyle'])->name('create-life-style');
        Route::get('/edit-life-style/show/{id}', [LifeStyleContentController::class, 'editLifeStyleContent'])->name('edit-page-show-life-style');
        Route::put('/update-life-style', [LifeStyleContentController::class, 'updateLifeStyleContent'])->name('life-style-update');
        Route::get('/content/{name}', [LifeStyleContentController::class, 'lifeStyleSportsItem'])->name('specific-content');
    });
    // all content can delete with this route
    Route::delete('/content/delete/{id}', [LifeStyleContentController::class, 'deleteContent'])->name('delete-content');

    // all hadith route are mention bellow
    Route::prefix('hadith')->group(function () {
        Route::get('/', [HadithContentController::class, 'index'])->name('hadith');
        Route::get('/crate-page-show', [HadithContentController::class, 'createPageShow'])->name('hadith-create-page-show');
        Route::post('/crate-hadith', [HadithContentController::class, 'createHadith'])->name('hadith-create');
        Route::get('/edit-page-show/{id}', [HadithContentController::class, 'editHadithPageShow'])->name('hadith-edit-page');
        Route::put('/update-hadith', [HadithContentController::class, 'updateHadith'])->name('hadith-update');
        Route::delete('/hadith-delete/{id}', [HadithContentController::class, 'deleteHadith'])->name('hadith-delete');
    });
    Route::delete('/content/delete/{id}', [LifeStyleContentController::class, 'deleteContent'])->name('delete-content');

    //Educative route
    Route::group(['as' => 'educatie', 'prefix' => 'educatie'], function () {
        Route::get('/', [EducativeController::class, 'index']);
        Route::get('create', [EducativeController::class, 'create'])->name('.create');
        Route::post('store', [EducativeController::class, 'store'])->name('.store');
        Route::get('edit/{id}', [EducativeController::class, 'edit'])->name('.edit');
        Route::put('update', [EducativeController::class, 'update'])->name('.update');
        Route::delete('delete/{id}', [EducativeController::class, 'delete'])->name('.delete');
        Route::get('content/{name}', [EducativeController::class, 'educativeContent'])->name('.content');
    });

    // all News Portal Route are mention bellow
    Route::group(['as' => 'newsPortal', 'prefix' => 'news-portal'], function () {
        Route::get('/', [NewsPortalController::class, 'index']);
        Route::get('create', [NewsPortalController::class, 'create'])->name('.create');
        Route::post('store', [NewsPortalController::class, 'store'])->name('.store');
        Route::get('edit/{id}', [NewsPortalController::class, 'edit'])->name('.edit');
        Route::put('update', [NewsPortalController::class, 'update'])->name('.update');
        Route::delete('delete/{id}', [NewsPortalController::class, 'delete'])->name('.delete');
    });

    // Rules route
    Route::group(['as'=>'rules','prefix'=>'rules'],function (){
        Route::get('/', [RulesController::class, 'index']);
        Route::get('/create', [RulesController::class, 'create'])->name('.create');
        Route::post('/create-rules', [RulesController::class, 'createRules'])->name('.create-rules');
        Route::get('/edit/{id}', [RulesController::class, 'edit'])->name('.edit');
        Route::put('update', [RulesController::class, 'update'])->name('.update');
        Route::delete('delete/{id}', [RulesController::class, 'delete'])->name('.delete');
        Route::get('/quiz-items/{name}', [RulesController::class, 'quizItems'])->name('.specific-items');
        Route::put('/status/{id}',[RulesController::class,'statusUpdate'])->name('.status');
    });
    // Payment History Route
    Route::group(['as' => 'payment-history','prefix'=>'payment-history'],function(){
       Route::get('/',[PaymentHistoryController::class,'index']);
        Route::post('/search',[PaymentHistoryController::class,'search'])->name('.search');
    });
});
//Route::get('/test',[NewsPortalController::class,'test']);
Route::get('/login', [BaseUserController::class, 'LoginPageShow'])->name('login');
Route::post('/login-check', [BaseUserController::class, 'userLoginCheck'])->name('login-check');
Route::get('/callback',[MollePaymentController::class,'webView']);
