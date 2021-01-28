@include('layouts.header')
<h2>Edit Blog Category</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
		    @if($blog_categorydata->count()>0)
		     @foreach($blog_categorydata as $blog_category)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-blog_category')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
					<div class="form-group col-md-6">
						<label class="control-label">Category Name</label>
						<input type="text" class="form-control" value="{{$blog_category->name}}" name="name" data-validate="required" data-message-required="Category name is required" placeholder="Blog Category name" />
						<input type="hidden" name="id" value="{{$blog_category->id}}">
					</div>
					
					   <div class="form-group col-md-6">
						<label class="control-label">Date</label>
		
						<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="log_date_created"  value="{{$blog_category->log_date_created}}" data-validate="required" data-message-required="Date is required">
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
<script type="text/javascript">
		CKEDITOR.replace( 'editor1', {
			extraPlugins : 'autogrow',
			removePlugins : 'resize'
		});

		CKEDITOR.replace( 'editor2', {
			extraPlugins : 'autogrow',
			removePlugins : 'resize'
		});

		CKEDITOR.replace( 'editor3', {
			extraPlugins : 'autogrow',
			removePlugins : 'resize'
		});
		
	</script>
</body>
</html>