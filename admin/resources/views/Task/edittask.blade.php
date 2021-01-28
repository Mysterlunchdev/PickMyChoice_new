@include('layouts.header')
<?php $hist = array(); ?>
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
			 @if($taskdata->count()>0)
		     @foreach($taskdata as $task)
		     
			<div class="panel-body">
						
			<div class="row">
			
			<div class="col-md-6">
			<div class="orderInfo">
			<h4><B>USER INFO</B></h4>
			
			<ul>
	       	<li><span>User:</span> {{$task->user_name}} </li>
			<li><span>Code:</span> {{$task->code}}</li>
			<li><span>Category:</span> {{$task->cat_name}} </li>
			<li><span>Subcategory:</span> {{$task->name}}</li>
			<li><span>Description:</span><?php echo strip_tags($task->description); ?> </li>
		
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
		<?php $hist = LayoutHelper::fetch_quote_history($taskdata[0]->taskid);  ?>
		</div>
		 <table class="table table-bordered table-striped datatable" id="table-2">
		   <h4><B> QUOTE</B></h4>
			<thead>
				<tr>
					<th>S.No</th>
				    <th>Vendor</th>
					<th>Amount</th>
				    <th>Date</th>
					<th>Status</th>
					
				</tr>
				
			</thead>
			<tbody>
				@php
				 $i=1;
				@endphp
			
				@if($taskquotedata->count()>0)
				 @foreach($taskquotedata as $data)
				 
				<tr>
					<td>{{$i++}}</td>
					<td>{{$data->username}}</td>
					<td>{{$data->amount}}</td>
					<td>{{$data->date}}</td>
					<td><a href="javascript:void[0]" onclick="{{$data->status}}('{{$data->id}}','I')" data-toggle="modal" data-target="#myModals" class="btn btn-info">
							{{$data->status}}
						</a>
						@if($data->status=='Accepted')
						<a href="javascript:void[0]"  data-toggle="modal" data-target="#view_data" class="btn btn-success">
							View Details
						</a>
						

						@endif
                    </td>
				
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
          <h4 class="modal-title">Quote Status</h4>
        </div>
        <div class="modal-body">
         <div class="panel-body">
				@csrf
				    <div class="form-group col-md-6">
					<label class="control-label">Status</label>
		                <select name="status" class="form-control" data-valdate="required" data-message-required="required">
	                   
		                   <option value='Active'>Active</option>
						   <option value='Inactive'>Inactive</option>
						   <option value='Accepted'>Accepted</option>
						   <option value='Rejected'>Rejected</option>
		                 
						  </select>
		           </div>
				   
				<div class="form-group col-md-6">
						<label class="control-label">Date</label>
		        <input type="date" class="form-control datepicker" data-format="yyyy-mm-dd"  name="log_date_modified"/>
				</div>
				   
		            <div class="form-group col-md-6">
						<button type="button" class="btn btn-success status_change">Submit</button>
						<button type="reset" class="btn">Reset</button>
					</div>
		    </div>
			 </div>
        </div>
     </div>
  </div>


  <div class="modal fade" id="view_data" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Quote Details</h4>
        </div>
        <div class="modal-body">
         <div class="panel-body">
         		<table class="table table-responsive">
         			<thead>
         				<tr>
         					<th>Status</th>
         					<th>Date time</th>
         				</tr>
         			</thead>
         			<tbody>
         			    @php $j=1;@endphp
         				@if($hist->count()>0)
         				@foreach($hist as $h)
         				
         				
         			    <?php
         			      if($h->status=='Started')
         			      {
         			         $date11 = date('Y-m-d H:i:s',strtotime($h->date));
         			      }
         			      
         			      if($h->status=='Completed')
         			      {
         			          $date21 = date('Y-m-d H:i:s',strtotime($h->date));
         			          
         			          $to_time = strtotime($date21);
                              $from_time = strtotime($date11);
                               

                              echo 'Spent time (in Minutes) <b>'.round(($to_time - $from_time) / 60).'</b><br>';
         			      }
         			      
         			     
         			    ?>
         				<tr>
         					<td>
         						{{$h->status}} on
         					</td>
         					<td>
         						{{$h->date}}
         					</td>
         				</tr>
         				@php $j++ @endphp
         				@endforeach
         				@endif
         				
         			</tbody>
         		</table>
				   
		    
		    </div>
			 </div>
        </div>
     </div>
  </div>
		   
		  
		 <table class="table table-bordered table-striped datatable" id="table-2">
		   <h4><B> PAYMENT </B></h4>
			<thead>
				<tr>
					<th>S.No</th>
					<th>User</th>
					<th>Amount</th>
					<th>Waived Amount</th>
					<th>Commission</th>
					<th>Paid Date</th>
					<th>Payment Status</th>
				    <th>Date</th>
					
				</tr>
				
			</thead>
			<tbody>
				@php
				 $i=1;
				@endphp
			
				@if($taskpaymentdata->count()>0)
				 @foreach($taskpaymentdata as $data)
				 
				<tr>
					<td>{{$i++}}</td>
					<td>{{$data->user_id}}</td>
					<td>{{$data->task_id}}</td>
					<td>{{$data->amount}}</td>
					<td>{{$data->waived_amount}}</td>
					<td>{{$data->commission}}</td>
					<td>{{$data->paid_date}}</td>
					<td>{{$data->payment_status}}</td>

				
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
<script>
$('.status_change').click(function(){
	   
		var status = $('select[name="status"] option:selected').val();
        var log_date_modified = $('input[name="log_date_modified"]').val();
		
		
		if(log_date_modified!="")
		{
			$.post('{{URL::to("/change-order-status")}}',{status:status,log_date_modified:log_date_modified},function(data){
				if(data==1)
				{
					window.location.reload();
				}
				else
				{
					alert('Data updated');
					window.location.reload();
				}
			})
		}
	})
</script>
</body>
</html>