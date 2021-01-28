@include('layouts.header')
   <link rel="stylesheet" href="https://demo.neontheme.com/assets/js/datatables/datatables.css" id="style-resource-1">
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Type</th>
					<th>User Details</th>
					<th>Task Details</th>
					<th>Reason</th>
					<th>Solution</th>
					<th>Date</th>
					<th>Close Ticket</th>
					
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($refundrequestreportsdata->count()>0)
				 @foreach($refundrequestreportsdata as $data)
				 
				<tr>
					<td>{{$i++}}</td>
					<td>{{$data->type}}</td>
					<td>
					            <span>User Code:</span> {{$data->user_code}}<br>
			                    <span>Name:</span> {{$data->name}}<br>
			                    <span>Email:</span> {{$data->email}}<br>
			                    <span>Mobile:</span> {{$data->mobile}}<br>
			                    <span>Gender:</span> {{$data->gender}}<br>
			                    <span>DOB:</span> {{$data->dob}}<br>
			                    <span>City:</span> {{$data->city}}<br>
			                    <span>Postcode:</span> {{$data->postcode}}<br>
			                    <span>Address:</span> {{$data->address}}<br>
					</td>
					<td>
					            <span>Code:</span> {{$data->code}}<br>
			                    <span>Title:</span> {{$data->title}}<br>
			                    <span>Description:</span> {{$data->description}}<br>
			                    <span>Budget:</span> {{$data->budget}}<br>
			                    <span>Postal Code:</span> {{$data->postal_code}}<br>
			                    <span>City:</span> {{$data->city}}<br>
			                    <span>Address:</span> {{$data->address}}<br>
			                    <span>Date:</span> {{$data->date}}
					</td>
					<td>{{$data->reason}}</td>
					<td>{{$data->solution}}</td>
					<td>{{$data->date}}</td>
					
						<td><a href="javascript:void[0]" data-id="{{$data->ref_id}}"  data-toggle="modal" data-target="#myModals" class="btn btn-info vstatus">
							Close Ticket
						</a>
                    </td>
				
					
				</tr>
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
          <h4 class="modal-title">Close Ticket</h4>
        </div>
        <div class="modal-body">
         <div class="panel-body">
				@csrf
				    	<div class="form-group col-md-6">
						<label class="control-label">Solution</label>
		        <input type="text" name="solution" class="form-control" data-valdate="required" data-message-required="required">
		        <input type="hidden" id="id">

				</div>
				
					<div class="form-group col-md-6">
						<label class="control-label">Date</label>
		        <input type="date" class="form-control datepicker" data-format="yyyy-mm-dd"  name="log_date_modified"/>
				</div>
				   
				   
		            <div class="form-group col-md-6">
						<button type="button" class="btn btn-success status_change" id="ticket">Submit</button>
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

<script>

$('#ticket').click(function(){
    
        var solution = $('input[name="solution"]').val();
	    var log_date_modified = $('input[name="log_date_modified"]').val();
	    		var id=$("#id").val();

	 
		if(solution!="")
		{
			$.post('{{URL::to("/change-vendor-ticket")}}',{solution:solution,log_date_modified:log_date_modified,id:id,"_token": "{{ csrf_token() }}"},function(data){
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
		$('.vstatus').click(function(){
	    var id = $(this).attr("data-id");
	    //alert(id);exit;
	    $("#id").val(id);
	})
</script>    
    
</script>

</body>
</html>


