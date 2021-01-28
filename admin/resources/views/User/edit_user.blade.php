@include('layouts.header')
<h2>Edit User</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					<!-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
					<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
					<a href="#" data-rel="close"><i class="entypo-cancel"></i></a> -->
				</div>
			</div>
		    @if($userdata->count()>0)
		     @foreach($userdata as $user)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-user')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">First Name</label>
						<input type="text" class="form-control" value="{{$user->name}}" name="name" data-validate="required" data-message-required="User name is required" placeholder="User name" />
						<input type="hidden" name="id" value="{{$user->id}}">
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">Last name</label>
						<input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" data-validate="required" data-message-required="Last name is required" placeholder="Last name" />
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">email</label>
		
						<input type="email" class="form-control" name="email" value="{{$user->email}}" data-validate="required" data-message-required="Email is required"/>
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Mobile Number</label>
		
						<input type="text" class="form-control"  name="mobile" value="{{$user->mobile}}" data-validate="number,minlength[10],maxlength[10]"  data-message-required="Mobile number is required"/>
					</div>
				
					<div class="form-group col-md-6">
						<label class="control-label">Department</label>
		               	<select class="form-control" name="department_id" data-validate="" data-message-required="" >
							<option value="">select department</option>
							<option value="2">Admin</option>
							
						</select>
						
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
		         
						 <input type="file" class="form-control"  name="attachment" accept="image/x-png,image/gif,image/jpeg" />
					</div>

				
					<div class="form-group col-md-6">
						<label class="control-label">Address</label>
		         
						 <textarea class="form-control" rows="3" data-validate="required" name="address"  data-message-required="Address is required">{{$user->address}}</textarea>
					</div>
		
					<div class="form-group col-md-6">
						<button type="submit" class="btn btn-success">Update</button>
						<!-- <button type="reset" class="btn">Reset</button> -->
					</div>
				</form>
			</div>
		    @endforeach
		   @endif
		</div>
		
	<!-- Bottom scripts (common) -->
	<script src="{{URL::asset('assets/js/gsap/main-gsap.js')}}"></script>
	<script src="{{URL::asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/bootstrap.js')}}"></script>
	<script src="{{URL::asset('assets/js/joinable.js')}}"></script>
	<script src="{{URL::asset('assets/js/resizeable.js')}}"></script>
	<script src="{{URL::asset('assets/js/neon-api.js')}}"></script>


	<!-- Imported scripts on this page -->
	<script src="{{URL::asset('assets/js/jquery.validate.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/neon-chat.js')}}"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="{{URL::asset('assets/js/neon-custom.js')}}"></script>


	<!-- Demo Settings -->
	<script src="{{URL::asset('assets/js/neon-demo.js')}}"></script>
	@if(session()->get('msg'))
	<script type="text/javascript">
		swal("Success", "{{session()->get('msg')}}", "success");
	</script>
	{{session()->forget('msg')}}
	@endif

	@if(session()->get('err'))
	<script type="text/javascript">
		swal("Error", "{{session()->get('err')}}", "error");
	</script>
	{{session()->forget('err')}}
	@endif

</body>
</html>