@extends('investmentclub::layouts.app')

@section('title', 'Users')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Users</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">users</li>
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
              All Users
            </h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <span class="fas fa-minus"></span>
                </button>
                <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <span class="fas fa-plus"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="{{route('investmentclub.users.create')}}" class="dropdown-item" >New User</a>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>@if($user->status==1)
                                      <span class="badge badge-success"> <span class="fas fa-check"></span></span>
                                    @else
                                    <span class="badge badge-danger"> <span class="fas fa-times"></span></span>

                                    @endif
                                 </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->getRoleNames()}}</td>
                                <td><a title="Edit" href="{{route('investmentclub.users.edit',$user->id)}}"><span class="fas fa-edit"></span></a>
                                    <a title="Delete" onclick="return confirm('Are you sure you want to delete this User {{$user->name}}')" href="{{route('investmentclub.users.delete',$user->id)}}"><span style="color:tomato"><span class="fas fa-trash-alt"></span></span></a>
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
          $("#example1").DataTable();
          $('div.alert').not('.alert-danger').delay(5000).fadeOut(350);
        });
    </script>
@stop
