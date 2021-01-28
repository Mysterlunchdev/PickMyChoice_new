@include('layouts.header')
<link rel="stylesheet" href="https://demo.neontheme.com/assets/js/datatables/datatables.css" id="style-resource-1">
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>User</th>
					<th>Code</th>
					<th>Title</th>
					<th>Category</th>
					<th>Subcategory</th>
					<th>Budget</th>
					<th>Status</th>
					<th>Actions</th>
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($taskdata->count()>0)
				 @foreach($taskdata as $data)

				 <?php 
				 $t_status = LayoutHelper::fetch_task_status($data->id); 
                 
                 $st = '';
				 if($t_status->count()>0)
				 {
                    $st = $t_status[0]->status;
				 }
				 else
				 {
				 	$quote = LayoutHelper::fetch_task_quote_status($data->id);

				 	if($quote->count()>0)
				 	{
				 		$st = $quote[0]->status;
				 		if($st=='Active')
				 		{
				 			$st = 'Quote Sent';
				 		}
				 		else
				 		{
				 			$st = $st;
				 		}
				 	}
				 	else
				 	{
				 		$st = 'Assigned';
				 	}
				 }
				 ?>
				 
				<tr>
					<td>{{$i++}}</td>
					<td>{{$data->user_name}}</td>
					<td>{{$data->code}}</td>
					<td>{{$data->title}}</td>
					<td>{{$data->cat_name}}</td>
					<td>{{$data->sub_cat_name}}</td>
					<td>{{$data->budget}}</td>
					<td>{{$st}}</td>
				
						
					<td>
						@if(session()->get('userdata')[0]->department_id==1 || isset($page_access[0]->can_edit) && $page_access[0]->can_edit==1)
						<a href="{{URL::to('edit-task',base64_encode($data->id))}}" class="btn btn-info btn-sm btn-icon icon-left">
							<i class="entypo-eye"></i>
							Details
						</a>
						@endif
						
					</td>
					
				</tr>
					@endforeach
				@endif
				
			</tbody>
		</table>
		
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
				$.post("{{URL::to('/changestatus')}}",{ai:ai,s:s,t:'cat'},function(response){
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

</body>
</html>


