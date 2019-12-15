@extends('investmentclub::layouts.app')

@section('title', 'Payments')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><small><a href="{{route('investmentclub.payments')}}" class="btn btn-info">Back</a></small> Payments </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">payments</li>
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
            <h5 class="card-title">New Payment</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
              <div class="col-md-12">
              <form role="form" action="{{route('investmentclub.payments.store')}}" method="POST"  >
              {{csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                       <label> Account</label>
                       <select class="form-control select2 {{ $errors->has('account_id') ? ' is-invalid' : '' }}" name="account_id"  placeholder="Select Member">
                         <option value="">Select Account</option>
                         @foreach($accounts as $account)
                             <option value="{{$account->id}}" @php echo old('account_id') == $account->id ? 'selected' :  "" @endphp> {{'ACC/'.sprintf('%05d', $account->id)}} - {{$account->account_member->last_name}}  {{$account->account_member->first_name}} {{$account->account_member->middle_name}}</option>
                         @endforeach
                       </select>
                       @if ($errors->has('account_id'))
                           <span class="invalid-feedback">
                               <strong>{{ $errors->first('account_id') }}</strong>
                           </span>
                       @endif
                  </div>
                  <div class="form-group col-md-12 "></div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Payment Date</label>
                        <input type="date"  name="pay_date" value="{{old('pay_date')}}" class="form-control {{ $errors->has('pay_date') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Payment Date " >
                        @if ($errors->has('pay_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('pay_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Amount</label>
                        <input type="text"  name="amount" value="{{old('amount')}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Amount" >
                        @if ($errors->has('amount'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="exampleInputEmail1">Reference </label>
                        <input type="text"  name="reference" value="{{old('reference')}}" class="form-control {{ $errors->has('reference') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Reference" >
                        @if ($errors->has('reference'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('reference') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12 ">
                      <label for="exampleInputEmail1">Description</label>
                      <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="2" placeholder="Enter Description" name="description" >{{old('description')}}</textarea>
                      @if ($errors->has('description'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                      @endif
                  </div>
                    <div class=" col-md-3 form-group">
                        <label for="signed" class=" col-md-12 control-label">Status</label>
                        <label class="radio-inline">
                          <input type="radio" id="Active" name="status" value="1" > Active</label>
                        </label>
                       <label class="radio-inline">
                          <input type="radio" id="Deactive" name="status" value="0" checked > Deactive</label>
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
