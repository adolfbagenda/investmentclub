@extends('investmentclub::layouts.app')

@section('title', 'Payments')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><small><a href="{{route('investmentclub.payments')}}" class="btn btn-info">Back</a></small> Payments</h1>
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
          <p>
          <span class="label label-warning ">   Updated {{ $diffs = Carbon\Carbon::parse($payment->updated_at)->diffForHumans() }} </span>   &nbsp
          <span class="label label-success ">   Created {{ $diffs = Carbon\Carbon::parse($payment->created_at)->diffForHumans() }} </span>    &nbsp
          </p>
        <div class="card">
            <div class="card-header">
            <h5 class="card-title">Edit <b>  {{sprintf('%05d', $payment->account_id)}} /  {{$payment->account_no->account_member->last_name}}  {{$payment->account_no->account_member->first_name}}  {{$payment->account_no->account_member->middle_name}}</b></h5>
            </div>

            <!-- /.card-header -->
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
              <div class="col-md-12">
            <form role="form" action="{{route('investmentclub.payments.update',$payment->id)}}" method="POST" >
              {{csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                       <label> Account</label>
                       <select class="form-control select2 {{ $errors->has('account_id') ? ' is-invalid' : '' }}" name="account_id"  placeholder="Select Member">
                         <option value="">Select Account</option>
                         @foreach($accounts as $account)
                             <option value="{{$account->id}}" @php echo $payment->account_id == $account->id ? 'selected' :  "" @endphp> {{'ACC/'.sprintf('%05d', $account->id)}} - {{$account->account_member->last_name}}  {{$account->account_member->first_name}} {{$account->account_member->middle_name}}</option>
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
                        <input type="date"  name="pay_date" value="{{$payment->pay_date}}" class="form-control {{ $errors->has('pay_date') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Payment Date " >
                        @if ($errors->has('pay_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('pay_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Amount</label>
                        <input type="text"  name="amount" value="{{$payment->amount}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Amount" >
                        @if ($errors->has('amount'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="exampleInputEmail1">Reference </label>
                        <input type="text"  name="reference" value="{{$payment->reference}}" class="form-control {{ $errors->has('reference') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Reference" >
                        @if ($errors->has('reference'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('reference') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12 ">
                      <label for="exampleInputEmail1">Description</label>
                      <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="2" placeholder="Enter Description" name="description" >{{$payment->description}}</textarea>
                      @if ($errors->has('description'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                      @endif
                  </div>
                    <div class=" col-md-3 form-group">
                        <label for="signed" class=" col-md-12 control-label">Status</label>
                        <label class="radio-inline">
                          <input type="radio" id="Active" name="status" value="1" @php echo $payment->status ==1? 'checked' :  "" @endphp > Approved</label>
                        </label>
                       <label class="radio-inline">
                          <input type="radio" id="Deactive" name="status" value="0" @php echo $payment->status == 0? 'checked' :  "" @endphp > Not Approved</label>
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
          $('div.alert').not('.alert-danger').delay(5000).fadeOut(350);
          $('.select2').select2();

        })
    </script>
@stop
