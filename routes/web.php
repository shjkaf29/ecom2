<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// User Controllers
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserOrderController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;

// --------------------- USER ROUTES ---------------------
Route::get('/', [UserProductController::class,'home'])->name('index');

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/product_details/{id}', [UserProductController::class, 'productDetails'])->name('product_details');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/addtocart/{id}', [UserCartController::class, 'addToCart'])->name('addtocart');
    Route::get('/cartproducts', [UserCartController::class, 'cartProducts'])->name('cartproducts');
    Route::get('/removecartproducts/{id}', [UserCartController::class, 'removeCart'])->name('removecartproducts');
    Route::post('/confirm_order', [UserOrderController::class, 'confirmOrder'])->name('confirm_order');
    Route::get('/myorders', [UserOrderController::class, 'myOrders'])->name('myorders');
    Route::get('/cancel-order/{id}', [UserOrderController::class, 'cancelOrder'])->name('user.cancelorder');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Auth routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


    Route::middleware(['auth:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/add_category', [AdminCategoryController::class, 'addCategory'])->name('addcategory');
        Route::post('/add_category', [AdminCategoryController::class, 'postAddCategory'])->name('postaddcategory');
        Route::get('/view_category', [AdminCategoryController::class, 'viewCategory'])->name('viewcategory');
        Route::delete('/delete_category/{id}', [AdminCategoryController::class, 'deleteCategory'])->name('categorydelete');
        Route::get('/update_category/{id}', [AdminCategoryController::class, 'updateCategory'])->name('categoryupdate');
        Route::post('/update_category/{id}', [AdminCategoryController::class, 'postUpdateCategory'])->name('postupdatecategory');

        Route::get('/add_product', [AdminProductController::class, 'addProduct'])->name('addproduct');
        Route::post('/add_product', [AdminProductController::class, 'postAddProduct'])->name('postaddproduct');
        Route::get('/view_product', [AdminProductController::class, 'viewProduct'])->name('viewproduct');
        Route::delete('/view_product/{id}', [AdminProductController::class, 'deleteProduct'])->name('deleteproduct');
        Route::get('/update_product/{id}', [AdminProductController::class, 'updateProduct'])->name('updateproduct');
        Route::post('/update_product/{id}', [AdminProductController::class, 'postUpdateProduct'])->name('postupdateproduct');

        Route::get('/vieworder', [AdminOrderController::class, 'viewOrder'])->name('vieworders');
        Route::post('/update_order_status/{id}', [AdminOrderController::class, 'updateOrderStatus'])->name('updateorderstatus');
        Route::delete('/delete_order/{id}', [AdminOrderController::class, 'deleteOrder'])->name('deleteorder');

      
        Route::get('/users', [AdminUserController::class, 'viewUsers'])->name('users');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'editUser'])->name('users.edit');
        Route::post('/users/update/{id}', [AdminUserController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/delete/{id}', [AdminUserController::class, 'deleteUser'])->name('users.delete');
    });
});
