<?php

use App\Models\ContactInfo;
use Illuminate\Support\Facades\App;
use ProtoneMedia\Splade\Facades\SEO;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\ImageUpscallerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SpamFilterController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Contracts\Role;

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

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return redirect(App::getLocale());
    });

    Route::prefix('{locale?}')
        ->where(['locale' => '[a-zA-Z]{2}'])
        ->middleware('setlocale')
        ->group(function () {
            Route::get('/', function () {
                return view('welcome');
            })->name('home');
            require __DIR__ . '/auth.php';

            Route::middleware('auth')->group(function () {

                Route::prefix('super')->group(function () {
                    Route::get('/super-user', [AdminController::class, 'index'])->name('super-user');
                    Route::resource('users', UserController::class);
                    Route::resource('roles', RoleController::class);
                });
                Route::get('/dashboard', function () {
                    return view('dashboard');
                })->middleware(['verified'])->name('dashboard');

                Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



                Route::prefix('file-manager')->group(function () {
                    // Custom route to download an asset by slug
                    Route::get('/train-csv/{id}', [AssetController::class, 'trainCSV'])->name('train-csv');
                    Route::get('/download/{asset:slug}', [AssetController::class, 'downloadFile'])->name('download');
                    // Custom route to restore a soft-deleted asset
                    Route::post('/{id}/restore', [AssetController::class, 'restore'])->name('restore-asset');
                    Route::get('/share-page/{asset}', [AssetController::class, 'sharePage'])->name('assets.share-page');
                    Route::post('/share-files/{asset}', [AssetController::class, 'shareFiles'])->name('assets.share');
                    // Custom route to force delete an asset
                    Route::post('/{id}/forcedelete', [AssetController::class, 'forceDelete'])->name('delete-asset');
                    Route::get('/download-all', [AssetController::class, 'downloadAll'])->name('download-all');
                    // Custom route for Naive Bayes analysis (example)
                    Route::get('/naive-bayes', [AssetController::class, 'naiveBayes'])->name('naive-bayes');
                    Route::get('/assets-analytics', [AssetController::class, 'assetAnalytics'])->name('assets-analytics');
                    Route::get('/assets-card-view', [AssetController::class, 'assetsCardView'])->name('assets-card-view');
                    Route::get('/shared-assets', [AssetController::class, 'sharedAssets'])->name('shared-assets');
                    Route::get('/detect-images', [AssetController::class, 'tensorFlowImgPrediction'])->name('detect-images');
                    // Custom route to view trashed assets
                    Route::get('/trashed', [TrashedController::class, 'index'])->name('trashed');
                    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
                    Route::post('/change-prediction-settings', [SettingsController::class, 'setAssetPrediction'])->name('change-prediction-settings');
                });
                Route::resource('assets', AssetController::class);
            });
        });
});
