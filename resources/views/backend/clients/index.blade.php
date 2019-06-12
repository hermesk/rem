@extends('layouts.app')
@section('title','Clients List')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
             <div class="card-header">Clients List
             @can('create', App\Client::class)
             <h6><a class="nav-link" href="{{route('clients.create')}}">+Add</a></h6>
             @endcan
             </div>
             <table>
				<thead>
				<tr>
			    <th width="20%">Name</th>
			    <th width="20%">ID No</th>
			    <th width="20%">Mobile No</th>
			    <th width="20%">KRA Pin No</th>

			  </tr>
			</thead>
			<tbody>

			  @foreach($clients as $client)
			 <tr>
			 	<td>
			 	<a href="{{route('clients.show',['client'=>$client])}}">{{$client->name}}</a>
			 	</td>
			 	<td>{{$client->idno}}</td>
			 	<td>{{$client->mobile}}</td>
			 	<td>{{$client->kra_pin}}</td>

			 </tr>
			    @endforeach
			    </tbody>
            </table>
            <div class="row">
            	<div class="col-12 d-flex justify-content-center pt-4">
            		{{$clients->links()}}
            	</div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
