@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">

        @php
        if(isset($edit)){
            $link='dashboard/income/update';
        }
        else{
            $link='dashboard/income/submit';
        }
        @endphp
        <form class="form-horizontal" method="get" action="{{url($link)}}" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{isset($edit->income_id)? $edit->income_id:''}}">
            <input type="hidden" name="income_ref_no" value="{{isset($edit->income_ref_no)? $edit->income_ref_no:''}}">
            <input type="hidden" name="income_status" value="{{isset($edit->income_id)?$edit->income_status:''}}">
            @csrf
            <div class="card">
                <div class="row">
					<div class="col-3"></div>
					<div class="col-6">
						@if(Session::has('success'))
						<div class="alert alert-success alertsuccess" role="alert">
							{{session::get('success')}}
						</div>
						@endif
						@if(Session::has('error'))
						<div class="alert alert-danger alerterror" role="alert">
							{{session::get('error')}}
						</div>
						@endif
					</div>
					<div class="col-3"></div>
				</div>
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8 tbl_text">
                            <i class="  uil-analytics  "></i> Add/Update Payment Information
                        </div>
                        <div class="col-md-4 card_butt_part">
                            <a class="btn btn-sm btn-dark" href="{{url('dashboard/income')}}"><i class="uil-rupee"></i> All Payment</a>
                        </div>
                    </div>
                </div>
                <div class="card-body card_body">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row">
                            @if(!empty($edit->income_ref_no))
                            <div class="col-lg-12">
                                <div class="">
                                    <label class="col_form_label">Payment Ref No:</label>
                                    <span>{{isset($edit->income_ref_no)?$edit->income_ref_no:''}}</span>
                                </div>
                            </div>
                            <br>
                            <br>
                            @endif
                            <div class="col-lg-12">
                                <div>
                                    <label class="col-form-label col_form_label"> Collection Type <span class="req_star">*</span>:</label>
                                    <input type="radio" value="0" required name="collection_type" onclick="toggleDiv('vendorContainer','hide');toggleDiv('ihplContainer','show')" required style="margin-left:15px;"> IHPL
                                    <input type="radio" value="1" required name="collection_type"  onclick="toggleDiv('vendorContainer','show');toggleDiv('ihplContainer','hide')" required style="margin-left:15px;"> VENDOR
                                </div>
                            </div>
                            <div class="row" id="vendorContainer" style="display: none;">
                                @php
                                $allcompany=App\Models\Companyinfo::where('status',1)->where('id','>',1)->orderBy('name','ASC')->get(); //get all user
                                $allbranch=App\Models\Branch::where('status',1)->where('company_id','>',1)->orderBy('name','ASC')->get(); //get all user
                                @endphp
                                <div class="col-lg-6">
                                    <label class="col-form-label col_form_label">Company Name :</label>
                                    <div class="{{$errors->has('company_name') ? ' has-error' :''}} ">
                                        <select class="form-select" id="company_name" name="company_name">
                                            <option value=""> Select Company </option>
                                            @foreach($allcompany as $cname)
                                                <option value="{{$cname->id}}" {{isset($edit->company_name)?$cname->id==$edit->company_name?'selected':'':''}}>{{$cname->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6"  >
                                    <label class="col-form-label col_form_label">Company Branch :</label>
                                    <div class="{{$errors->has('branch_name') ? ' has-error' :''}} ">
                                        <select class="form-select" id="branch" name="branch_name">
                                            <option value="">Select Branch</option>
                                            @foreach($allbranch as $branch)
                                            <option value="{{$branch->id}}" data-chained="{{$branch->company_id}}" {{isset($edit->branch)?$branch->id==$edit->branch_name?'selected':'':''}}>{{$branch->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6"  >
                                    <label class="col-form-label col_form_label"> Vendor Collector Details :</label>
                                    <div class="{{$errors->has('vendor_detatils') ? ' has-error' :''}} ">
                                        <textarea class="form-control"  id="" name="vendor_detatils" value="{{isset($edit->vendor_detatils)?$edit->vendor_detatils:''}}" >
                                        @if ($errors->has('vendor_detatils'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('vendor_detatils') }}</strong>
                                        </span>
                                        @endif
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="ihplContainer" style="display: none;">
                                <label class="col-form-label col_form_label ">Payment  Collector :</label>
                                <div class="{{$errors->has('income_collector') ? ' has-error' : ''}}">
                                    @php
                                        $alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get(); //get all user
                                    @endphp
                                    <select class="form-select" id="" name="income_collector">
                                        <option value="0"> Select User </option>
                                        @foreach($alluser as $user)
                                        @php
                                            $d = App\Helper::deparmentsName($user->department_id);
                                        @endphp
                                            <option value="{{$user->id}}" {{isset($edit->income_collector)?$user->id==$edit->income_collector?'selected':'':''}}>{{$user->name}} ({{$d}})</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('income_collector'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('income_collector') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <label class="col-form-label col_form_label "> Payment Receiver <span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('income_receiver') ? ' has-error' : ''}}">
                                    @php
                                    $alluser=\App\Models\User::where('status',1)->orderBy('name','ASC')->get();
                                    @endphp
                                    <select class="form-select" id="" name="income_receiver" required>
                                        <option value="">Select User</option>
                                        @foreach($alluser as $user)
                                        @php
                                            $d = App\Helper::deparmentsName($user->department_id);
                                        @endphp
                                        <option value="{{$user->id}}" {{isset($edit->income_receiver)?$user->id==$edit->income_receiver?'selected':'':''}}>{{$user->name}} ({{$d}})</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('income_receiver'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('income_receiver') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label ">Operation  Person <span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('income_operation') ? ' has-error' : ''}}">
                                    @php
                                    $alluser =\App\Models\User::where('status',1)->where('role',15)->orderBy('name','ASC')->get();
                                    @endphp
                                    <select class="form-select" id="" name="income_operation" required>
                                        <option value="">Select User</option>
                                        @foreach($alluser as $user)
                                            @php
                                                $d = App\Helper::deparmentsName($user->department_id);
                                            @endphp
                                            <option value="{{$user->id}} " {{isset($edit->income_operation)?$user->id==$edit->income_operation?'selected':'':''}}>{{$user->name}} ({{$d}})</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('income_operation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('income_operation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label ">Account  Person <span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('account_receiver') ? ' has-error' : ''}}">
                                    @php
                                    $alluser =\App\Models\User::where('status',1)->where('role',16)->orderBy('name','ASC')->get();
                                    @endphp
                                    <select class="form-select" id="" name="account_receiver" required>
                                        <option value="">Select User</option>
                                        @foreach($alluser as $user)
                                            @php
                                                $d = App\Helper::deparmentsName($user->department_id);
                                            @endphp
                                            <option value="{{$user->id}} " {{isset($edit->account_receiver)?$user->id==$edit->account_receiver?'selected':'':''}}>{{$user->name}} ({{$d}})</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('account_receiver'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_receiver') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">Guest name<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('guest_name') ? ' has-error' :''}} ">
                                    <input type="text" class="form-control" required id="" name="guest_name" value="{{isset($edit->guest_name)?$edit->guest_name:''}}" required>
                                    @if ($errors->has('guest_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('guest_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">Guest phone no<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('guest_phone') ? ' has-error' : ''}}">
                                    <input type="text" class="form-control" required id="" name="guest_phone" value="{{isset($edit->guest_phone)?$edit->guest_phone:''}}" required>
                                    @if ($errors->has('guest_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('guest_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">Guest email<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('guest_email') ? ' has-error' : ''}}">
                                    <input type="email" class="form-control" required id="" name="guest_email" value="{{isset($edit->guest_email)?$edit->guest_email:''}}" required>
                                    @if ($errors->has('guest_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('guest_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">  Amount <span class="req_star">*</span> :</label>

                                <div class="row">
                                    <div class="col-lg-7 col-xs-7">
                                        <input type="text" class="form-control" required id="" name="income_amount" value="{{isset($edit->income_amount)?$edit->income_amount:''}}" required>
                                        @if ($errors->has('income_amount'))
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('income_amount') }}</strong>
                                          </span>
                                      @endif
                                    </div>

                                    <div class="col-lg-5 col-xs-5 {{$errors->has('currency') ? ' has-error' : ''}}">
                                        @php
                                        $allCurrency = \App\Models\Currency::where('status',1)->orderBy('title','ASC')->get(); //Fetch all currency type
                                        @endphp
                                        <select class="form-select" id="" name="income_currency" required>
                                            <option value="">Currency</option>
                                            @foreach($allCurrency as $curr)
                                            <option value="{{$curr->id}}" {{isset($edit->income_currency)?$edit->income_currency==$curr->id?'selected':'':''}}><i class="fa {{$curr->icons}}"></i> {{$curr->title}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('income_currency'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('income_currency') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">File Ref no<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('file_ref_no') ? ' has-error' : ''}}">
                                    <input type="text" class="form-control" id="" name="file_ref_no" value="{{isset($edit->file_ref_no)?$edit->file_ref_no:''}}" required>
                                     @if ($errors->has('file_ref_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file_ref_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">Payment type<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('category') ? ' has-error' : ''}}">

                                    @php
                                    $allCate=\App\Models\IncomeCategory::where('incate_status',1)->orderBy('incate_name','ASC')->get(); //Get all income category for find seletech category
                                    @endphp
                                    <select class="form-select" id="" name="incate_id" required>
                                        <option value="">Payment Against</option>
                                        @foreach($allCate as $cate)
                                            <option value="{{$cate->incate_id}}" {{isset($edit->incate_id)?$cate->incate_id==$edit->incate_id ? 'selected':'':''}} >{{$cate->incate_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('incate_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('incate_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label"> Collection Date <span class="req_star">*</span>:</label>
                                <input type="date" class="form-control" required id="" name="income_date" value="{{isset($edit->income_date)?$edit->income_date:''}}" required onclick="this.showPicker()">
                                    @if ($errors->has('income_date'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('income_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label col_form_label">Payment remarks<span class="req_star">*</span>:</label>
                                <div class="{{$errors->has('income_title') ? ' has-error' : ''}}">
                                    <input type="text" class="form-control" id="" name="income_title" value="{{isset($edit->income_title)?$edit->income_title:''}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                    </div>
                </div>
                <!-- end card body-->
                <div class="card-footer card_footer center">
                    <button type="submit" class="btn btn-md btn-dark">Submit</button>
                </div>
            </div> <!-- end card -->
        </form>
    </div><!-- end col-->
</div>
<script>
      $(document).ready(function() {
      $('#company_name').on('change', function() {
        var companyID = $(this).val();
        if(companyID) {
            $.ajax({
                url: '{{ url('') }}/dashboard/branch/bycompany/'+companyID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                      $('#branch').empty();
                      $('#branch').append('<option value="">Select Branch</option>'); 
                      $.each(data, function(key, branch){
                          $('#branch').append('<option value="'+ branch.id +'">' + branch.name+ '</option>');
                      });
                  }else{
                      $('#branch').empty();
                  }
              }
            });
        }else{
          $('#branch').empty();
        }
      });
      });
</script>
@endsection