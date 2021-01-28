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
<h2>Service Details</h2>
		<br/>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-options">
					</div>
			</div>
			 @if($editpendingtasksdata->count()>0)
		     @foreach($editpendingtasksdata as $task_status)
		     
			<div class="panel-body">
						
			<div class="row">
			
			<div class="col-md-6">
			<div class="orderInfo">
			<h4><B>USER INFO</B></h4>
			
			<ul>
	       	<li><span>User:</span> {{$task_status->name}} </li>
			<li><span>Email:</span> {{$task_status->email}} </li>
			<li><span>Gender:</span> {{$task_status->gender}} </li>
			<li><span>Dob:</span> {{$task_status->dob}} </li>
			<li><span>City:</span> {{$task_status->city}} </li>
			<li><span>Postcode:</span> {{$task_status->postcode}} </li>
			<li><span>Address:</span> {{$task_status->address}} </li>
			
			
		
			</ul>
			
			</div>
			</div>
			
 @if($taskdata->count()>0)
		     @foreach($taskdata as $task)
				<div class="col-md-6">
			<div class="orderInfo">
			<h4><B>SERVICE INFO</B></h4>
			
			<ul>
	       	<li><span>Category:</span> {{$task->cat_name}} </li>
	        <li><span>Budget:</span> {{$task->budget}} </li>
	       	<li><span>Postal Code:</span> {{$task->postal_code}} </li>
	       	<li><span>City:</span> {{$task->city}} </li>
	       	<li><span>Address:</span> {{$task->address}} </li>
	       	<li><span>Landmark:</span> {{$task->land_mark}} </li>
	       	<li><span>Date:</span> {{$task->date}} </li>
	       	<li><span>Time:</span> {{$task->time}} </li>
		
			
			
		
			</ul>
			
			</div>
			</div>
			@endforeach
		    @endif



			</div>
						
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