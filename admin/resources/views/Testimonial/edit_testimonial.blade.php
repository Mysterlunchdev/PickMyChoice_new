@include('layouts.header')
<h2>Edit Testimonial</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
				
				</div>
			</div>
		    @if($testimonialdata->count()>0)
		      @foreach($testimonialdata as $data)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-testimonial')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Title</label>
						<input type="text" class="form-control" name="title" value="{{$data->title}}" data-validate="required" data-message-required="name is required" placeholder="name" />
						<input type="hidden" name="id" value="{{$data->id}}">
					</div>
		
		
		        <div class="form-group col-md-6">
						<label class="control-label">Description</label>
						<input type="text" class="form-control" name="description"  value="{{$data->description}}"  data-validate="" data-message-required="" placeholder="Description" />
					</div>
				    <div class="form-group col-md-6">
						<label class="control-label">Date</label>
		
						<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="posted_date"  value="{{$data->posted_date}}" data-validate="" data-message-required="">
					</div>
					
				


					<div class="form-group">
						<button type="submit" class="btn btn-success">Update</button>
						<!-- <button type="reset" class="btn">Reset</button> -->
					</div>
		
				</form>
		
			</div>
			 
		
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
	<script src="{{URL::asset('assets/js/bootstrap-datepicker.js')}}"></script>


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
@endforeach
@endif