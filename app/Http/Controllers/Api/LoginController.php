<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
// use Illuminate\Http\Requests\users;
use App\Models\users;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount()
    {
        return users::all();
    }

    public function loginUser(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => 'required|max:20|min:5',
            'password' => 'required|max:20|min:3',
        ],[
            'account.required' => 'Tài khoản rỗng',
            'account.max' => 'Tài khoản quá 20 kí tự',
            'account.min' => 'Tài khoản ít hơn 5 kí tự',
            'password.required' => 'Mật khẩu rỗng',
            'password.max' => 'Mật khẩu quá 20 kí tự',
            'password.min' => 'Mật khẩu ít hơn 3 kí tự',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }else{
            $name = $request->input('account');
    		$password = $request->input('password');   
            $key ="anh";
            if (Auth::attempt(['account' => $name, 'password' => $password])) {
                $user_id= Auth::user()->id;
                $cookie=Cookie::make('user', $name, 30);
                $data = array("idToken" => $user_id);
                return response()->json($data,200)->cookie($cookie);
                
    		}else{
    			$array = array("data" => null);
    			return response()->json($array,400);
    		}
        }
    }
    public function loginAdmin(Request $request){
        $name = $request->input('account');
		$password = $request->input('password');   
        $key ="anh";
        
        if (Auth::attempt(['account' => $name, 'password' => $password])) {
             echo "response data admin";
            if( Auth::user()->remember_token==1){
                $user_id= Auth::user()->id;
                $cookie=Cookie::make('user', $name, 30);
                $data = array("idToken" => $user_id);
                echo "response data admin";
                return response()->json($data,200)->cookie($cookie);
            }
           
            
		}else{
		    
			$array = array("data" => $validator->errors());
			return response()->json($array,400);
		}
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'account' => 'required|max:20|min:5',
            'password' => 'required|max:20|min:3',
            'phone' => 'required|max:11|min:10',
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'email' => 'required|regex:/(.+)@(gmail)\.(com)/i'
        ],[
            'account.required' => 'Tài khoản rỗng',
            'account.max' => 'Tài khoản quá 20 kí tự',
            'account.min' => 'Tài khoản ít hơn 5 kí tự',
            'password.required' => 'Mật khẩu rỗng',
            'password.max' => 'Mật khẩu quá 20 kí tự',
            'password.min' => 'Mật khẩu ít hơn 3 kí tự',
            'phone.required' => 'Mật khẩu rỗng',
            'phone.max' => 'Mật khẩu quá 11 kí tự',
            'phone.min' => 'Mật khẩu ít hơn 10 kí tự',
            'firstName.required' => 'Tên rỗng',
            'lastName.required' => 'Họ rỗng',
            'address.required' => 'Địa chỉ rỗng',
            'email.required' => 'email rỗng',
            'email.regex' => 'Không phải email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }else{
            $name = $request->input('account');
            $password = $request->input('password');
            $key ="anh";
            if (Auth::attempt(['account' => $name, 'password' => $password])) {
                $user_id= Auth::user()->id;
                // $data=JWT::encode($user_id, $key);
    	 	    $array = array("idToken" => $user_id);
    			return response()->json($array,400);
            }else{
                $users=new users();
                $users->account=$request->get('account');
                $users->firstName=$request->get('firstName');
                $users->lastName=$request->get('lastName');
                $users->email=$request->get('email');
                $users->phone=$request->get('phone');
                $users->gender=$request->get('gender');
                $users->address=$request->get('address');
                $users->password=Hash::make($request->get('password'));
                $users->birthday=$request->get('brithday');
                 $users->img=$request->get('img');
                $users->remember_token='123';
                $users->save();
                echo "regist user success";
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAccount($id)
    {
        return users::find($id);
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
    public function destroyAccount($id)
    {
        return users::destroy($id);
    }
    
    
    
    public function uploadImage() {	
        echo "123456789";
      if(!empty($_FILES['file_attachment']['name'])) {
        $res        = array();
        $name       = 'file_attachment';
        $imagePath 	= 'assets/upload/file_attachment';
        $temp       = explode(".",$_FILES['file_attachment']['name']);
        $extension 	= end($temp);
        $filenew 	= str_replace(
                        $_FILES['file_attachment']['name'],
                        $name,
                        $_FILES['file_attachment']['name']) . 
                        '_' . time() . '' . "." . $extension;  		
        $config['file_name']   = $filenew;
        $config['upload_path'] = $imagePath;
        $this->upload->initialize($config);
        $this->upload->set_allowed_types('*');
        $this->upload->set_filename($config['upload_path'],$filenew);
        if(!$this->upload->do_upload('file_attachment')) {
          $data = array('msg' => $this->upload->display_errors());
        } else {
          $data = $this->upload->data();	
          if(!empty($data['file_name'])){
            $res['image_url'] = 'assets/upload/file_attachment/' .
                                $data['file_name']; 
          }
          if (!empty($res)) {
    	echo json_encode(
              array(
                "status" => 1,
                "data" => array(),
                "msg" => "upload successfully",
                "base_url" => base_url(),
                "count" => "0"
              )
            );
          }else{
    	echo json_encode(
              array(
                "status" => 1,
                "data" => array(),
                "msg" => "not found",
                "base_url" => base_url(),
                "count" => "0"
              )
            );
          }
        }
      }
    }
    
    public function uploadImageUser(Request $request, $id)
    {
        echo $id;
        // $users= users::find($id);
        // $users->img=$request->get('img');
        // $users->save();
        // return $users;
    }

}
