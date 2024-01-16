<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Income;
use Carbon\Carbon;
use Session;
use Auth;

class IncomeController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $all=Income::where('income_status',1)->orderBy('income_id','DESC')->get();
        return view('admin.income.main.all',compact('all'));
    }

    public function add(){
        return view('admin.income.main.add'); 
    }

    public function edit($slug){
        $data=Income::where('income_status',1)->where('income_slug',$slug)->firstOrFail();
        return view('admin.income.main.EDIT',compact('data'));
    }

    public function view($slug){
        $data=Income::where('income_status',1)->where('income_slug',$slug)->firstOrFail();
        return view('admin.income.main.view',compact('data'));
    }

    public function insert(Request $request){
        $this->validate($request,[
            'title'=>'required|max:100',
            'category'=>'required',
            'date'=>'required',
            'amount'=>'required',
        ],[
            'title.required'=>'Please enter your Income Category name',
            'category.required'=>'Please select income category',
            'date.required'=>'Please select income date',
            'title.required'=>'Please enter income date',
        ]);

        // $slug='IC'.uniqid(20);
        $slug ='I'.uniqid(20);
        
        $creator=Auth::user()->id;

        $insert=Income::insert([
            'income_title'=>$request['title'],
            'incate_id'=>$request['category'],
            'income_date'=>$request['date'],
            'income_amount'=>$request['amount'],
            'income_creator'=>$creator,
            'income_slug'=>$slug,
            'created_at'=>Carbon::now('Asia/dhaka')->toDateTimeString(),
        ]); 

        if($insert){
            Session::flash('success','Successfully add income  information.');
            return redirect('dashboard/income/add');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/income/add');
        };
    }

    public function update(Request $request){
        $id =$request['id'];
        
        $this->validate($request,[
            'title'=>'required|max:100',
            'category'=>'required',
            'date'=>'required',
            'amount'=>'required',
        ],[
            'title.required'=>'Please enter your Income Category name',
            'category.required'=>'Please select income category',
            'date.required'=>'Please select income date',
            'title.required'=>'Please enter income date',
        ]);

        // $slug='IC'.uniqid(20);
        
        $slug =$request['slug'];       
        $editor=Auth::user()->id;

        $update=Income::where('income_status',1)->where('income_id',$id)->update([
            'income_title'=>$request['title'],
            'incate_id'=>$request['category'],
            'income_date'=>$request['date'],
            'income_amount'=>$request['amount'],
            'income_editor'=>$creator,
            'updated_at'=>Carbon::now('Asia/dhaka')->toDateTimeString(),
        ]); 

        if($update){
            Session::flash('success','Successfully update income  information.');
            return redirect('dashboard/income/view');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/income/edit');
        };
    }

    public function softdelete(){

    }

    public function restore(){

    }

    public function delete(){

    }
}
