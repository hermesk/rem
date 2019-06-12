<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Settings @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Institute Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Institute Settings</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form  id="entryForm" action="{{URL::Route('settings.institute')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Application Settings</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Institute Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" name="name" class="form-control" placeholder="HR High School" value="@if($info){{ $info->name }}@endif" maxlength="255" required />
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="short_name">Institute Short Name<span class="text-danger">*</span></label>
                                        <input type="text" name="short_name" class="form-control" placeholder="HRHS" value="@if($info){{ $info->short_name }}@endif" minlength="3" maxlength="255" required />
                                        <span class="fa fa-info form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('short_name') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="establish">Establish<span class="text-danger">*</span></label>
                                        <input type='text' class="form-control year_picker"  readonly name="establish" placeholder="year" value="@if($info){{ $info->establish }}@else{{ old('establish',date('Y')) }} @endif" required minlength="4" maxlength="255" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('establish') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="logo">Logo<span class="text-danger">[230 X 50 max size and max 1MB]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo" placeholder="logo image">
                                        @if($info && isset($info->logo))
                                            <input type="hidden" name="oldLogo" value="{{$info->logo}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group has-feedback">
                                        <label for="logo_small">Logo Small<span class="text-danger">[50 X 50 max size and max 512kb]</span></label>
                                        <input  type="file" class="form-control" accept=".jpeg, .jpg, .png" name="logo_small" placeholder="logo image">
                                        @if($info && isset($info->logo_small))
                                            <input type="hidden" name="oldLogoSmall" value="{{$info->logo_small}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('logo_small') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="favicon">Favicon<span class="text-danger">[only .png image][32 X 32 exact size and max 512KB]</span></label>
                                        <input  type="file" class="form-control" accept=".png" name="favicon" placeholder="favicon image">
                                        @if($info && isset($info->favicon))
                                            <input type="hidden" name="oldFavicon" value="{{$info->favicon}}">
                                        @endif
                                        <span class="glyphicon glyphicon-open-file form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('favicon') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="website_link">Website Link</label>
                                        <input  type="text" class="form-control" name="website_link"  placeholder="url" value="@if($info) {{ $info->website_link }} @endif" maxlength="500">
                                        <span class="fa fa-link form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('website_link') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="email">Email</label>
                                        <input  type="email" class="form-control" name="email"  placeholder="email address" value="@if($info) {{ $info->email }} @endif" maxlength="255">
                                        <span class="fa fa-envelope form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="phone_no">Phone/Mobile No.<span class="text-danger">*</span></label>
                                        <input  type="text" class="form-control" name="phone_no" required placeholder="phone or mobile number" value="@if($info) {{ $info->phone_no }}@endif" minlength="8" maxlength="255">
                                        <span class="fa fa-phone form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('phone_no') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback">
                                        <label for="address">Address<span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" required maxlength="500" required>@if($info){{ $info->address }}@endif</textarea>
                                        <span class="fa fa-location-arrow form-control-feedback"></span>
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    </div>
                                </div>                            
                            </div>

                          
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box">
                        <div class="box-footer">
                            <a href="{{URL::route('user.dashboard')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        window.smsGatewayListURL = '{{URL::route('settings.sms_gateway.index')}}';
        window.templateListURL = '{{URL::route('administrator.template.mailsms.index')}}';

        window.gatewaySt = @if(isset($metas['student_attendance_gateway'])) {{$metas['student_attendance_gateway']}}; @else 0; @endif
        window.templateSt = @if(isset($metas['student_attendance_template'])) {{$metas['student_attendance_template']}}; @else 0; @endif
        window.gatewayEmp = @if(isset($metas['employee_attendance_gateway'])) {{$metas['employee_attendance_gateway']}}; @else 0; @endif
        window.templateEmp = @if(isset($metas['employee_attendance_template'])) {{$metas['employee_attendance_template']}}; @else 0; @endif

        $(document).ready(function () {
            Settings.instituteInit();

        });
    </script>
@endsection
<!-- END PAGE JS-->

