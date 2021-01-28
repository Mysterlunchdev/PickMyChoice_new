@include('layouts.header')
<h2>Update Side Menus</h2>
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
		    @if($sidemenu->count()>0)
		    @foreach($sidemenu as $sidemenus)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-side-menu')}}" method="post" class="validate">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Main Menu</label>
						<select class="form-control" name="main_menu" data-validate="required" data-message-required="Main Menu is required">
							@if($menus->count()>0)
							 @foreach($menus as $main)
							  <option @if($sidemenus->main_menu==$main->id) selected @endif value="{{$main->id}}">{{$main->name}}</option>
							 @endforeach
							@endif
						</select>
						<input type="hidden" name="id" value="{{$sidemenus->id}}">
					</div>
					<div class="form-group col-md-6">
						<label class="control-label">Side Menu</label>
						<select class="select2" multiple name="side_menu[]" data-validate="required" data-message-required="Side Menu is required">
							@if($menus->count()>0)
							 @foreach($menus as $main)
							  <option @if($sidemenus->side_menu==$main->name) selected @endif value="{{$main->name}}">{{$main->name}}</option>
							 @endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-6">
						<button type="submit" class="btn btn-success">Update</button>
					</div>
				</form>
			</div>
		   @endforeach
		   @endif
		
		</div>

	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2-bootstrap.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2.css')}}">
	<script src="{{URL::asset('assets/js/select2/select2.min.js')}}"></script>

		
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