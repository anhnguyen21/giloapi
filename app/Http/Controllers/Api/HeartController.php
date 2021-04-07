<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\heart;

class HeartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return heart::all();
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
    
        public function getHeartDetails($id)
    {
        $review = DB::table('hearts')
        ->join('product','hearts.id','=','product.id')
        ->join('users','hearts.id','=','users.id')
        ->select('product.name','users.account','hearts.*')
        ->where('id_product',$id)
        ->get();
        return $review;
    }

    public function addProductHeart(Request $request){
        $pro=DB::select('select id from hearts where id_product ='.$request->get('id_pro').' and id_user='.$request->get('id_user'));
        if($pro==null){
            $product=new heart();
            $product->id_product=$request->get('id_pro');
            $product->id_user=$request->get('id_user');
            $product->save();
            echo "add 1 heart for product";
        }else{
            DB::delete('delete from hearts where id ='.$pro[0]->id);
            echo "delete heart of product";
        }
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
