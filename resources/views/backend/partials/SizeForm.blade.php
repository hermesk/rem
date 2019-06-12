          @csrf
   	
         <div class="row form-group col-md-8 ">  	
		   <label for="name">Size<span class="text-danger">*</span></label>
		   <input  type="text" name="name" class="form-control" placeholder="name of the size" value="{{old('name')?? $size->name}}">
		     <div>{{$errors->first('name')}}</div>
	    </div>	

	      <div class="box-footer">


       </div>