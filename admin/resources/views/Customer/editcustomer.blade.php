@include('layouts.header')

<style type="text/css">
.orderInfo h4{
	margin-bottom:20px;
}
.orderInfo ul{
	padding-left:0px;
	list-style:none;
}

.orderInfo ul li{
margin-bottom:10px;
font-size:15px;
line-height:21px;
}

.orderInfo ul li span{
	color: #949494;
    font-weight: bold;
	min-width:100px;
	display:inline-block;
}

</style>
<h4>Customer Details</h4>
		<br/>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
			 @if($userdata->count()>0)
		     @foreach($userdata as $user)
		     
			<div class="panel-body">
						
			<div class="row">
			
			<div class="col-md-6">
			<div class="orderInfo">
			<h4><B>CUSTOMER INFO :</B></h4>
			
			<ul>
	       	<li><span>User:</span> {{$user->name}} </li>
			<li><span>Code:</span> {{$user->user_code}}</li>
			<li><span>Email:</span> {{$user->email}} </li>
			<li><span>Mobile:</span> {{$user->mobile}}</li>
			<li><span>Gender:</span> {{$user->gender}} </li>
		
		
			</ul>
			
			</div>
			</div>
			<br>
			<br>
			<div class="col-md-6">
			<div class="orderInfo">
			<ul>
	       
			<li><span>Dob:</span> {{$user->dob}} </li>
			<li><span>City:</span> {{$user->city}} </li>
			<li><span>Postcode:</span> {{$user->postcode}} </li>
	    	<li><span>Address:</span> {{$user->address}} </li>
			<li><span>Date:</span> {{$user->log_date_created}} </li>
		
			</ul>
			
			</div>
			</div>
			
		
			</div>
			
			
			
			
			
						
		</div>
		
		@endforeach
		   @endif
		
		</div>
		
		
		
		<h4>Task Details</h4>
		<br/>
		
		<!--<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
			 @if($taskdata->count()>0)
		     @foreach($taskdata as $task)
		     
			<div class="panel-body">
						
			<div class="row">
			
			<div class="col-md-6">
			<div class="orderInfo">
			<h4><B> INFO</B></h4>
			
			<ul>
	       	<li><span>User:</span> {{$task->user_name}} </li>
			<li><span>Code:</span> {{$task->code}}</li>
			<li><span>Category:</span> {{$task->cat_name}} </li>
			<li><span>Subcategory:</span> {{$task->name}}</li>
			<li><span>Description:</span> {{$task->description}} </li>
		
			</ul>
			
			</div>
			</div>
			
			
			<div class="col-md-6">
			<div class="orderInfo">
			<h4><B> BUDGET INFO </B></h4>
			<ul>
			<li><span>Budget:</span> {{$task->budget}} </li>
			<li><span>Postal Code:</span> {{$task->postal_code}}</li>
			<li><span>Address:</span> {{$task->address,$task->land_mark}}</li>
			<li><span>Date:</span> {{$task->date}} </li>
			</ul>
			</div>
			
		   </div>
		   
			</div>
						
		</div>
		
		@endforeach
		   @endif
		
		</div>-->
		
		<table class="table table-bordered table-striped datatable" id="table-2">
			<thead>
				<tr>
					<th>S.No</th>
					<th>User</th>
					<th>User Code</th>
					<th>Category</th>
					<th>Sub Category</th>
					<th>Budget</th>
                    <th>Postal Code</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Time</th>
				
				</tr>
			</thead>
			
			<tbody>
				@php
				 $i=1;
				@endphp

				@if($taskdata->count()>0)
				 @foreach($taskdata as $task)

				 <tr>
					<td>{{$i++}}</td>
					<td>{{$task->user_name}}</td>
					<td>{{$task->code}}</td>
					<td>{{$task->cat_name}}</td>
					<td>{{$task->name}}</td>
					<td>{{$task->budget}}</td>
					<td>{{$task->postal_code}}</td>
					<td>{{$task->city}}</td>
					<td>{{$task->address}}</td>
					<td>{{$task->date}}</td>
					<td>{{$task->time}}</td>
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