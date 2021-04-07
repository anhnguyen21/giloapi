<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\chat;

class ChatContronller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return chat::all();
    }

    public function getMessageUserToShop(Request $request){
        $chat = DB::select('select u.*,c.* from chat as c , users as u where c.id_admin=u.id and c.id_user='. $request->get('id_user').' and c.id_admin='. $request->get('id_admin'));
        return $chat;
        echo "get message user to admin";
    }
    
    public function getInsertMessageUserToShop(Request $request){
        $chat=new chat();
        $chat->id_admin=$request->get('id_admin');
        $chat->id_user=$request->get('id_user');
        $chat->id_role=0;
        $chat->content=$request->get('content');
        $chat->time=date_create()->format('Y-m-d H:i:s');
        $chat->save();
        echo "add 1 message for admin";
    }
    
     public function postMessageUserToShopAdmin(Request $request){
        $chat = DB::select('select u.*,c.* from chat as c , users as u where c.id_admin=u.id and c.id_user='. $request->get('id_user').' and c.id_admin='. $request->get('id_admin'));
        return $chat;
        echo "get message user to admin";
    }
    
    public function postInsertMessageUserToShopAdmin(Request $request){
        $chat=new chat();
        $chat->id_admin=$request->get('id_admin');
        $chat->id_user=$request->get('id_user');
        $chat->id_role=0;
        $chat->content=$request->get('content');
        $chat->time=date_create()->format('Y-m-d H:i:s');
        $chat->save();
        echo "add 1 message for admin";
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
