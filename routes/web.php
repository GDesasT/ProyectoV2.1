<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarouselImageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\inventoryController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleHistoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::post('/menu', [FeedbackController::class, 'store'])->name('menu.store');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/enterprises', [EnterpriseController::class, 'create'])->name('enterprises.create');
Route::post('/enterprises/create', [EnterpriseController::class, 'store'])->name('enterprises.store');

Route::get('/customers', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers/create', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

Route::get('/salehistory', [SaleHistoryController::class, 'index'])->name('sales.history');

Route::middleware('auth')->group(function () {

    Route::get('/inventory', [inventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [inventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [inventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [inventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [inventoryController::class, 'destroy'])->name('inventory.destroy');


    Route::get('/PointOfSale', [SaleController::class, 'index'])->name('PointOfSale');
    Route::post('/PointOfSale', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');



    Route::get('/carousel', [CarouselImageController::class, 'index'])->name('carousel.index');
    Route::get('/carousel/create', [CarouselImageController::class, 'create'])->name('carousel.create');
    Route::post('/carousel', [CarouselImageController::class, 'store'])->name('carousel.store');
    Route::get('/carousel/toggle/{id}', [CarouselImageController::class, 'toggleActive'])->name('carousel.toggle');
    Route::delete('/carousel/{id}', [CarouselImageController::class, 'destroy'])->name('carousel.destroy');

    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

Route::middleware('admin:Admin,Dev')->group(function (){
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store', 'destroy']);
});
