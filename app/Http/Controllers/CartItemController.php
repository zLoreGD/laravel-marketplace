<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function addItem(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:999',
        ]);
       
        $item = CartItem::create([
            'user_id'=>Auth::id(),
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity,

        ]);
        if($item){
            return redirect('/')->with('success','Product added to cart succesfully');
        }

        return redirect('/');
        
        
    }
    public function deleteItem(Request $request){
        $item = CartItem::where('product_id',$request->product_id)->first();
        $item->delete();
        return redirect('/cart');
    }
}
