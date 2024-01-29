@extends('layouts.admin')
@section('content')
@php
  $now=Carbon\Carbon::now()->toDateTimeString();
  $month=date('m', strtotime($now));
  $year=date('y',strtotime($now));
  $date=date('d',strtotime($now));
  $monthName=date('F',strtotime($now));

  $allIncome=App\Models\Income::where('income_status',1)->whereYear('income_date','=',$year)->whereMonth('income_date','=',$month)->orderBy('income_date','DESC')->get();
  $allExpense=App\Models\Expense::where('expense_status',1)->whereYear('expense_date','=',$year)->whereMonth('expense_date','=',$month)->orderBy('expense_date','DESC')->get();
  $total_Income=App\Models\Income::where('income_status',1)->whereYear('income_date','=',$year)->whereMonth('income_date','=',$month)->sum('income_amount');
  $total_Expense=App\Models\Expense::where('expense_status',1)->whereYear('expense_date','=',$year)->whereMonth('expense_date','=',$month)->sum('expense_amount');
  $total_savings=($total_Income - $total_Expense);
@endphp
  <div class="row">
      <div class="col-md-12">
          <div class="card mb-3">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-8 card_title_part">
                      <i class="fab fa-gg-circle"></i>{{$monthName}} :: Income Expense Statement
                  </div>  
                  <div class="col-md-4 card_button_part">
                      <a href="{{url('dashboard/income')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>All Income </a>
                      <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-plus-circle"></i>All Expense</a>
                  </div>  
              </div>
            </div>
            <div class="card-body">
            <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                    @if(Session::has('success'))
                  <div class="alert alert-success alert_success" role="alert">
                    <strong>Success</strong>{{Session::get('success')}}
                  </div>
                  @endif
                  @if(Session::has('error'))
                  <div class="alert alert-danger alert_error" role="alert">
                    <strong>Opps!</strong> {{Session::get('error')}}
                  </div>
                  @endif
                    </div>
                    <div class="col-md-2"></div>
                  </div>           
              <table id="alltableDesc" class="table table-bordered table-striped table-hover custom_table">
                <thead class="table-dark">
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Income</th>
                    <th>Expense</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($allIncome as $income)
                  <tr>
                    <td>{{date('d-M-Y',strtotime($income->income_date))}}</td>
                    <td>{{$income->income_title}}</td>
                    <td>{{$income->categoryInfo->incate_name}}</td>
                    <td>{{number_format($income->income_amount,2)}}</td>  
                    <td></td>
                  </tr>
                  @endforeach()
                  @foreach($allIncome as $income)
                  <tr>
                    <td>{{date('d-M-Y',strtotime($income->income_date))}}</td>
                    <td>{{$income->income_title}}</td>
                    <td>{{$income->categoryInfo->incate_name}}</td>
                    <td></td>
                    <td>{{number_format($income->income_amount,2)}}</td>  
                  </tr>
                  @endforeach()
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>{{number_format($total_Income,2)}}</th>
                    <th>{{number_format($total_Expense,2)}}</th>
                  </tr>
                  <tr>
                    <th colspan="3" class="text-end text-success">Savings:</th>
                    <th colspan="2">{{number_format($total_savings,2)}}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="card-footer">
              <div class="btn-group" role="group" aria-label="Button group">
                <a type="button" onclick="window.print()" class="btn btn-sm btn-dark">Print</a>
                <a href="{{url('dashboard/income/pdf')}}" class="btn btn-sm btn-secondary">PDF</a>
                <a href="{{url('dashboard/income/excel')}}" class="btn btn-sm btn-dark">Excel</a>
              </div>
            </div>  
          </div>
      </div>
  </div>
<!-- Delete modal code -->
  <div class="modal fade" id="softDeleteModal" tabindex="-1" aria-labelledby="softDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post" action="{{url('dashboard/income/category/softdelete')}}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title modal_title fs-6" id="softDeleteModalLabel"><i class="fab fa-gg-circle"></i> Confirm Message </h5>
          </div>
        <div class="modal-body modal_body">
          Are you want to delete your data ?
          <input type="hidden" name="modal_id" id="modal_id">
        </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Confirm</button>
            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection               