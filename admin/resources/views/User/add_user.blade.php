@include('layouts.header')
<h2>Add User</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
				</div>
			</div>
		
			<div class="panel-body">
				<form role="form" id="form1" action="" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">First Name</label>
						<input type="text" class="form-control" name="name" data-validate="required" data-message-required="User name is required" placeholder="User name" />
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">Last name</label>
						<input type="text" class="form-control" name="last_name" data-validate="required" data-message-required="Last name is required" placeholder="Last name" />
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">email</label>
		
						<input type="email" class="form-control" name="email" data-validate="required" data-message-required="Email is required"/>
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Mobile Number</label>
		
						<input type="text" class="form-control"  name="mobile" data-validate="number,minlength[10],maxlength[10],required"  data-message-required="Mobile number is required"/>
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Password</label>
		
						
						<input type="password" class="form-control"  name="password" data-validate="required"  data-message-required="Password is required"/>
					</div>
		
				
					<div class="form-group col-md-6">
						<label class="control-label">Department</label>
						<select class="form-control" name="department_id" data-validate="required" data-message-required="Video type is required" >
							<option value="">select department</option>
							<option value="2">Admin</option>
							
						</select>
						
					</div>
		
		
					<div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
		         
						 <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"  name="profile_photo" data-validate="required"  data-message-required="Attachment is required"/>
					</div>

		
					<div class="form-group">
						<label class="control-label">Address</label>
		         
						 <textarea class="form-control" rows="3" data-validate="required" name="address"  data-message-required="Address is required"></textarea>
					</div>
		
					<div class="form-group col-md-6">
						<button type="submit" class="btn btn-success">Add</button>
						<button type="reset" class="btn">Reset</button>
					</div>
		
				</form>
		
			</div>
		
		</div>
		
	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>
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