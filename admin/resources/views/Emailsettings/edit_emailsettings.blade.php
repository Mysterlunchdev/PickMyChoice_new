@include('layouts.header')
<h2>Edit Email Settings</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
		    @if($emailsettingsdata->count()>0)
		     @foreach($emailsettingsdata as $emailsettings)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-emailsettings')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Host</label>
						<input type="text" class="form-control" value="{{$emailsettings->host}}" name="host" data-validate="required" data-message-required="name is required" placeholder="host" />
						<input type="hidden" name="id" value="{{$emailsettings->id}}">
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Port</label>
						<input type="text" class="form-control" value="{{$emailsettings->port}}" name="port" data-validate="" data-message-required="" placeholder="port" />
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Email</label>
						<input type="text" class="form-control" value="{{$emailsettings->email}}" name="email" data-validate="" data-message-required="" placeholder="email" />
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">To Email</label>
						<input type="text" class="form-control" value="{{$emailsettings->to_email}}" name="to_email" data-validate="" data-message-required="" placeholder="To Email" />
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