@include('layouts.header')
		<h2>Edit Banner</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					
				</div>
			</div>
		    @if($bannerdata->count()>0)
		     @foreach($bannerdata as $banner)
			<div class="panel-body">
				<form role="form" id="form1" action="{{url::to('update-banner')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					
						<input type="hidden" name="id" value="{{$banner->id}}">
					
					<div class="form-group col-md-6">
						<label class="control-label">Type</label>
		
						<select class="form-control" name="type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option @if($banner->type=='App') selected @endif value="App">App</option>
							
						</select>
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">User Type</label>
		
						<select class="form-control" name="user_type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option @if($banner->type=='user') selected @endif value="user">user</option>
							<option @if($banner->type=='vendor') selected @endif value="vendor">vendor</option>
						</select>
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">File Type</label>
		
						<select class="form-control" name="file_type" data-validate="required" data-message-required="Video type is required" >
							<option value="">Select type</option>
							<option @if($banner->type=='image') selected @endif value="image">image</option>
							<option @if($banner->type=='video') selected @endif value="video">video</option>
						</select>
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
		
						<input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="attachment" />
					</div>
					
					 <div class="form-group col-md-6">
						<label class="control-label">Description</label>
						<input type="text" class="form-control" name="description" value="{{$banner->description}}" data-validate="" data-message-required="" placeholder="Description" />
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Date</label>
		
						<input type="text" class="form-control datepicker" value="{{$banner->log_date_created}}" data-format="yyyy-mm-dd" name="log_date_created" data-validate="" data-message-required="">
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
	<script src="{{URL::asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>

    <script type="text/javascript" src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
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