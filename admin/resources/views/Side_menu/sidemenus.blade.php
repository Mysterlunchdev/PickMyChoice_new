@include('layouts.header')

		<a href="{{URL::to('add-side-menus')}}" class="btn btn-primary">
			<i class="entypo-plus"></i>
			Add Side Menu
		</a>
		

		<br>
		<br>
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Main Menu</th>
					<th>Side Menu Name</th>
					<th>status</th>
					<th>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($sidemenu->count()>0)
				 @foreach($sidemenu as $data)

				 <tr>
					<td>{{$i++}}</td>
					<td>{{$data->name}}</td>
					<td>{{$data->side_menu}}</td>
					<td>
						@if($data->sstatus=="Active")
						 <span class="label label-success">Active</span>
						@else
						 <span class="label label-danger">InActive</span>
						@endif
					</td>
					<td>
						
						<a href="{{URL::to('edit-side-menus',base64_encode($data->sid))}}" class="btn btn-default btn-sm btn-icon icon-left">
							<i class="entypo-pencil"></i>
							Edit
						</a>
						
						
						
						<a href="javascript:void[0]" onclick="changestatus('{{$data->sid}}','')" class="btn btn-danger btn-sm btn-icon icon-left">
							<i class="entypo-cancel"></i>
							Delete
						</a>
						

						
						@if($data->sstatus=="Active")
						 <a href="javascript:void[0]" onclick="changestatus('{{$data->sid}}','I')" class="btn btn-info btn-sm btn-icon icon-left">
							<i class="entypo-info"></i>
							change status
						</a>
						@else
						 <a href="javascript:void[0]" onclick="changestatus('{{$data->sid}}','A')" class="btn btn-info btn-sm btn-icon icon-left">
							<i class="entypo-info"></i>
							change status
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
				$.post("{{URL::to('/changestatus')}}",{ai:ai,s:s,t:'sm'},function(response){
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


	<!-- JavaScripts initializations and stuff -->
	<script src="{{URL::asset('assets/js/neon-custom.js')}}"></script>


	<!-- Demo Settings -->
	<script src="{{URL::asset('assets/js/neon-demo.js')}}"></script>

	<script type="text/javascript">
		$("#table-2").dataTable();
	</script>
	
	
	</body>
</html>

