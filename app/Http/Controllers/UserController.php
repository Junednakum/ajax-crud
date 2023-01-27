<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Redirect,Response,DB;
use Illuminate\Support\Facades\Validator;
use File;
use PDF;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        
        return view('user.list', compact('user','user'));
    } 
 
    public function store(Request $request)
    {  
        $user_id = $request->user_id;
        if($user_id){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'gender' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users|max:255',
                'phone' => 'required|unique:users|max:10',
                'gender' => 'required',
            ]);
        }

  
        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()->all()
                    ]);
        }

        $user_id = $request->user_id;
 
        $details = ['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone,'gender' => $request->gender];
 
        if ($files = $request->file('image')) {
            
           //delete old file
           \File::delete('user/'.$request->hidden_image);
         
           //insert new file
           $destinationPath = 'user/'; // upload path
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
           $details['image'] = "$profileImage";
        }
        if ($files = $request->file('file')) {
            
           //delete old file
           \File::delete('file/'.$request->file);
         
           //insert new file
           $destinationPath = 'file/'; // upload path
           $profilefile = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profilefile);
           $details['file'] = "$profilefile";
        }
         
        $user   =   User::updateOrCreate(['id' => $user_id], $details);  
               
        return Response::json($user);

    } 
 
    public function edit($id)
    {   
        $where = array('id' => $id);
        $product  = User::where($where)->first();
      
        return Response::json($product);
    }
    public function destroy(Request $request) 
    {
        $id = $request->id; 
        $data = User::where('id',$id)->first(['image']);
        \File::delete('user/'.$data->image);
        $product = User::where('id',$id)->delete();
      
        return Response::json($product);
    }
}
