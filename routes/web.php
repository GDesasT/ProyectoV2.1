<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarouselImageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;

//bola de pendejos, le mueven y no saben a que le movieron hijos de su puta madre


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::post('/menu', [FeedbackController::class, 'store'])->name('menu.store');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
<<<<<<< HEAD
=======
    Route::get('/PointOfSale', [HomeController::class, 'pointofsale'])->name('PointOfSale');

>>>>>>> 638ec9b0f53f380f348611c819a7f637494f1a9f
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

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

<<<<<<< HEAD
    Route::get('/PointOfSale', [SaleController::class, 'index'])->name('PointOfSale');
    Route::post('/PointOfSale', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
=======
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::get('/PointOfSale', [SaleController::class, 'PointOfSale'])->name('PointOfSale');
>>>>>>> 638ec9b0f53f380f348611c819a7f637494f1a9f

    Route::resource('feedback', FeedbackController::class)->only(['index', 'store', 'destroy']);
});