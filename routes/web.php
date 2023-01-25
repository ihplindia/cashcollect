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
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CompanyinfoController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SystemlogController;
use Illuminate\Http\Request;

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
    return view('auth.login');
})->name('login');


Route::get('/clearall', function () {
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('event:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    dd("Cache Clear All");

});
Route::get('/test', function () {
    return view('admin.income.main.demo');

});

Route::get('dashboard', [AdminController::class, 'index']);

Route::get('dashboard/user', [UserController::class, 'index'])->name('users');
Route::get('dashboard/user/add', [UserController::class, 'add'])->name('add.user');
Route::get('dashboard/user/edit/{id}', [UserController::class, 'edit']);
Route::get('dashboard/user/password/{id}', [UserController::class, 'password']);
Route::get('dashboard/user/view/{id}', [UserController::class, 'view']);
Route::get('dashboard/user/view', [UserController::class, 'userProfile'])->name('user.profile');
Route::get('dashboard/user/set/{slug}', [UserController::class, 'SetPassword'])->name('changepassword');
Route::post('dashboard/user/updatePassword', [UserController::class, 'updatePassword']);
Route::post('dashboard/user/submit', [UserController::class, 'insert'])->name('create.newuser');
Route::post('dashboard/user/update', [UserController::class, 'update'])->name('update.user');

Route::get('dashboard/setting',[SettingController::class, 'index']);
Route::get('dashboard/setting/add',[SettingController::class, 'add']);
Route::post('dashboard/setting/insert',[SettingController::class, 'insert']);
Route::get('dashboard/setting/edit/{slug}',[SettingController::class, 'edit']);
Route::post('dashboard/setting/update',[SettingController::class, 'update']);

Route::get('dashboard/companyinfo',[CompanyinfoController::class, 'index'])->name('companyinfo');
Route::get('dashboard/companyinfo/add',[CompanyinfoController::class, 'add'])->name('add.company');
Route::post('dashboard/companyinfo/insert',[CompanyinfoController::class, 'insert'])->name('insert.company');
Route::get('dashboard/companyinfo/edit/{slug}',[CompanyinfoController::class, 'editcompany'])->name('edit.company');
Route::post('dashboard/companyinfo/update',[CompanyinfoController::class, 'update'])->name('update.company');

Route::get('dashboard/branch/{slug}',[BranchController::class, 'index'])->name('branch');
Route::get('dashboard/branch/add',[BranchController::class, 'newbranch']);
Route::post('dashboard/branch/insert',[BranchController::class, 'storedBranch'])->name('addbranch');
Route::get('dashboard/branch/edit/{slug}',[BranchController::class, 'edit'])->name('edit.branch');
Route::post('dashboard/branch/update',[BranchController::class, 'update'])->name('update.branch');
Route::get('dashboard/branch/bycompany/{slug}',[BranchController::class, 'getbranch'])->name('getbranch');

Route::get('dashboard/department/view/',[DepartmentController::class, 'index'])->name('alldepartment');
Route::get('dashboard/department',[DepartmentController::class, 'add'])->name('add.department');
Route::post('dashboard/department',[DepartmentController::class, 'insert'])->name('insert.department');
Route::get('dashboard/department/edit/{slug}',[DepartmentController::class, 'edit'])->name('edit.department');
Route::post('dashboard/department/update',[DepartmentController::class, 'update'])->name('update.department');
// Route::get('dashboard/editbranch/{slug}',[CompanyinfoController::class, 'editbranch']);
// Route::post('dashboard/updatebranch',[CompanyinfoController::class, 'updatebranch']);
// Route::get('dashboard/companyinfo/editcompany/{slug}',[CompanyinfoController::class, 'editcompany']);
// Route::post('dashboard/companyinfo/updatempany',[CompanyinfoController::class, 'updatempany']);

Route::get('dashboard/currency',[CurrencyController::class, 'index']);
Route::get('dashboard/currency/add',[CurrencyController::class, 'add']);
Route::post('dashboard/currency/insert',[CurrencyController::class, 'insert']);
Route::get('dashboard/currency/edit/{slug}',[CurrencyController::class, 'edit']);
Route::post('dashboard/currency/update',[CurrencyController::class, 'update']);
Route::get('dashboard/income/rate/{slug}', [CurrencyController::class, 'Currency_Rate'])->name('currency.rate');

Route::get('dashboard/role', [RoleController::class, 'index']);
Route::get('dashboard/role/add', [RoleController::class, 'add']);
Route::get('dashboard/role/edit/{slug}', [RoleController::class, 'edit']);
Route::post('dashboard/role/update', [RoleController::class, 'update']);
Route::post('dashboard/role/stored', [RoleController::class, 'stored']);

Route::get('dashboard/permission/group', [PermissionGroupController::class, 'index']);
Route::get('dashboard/permission/group/add', [PermissionGroupController::class, 'add']);
Route::post('dashboard/permission/group/submit', [PermissionGroupController::class, 'insert']);
Route::get('dashboard/permission/permissiongroup/edit/{slug}', [PermissionGroupController::class, 'edit']);
Route::post('dashboard/permission/permissiongroup/update', [PermissionGroupController::class, 'update']);

Route::get('dashboard/permission', [PermissionController::class, 'index']);
Route::get('dashboard/permission/add', [PermissionController::class, 'add']);
Route::post('dashboard/permission/submit', [PermissionController::class, 'insert']);
Route::get('dashboard/permission/edit/{slug}', [PermissionController::class, 'edit']);
Route::post('dashboard/permission/update', [PermissionController::class, 'update']);
Route::post('dashboard/permission/delete', [PermissionController::class, 'permissionDelete'])->name('delete.permission');

Route::get('dashboard/income', [IncomeController::class, 'index'])->name('all.income');
Route::post('dashboard/income', [IncomeController::class, 'search'])->name('searching');
Route::get('dashboard/income/add', [IncomeController::class, 'add'])->name('add');
Route::get('dashboard/income/edit/{slug}', [IncomeController::class, 'edit']);
Route::get('dashboard/income/status/{slug}', [IncomeController::class, 'search'])->name('status');
Route::post('dashboard/income/collect', [IncomeController::class, 'collect'])->name('collector.collect');
Route::get('dashboard/income/deposit/{slug}', [IncomeController::class, 'deposit'])->name('collector.deposit');
Route::get('dashboard/income/selfdeposit/{slug}', [IncomeController::class, 'selftDeposit'])->name('self.deposit');
Route::get('dashboard/income/paid/{slug}', [IncomeController::class, 'sendPayment'])->name('paidPayment');
Route::get('dashboard/income/accept/{slug}', [IncomeController::class, 'accept'])->name('receiver.accept');
Route::get('dashboard/income/settled', [IncomeController::class, 'incomeSettled'])->name('income.settled');
Route::post('dashboard/income/file', [IncomeController::class, 'fileattchment'])->name('income.attchment');
Route::get('dashboard/income/view/{slug}', [IncomeController::class, 'View'])->name('income.view');
Route::get('dashboard/income/submit', [IncomeController::class, 'insert']);
Route::get('dashboard/income/update', [IncomeController::class, 'update']);
Route::get('dashboard/income/cancelled/{income_id}/{income_ref_no}', [IncomeController::class, 'cancelled'])->name('income.cancelled');
Route::post('dashboard/income/softdelete', [IncomeController::class, 'softdelete']);
Route::get('dashboard/income/repayment', [IncomeController::class, 'rePayment'])->name('income.rewpayment');
Route::post('dashboard/income/restore', [IncomeController::class, 'restore']);
Route::post('dashboard/income/delete', [IncomeController::class, 'delete']);
Route::get('dashboard/income/export', [IncomeController::class, 'export']);
Route::get('dashboard/income/report', [IncomeController::class, 'advanced']);
Route::get('dashboard/income/advanced-search', [IncomeController::class, 'advancedSearch'])->name('advanced.search');
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
Route::get('dashboard/report/view/{slug}', [ReportController::class, 'view']);
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
Route::get('dashboard/systemlog', [SystemlogController::class, 'index']);

Route::get('qrcode/view/{slug}', [QrCodeController::class, 'index'])->name('allincome');
Route::get('qrcode/scan/{slug}/{key}', [QrCodeController::class, 'scan']);

//laravell defolt routs
require __DIR__.'/auth.php';
