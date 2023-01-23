<!DOCTYPE >
<head>
</head>

<body>    
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
            <select class="form-select" id="branch" name="branch">
                <option value="">Select Branch</option>        
                @foreach($allbranch as $branch)                                           
                <option value="{{$branch->id}}" data-chained="{{$branch->company_id}}" {{isset($edit->branch)?$branch->id==$edit->branch_name?'selected':'':''}}>{{$branch->name}} </option>
                @endforeach        
            </select>                                     
        </div>
    </div>       
  <script src="{{asset('public\contents\admin\assets\js\jquery.chained.js')}}" type="text/javascript"></script>
  <script src="{{asset('public\contents\admin\assets\js\jquery.chained.remote.js')}}" type="text/javascript"></script>
  <script type="text/javascript" charset="utf-8">
    $(function() {
      /* For jquery.chained.js */
      $("#branch").chained("#company_name");
    });
  </script>

</body>
</html>
