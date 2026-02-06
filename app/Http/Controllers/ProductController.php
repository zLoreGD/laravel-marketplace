<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request){
        $category = $request->input("category");    
        $products = Product::whereHas('category', function ($query) use ($category){
            $query->where('name','like','%'.$category.'%');
        })->get();
        if($category == "All"){
            $products = Product::all();
            return view('home',['products'=> $products]);
        }
        return view("home",compact("products"));

    }
    public function search_item(Request $request){
        $search = $request->input("search");
        $products = Product::where("name","like","%".$search."%")->get();
        if(count($products) == 0){
            return view("home",compact('products'))->with("error","Could not find products with name $search");
        }
        return view('home',compact('products'));
    }
    public function details($id){
        $product = Product::findOrFail(($id));
        $comments = Comment::where('product_id','=', $product->id)->get();
        return view('/details',['product'=> $product,'comments'=>$comments]);
    }
}
