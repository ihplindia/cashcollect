<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\PermissionController;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('dashboard', [AdminController::class, 'index']);


Route::get('dashboard/user', [UserController::class, 'index']);
Route::get('dashboard/user/add', [UserController::class, 'add']);
Route::get('dashboard/user/edit/{id}', [UserController::class, 'edit']);
Route::get('dashboard/user/password/{id}', [UserController::class, 'password']);
Route::get('dashboard/user/view/{id}', [UserController::class, 'view']);

Route::post('dashboard/user/updatePassword', [UserController::class, 'updatePassword']);
Route::post('dashboard/user/submit', [UserController::class, 'insert']);
Route::post('dashboard/user/update', [UserController::class, 'update']);

Route::get('dashboard/role', [RoleController::class, 'index']);
Route::get('dashboard/role/add', [RoleController::class, 'add']);
Route::get('dashboard/role/edit/{slug}', [RoleController::class, 'edit']);
Route::post('dashboard/role/update', [RoleController::class, 'update']);
Route::post('dashboard/role/stored', [RoleController::class, 'stored']);

Route::get('dashboard/permission', [PermissionController::class, 'index']);
Route::get('dashboard/permission/add', [PermissionController::class, 'add']);
Route::post('dashboard/permission/submit', [PermissionController::class, 'insert']);
Route::get('dashboard/permission/edit/{slug}', [PermissionController::class, 'edit']);
Route::post('dashboard/permission/update', [PermissionController::class, 'update']);

Route::get('dashboard/income', [IncomeController::class, 'index']);
Route::get('dashboard/income/add', [IncomeController::class, 'add']);
Route::get('dashboard/income/edit/{slug}', [IncomeController::class, 'edit']);
Route::get('dashboard/income/view/{slug}', [IncomeController::class, 'View']);
Route::get('dashboard/income/submit', [IncomeController::class, 'insert']);
Route::get('dashboard/income/update', [IncomeController::class, 'update']);
Route::post('dashboard/income/softdelete', [IncomeController::class, 'softdelete']);
Route::post('dashboard/income/restore', [IncomeController::class, 'restore']);
Route::post('dashboard/income/delete', [IncomeController::class, 'delete']);
Route::get('dashboard/income/export', [IncomeController::class, 'export']);
Route::get('dashboard/income/pdf', [IncomeController::class, 'pdf']);

Route::get('dashboard/income/category', [IncomeCategoryController::class, 'index']);
Route::get('dashboard/income/category/add', [IncomeCategoryController::class, 'add']);
Route::get('dashboard/income/category/edit/{slug}', [IncomeCategoryController::class, 'edit']);
Route::get('dashboard/income/category/view/{slug}', [IncomeCategoryController::class, 'View']);
Route::get('dashboard/income/category/submit', [IncomeCategoryController::class, 'insert']);
Route::post('dashboard/income/category/update', [IncomeCategoryController::class, 'update']);
Route::post('dashboard/income/category/softdelete', [IncomeCategoryController::class, 'softdelete']);
Route::post('dashboard/income/category/restore', [IncomeCategoryController::class, 'restore']);
Route::post('dashboard/income/category/delete', [IncomeCategoryController::class, 'delete']);

Route::get('dashboard/expense', [ExpenseController::class, 'index']);
Route::get('dashboard/expense/add', [ExpenseController::class, 'add']);
Route::get('dashboard/expense/edit/{slug}', [ExpenseController::class, 'edit']);
Route::get('dashboard/expense/view/{slug}', [ExpenseController::class, 'view']);
Route::get('dashboard/expense/submit', [ExpenseController::class, 'insert']);
Route::get('dashboard/expense/update', [ExpenseController::class, 'update']);
Route::get('dashboard/expense/softdelete', [ExpenseController::class, 'softdelete']);
Route::get('dashboard/expense/restore', [ExpenseController::class, 'restore']);
Route::get('dashboard/expense/delete', [ExpenseController::class, 'delete']);
Route::get('dashboard/expense/export', [ExpenseController::class, 'export']);
Route::get('dashboard/expense/pdf', [ExpenseController::class, 'pdf']);

Route::get('dashboard/expense/category', [ExpenseCategoryController::class, 'index']);
Route::get('dashboard/expense/category/add', [ExpenseCategoryController::class, 'add']);
Route::get('dashboard/expense/category/edit/{slug}', [ExpenseCategoryController::class, 'edit']);
Route::get('dashboard/expense/category/view/{slug}', [ExpenseCategoryController::class, 'view']);
Route::get('dashboard/expense/category/submit', [ExpenseCategoryController::class, 'insert']);
Route::get('dashboard/expense/category/update', [ExpenseCategoryController::class, 'update']);
Route::get('dashboard/expense/category/softdelete', [ExpenseCategoryController::class, 'softdelete']);
Route::get('dashboard/expense/category/restore', [ExpenseCategoryController::class, 'restore']);
Route::get('dashboard/expense/category/delete', [ExpenseCategoryController::class, 'delete']);

Route::get('dashboard/report', [ReportController::class, 'index']);
Route::get('dashboard/report/reports', [ReportController::class, 'reports']);
Route::get('dashboard/report/current', [ReportController::class, 'current']);
Route::get('dashboard/report/summary', [ReportController::class, 'summary']);
Route::get('dashboard/report/search', [ReportController::class, 'search']);


Route::get('dashboard/recycle', [RecycleController::class, 'index']);
Route::get('dashboard/recycle/user', [RecycleController::class, 'user']);
Route::get('dashboard/recycle/income', [RecycleController::class, 'income']);
Route::get('dashboard/recycle/income_category', [RecycleController::class, 'income_category']);
Route::get('dashboard/recycle/expense', [RecycleController::class, 'expense']);
Route::get('dashboard/recycle/expense_category', [RecycleController::class, 'expense_category']);

//laravell defolt routs
require __DIR__.'/auth.php';
