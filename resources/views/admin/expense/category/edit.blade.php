@extends('layouts.admin')
@section('content')
  <div class="row">
      <div class="col-md-12 ">
          <form method="post" action="{{url('dashboard/expense/category/update')}}">
            @csrf
              <div class="card mb-3">
                <div class="card-header">
                  <div class="row">
                      <div class="col-md-8 card_title_part">
                          <i class="fab fa-gg-circle"></i>Update Expense Category Information
                      </div>  
                      <div class="col-md-4 card_button_part">
                          <a href="{{url('dashboard/expense/category')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Expense Category Information</a>
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
                    <div class="row mb-3">
                      <label class="col-sm-3 col-form-label col_form_label">Expense Category Name<span class="req_star">*</span>:</label>
                      <div class="col-sm-7">
                        <input type="hidden" name="id" value="{{$data->expcate_id}}">
                        <input type="text" class="form-control form_control" id="" name="name" value="{{$data->expcate_name}}">
                        @if($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{$errors->first('name')}}</strong>
                        </span>
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-sm-3 col-form-label col_form_label">Remarks:</label>
                      <div class="col-sm-7">
                        <textarea type="text" class="form-control form_control" id="" name="remarks">{{$data->expcate_remarks}}</textarea>
                      </div>
                    </div>                  
                </div>
                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-sm btn-dark">UPDATE</button>
                </div>  
              </div>
          </form>
      </div>
  </div>
@endsection                