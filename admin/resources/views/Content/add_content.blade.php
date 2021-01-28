@include('layouts.header')
        <h2>Add Content</h2>
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
						<label class="control-label">Menu Name</label>
						<select class="form-control" name="menu_id" data-validate="required" data-message-required="Menu name is required">
							<option value="">select menu</option>
							@if($menu->count()>0)
							 @foreach($menu as $m)
							   <option value="{{$m->id}}">{{$m->name}}</option>
							 @endforeach
							@endif
						</select>
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">Name</label>
						<input type="text" class="form-control" name="name" data-validate="required" data-message-required="Name is required" placeholder="Name" />
					</div>
		
					<div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
		
						<input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="attachment" data-validate="required" data-message-required="file is required"/>
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">Page Name</label>
						<input type="text" class="form-control" name="pagename" data-validate="required" data-message-required="Page Name is required" placeholder="Page Name" />
					</div>

					<div class="form-group col-md-6">
						<label class="control-label">URL</label>
						<input type="text" class="form-control" data-validate="required,url" name="url" data-validate="required" data-message-required="URL is required" placeholder="URL" />
					</div>
					<div class="form-group col-md-6">
						<label class="control-label">Index level</label>
						<input type="text" class="form-control"  name="index_level" data-validate="required" data-message-required="Index level is required" />
					</div>


					<div class="form-group">
						<label class="control-label">Content</label>
						
						<textarea cols="80" id="editor4" name="content" data-validate="required" data-message-required="Content is required"  rows="2" required></textarea>
					</div>
		
					<div class="form-group">
						<label class="control-label">Meta Title</label>
						
						<textarea cols="80" id="editor1" name="meta_title" data-validate="required" data-message-required="Meta Title is required"  rows="2" required></textarea>
					</div>
		
					<div class="form-group">
						<label class="control-label">Meta Description</label>
		
						<textarea cols="80" id="editor2" name="meta_description" data-validate="required" data-message-required="Meta Description is required"  rows="2" required></textarea>
					</div>
		
					<div class="form-group">
						<label class="control-label">Meta Keywords</label>
		
						<textarea cols="80" id="editor3" name="meta_keywords" data-validate="required" data-message-required="Meta Keywords is required"  rows="2" required></textarea>
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

            CKEDITOR.replace( 'editor4', {
            	extraPlugins : 'autogrow',
            	removePlugins : 'resize'
            });

            //]]>
        </script>

</body>
</html>