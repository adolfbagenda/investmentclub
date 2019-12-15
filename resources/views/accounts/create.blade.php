@extends('investmentclub::layouts.app')

@section('title', 'Accounts')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><small><a href="{{route('investmentclub.accounts')}}" class="btn btn-info">Back</a></small> Accounts </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">accounts</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title">Add Account</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
              <div class="col-md-12">
              <form role="form" action="{{route('investmentclub.accounts.store')}}" method="POST" enctype="multipart/form-data" >
              {{csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                       <label> Member</label>
                       <select class="form-control select2 {{ $errors->has('member_id') ? ' is-invalid' : '' }}" name="member_id"  placeholder="Select Member">
                         <option value="">Select Member</option>
                         @foreach($members as $member)
                             <option value="{{$member->id}}" @php echo old('member_id') == $member->id ? 'selected' :  "" @endphp>{{$member->last_name}}  {{$member->first_name}} {{$member->middle_name}}</option>
                         @endforeach
                       </select>
                       @if ($errors->has('member_id'))
                           <span class="invalid-feedback">
                               <strong>{{ $errors->first('member_id') }}</strong>
                           </span>
                       @endif
                  </div>
                  <div class="form-group col-md-12 "></div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Open Date</label>
                        <input type="date"  name="open_date" value="{{old('open_date')}}" class="form-control {{ $errors->has('open_date') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Open Date " >
                        @if ($errors->has('open_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('open_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">Amount</label>
                        <input type="text"  name="amount" value="{{old('amount')}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Amount" >
                        @if ($errors->has('amount'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">Fine </label>
                        <input type="text"  name="fine" value="{{old('fine')}}" class="form-control {{ $errors->has('fine') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Fine" >
                        @if ($errors->has('fine'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('fine') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class=" col-md-3 form-group">
                        <label for="signed" class=" col-md-12 control-label">Status</label>
                        <label class="radio-inline">
                          <input type="radio" id="Active" name="status" value="1" checked> Active</label>
                        </label>
                       <label class="radio-inline">
                          <input type="radio" id="Deactive" name="status" value="0" > Deactive</label>
                       </label>
                    </div>
                  </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              </div>
            </form>
            </div>

            <!-- /.row -->
            </div>
            <!-- ./card-body -->

            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
   @parent
   <script>
       $(function () {
          $('.select2').select2();
         $("#divspouse").hide();
         $("#Divreason").hide();
         if($("#Married").is(":checked"))
               {
                  $("#divspouse").show(1000);
               }
         $(":input[name=marital_status]:eq(0)").click(function(){
               $("#divspouse").hide(1000);
            });
            $(":input[name=marital_status]:eq(1)").click(function(){
               $("#divspouse").show(1000);
            });
            if($("#Deactive").is(":checked"))
                  {
                     $("#Divreason").show(1000);
                  }
            $(":input[name=status]:eq(0)").click(function(){
                  $("#Divreason").hide(1000);
               });
               $(":input[name=status]:eq(1)").click(function(){
                  $("#Divreason").show(1000);
               });
       })
</script>
@stop
