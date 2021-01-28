@include('layouts.header')
<h2>Add Side Menus</h2>
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
		
			<div class="panel-body">
				<form role="form" id="form1" action="" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Main Menu</label>
						<select class="form-control" name="main_menu" data-validate="required" data-message-required="Main Menu is required">
							<option value="">Select Main Menu</option>
							@if($menus->count()>0)
							 @foreach($menus as $main)
							  <option value="{{$main->id}}">{{$main->name}}</option>
							 @endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-6">
						<label class="control-label">Side Menu</label>
						<select class="select2" multiple name="side_menu[]" data-validate="required" data-message-required="Side Menu is required">
							@if($menus->count()>0)
							 @foreach($menus as $main)
							  <option value="{{$main->name}}">{{$main->name}}</option>
							 @endforeach
							@endif
						</select>
					</div>
	
		
					<div class="form-group col-md-6">
						<button type="submit" class="btn btn-success">Add</button>
						<button type="reset" class="btn">Reset</button>
					</div>
		
				</form>
		
			</div>
		
		</div>

	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<script src="assets/js/select2/select2.min.js"></script>

		
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
	<script src="{{URL::asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>


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


	<script type="text/javascript">
            //<![CDATA[
            CKEDITOR.replace( 'editor3', {
            	extraPlugins : 'autogrow',
            	removePlugins : 'resize'
            });
            //]]>
        </script>

</body>
</html>