@include('layouts.header')
@if(session()->get('userdata')[0]->department_id==1 || isset($page_access[0]->can_add) && $page_access[0]->can_add==1)
		<a href="{{URL::to('add-settlementreports')}}" class="btn btn-primary">
			<i class="entypo-plus"></i>
			Add 
		</a>
		@endif
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/js/datatables/datatables.css" id="style-resource-1">
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Vendor Details</th>
					<th>Amount Paid</th>
					<th>Waived Amount</th>
					<th>Total Amount</th>
					<th>Commission Amount</th>
					<th>Paid Date</th>
					<th>Transaction No</th>
					<th>Transaction Date</th>
				
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($settlementreportsdata->count()>0)
				 @foreach($settlementreportsdata as $data)
				 
				<tr>
					<td>{{$i++}}</td>
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
					<td>{{$data->amount_paid}}</td>
					<td>{{$data->waived_amount}}</td>
					<td>{{$data->total_amount}}</td>
					<td>{{$data->commission_amount}}</td>
					<td>{{$data->paid_date}}</td>
					<td>{{$data->transaction_no}}</td>
					<td>{{$data->transaction_date}}</td>
					
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


