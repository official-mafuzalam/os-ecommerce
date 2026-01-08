<?php

use App\Http\Controllers\Api\AiController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
Route::get('/active-visitors', function () {
    $activeVisitors = Cache::remember('active_visitors', 300, function () {
        return DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(2)->timestamp)
            ->count();
    });

    return response()->json(['activeVisitors' => $activeVisitors]);
});


Route::post('/generate-description', [AiController::class, 'generateDescription'])->name('admin.products.generate-description');