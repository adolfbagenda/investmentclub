@extends('investmentclub::layouts.app')

@section('title', 'Members')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><small><a href="{{route('investmentclub.members')}}" class="btn btn-info">Back</a></small> Members</h1>
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
          <p>
          <span class="badge badge-warning">   Updated {{ $diffs = Carbon\Carbon::parse($member->updated_at)->diffForHumans() }} </span>   &nbsp
          <span class="badge badge-success ">   Created {{ $diffs = Carbon\Carbon::parse($member->created_at)->diffForHumans() }} </span>    &nbsp
          </p>
          @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                   @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                   @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
          </div>
      @endif
        <div class="card">
            <div class="card-header">
            <h5 class="card-title">Edit <b>  {{sprintf('%05d', $member->id)}} /  {{$member->last_name}}  {{$member->first_name}}  {{$member->middle_name}}</b></h5>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
            <div class="row">

              <div class="col-md-12">
              <form role="form" action="{{route('investmentclub.members.update',$member->id)}}" method="POST" enctype="multipart/form-data" >
              {{csrf_field() }}
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-md-12"><h4>General Detials</h4><hr></div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">First Name/Given name</label>
                        <input type="text"  name="first_name" value="{{$member->first_name}}" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter First Name" >
                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">Middle Name</label>
                        <input type="text"  name="middle_name" value="{{$member->middle_name}}" class="form-control {{ $errors->has('middle_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Middle Name" >
                        @if ($errors->has('middle_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('middle_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">Last Name/Surname</label>
                        <input type="text"  name="last_name" value="{{$member->last_name}}" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Last Name" >
                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-5 ">
                        <label for="exampleInputEmail1">Gender</label><br>
                        <label class="radio-inline"><input type="radio" id="Male" name="gender" value="1" @php echo $member->gender == 1 ? 'checked' :  "" @endphp> Male</label>
                        <label class="radio-inline"><input type="radio" id="Female" name="gender" value="2" @php echo $member->gender == 2 ? 'checked' :  "" @endphp> Female</label>
                        <label class="radio-inline"> <input type="radio" id="NotApplicable" name="gender" value="0"  @php echo $member->gender == 0 ? 'checked' :  "" @endphp> Rather not say</label>
                    @if ($errors->has('gender'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">National Id</label>
                        <input type="text"  name="national_id" value="{{$member->national_id}}" class="form-control {{ $errors->has('national_id') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter National ID" >
                        @if ($errors->has('national_id'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('national_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="exampleInputEmail1">Nationality</label>
                        <input type="text"  name="nationality" value="{{$member->nationality}}" class="form-control {{ $errors->has('nationality') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Nationality" >
                        @if ($errors->has('nationality'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('nationality') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Date of Birth</label>
                        <input type="date"  name="date_of_birth" value="{{$member->date_of_birth}}" class="form-control {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Date of Birth" >
                        @if ($errors->has('date_of_birth'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('date_of_birth') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3 ">
                        <label for="exampleInputEmail1">Joining Date</label>
                        <input type="date" name="joining_date" value="{{$member->joining_date}}"  class="form-control {{ $errors->has('joining_date') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Joining Date">
                        @if ($errors->has('joining_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('joining_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12"><h4>Personal Details</h4><hr></div>
                    <div class="form-group col-md-5 ">
                        <label for="exampleInputEmail1">Marital Status:</label><br>
                        <label class="radio-inline"><input type="radio" id="Single" name="marital_status" value="0" @php echo $member->marital_status == 0 ? 'checked' :  "" @endphp> Single</label>
                        <label class="radio-inline"><input type="radio" id="Married" name="marital_status" value="1" @php echo $member->marital_status == 1 ? 'checked' :  "" @endphp > Married</label>
                    @if ($errors->has('gender'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12 "></div>
                    <div id="divspouse" class="col-md-12">
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Spouse Name</label>
                        <input type="text"  name="spouse_name" value="{{$member->spouse_name}}" class="form-control {{ $errors->has('spouse_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Spouse Name" >
                        @if ($errors->has('spouse_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('spouse_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Spouse Name Phone No</label>
                        <input type="text"  name="spouse_phone_no" value="{{$member->spouse_phone_no}}" class="form-control {{ $errors->has('spouse_phone_no') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Spouse Name No" >
                        @if ($errors->has('spouse_phone_no'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('spouse_phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Father Name</label>
                        <input type="text"  name="father_name" value="{{$member->father_name}}" class="form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Father Name" >
                        @if ($errors->has('father_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('father_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                          <label for="exampleInputEmail1">Mother Name</label>
                        <input type="text"  name="mother_name" value="{{$member->mother_name}}" class="form-control {{ $errors->has('mother_name') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Mother Name" >
                        @if ($errors->has('mother_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('mother_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                          <label for="exampleInputEmail1">Next OF KIN</label>
                        <input type="text"  name="next_of_kin" value="{{$member->next_of_kin}}" class="form-control {{ $errors->has('next_of_kin') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Next OF KIN" >
                        @if ($errors->has('next_of_kin'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('next_of_kin') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                          <label for="exampleInputEmail1">Next OF KIN Phone</label>
                        <input type="text"  name="next_of_kin_phone" value="{{$member->next_of_kin_phone}}" class="form-control {{ $errors->has('next_of_kin_phone') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Next OF KIN Phone" >
                        @if ($errors->has('next_of_kin_phone'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('next_of_kin_phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                          <label for="exampleInputEmail1">Next OF KIN Relationship</label>
                        <input type="text"  name="next_of_kin_relationship" value="{{$member->next_of_kin_relationship}}" class="form-control {{ $errors->has('next_of_kin_relationship') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Next OF KIN Relationship" >
                        @if ($errors->has('next_of_kin_relationship'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('next_of_kin_relationship') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-8">
                          <label for="exampleInputEmail1">Next OF KIN Address</label>
                        <input type="text"  name="next_of_kin_address" value="{{$member->next_of_kin_address}}" class="form-control {{ $errors->has('next_of_kin_address') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Next OF KIN Address" >
                        @if ($errors->has('next_of_kin_address'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('next_of_kin_address') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                          <label for="exampleInputEmail1">Picture</label>
                        <input type="file" id="exampleInputFile" name="picture" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                       @if($member->picture)
                             <img src="{{url('/storage/photo_thumbs/'.$member->picture) }}" width="100px"/>
                       @endif
                    </div>
                    <div class="form-group col-md-12"><h4>Contact Details</h4><hr></div>
                    <div class="form-group col-md-1">
                          <label for="exampleInputEmail1">Code</label>
                        <input type="text"  name="code" value="{{$member->code}}" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Phone Number" >
                        @if ($errors->has('code'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                          <label for="exampleInputEmail1">Phone Number  ( 751000000 )</label>
                        <input type="text"  name="phone_no" value="{{$member->phone_no}}" class="form-control {{ $errors->has('phone_no') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Phone Number" >
                        @if ($errors->has('phone_no'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                          <label for="exampleInputEmail1">Email</label>
                        <input type="text"  name="email" value="{{$member->email}}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Email" >
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                          <label for="exampleInputEmail1">City</label>
                        <input type="text"  name="city" value="{{$member->city}}" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter City" >
                        @if ($errors->has('city'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                          <label for="exampleInputEmail1">Address</label>
                        <input type="text"  name="address" value="{{$member->address}}" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Address" >
                        @if ($errors->has('address'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-12"><hr></div>
                    <div class=" col-md-3 form-group">
                        <label for="signed" class=" col-md-12 control-label">Status</label>
                        <label class="radio-inline">
                          <input type="radio" id="Active" name="status" value="1"@if(auth()->user()->hasAnyRole('IC User')) disabled @endif  @php echo $member->status == 1? 'checked' :  "" @endphp> Active</label>
                        </label>
                       <label class="radio-inline">
                          <input type="radio" id="Deactive" name="status" value="0" @if(auth()->user()->hasAnyRole('IC User')) disabled @endif @php echo $member->status == 0? 'checked' :  "" @endphp> Deactive</label>
                       </label>
                    </div>
                    <div class="form-group col-md-4" id="Divreason">
                          <label for="exampleInputEmail1"> Reason</label>
                        <input type="text"  name="status_reason" value="{{old('status_reason')}}" class="form-control {{ $errors->has('status_reason') ? ' is-invalid' : '' }}" id="exampleInputEmail1" placeholder="Enter Status Reason" >
                        @if ($errors->has('status_reason'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('status_reason') }}</strong>
                            </span>
                        @endif
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
