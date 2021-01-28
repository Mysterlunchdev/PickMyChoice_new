@include('layouts.header')
<h2>Edit Sms Settings</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
		    @if($smssettingsdata->count()>0)
		     @foreach($smssettingsdata as $smssettings)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-smssettings')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Company</label>
						<input type="text" class="form-control" value="{{$smssettings->company}}" name="company" data-validate="required" data-message-required="company name is required" placeholder="company" />
						<input type="hidden" name="id" value="{{$smssettings->id}}">
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Url</label>
						<input type="text" class="form-control" value="{{$smssettings->url}}" name="url" data-validate="" data-message-required="" placeholder="url" />
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Username</label>
						<input type="text" class="form-control" value="{{$smssettings->username}}" name="username" data-validate="" data-message-required="" placeholder="username" />
					</div>
					

					
					<div class="form-group col-md-6">
						<label class="control-label">Sender ID</label>
						<input type="text" class="form-control" value="{{$smssettings->sender_id}}" name="sender_id" data-validate="" data-message-required="" placeholder="Sender Id" />
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