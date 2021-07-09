<?php
declare(strict_types=1);

use App\Http\Controllers\UserController;
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

Route::get('/users', [UserController::class, 'list'])->name('users.list');
Route::match(['put', 'patch'], '/users/{user}/details', [UserController::class, 'updateDetails'])
    ->name('users-detail.update');
Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.delete');
