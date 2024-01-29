@extends('layouts.admin')
@section('content')
@php
  $all_Income=App\Models\Income::select(DB::raw('count(*) as total'),DB::raw('YEAR(income_date) year, MONTH(income_date)month'))->groupby('year','month')->orderBy('income_date','DESC')->get();
  $allExpense=App\Models\Expense::select(DB::raw('count(*) as total'),DB::raw('YEAR(expense_date) year,MONTH(expense_date)month'))->groupby('year','month')->orderBy('expense_date','DESC')->get();
@endphp
  <div class="row">
      <div class="col-md-12">
          <div class="card mb-3">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-8 card_title_part">
                      <i class="fab fa-gg-circle"></i>Income Expense Archive
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
              <table id="alltableInfo" class="table table-bordered table-striped table-hover custom_table">
                <thead class="table-dark">
                  <tr>
                    <th>Month</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Savings</th>
                    <th>Manage</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($all_Income as $income)
                  <tr>
                    <td>
                      @php
                        $year=$income->year;
                        $month=$income->month;
                        $year_month=$year.'-'.$month;
                        $month_year=date('F-Y',strtotime($year_month));
                       echo $month_year ;
                      @endphp
                    </td>
                    <td>
                      @php
                        echo $total_income=App\Models\Income::where('income_status',1)->whereYear('income_date','=',$year)->whereMonth('income_date','=',$month)->sum('income_amount');
                        
                      @endphp
                    </td>
                    <td>
                      @php
                        echo $total_expense=App\Models\Expense::where('expense_status',1)->whereYear('expense_date','=',$year)->whereMonth('expense_date','=',$month)->sum('expense_amount'); 
                      @endphp
                    </td>
                    <td>
                      @php
                       echo $total_savings=$total_income - $total_expense;
                      @endphp
                    </td>  
                    <td>
                      <div class="btn-group btn_group_manage" role="group">
                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Manage</button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{url('dashboard/archive/month/'.$month_year)}}">Details</a></li>                            
                        </ul>
                      </div>
                    </td>
                  </tr>
                  @endforeach()
                </tbody>
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