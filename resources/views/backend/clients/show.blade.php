@extends('layouts.app')
@section('title',$client->name. ' Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             <div class="card-header">{{$client->name}} Details
              <p><a href="{{route('clients.edit',['client'=>$client])}}">Edit</a></p>
             </div>
              <div class="row">

				<div class="col-12">
					<p><strong>Name:</strong>{{$client->name}}</p>
					<p><strong>Id No:</strong>{{$client->idno}}</p>
					<p><strong>Mobile:</strong>{{$client->mobile}}</p>
					<p><strong>KRA Pin No:</strong>{{$client->kra_pin}}</p>

				</div>
				<form action="{{route('clients.destroy',['client'=>$client])}}" method="POST">
					@csrf
					@method('DELETE')
				   <button type="submit" class="btn btn-danger">Delete</button>
					
				</form>
				</div>

            </div>
        </div>
    </div>
</div>
@endsection

