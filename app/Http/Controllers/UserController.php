<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Session;

use Auth;

class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('superadmin');
    }

    public function index(){
        $all=User::where('status',1)->orderBy('id','DESC')->get();
        return view('admin.user.all',compact('all'));
    }

    public function add(){
        return view('admin.user.add');
    }

    public function edit($slug){
        $data=User::where('status',1)->where('slug',$slug)->firstOrFail()
;        return view('admin.user.edit',compact('data'));
    }

    public function view($slug){
        $data=User::where('status',1)->where('slug',$slug)->firstOrFail()
;        return view('admin.user.view',compact('data'));
    }

    public function insert(Request $request){
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|max:50|unique:users',
            'password'=>'required|min:8',
            'confirm_password'=>'required_with:password|same:password',
            'username'=>'required',
            'role'=>'required',
        ],[
            'name.required'=>'Please enter your name',
            'email.required'=>'Please enter your email',
            'password.required'=>'Please enter password',
            'confirm_password.required'=>'Please enter your confirm password', 
            'username.required'=>'Please enter your confirm password', 
            'role.required'=>'Please select your role', 
        ]);

        $slug='U'.uniqid('20');

        $insert=User::insertGetId([
            'name'=>$request['name'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'username'=>$request['username'],
            'password'=>Hash::make($request['password']),
            'role'=>$request['role'],
            'slug'=>$slug,
            'created_at'=>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        if($request->hasfile('pic')){
            $image = $request->file('pic');
            $imageName = 'user_'.time().'.'.$image->getClientOriginalExtension(); 
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image);
            $image = $image->resize(300,300);
            $image->save('uploads/user/'.$imageName);

            User::where('id',$insert)->update([
                'photo' => $imageName,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }


        if($insert){
            Session::flash('success','Successfully completed user registration');
            return redirect('dashboard/user/add');
        }else{
            Session::flash('error','Opps operation failed');
            return redirect('dashboard/user/add');
        }
    }

    public function update(Request $request){
        $id=$request['id'];
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|max:50|unique:users,email,'.$id.'id',
            'role'=>'required',
        ],[
            'name.required'=>'Please enter your name',
            'email.required'=>'Please enter your email',
            'role.required'=>'Please select your role', 
        ]);

        $slug=$request['slug'];

        $update=User::where('status',1)->where('id',$id)->update([
            'name'=>$request['name'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'role'=>$request['role'],
            'updated_at' =>Carbon::now('asia/dhaka')->toDateTimeString(),
  
        ]);

        if($request->hasfile('pic')){
            $image = $request->file('pic');
            $imageName = 'user_'.time().'.'.$image->getClientOriginalExtension(); 
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image);
            $image = $image->resize(300,300);
            $image->save('uploads/user/'.$imageName);

            User::where('id',$id)->update([
                'photo' => $imageName,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }


        if($update){
            Session::flash('success','Successfully updated user registration');
            return redirect('dashboard/user/view/'.$slug);
        }else{
            Session::flash('error','Opps operation failed');
            return redirect('dashboard/user/add/'.$slug);
        }
    }

    public function softdelete(){
        $id=$_POST['modal_id'];
        $soft=User::where('status',1)->where('id',$id)->update([
            'status'=>0,
            'updated_at'=>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        if($soft){
            Session::flash('success',':Successfully delete user information.');
            return redirect('dashboard/user');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/user');
        };
    }

    public function restore(){
        $id=$_POST['modal_id'];
        $soft=User::where('status',0)->where('expense_id',$id)->update([
            'status'=>1,
            'updated_at'=>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        if($soft){
            Session::flash('success',':Successfully restore user information.');
            return redirect('dashboard/user');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/recyle/user');
        };
    }

    public function delete(){
        $id=$_POST['modal_id'];
        $delete=User::where('status',0)->where('id',$id)->delete([]);

        if($delete){
            Session::flash('success',':Successfully permanently delete your expense category information.');
            return redirect('dashboard/recycle/user');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/recycle/user');
        };
    }
}
