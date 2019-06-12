  	@csrf
  	
	    <div class="row form-group col-md-6">  	
		<label for="name">Name<span class="text-danger">*</span></label>
		<input  type="text" name="name" class="form-control" placeholder="name" value="{{old('name') ?? $client->name}}">
		     <div>{{$errors->first('name')}}</div>

	    </div>

	    <div class="row form-group col-md-6">
	    	<label for="idno">ID No.<span class="text-danger">*</span></label>
	    	<input type="text" name="idno" class="form-control" placeholder="ID number" value="{{old('idno') ?? $client->idno}}" >
	    	 <div>{{$errors->first('idno')}}</div>
	    </div>
	        
	    <div class="row form-group col-md-6">
	    	<label for="mobile">Mobile No.<span class="text-danger">*</span></label>
	    	<input type="number" name="mobile" class="form-control" placeholder="mobile number" value="{{old('mobile') ?? $client->mobile}}" >
	    	     <div>{{$errors->first('mobile')}}</div>
	    </div>
	     <div class="row form-group col-md-6">
	    	<label for="kra_pin">KRA Pin No.</label>
	    	<input type="kra_pin" name="kra_pin" class="form-control" placeholder="KRA Pin" value="{{old('kra_pin') ?? $client->kra_pin}}" >
	    	     <div>{{$errors->first('kra_pin')}}</div>
	    </div>
