@include('layouts.header')

<style type="text/css">
.orderInfo h4{
	margin-bottom:20px;
}
.orderInfo ul{
	padding-left:0px;
	list-style:none;
}

</style>

		

		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
			<h4><B>VENDOR INFO</B></h4>
				<tr>
					<th>S.No</th>
					<th>Name</th>
					<th>Code</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Gender</th>
					<th>Dob</th>
					<th>City</th>
					<th>Postcode</th>
					
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($userdata->count()>0)
				 @foreach($userdata as $user)

				 <tr>
					<td>{{$i++}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->user_code}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->mobile}}</td>
					<td>{{$user->gender}}</td>
					<td>{{$user->dob}}</td>
					<td>{{$user->city}}</td>
					<td>{{$user->postcode}}</td>
					
			
					
				</tr>

				 @endforeach
				@endif
			</tbody>
		</table>
		
		
		
		
	
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
			<h4><B>UPLOADS</B></h4>
				<tr>
					<th>S.No</th>
					<th>Proof Type</th>
				 	<th>Proof Attachment</th>
				<!-- <th>Profile Photo</th> -->
					
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($user_uploaddata->count()>0)
				 @foreach($user_uploaddata as $user_upload)

				<tr>
					<td>{{$i++}}</td>
					<td>{{$user_upload->file_name}}</td>
				<!--<td><img src="{{URL::asset('../uploads/vendor/'.$user->proof_attachment)}}" style="width:90px;"></td>-->
					<td><img src="{{URL::asset('../uploads/vendor/'.$user_upload->attachment)}}" style="width:90px;"></td>
				</tr>

				 @endforeach
				@endif
			</tbody>
		</table>
		
			
		
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
			<h4><B>BANK DETAILS</B></h4>
				<tr>
					<th>S.No</th>
					<th>Vendor</th>
					<th>Bank Name</th>
					<th>Short Code</th>
					<th>Acoount No</th>
					<th>Branch Address</th>
					
					
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

			@if($bankdetailsdata->count()>0)
		     @foreach($bankdetailsdata as $user_bank_details)

				 <tr>
					<td>{{$i++}}</td>
					<td>{{$user_bank_details->name}}</td>
					<td>{{$user_bank_details->bank_name}}</td>
					<td>{{$user_bank_details->short_code}}</td>
					<td>{{$user_bank_details->ac_no}}</td>
					<td>{{$user_bank_details->branch_address}}</td>
				
			
					
				</tr>

				 @endforeach
				@endif
			</tbody>
		</table>
		
		
	
		
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

</body>
</html>