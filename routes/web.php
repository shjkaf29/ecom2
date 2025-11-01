<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserProductController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
         ->name('user.dashboard'); 
});


Route::get('/product_details/{id}', [UserProductController::class, 'productDetails'])->name('product_details');

Route::post('/addtocart/{id}', [UserCartController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('addtocart');

Route::get('/cartporducts', [UserCartController::class, 'cartProducts'])->middleware(['auth', 'verified'])->name('cartproducts');

Route::get('/removecartproducts/{id}', [UserCartController::class, 'removeCart'])->middleware(['auth', 'verified'])->name('removecartproducts');

Route::post('/confirm_order', [UserOrderController::class, 'confirmOrder'])->middleware(['auth', 'verified'])->name('confirm_order');

Route::get('/myorders', [UserOrderController::class, 'myOrders'])->middleware(['auth', 'verified'])->name('myorders');

Route::get('/cancel-order/{id}', [UserOrderController::class, 'cancelOrder'])
     ->name('user.cancelorder')
     ->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->group(function(){
    Route::get('/add_category',[AdminCategoryController::class, 'addCategory'])->name('admin.category.addcategory');
    Route::post('/add_category',[AdminCategoryController::class, 'postAddCategory'])->name('admin.category.postaddcategory');
    Route::get('/view_category',[AdminCategoryController::class, 'viewCategory'])->name('admin.category.viewcategory');
    Route::delete('/delete_category/{id}',[AdminCategoryController::class, 'deleteCategory'])->name('admin.category.categorydelete');
    Route::get('/update_category/{id}',[AdminCategoryController::class, 'updateCategory'])->name('admin.category.categoryupdate');
    Route::post('/update_category/{id}',[AdminCategoryController::class, 'postUpdateCategory'])->name('admin.category.postupdatecategory');
    Route::get('/add_product',[AdminProductController::class, 'addProduct'])->name('admin.product.addproduct');
    Route::post('/add_product',[AdminProductController::class,'postAddProduct'])->name('admin.product.postaddproduct');
    Route::get('/view_product',[AdminProductController::class,"viewProduct"])->name('admin.product.viewproduct');
    Route::delete('/view_product/{id}',[AdminProductController::class, 'deleteProduct'])->name('admin.deleteproduct');
    Route::get('/update_product/{id}', [AdminProductController::class, 'updateProduct'])->name('admin.updateproduct');
    Route::post('/update_product/{id}', [AdminProductController::class, 'postUpdateProduct'])->name('admin.postupdateproduct');
    Route::get('/vieworder', [AdminOrderController::class, 'viewOrder'])->name('admin.orders.vieworders');
    Route::post('/update_order_status/{id}', [AdminOrderController::class, 'updateOrderStatus'])->name('admin.orders.updateorderstatus');
    Route::delete('/delete_order/{id}', [AdminOrderController::class, 'deleteOrder'])->name('admin.deleteorder');
    Route::get('/users', [AdminUserController::class, 'viewUsers'])
        ->name('admin.users');
    Route::get('/users/edit/{id}', [AdminUserController::class, 'editUser'])
        ->name('admin.users.edit');
    Route::post('/users/update/{id}', [AdminUserController::class, 'updateUser'])
        ->name('admin.users.update');
    Route::delete('/users/delete/{id}', [AdminUserController::class, 'deleteUser'])
        ->name('admin.users.delete');
    Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
    })->name('admin.dashboard');
});

    Route::get('/', [UserDashboardController::class,'home'])->name('index');