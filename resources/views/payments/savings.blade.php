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

                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($savings as $saving)
                            <tr>
                              <td>{{$saving->id}}</td>
                              <td>
                                @if($saving->status==1)
                                    <span class="badge badge-success"> <span class="fas fa-check"></span></span>
                                  @else
                                  <span class="badge badge-danger"> <span class="fas fa-times"></span></span>
                                  @endif
                               </td>
                                <td>{{'ACC/'.sprintf('%05d', $saving->payment_no->account_id)}} - {{$saving->payment_no->account_no->account_member->last_name}}  {{$saving->payment_no->account_no->account_member->first_name}} {{$saving->payment_no->account_no->account_member->middle_name}} - {{Carbon\Carbon::parse($saving->payment_no->pay_date)->format('d-m-Y')}}</td>
                                <td>{{$saving->month}} - {{$saving->year}}</td>
                                <td>{{number_format($saving->amount,2)}}</td>
                                <td>{{Carbon\Carbon::parse($saving->payment_no->pay_date)->format('d-m-Y')}}</td>

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
