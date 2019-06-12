<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Client @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Client
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('clients.index')}}"><i class="fa icon-student"></i> Client</a></li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                 <form action="{{route('clients.store')}}" method="POST">
                      @include('backend.partials.client_form')

                     <div class="box-footer">
                        <cancle-button text="Cancel"  type="reset" ></cancle-button>
                       <my-button type="submit" text="Add"></my-button>

                  
                       </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{URL::route('clients.index')}}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">Add</button>

                        </div>

                  </form>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')

@endsection
