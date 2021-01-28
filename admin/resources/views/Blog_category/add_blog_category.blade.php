@include('layouts.header')
		<h2>Add Blog Category</h2>
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
						<label class="control-label">Name</label>
						<input type="text" class="form-control" name="name" data-validate="required" data-message-required="required" placeholder="Name" />
					</div>
					
					
						<div class="form-group col-md-6">
						<label class="control-label">Date</label>
		
						<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="log_date_created" data-validate="required" data-message-required="Date is required">
					</div>
					
					
					
					
		
					<div class="form-group">
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


	<!-- Imported scripts on this page -->
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>


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
           
            //]]>
        </script>
</body>
</html>