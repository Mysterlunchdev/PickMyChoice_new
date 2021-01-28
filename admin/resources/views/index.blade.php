@include('layouts.header')
<script>
		
		function getRandomInt(min, max)
		{
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}
		</script>
		
		
		<div class="row">
		    
			<div class="col-sm-3 col-xs-6">
			    
			   @php
				 $i=1;
				 $custcount=$customerdata1->count();
				@endphp

		          <div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-users"></i></div>
					<div class="num" data-start="0" data-end="{{$custcount}}" data-postfix="" data-duration="1500" data-delay="0">{{$custcount}}</div>
		        <h3>customer</h3>
				</div>
				
			 </div>
		    
			
				<div class="col-sm-3 col-xs-6">
				@php
				 $i=1;
				 $custcount1=$customerdata2->count();
				@endphp
		         <div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-users"></i></div>
					<div class="num" data-start="0" data-end="{{$custcount1}}" data-postfix="" data-duration="1500" data-delay="0">{{$custcount1}}</div>
		             <h3>vendor</h3>
				</div>
		       </div>
		
			<div class="col-sm-3 col-xs-6">
			    	@php
				 $i=1;
				 $custcount2=$taskdata1->count();
				@endphp
				
					<?php
				  $i=0;
         foreach($taskdata1 as $das)
          {
             $date1=date('Y-m-d H:i:s');
             $date2= date('Y-m-d H:i:s',strtotime($das->log_date_created));
             $seconds = strtotime($date1) - strtotime($date2);
             $hours = $seconds / 60 /  60;
             $hours= round($hours,0).'<br>';
             if($hours<=24)
             {
                $i++; 
             }
           }
				?>
		        <div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-chart-bar"></i></div>
					<div class="num" data-start="0" data-end="{{$i}}" data-postfix="" data-duration="1500" data-delay="600">{{$i}}</div>
		            <h3>Services Posted</h3>
					<p>Last 24hrs.</p>
				</div>
	    	</div>
		
			<div class="col-sm-3 col-xs-6">
		        @php
				 $i=1;
				 $custcount6=$acceptedtasksdata1->count();
				@endphp
				
					<?php
				  $i=0;
         foreach($acceptedtasksdata1 as $das)
          {
             $date1=date('Y-m-d H:i:s');
             $date2= date('Y-m-d H:i:s',strtotime($das->log_date_created));
             $seconds = strtotime($date1) - strtotime($date2);
             $hours = $seconds / 60 /  60;
             $hours= round($hours,0).'<br>';
             if($hours<=24)
             {
                $i++; 
             }
           }
			?>	
			<div class="tile-stats tile-blue">
					<div class="icon"><i class="entypo-mail"></i></div>
					<div class="num" data-start="0" data-end="{{$i}}" data-postfix="" data-duration="1500" data-delay="1200">$i</div>
		
					<h3>Services Accepted</h3>
					<p>Last 24hrs.</p>
				</div>
		
			</div>
			
				<div class="col-sm-3 col-xs-6">
		        @php
				 $i=1;
				 $custcount5=$rejectedtasksdata1->count();
				@endphp
				<div class="tile-stats tile-blue">
					<div class="icon"><i class="entypo-mail"></i></div>
					<div class="num" data-start="0" data-end="{{$custcount5}}" data-postfix="" data-duration="1500" data-delay="1200">{{$custcount5}}</div>
		
					<h3>Services Rejected</h3>
					<p>Last 24hrs.</p>
				</div>
		
			</div>
		
		<div class="col-sm-3 col-xs-6">
		       @php
				 $i=1;
				 $custcount4=$startedtasksdata1->count();
				@endphp
				
			<?php
				  $i=0;
         foreach($startedtasksdata1 as $das)
          {
             $date1=date('Y-m-d H:i:s');
             $date2= date('Y-m-d H:i:s',strtotime($das->log_date_created));
             $seconds = strtotime($date1) - strtotime($date2);
             $hours = $seconds / 60 /  60;
             $hours= round($hours,0).'<br>';
             if($hours<=24)
             {
                $i++; 
             }
           }
				?>
				<div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-mail"></i></div>
					<div class="num" data-start="0" data-end="{{$i}}" data-postfix="" data-duration="1500" data-delay="1200">{{$i}}</div>
		
					<h3>Services Started</h3>
					<p>Last 24hrs.</p>
				</div>
		
			</div>
			
		<div class="col-sm-3 col-xs-6">
			    @php
				 $i=1;
				 $custcount3=$completedtasksdata1->count();
				@endphp
				
				<?php
				  $i=0;
         foreach($completedtasksdata1 as $das)
          {
             $date1=date('Y-m-d H:i:s');
             $date2= date('Y-m-d H:i:s',strtotime($das->log_date_created));
             $seconds = strtotime($date1) - strtotime($date2);
             $hours = $seconds / 60 /  60;
             $hours= round($hours,0).'<br>';
             if($hours<=24)
             {
                $i++; 
             }
           }
				?>
				<div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-mail"></i></div>
					<div class="num" data-start="0" data-end="{{$i}}" data-postfix="" data-duration="1500" data-delay="1200">{{$i}}</div>
		
					<h3>Services Completed</h3>
					<p>Last 24hrs.</p>
				</div>
		
			</div>
				<div class="col-sm-3 col-xs-6">
		          @php
				 $i=1;
				 $custcount4=$paidtasksdata1->count();
				@endphp
				
					<?php
				  $i=0;
         foreach($paidtasksdata1 as $das)
          {
             $date1=date('Y-m-d H:i:s');
             $date2= date('Y-m-d H:i:s',strtotime($das->log_date_created));
             $seconds = strtotime($date1) - strtotime($date2);
             $hours = $seconds / 60 /  60;
             $hours= round($hours,0).'<br>';
             if($hours<=24)
             {
                $i++; 
             }
           }
				?>
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-mail"></i></div>
					<div class="num" data-start="0" data-end="{{$i}}" data-postfix="" data-duration="1500" data-delay="1200">{{$i}}</div>
		
					<h3>Services Paid</h3>
					<p>Last 24hrs.</p>
				</div>
		
			</div>
		
		</div>
		
		<br />
		
	
		<br />
		
		<br />
		
		<script type="text/javascript">
			// Code used to add Todo Tasks
			jQuery(document).ready(function($)
			{
				var $todo_tasks = $("#todo_tasks");
		
				$todo_tasks.find('input[type="text"]').on('keydown', function(ev)
				{
					if(ev.keyCode == 13)
					{
						ev.preventDefault();
		
						if($.trim($(this).val()).length)
						{
							var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
							$(this).val('');
		
							$todo_entry.appendTo($todo_tasks.find('.todo-list'));
							$todo_entry.hide().slideDown('fast');
							replaceCheckboxes();
						}
					}
				});
			});
		</script>
		
	
		@include('layouts.footer')