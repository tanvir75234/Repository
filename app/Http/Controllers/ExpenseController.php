<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Expense;
use Carbon\Carbon;
use Session;
use Auth;

class ExpenseController extends Controller{
    public function __construct(){

    }

    public function index(){
        $all=Expense::where('expense_status',1)->orderBy('expense_id','DESC')->get();
        return view('admin.expense.main.all',compact('all'));
    }

    public function add(){
        return view('admin.expense.main.add'); 
    }

    public function edit($slug){
        $data=Expense::where('expense_status',1)->where('expense_slug',$slug)->firstOrFail();
        return view('admin.expense.main.EDIT',compact('data'));
    }

    public function view($slug){
        $data=Expense::where('expense_status',1)->where('expense_slug',$slug)->firstOrFail();
        return view('admin.expense.main.view',compact('data'));
    }

    public function insert(Request $request){
        $this->validate($request,[
            'title'=>'required|max:100',
            'category'=>'required',
            'date'=>'required',
            'amount'=>'required',
        ],[
            'title.required'=>'Please enter your expense Category name',
            'category.required'=>'Please select expense category',
            'date.required'=>'Please select expense date',
            'title.required'=>'Please enter expense date',
        ]);

        // $slug='IC'.uniqid(20);
        $slug ='E'.uniqid(20);
        
        $creator=Auth::user()->id;

        $insert=Expense::insert([
            'expense_title'=>$request['title'],
            'expcate_id'=>$request['category'],
            'expense_date'=>$request['date'],
            'expense_amount'=>$request['amount'],
            'expense_creator'=>$creator,
            'expense_slug'=>$slug,
            'created_at'=>Carbon::now('Asia/dhaka')->toDateTimeString(),
        ]); 

        if($insert){
            Session::flash('success','Successfully add expense  information.');
            return redirect('dashboard/expense/add');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/expense/add');
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
            'title.required'=>'Please enter your Expense Category name',
            'category.required'=>'Please select Expense category',
            'date.required'=>'Please select Expense date',
            'title.required'=>'Please enter Expense date',
        ]);

        // $slug='IC'.uniqid(20);
        
        $slug =$request['slug'];       
        $editor=Auth::user()->id;

        $update=Expense::where('expense_status',1)->where('expense_id',$id)->update([
            'expense_title'=>$request['title'],
            'expcate_id'=>$request['category'],
            'expense_date'=>$request['date'], 
            'expense_amount'=>$request['amount'],
            'expense_editor'=>$creator,
            'updated_at'=>Carbon::now('Asia/dhaka')->toDateTimeString(),
        ]); 

        if($update){
            Session::flash('success','Successfully update expense  information.');
            return redirect('dashboard/expense/view');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/expense/edit');
        };
    }

    public function softdelete(){
        $id=$_POST['modal_id'];
        $soft=Expense::where('expense_status',1)->where('expense_id',$id)->update([
            'expense_status'=>0,
            'updated_at'=>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        if($soft){
            Session::flash('success',':Successfully delete expense category information.');
            return redirect('dashboard/expense');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/expense');
        };
    }

    public function restore(){
        $id=$_POST['modal_id'];
        $soft=Expense::where('expense_status',0)->where('expense_id',$id)->update([
            'expense_status'=>1,
            'updated_at'=>Carbon::now('asia/dhaka')->toDateTimeString(),
        ]);

        if($soft){
            Session::flash('success',':Successfully restore expense category information.');
            return redirect('dashboard/expense');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/expense/recyle');
        };
    }

    public function delete(){
        $id=$_POST['modal_id'];
        $delete=Expense::where('expense_status',0)->where('expense_id',$id)->delete([]);

        if($delete){
            Session::flash('success',':Successfully permanently delete your expense category information.');
            return redirect('dashboard/recycle/expense');
        }else{
            Session::flash('error','Opps! Operation failed.');
            return redirect('dashboard/recycle/expense');
        };
    }
}