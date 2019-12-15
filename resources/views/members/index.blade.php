@extends('investmentclub::layouts.app')

@section('title', 'Members')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Members</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">members</li>
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
            <h5 class="card-title">All Members</h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="{{route('investmentclub.members.create')}}" class="dropdown-item">New Member</a>
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
																<th>No #</th>
																<th>Name</th>
																<th>Age </th>
																<th>Gender</th>
																<th>Tel No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($members as $member)
                            <tr>
                              <td>@if($member->status==1)
                                    <a href="#" class="btn btn-xs btn-success"> <i class="fas fa-check"></i></a>
                                  @else
                                  <a href="#" class="btn btn-xs btn-danger"> <i class="fas fa-times"></i></a>

                                  @endif
                               </td>
                               <td>
                               @if($member->picture)
                                    <img src="{{url('/members/photos/'.$member->picture) }}" width="50px"/>
                                  @endif
                                </td>
                                <td>{{sprintf('%05d', $member->id)}}</td>
                                <td>{{$member->last_name}}  {{$member->first_name}} {{$member->middle_name}}</td>
                               	<td>
                                   @if(!is_null($member->date_of_birth))
																			{{ Carbon\Carbon::parse($member->date_of_birth)->age}}
                                    @endif
                                </td>
                                <td>
                                  @if($member->gender ==1)
                                   Male
                                  @elseif($member->gender ==2)
                                  Female
                                 @else
                                 Rather not say
                                  @endif

                                </td>
                                <td>
                                  @if($member->phone_no)
                                  {{$member->code}} - {{$member->phone_no}}
                                  @endif
                                  </td>
                                <td><a title="Edit" href="{{route('investmentclub.members.edit',$member->id)}}"><i class="fas fa-edit"></i></a>
                                    <a title="Delete" onclick="return confirm('Are you sure you want to delete this Employee')" href="{{route('investmentclub.members.delete',$member->id)}}"><span style="color:tomato"><i class="fas fa-trash-alt"></i></span></a>
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
