@include('layouts.header')
 <link href="https://www.jqueryscript.net/demo/jQuery-Tags-Input-Plugin-with-Autocomplete-Support-Mab-Tag-Input/mab-jquery-taginput.css?v2">
<h2>Edit Blog</h2>
		<br />
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
		    @if($blogdata->count()>0)
		     @foreach($blogdata as $blog)
			<div class="panel-body">
				<form role="form" id="form1" action="{{URL::to('update-blog')}}" method="post" class="validate" enctype="multipart/form-data">
					@csrf
						<input type="hidden" name="id" value="{{$blog->id}}">
					<div class="form-group col-md-6">
						<label class="control-label">Category Name</label>
						<select name="category_id" class="form-control"  data-valdate="required" data-message-required="Category is required">
							<option value="">select blog category</option>
							@if($category->count()>0)
							 @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
							 @endforeach
							@endif
						</select>
						</select>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Title</label>
						<input type="text" class="form-control" value="{{$blog->title}}" name="title" data-validate="required" data-message-required="Title" placeholder="Title" />
						<input type="hidden" name="id" value="{{$blog->id}}">
					</div>
					
					  <div class="form-group col-md-6">
						<label class="control-label">Attachment</label>
						 <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" multiple  name="attachment"/>
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">Tags</label>
						<input type="text" name="tags" value="{{$blog->tags}}" class="form-control tag-input-basic" data-validate="" data-message-required="required"/>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label">Description</label>
						
						<textarea cols="80" id="editor4" name="description" data-validate="" data-message-required=""  rows="2" required>{{$blog->meta_title}}</textarea>
					</div>
					
					<div class="form-group">
						<label class="control-label">Meta Title</label>
						
						<textarea cols="80" id="editor1" name="meta_title" data-validate="" data-message-required="Meta Title is required"  rows="2" required>{{$blog->meta_title}}</textarea>
					</div>
		
					<div class="form-group">
						<label class="control-label">Meta Description</label>
		
						<textarea cols="80" id="editor2" name="meta_description" data-validate="" data-message-required="Meta Description is required"  rows="2" required>{{$blog->meta_description}}</textarea>
					</div>
		
					<div class="form-group">
						<label class="control-label">Meta Keywords</label>
		
						<textarea cols="80" id="editor3" name="meta_keywords" data-validate="required" data-message-required="Meta Keywords is required"  rows="2" required>{{$blog->meta_keywords}}</textarea>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label">Date</label>
		
						<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="log_date_created" value="{{$blog->log_date_created}}" data-validate="" data-message-required="Date is required">
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

<script src="https://www.jqueryscript.net/demo/jQuery-Tags-Input-Plugin-with-Autocomplete-Support-Mab-Tag-Input/mab-jquery-taginput.js?v2"></script>
		
		<script src="https://www.jqueryscript.net/demo/jQuery-Tags-Input-Plugin-with-Autocomplete-Support-Mab-Tag-Input/typeahead.bundle.min.js"></script>
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
		
		CKEDITOR.replace( 'editor4', {
			extraPlugins : 'autogrow',
			removePlugins : 'resize'
		});
		
		
		
			 $('.tag-input-basic').tagInput({
                    onTagDataChanged: logCallbackDataToConsole
                });
				  var logCallbackDataToConsole = function(added, removed) {
                    screenConsole.append('Tag Data: ' + (this.val() || null) + ', Added: ' + added + ', Removed: ' + removed + '\n');
                };
		
	</script>
</body>
</html>