@extends('investmentclub::layouts.app')

@section('title', 'Accounts')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Accounts</h1>
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
            <h5 class="card-title">All Accounts</h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="{{route('investmentclub.accounts.create')}}" class="dropdown-item">New Account</a>
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
                                <th>Status</th>
                                <th>Picture</th>
																<th>Account No #</th>
																<th>Name</th>
																<th>Amount</th>
																<th>Fine</th>
																<th>Open Date</th>
                                <th>Updated </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($accounts as $account)
                            <tr>
                              <td>@if($account->status==1)
                                    <a href="#" class="btn btn-xs btn-success"> <i class="fas fa-check"></i></a>
                                  @else
                                  <a href="#" class="btn btn-xs btn-danger"> <i class="fas fa-times"></i></a>

                                  @endif
                               </td>
                               <td>
                               @if($account->account_member->picture)
                                    <img src="{{url('/members/photos/'.$account->account_member->picture) }}" width="50px"/>
                                  @endif
                                </td>
                                <td>{{'ACC/'.sprintf('%05d', $account->id)}}</td>
                                <td>{{$account->account_member->last_name}}  {{$account->account_member->first_name}} {{$account->account_member->middle_name}}</td>
                               	<td>{{number_format($account->amount,2)}}</td>
                                <td>{{number_format($account->fine,2)}}</td>
                                <td>{{Carbon\Carbon::parse($account->open_date)->format('d-m-Y')}}</td>
                                <td>{{Carbon\Carbon::parse($account->updated_at)->format('d-m-Y')}}</td>
                                <td><a title="Edit" href="{{route('investmentclub.accounts.edit',$account->id)}}"><i class="fas fa-edit"></i></a>
                                    <a title="Delete" onclick="return confirm('Are you sure you want to delete this Employee')" href="{{route('investmentclub.accounts.delete',$account->id)}}"><span style="color:tomato"><i class="fas fa-trash-alt"></i></span></a>
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
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
    @parent
    <script>
        $(function () {
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
  $('div.alert').not('.alert-danger').delay(5000).fadeOut(350);
})
</script>

@stop
