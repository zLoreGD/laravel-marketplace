<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartItemController;

Route::get('/', function () {
    $products = Product::all();
    return view('home',['products'=> $products]);
});
Route::get('/category-search',[ProductController::class,'search']);
Route::get('/search-product',[ProductController::class,'search_item']);
Route::get('/details/{id}',[ProductController::class,'details']);
Route::post('/comment',[CommentController::class,'comment']);
Route::post('/register',[UserController::class,'register']);
Route::post('/logout',[UserController::class,'logout']);
Route::post('/login',[UserController::class,'login']);
Route::post('/add-to-cart',[CartItemController::class,'addItem']);
Route::get('/cart',function(){
    $items = CartItem::with('product')
    ->where('user_id',Auth::id())
    ->get();
    
    return view('cart',['items'=> $items]);
});
Route::delete('/delete-item',[CartItemController::class,'deleteItem']);