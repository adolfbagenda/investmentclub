@extends('investmentclub::layouts.app')

@section('title', 'Savings')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Savings</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">savings</li>
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
            <h5 class="card-title">
              All Savings
            </h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="#modal-default" class="dropdown-item" data-toggle="modal">New Saving</a>
                    <a href="#" class="dropdown-item">delete selected</a>
                </div>
                </div>

            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-hover table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                               <th>#</th>
                               <th>Status</th>
                                <th>Detials</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Paid Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($savings as $saving)
                            <tr>
                              <td>{{$saving->id}}</td>
                              <td>
                                @if($saving->status==1)
                                    <a href="#" class="btn btn-xs btn-success"> <i class="fas fa-check"></i></a>
                                  @else
                                  <a href="#" class="btn btn-xs btn-danger"> <i class="fas fa-times"></i></a>
                                  @endif
                               </td>
                                <td>{{'ACC/'.sprintf('%05d', $saving->payment_no->account_id)}} - {{$saving->payment_no->account_no->account_member->last_name}}  {{$saving->payment_no->account_no->account_member->first_name}} {{$saving->payment_no->account_no->account_member->middle_name}} - {{Carbon\Carbon::parse($saving->payment_no->pay_date)->format('d-m-Y')}}</td>
                                <td>{{Carbon\Carbon::parse($saving->month)->format('F-Y')}}</td>
                                <td>{{number_format($saving->amount,2)}}</td>
                                <td>{{Carbon\Carbon::parse($saving->payment_no->pay_date)->format('d-m-Y')}}</td>

                                <td><a title="Edit" href="#" data-id="{{$saving->id}}" data-amount="{{$saving->amount}}" data-month="{{$saving->month}}" data-status="{{$saving->status}}" data-payment_id="{{$saving->payment_id}}" data-toggle="modal"  data-target="#editModal"><i class="fas fa-edit"></i></a>
                                    <a title="Delete" onclick="return confirm('Are you sure you want to delete this Saving')" href="{{route('investmentclub.savings.delete',$saving->id)}}"><span style="color:tomato"><i class="fas fa-trash-alt"></i></span></a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                    </table>
               </div>
            </div>
            <!-- /.row -->
            </div>
            <!-- ./card-body -->
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        <!--add form -->
        <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add  Permission</h4>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
              <form role="form" action="{{route('investmentclub.savings.store')}}" method="POST" >
              {{csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-md-12">
                       <label> Account</label><br>
                       <select class="form-control select2 {{ $errors->has('payment_id') ? ' is-invalid' : '' }}" name="payment_id"  placeholder="Select Payment" style="width:100%">
                         <option value="">Select Account</option>
                         @foreach($payments as $payment)
                             <option value="{{$payment->id}}" @php echo old('payment_id') == $payment->id ? 'selected' :  "" @endphp> {{'ACC/'.sprintf('%05d', $payment->account_id)}} - {{$payment->account_no->account_member->last_name}}  {{$payment->account_no->account_member->first_name}} {{$payment->account_no->account_member->middle_name}} - {{Carbon\Carbon::parse($payment->pay_date)->format('d-m-Y')}} / {{number_format($payment->amount,2)}}</option>
                         @endforeach
                       </select>
                       @if ($errors->has('payment_id'))
                           <span class="invalid-feedback">
                               <strong>{{ $errors->first('payment_id') }}</strong>
                           </span>
                       @endif
                  </div>
                    <div class="form-group col-md-6 ">
                        <label for="exampleInputEmail1">Month</label>
                        <input type="date"  name="month" value="{{old('month')}}" class="form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Month"  required>
                        @if ($errors->has('month'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('month') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="exampleInputEmail1">Amount</label>
                        <input type="text"  name="amount" value="{{old('amount')}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Month"  required>
                        @if ($errors->has('amount'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class=" col-md-12 form-group">
                        <label for="signed" class=" col-md-12 control-label">Status</label>
                        <label class="radio-inline">
                          <input type="radio" id="Active" name="status" value="1" > Approved</label>
                        </label>
                       <label class="radio-inline">
                          <input type="radio" id="Deactive" name="status" value="0" checked > Not Approved</label>
                       </label>
                    </div>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
              </div>
            </form>
          </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
        <!---end add -->

        <!--edit form -->
        <div class="modal fade" id="editModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit  Saving</h4>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
              <form role="form" action="{{route('investmentclub.savings.update','hhh')}}" method="POST" enctype="multipart/form-data" >
              {{csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="row">
                      <div class="form-group col-md-12">
                         <label> Account</label><br>
                         <input type="hidden" id="Id" value="" name="id">
                         <select id="Payment" class="form-control select2 {{ $errors->has('payment_id') ? ' is-invalid' : '' }}" name="payment_id"  placeholder="Select Payment" style="width:100%">
                           <option value="">Select Account</option>
                           @foreach($payments as $payment)
                               <option value="{{$payment->id}}" @php echo old('payment_id') == $payment->id ? 'selected' :  "" @endphp> {{'ACC/'.sprintf('%05d', $payment->account_id)}} - {{$payment->account_no->account_member->last_name}}  {{$payment->account_no->account_member->first_name}} {{$payment->account_no->account_member->middle_name}} - {{Carbon\Carbon::parse($payment->pay_date)->format('d-m-Y')}} / {{number_format($payment->amount,2)}}</option>
                           @endforeach
                         </select>
                         @if ($errors->has('payment_id'))
                             <span class="invalid-feedback">
                                 <strong>{{ $errors->first('payment_id') }}</strong>
                             </span>
                         @endif
                    </div>
                      <div class="form-group col-md-6 ">
                          <label for="exampleInputEmail1">Month</label>
                          <input type="date"  name="month" value="{{old('month')}}" class="form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="Month" placeholder="Enter Month"  required>
                          @if ($errors->has('month'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('month') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="form-group col-md-6 ">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="text" name="amount" value="{{old('amount')}}" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" id="Amount" placeholder="Enter Month"  required>
                          @if ($errors->has('amount'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('amount') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class=" col-md-12 form-group">
                          <label for="signed" class=" col-md-12 control-label">Status</label>
                          <label class="radio-inline">
                            <input type="radio" id="Active" name="status" value="1" > Approved</label>
                          </label>
                         <label class="radio-inline">
                            <input type="radio" id="Deactive" name="status" value="0" checked > Not Approved</label>
                         </label>
                      </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
              </div>
            </form>
          </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
        <!---end edit -->
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
          var table = $('#example1').DataTable({
                responsive: false,
                dom: 'Blfrtip',
                buttons: [
                  {
                    extend: 'excelHtml5',
                    exportOptions: {
                      columns: ':visible'
                    }
                  },
                  {
                    extend: 'pdfHtml5',
                    exportOptions: {
                      columns: ':visible'
                    }
                  },
                'colvis',
                  //'selectAll',
                    //	'selectNone'
                ],
                      });
          $('#editModal').on('show.bs.modal', function (event) {
           var button = $(event.relatedTarget) // Button that triggered the modal
            var Payment = button.data('pament-id') // Extract info from data-* attributes
            var Id = button.data('id')
            var Month = button.data('month')
            var Amount = button.data('amount')
            var Status = button.data('status')
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body #Month').val(Month)
            modal.find('.modal-body #Amount').val(Amount)
            modal.find('.modal-body #Id').val(Id)
            $('input[name=status][value=' + Status + ']').prop('checked',true)
            modal.find('.modal-body #Payment option[value="' + Payment + '"]').attr("selected", "selected")
          });
        });
    </script>
@stop
