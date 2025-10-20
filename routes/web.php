<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class,'home'])->name('index');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('product_details');

Route::post('/addtocart/{id}', [UserController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('addtocart');

Route::get('/cartporducts', [UserController::class, 'cartProducts'])->middleware(['auth', 'verified'])->name('cartproducts');

Route::get('/removecartproducts/{id}', [UserController::class, 'removeCart'])->middleware(['auth', 'verified'])->name('removecartproducts');

Route::post('/confirm_order', [UserController::class, 'confirmOrder'])->middleware(['auth', 'verified'])->name('confirm_order');

Route::get('/myorders', [UserController::class, 'myOrders'])->middleware(['auth', 'verified'])->name('myorders');

Route::get('/cancel-order/{id}', [UserController::class, 'cancelOrder'])
     ->name('user.cancelorder')
     ->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->group(function(){
    Route::get('/add_category',[AdminController::class, 'addCategory'])->name('admin.addcategory');
    Route::post('/add_category',[AdminController::class, 'postAddCategory'])->name('admin.postaddcategory');
    Route::get('/view_category',[AdminController::class, 'viewCategory'])->name('admin.viewcategory');
    Route::delete('/delete_category/{id}',[AdminController::class, 'deleteCategory'])->name('admin.categorydelete');
    Route::get('/update_category/{id}',[AdminController::class, 'updateCategory'])->name('admin.categoryupdate');
    Route::post('/update_category/{id}',[AdminController::class, 'postUpdateCategory'])->name('admin.postupdatecategory');
    Route::get('/add_product',[AdminController::class, 'addProduct'])->name('admin.addproduct');
    Route::post('/add_product',[AdminController::class,'postAddProduct'])->name('admin.postaddproduct');
    Route::get('/view_product',[AdminController::class,"viewProduct"])->name('admin.viewproduct');
    Route::delete('/view_product/{id}',[AdminController::class, 'deleteProduct'])->name('admin.deleteproduct');
    Route::get('/update_product/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateproduct');
    Route::post('/update_product/{id}', [AdminController::class, 'postUpdateProduct'])->name('admin.postupdateproduct');
    Route::get('/vieworder', [AdminController::class, 'viewOrder'])->name('admin.vieworders');
    Route::post('/update_order_status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.updateorderstatus');
    Route::delete('/delete_order/{id}', [AdminController::class, 'deleteOrder'])->name('admin.deleteorder');
});


require __DIR__.'/auth.php';
