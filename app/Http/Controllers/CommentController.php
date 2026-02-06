<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'description'=> 'required|string|max:500'
        ]);
        $comment = Comment::create([
            'description'=>$request->description,
            'product_id'=>$request->product_id,
            'user_id'=>Auth::id()

        ]);
        if($comment){
            return redirect("/details/$request->product_id")->with('success','Added with success');
        }
        return redirect('/');
        

        
    }
}
