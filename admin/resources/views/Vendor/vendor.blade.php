@include('layouts.header')
       <link rel="stylesheet" href="https://demo.neontheme.com/assets/js/datatables/datatables.css" id="style-resource-1">
		<br>
		<br>
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Code</th>
					<th>Name</th>
					<th>Last Name</th>
					<th>Mobile</th>
					<th>Email</th>
						<th>Category</th>
					<th>Address Details</th>
					<th>Reg Date</th>
                    <th>Is Verified</th>
					<th>Verified</th>
					<th>status</th>
					<th>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($vendordata->count()>0)
				 @foreach($vendordata as $data)
				 
				 	@if($vendordata1->count()>0)
				 @foreach($vendordata1 as $data1)

				 <tr>
					<td>{{$i++}}</td>
					<td>{{$data->user_code}}</td>
					<td>{{$data->name}}</td>
					<td>{{$data->last_name}}</td>
					<td>{{$data->mobile}}</td>
					<td>{{$data->email}}</td>
					<td>{{$data1->cat_name}}</td>
					<td>{{$data->address}}</td>
					<td>{{$data->log_date_created}}</td>
					<td>{{$data->is_verified}}</td>
					<td><a href="javascript:void[0]" data-id="{{$data->id}}" id="vstatus" data-toggle="modal" data-target="#myModals" class="btn btn-info">
							VERIFIED
						</a>
                    </td>
					<td>
						@if($data->status=="Active")
						 <span class="label label-success">Active</span>
						@else
						 <span class="label label-danger">InActive</span>
						@endif
					</td>
					<td>
						@if(session()->get('userdata')[0]->department_id==1 || isset($page_access[0]->can_edit) && $page_access[0]->can_edit==1)
						<a href="{{URL::to('edit-vendor',base64_encode($data->id))}}" class="btn btn-default btn-sm btn-icon icon-left">
								<i class="entypo-eye"></i>
							Details
						</a>
						@endif
					</td>
				</tr>

				 @endforeach
				@endif
				
				 @endforeach
				@endif
			</tbody>
		</table>
		
		
			
		<div class="modal fade" id="myModals" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Verified</h4>
        </div>
        <div class="modal-body">
         <div class="panel-body">
				@csrf
				    <div class="form-group col-md-6">
					<label class="control-label">Verified</label>
		                <select name="is_verified" class="form-control" data-valdate="required" data-message-required="required">
	                   
		                   <option value='Verified'>Verified</option>
						   <option value='Not verified'>Not verified</option>
						  </select>
						  <input type="hidden" id="id">
		           </div>
				   
				   
		            <div class="form-group col-md-6">
						<button type="button" class="btn btn-success status_change1">Submit</button>
						<button type="reset" class="btn">Reset</button>
					</div>
		    </div>
			 </div>
        </div>
     </div>
  </div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>
		<script type="text/javascript">
			function changestatus(ai,s)
			{
				if(s=="")
				{
                   if(confirm('Are You sure want to Delete This record..?'))
                   {
                      action(ai,s);
                   }
				}
				else
				{
                  action(ai,s);
				}
			}

			function action(ai,s)
			{
				$.post("{{URL::to('/changestatus')}}",{ai:ai,s:s,t:'u'},function(response){
						swal({title: "Success", text: response, type: "success"},
							function(){ 
								location.reload();
							}
							);
				})
			}
		</script>

		<br />

		<!-- Imported styles on this page -->
		
	<link rel="stylesheet" href="{{URL::asset('assets/js/datatables/responsive/css/datatables.responsive.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2-bootstrap.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/js/select2/select2.css')}}">

	<!-- Bottom scripts (common) -->
	<script src="{{URL::asset('assets/js/gsap/main-gsap.js')}}"></script>
	<script src="{{URL::asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/bootstrap.js')}}"></script>
	<script src="{{URL::asset('assets/js/joinable.js')}}"></script>
	<script src="{{URL::asset('assets/js/resizeable.js')}}"></script>
	<script src="{{URL::asset('assets/js/neon-api.js')}}"></script>
	<script src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/datatables/TableTools.min.js')}}"></script>


	<!-- Imported scripts on this page -->
	<script src="{{URL::asset('assets/js/dataTables.bootstrap.js')}}"></script>
	<script src="{{URL::asset('assets/js/datatables/jquery.dataTables.columnFilter.js')}}"></script>
	<script src="{{URL::asset('assets/js/datatables/lodash.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/datatables/responsive/js/datatables.responsive.js')}}"></script>
	<script src="{{URL::asset('assets/js/select2/select2.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/neon-chat.js')}}"></script>
	
	<script src="{{URL::asset('assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
	      <script src="https://demo.neontheme.com/assets/js/datatables/datatables.js" id="script-resource-8"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="{{URL::asset('assets/js/neon-custom.js')}}"></script>


	<!-- Demo Settings -->
	<script src="{{URL::asset('assets/js/neon-demo.js')}}"></script>

<script type="text/javascript">
		$("#table-2").dataTable({
		    "lengthMenu": [[ 25, 50, -1], [ 25, 50, "All"]],
		    dom: 'lBfrtip',
buttons: [
'excelHtml5',
'csvHtml5',
'pdfHtml5'
]
		  });
				
</script>

	@if(session()->get('userdata')[0]->department_id==1 || isset($page_access[0]->can_view) && $page_access[0]->can_view==1)
	@else
	<script type="text/javascript">
		swal('Error','You dont have permisson to view this page','error');
		setTimeout(function() {  window.location = "{{URL::to('dashboard')}}"; }, 1500);
	</script>
	@endif
	
	<script>
$('.status_change1').click(function(){
	
	   
		var is_verified = $('select[name="is_verified"] option:selected').val();
		var id=$("#id").val();
      
		if(is_verified!="")
		{
			$.post('{{URL::to("/change-vendor-status")}}',{is_verified:is_verified,id:id},function(data){
				if(data==1)
				{
					window.location.reload();
				}
				else
				{
					
					window.location.reload();
				}
			})
		}
	})
	$('#vstatus').click(function(){
	    var id = $(this).attr("data-id");
	    $("#id").val(id);
	})
</script>
	</body>
</html>

