@extends('layouts.app')
@section('title','Edit Details for ' .$client->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             <div class="card-header">Edit Details for {{$client->name}}</div>
            
            <div class="form">
               <form action="{{route('clients.update',['client'=>$client])}}" method="POST">
                     @method('PATCH')
                    @include('partials.client_form')

                <my-button type="submit" text="Update"></my-button>


                </form>

  </div>


            </div>
        </div>
    </div>
</div>
@endsection
