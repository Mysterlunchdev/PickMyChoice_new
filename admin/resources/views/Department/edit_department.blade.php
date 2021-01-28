@include('layouts.header')
        <h2>Edit Department</h2>
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

			@if($deptdata->count()>0)
		      @foreach($deptdata as $vdata)
		
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-department')}}" method="post" class="validate">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Name</label>
						<input type="text" class="form-control" value="{{$vdata->name}}" name="name" data-validate="required" data-message-required="News name is required" placeholder="News name" />
						<input type="hidden" name="id" value="{{$vdata->id}}">
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">Description</label>
						<input type="text" class="form-control" value="{{$vdata->description}}" name="description" data-validate="required" data-message-required="Description is required" placeholder="Description" />
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