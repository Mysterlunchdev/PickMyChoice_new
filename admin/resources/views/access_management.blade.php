@include('layouts.header')	
<style type="text/css">
	input[type="checkbox"]{
		margin-left: 5px;
	}
</style>
		<br/>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
				</div>
			</div>
		
			<div class="panel-body">
					<!--<div class="form-group col-md-5">
						<label class="control-label">Department</label>
						<select class="form-control" name="department" data-validate="required" data-message-required="Department is required">
							<option value="">Select Department</option>
							 @if($department->count()>0)
							  @foreach($department as $dept)
							  <option value="{{$dept->id}}">{{$dept->name}}</option>
							  @endforeach
							 @endif
						</select>
					</div>-->
					<div class="form-group col-md-5">
						<label class="control-label">Department</label>
						<select class="form-control" name="department" data-validate="required" data-message-required="Video type is required" >
							<option value="">select department</option>
							<option value="2">Admin</option>
						</select>
					</div>

					<div class="form-group col-md-5">
						<label class="control-label">User</label>
						<select class="form-control" name="user" data-validate="required" data-message-required="User is required">
							<option value="">Select User</option>
						</select>
					</div>

					<div class="form-group col-md-2">
						<input type="submit" style="margin-top: 20px;" class="btn btn-success" value="Go">
					</div>
			</div>

			<div class="panel-body pagedata" style="display: none;">
				    <div class="col-md-4">
						<label><b>Page Name</b></label>
					</div>
					<div class="col-md-2">
							<label><b>Add</b></label>
					</div>
					<div class="col-md-2">
							<label><b>Edit</b></label>
					</div>
					<div class="col-md-2">
							<label><b>Delete</b></label>
					</div>
					<div class="col-md-2">
							<label><b>View</b></label>
					</div>
					<form method="post" action="">
						@csrf
						<input type="hidden" name="department_id">
						<input type="hidden" name="user_id">
						<div class="page_data">
						</div>
						<div class="form-group col-md-6">
							<input type="submit" class="btn btn-success" value="Submit">
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
		swal("Success", "Access Changed Successfully", "success");
	</script>
	{{session()->forget('msg')}}
	@endif

	@if(session()->get('err'))
	<script type="text/javascript">
		swal("Error", "{{session()->get('err')}}", "error");
	</script>
	{{session()->forget('err')}}
	@endif

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

	<script type="text/javascript">
		$('select[name="department"]').change(function(){
			if($(this).val()!="")
			{
				$.post('{{URL::to("user_by_dept_id")}}',{did:$(this).val()},function(respo){
					$('select[name="user"]').html(respo);
				})
			}
			else
			{
				$('.pagedata').hide();
				$('.page_data').html('');$('input[name="department_id"]').val('');$('input[name="user_id"]').val('');
				$('select[name="user"]').html('<option value="">Select User</option>');
			}
		})

		$('select[name="user"]').change(function(){
			if($(this).val()!="")
			{
				$('.pagedata').hide();
				$('.page_data').html('');$('input[name="department_id"]').val('');$('input[name="user_id"]').val('');
			}
			else
			{
				$('.pagedata').hide();
				$('.page_data').html('');$('input[name="department_id"]').val('');$('input[name="user_id"]').val('');
			}
		})


		$('input[type="submit"]').click(function(){
			var dept = $('select[name="department"] option:selected').val();
			var user = $('select[name="user"] option:selected').val();

			$('input[name="department_id"]').val(dept);$('input[name="user_id"]').val(user);

			if(dept=="")
			{
				swal("Error", "Please Select Department", "error");return false;
			}
			else if(user=="")
			{
				swal("Error", "Please Select User", "error");return false;
			}

			if(dept!="" && user!="")
			{
				$.post('{{URL::to("page_data")}}',{dept:dept,user:user},function(response){
					$('.pagedata').show();
					$('form').attr('action',"{{URL::to('update-permission')}}");
                    $('.page_data').html(response);
				})
			}
			else
			{
				$('.pagedata').hide();
				$('.page_data').html('');$('input[name="department_id"]').val('');$('input[name="user_id"]').val('');
			}
		})

		function check(id) {
			if($(id).is(":checked")) {
				$(id).val('1');
			}else
			{
				$(id).val('0');
			}
		}
	</script>

</body>
</html>