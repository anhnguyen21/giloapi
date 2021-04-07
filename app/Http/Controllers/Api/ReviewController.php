<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return review::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    public function getReviewDetails($id)
    {
        $review = DB::table('reviews')
        ->join('product','reviews.id','=','product.id')
        ->join('users','reviews.id','=','users.id')
        ->select('product.name','users.account','reviews.*')
        ->where('id_product',$id)
        ->get();
        return $review;
    }
    
    public function addProductReview(Request $request){
        $product=new review();
        $product->id_product=$request->get('id_pro');
        $product->id_user=$request->get('id_user');
        $product->content=$request->get('content');
        $product->time=date_create()->format('Y-m-d H:i:s');
        $product->save();
        echo "add 1 review for product";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
