@include('layouts.header')

        <h2>Add Banner</h2>
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
						<label class="control-label">Type</label>
		
						<select class="form-control" name="type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option value="App">App</option>
							
						</select>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">User Type</label>
		
						<select class="form-control" name="user_type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option value="user">user</option>
							<option value="vendor">vendor</option>
						</select>
					</div>
					
					
					<div class="form-group col-md-6">
						<label class="control-label">File Type</label>
		
						<select class="form-control" name="file_type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option value="image">image</option>
							<option value="video">video</option>
						</select>
					</div>
					
		
					<div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
		
						<input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="attachment" data-validate="required" data-message-required="Video file is required"/>
					</div>
					
						 <div class="form-group col-md-6">
						<label class="control-label">Description</label>
						<input type="text" class="form-control" name="description" data-validate="" data-message-required="" placeholder="Description"/>
					</div>
					
						 <div class="form-group col-md-6">
						<label class="control-label">Date</label>
						<input type="text" class="form-control" name="log_date_created" data-validate="" data-message-required="" placeholder="date"/>
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

	<script src="{{URL::asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>

    <script type="text/javascript" src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
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