@include('layouts.header')
<h2>Add</h2>
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
						<label class="control-label">Vendor</label>
						<select name="user_id" id="user_id" class="form-control" data-valdate="required" data-message-required="required">
							<option value="">select </option>
							@if($user->count()>0)
							 @foreach($user as $use)
                                <option value="{{$use->id}}">{{$use->name}} - {{$use->last_name}} - {{$use->user_code}}</option>
							 @endforeach
							@endif
						</select>
						</select>
					</div>
					
					
					 <div class="form-group col-md-6" id="user_id" style="border:1px solid #eee;">
					     <h4><B>Vendor Details</B></h4>
					     <span id="data_here"></span>
					 </div>
					 
					<div class="form-group col-md-6">
						<label class="control-label">Amount</label>
						<input type="text" class="form-control" name="amount_paid" data-validate="" data-message-required="" placeholder=""/>
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">Transaction No</label>
						<input type="text" class="form-control" name="transaction_no" data-validate="" data-message-required="" placeholder=""/>
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">Paid Date</label>
						<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="paid_date" data-validate="" data-message-required="Date is required">
					</div>
					
						<div class="form-group col-md-6">
						<label class="control-label">Narration</label>
						<input type="text" class="form-control" name="narration" data-validate="" data-message-required="" placeholder=""/>
					</div>
					

					
					
					<div class="form-group col-md-6">
						<button type="submit" class="btn btn-success">Submit</button>
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

          
            //]]>
        </script>
  <script>
 $("#user_id").change(function(){
   var id = $(this).val()
   $.post('{{URL::to("/vendor-details")}}',{id:id},function(respo){
       $('span[id=data_here]').html(respo);
   })
  });
  </script>
</body>
</html>
