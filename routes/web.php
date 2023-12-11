<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FormOneController;
use App\Http\Controllers\FormSecondController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Begin:   Muhammad Adil Task Sub-Task 0.2

    // Begin: Route for first form
        // Route to show the first form
        Route::get('/firstForm',[FormOneController::class,'index'])->name('first-form.show');
        // Post Route for the first form to remove the space
        Route::post('/remove/space',[FormOneController::class,'remove_space'])->name('frist-form.remove-space');
    // End: Route for first form

    // //////////////////////
    // Begin: Route for second form
        // Route to show the 2nd form
        Route::get('/secondForm',[FormSecondController::class,'index'])->name('second-form.show');
        // Post Route for the 2nd form to coun the words from the given paragraph
        Route::post('/secondform/words/counts',[FormSecondController::class,'count_words'])->name('second-form.count_words');
    // End: Route for second form
// End:    Muhammad Adil Task Sub-Task 0.2

// Route::get(/'home',function(){return view('admin.home');});
Route::get('/home', function () {
    return view('admin.home');
})->name('home_dashboard');

// Begin: Route for companies
// Route to show the post-companies.blade.php
Route::get('/home/companies',[CompanyController::class,'index'])->name('home.companies.index');
// Route to store the companies in db
Route::post('/home/companies',[CompanyController::class,'store_company'])->name('home.companies.store_company');
// Route to list the list-companies.blade.php
Route::get('/home/companies/list',[CompanyController::class,'list_companies'])->name('home.companies.list_companies');
// Route to show the edit-companies.blade.php
Route::get('/home/companies/{companyId}/edit',[CompanyController::class,'edit_company'])->name('home.companies.edit_company');
// Route to update the company dataa
Route::post('/home/companies/update',[CompanyController::class,'update_company'])->name('home.companies.update_company');
// Route to delete the company data
Route::get('/home/companies/delete/{companyId}',[CompanyController::class,'delete_company'])->name('home.companies.delete_company');
// End: Route for companies


// Begin: Route for employees
// Route to show the post-employees.blade.php file
Route::get('/home/employees',[EmployeeController::class,'index'])->name('home.employees.index');
// Route to store the employees in db
Route::post('/home/employees',[EmployeeController::class,'store_employee'])->name('home.employees.store_employee');
// Route to list the list-employees.blade.php
Route::get('/home/employees/list',[EmployeeController::class,'list_employee'])->name('home.employees.list_employee');
// Route to update the comapny of an employee
Route::get('/home/employees/list/{company_id}/{employee_id}',[EmployeeController::class,'update_company_employee'])->name('home.employees.update_company_employee');
// Route to show the edit-employee.blade.php
Route::get('/home/employees/{employee_id}/edit',[EmployeeController::class,'edit_employee'])->name('home.employees.edit_employee');
// Route to update the employees data
Route::post('/home/employees/update',[EmployeeController::class,'update_employee'])->name('home.employees.update_employee');
// Route to delete the employees data
Route::get('/home/employees/delete/{employee_id}',[EmployeeController::class,'delete_employee'])->name('home.employees.delete_employee');
// End: Route for employees