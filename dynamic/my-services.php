<?php
include_once("session_exist.php");
include("header.php");
?>
	<section class="ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="my-acount">
						<div class="row">
							<div class="col-md-3">
								
								<?php include("user-left-nav.php"); ?>
							</div>
							<div class="col-md-9">
								<div class="ma-right">
									<div class="my-task-list">
										<ul class="nav nav-pills" role="tablist">
											<li class="nav-item"> <a class="nav-link active" id="All" data-toggle="pill" href="#all">All</a> </li>
											<li class="nav-item"> <a class="nav-link" id="Pending" data-toggle="pill" href="#inprocess">Pending</a> </li>
											<li class="nav-item"> <a class="nav-link" id="Accepted" data-toggle="pill" href="#accepted">Accepted</a> </li>
											<li class="nav-item"> <a class="nav-link" id="Paid" data-toggle="pill" href="#paid">Paid</a> </li>
											<li class="nav-item"> <a class="nav-link" id="Completed" data-toggle="pill" href="#completed">Completed</a> </li>
											
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div id="all" class="container tab-pane active">
												<div class="row">
													<div class="col-md-12">
													<?php
										            $servicedata=$common_model->fetch_all_services_data($user_id);
													if(sizeof($servicedata))
													{
														for($s=0;$s<sizeof($servicedata);$s++)
														{
															//echo $s;
															$taskdata=$servicedata[$s];
															$taskid=$taskdata['tid'];
															$taskuser_id=$taskdata['user_id'];
															$taskcode=$taskdata['code'];
															$tasktitle=$taskdata['title'];
															$taskcategory_id=$taskdata['category_id'];
															$tasksub_category_id=$taskdata['sub_category_id'];
															$taskdescription=$taskdata['description'];
															$taskbudget=$taskdata['budget'];
															$taskpostal_code=$taskdata['postal_code'];
															$taskcity=$taskdata['city'];
															$taskaddress=$taskdata['address'];
															$taskland_mark=$taskdata['land_mark'];
										
															$taskdate=$taskdata['date'];
															$edittaskdate=date('Y-m-d G:i:s',strtotime($taskdate));
															$tasktime=$taskdata['time'];
															$edittasktime=substr($tasktime,0,-3);
															$taskverified=$taskdata['verified'];
															$taskstatus=$taskdata['status'];
															 $tasklog_date_created=$taskdata['log_date_created'];
															$taskis_negotiated=$taskdata['is_negotiate'];
															$taskcname=$taskdata['cname'];
															$tasksub_name=$taskdata['sub_name'];
														 $subcatimg=$taskdata['sattachment'];
														 
														 $quotlist=$common_model->fetch_all_quotes($user_id,$taskid);
														
															
															$tasklocation=$taskaddress.', '.$taskcity;
															
															$gttaskdate=$taskdate.$tasktime;
															 $createdate= date('Y-m-d G:i:s', strtotime($tasklog_date_created));
															 
															 $taskdatetime= date('Y-m-d G:i:s', strtotime($gttaskdate)); 
															 
							$gettasksts=$common_model->fetch_task_status($taskid,$taskuser_id);
															 $tasksts=$gettasksts[0]['status'];
														     if($tasksts!="")
															 {
																 if($tasksts=="Started")
																 {
																	$tasksts="Paid"; 
																 }
																 $newtasksts=$tasksts;
															 }
															 else
															 {
																 $newtasksts='Not Assigned';
																  $wr=" 1=1 and task_id='$taskid'";
																 $assignid=$common_model->fetch_one_column('task_assigned','id',$wr);
																 if($assignid!="")
																 {
																	$newtasksts='Pending'; 
																 }
															 }
															 
															 if($tasksts=='Pending' || $newtasksts=='Pending' || $newtasksts=='Not Assigned')
															 {
																 $pendingdata[]=$taskdata;
																 $divclass="task_inprocess";
																 
															 }
															 
															 if($tasksts=='Accepted')
															 {
																 $accepteddata[]=$taskdata;
																 $divclass="task_accepted";
															 }
															 if($tasksts=='Paid' || $tasksts=='Started')
															 {
																 $paiddata[]=$taskdata;
																 $divclass="task_paid";
															 }
															 if($tasksts=='Completed')
															 {
																 $completddata[]=$taskdata;
																 $divclass="task_completed";
															 }
															 
															 
															  $taskstslogdate=$gettasksts[0]['date'];
															 
															 $taskstslogdateformat= date('Y-m-d G:i:s', strtotime($taskstslogdate));
															 
															 $cataskstsvendorid=$gettasksts[0]['vendor_id'];
														$cataskststaskid=$gettasksts[0]['task_id'];
															 
															 
													
													?>
														<div class="task_card  flex-wrap <?php echo $divclass; ?>">
														    
														    
														    <div class="task_service_top_block d-flex w-100">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
										<a href="#"><img src="../uploads/subcategory/<?php echo $subcatimg; ?>"></a>
																	<button class="task_sc"><?php echo $tasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $taskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $tasktitle; ?> </a>
																		<p><?php echo substr($taskdescription,0,100); ?> </p>
																	</div>
																</div>
															
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $createdate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $taskdatetime; ?></span> <span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $taskbudget; ?> </span> </div>
																<div class="task_menu_list">
																<?php
																
																if($newtasksts=='Pending' || $newtasksts=='Not Assigned')
																{
																
																?>
																	
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> <?php echo $newtasksts; ?>
																	
																
																	
																	</h6>
																	<div class="clearfix"></div>
																	<?php
																	if($newtasksts=='Pending')
																	{
																	?>
																	<ul>
																		<li> <a href="quotations.php?tid=<?php echo base64_encode($taskid); ?>"><i class="flaticon-budget"></i>View Quotes
																		<?php
																		if(sizeof($quotlist)>0)
																		{
																		}
																		else
																		{
																		?>
																		<br>
																		<span style='color:red;font-size:11px;'>No Quotes</span>
																		<?php
																		}
																		?>
																		</a></li>
																	
														         	</ul>
																	
														
																	<?php
																	}
																
																}
																else if($newtasksts=='Completed')
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Completed	
																	</h6> <span class="status_text"> On <?php echo $taskstslogdateformat;?></span>
																	<div class="clearfix"></div>
																	<ul>
																	    <?php
																	    $reviews = $common_model->get_see_reviews($cataskstsvendorid,$cataskststaskid);
																	    	 
																	        if(count($reviews)>0){  
																	            
																	           
																	        }
																	        else{
																	            ?>
																	            <li> <a data-toggle="modal" data-target=".Review_Popup" onClick="getVendorReviewDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-review"></i>Write a review</a></li>
																	            <?php
																	            }
																	    	    ?>
																	    
																		
																	
																	</ul>
																	<?php
																}
																
																
																else if($newtasksts=='Paid')
																{
																	?>
																		<h6 class="task_sch_status"> <i class="fas fa-circle"></i>paid</h6>
	
																	<div class="clearfix"></div>
																		<ul>
																		<!--<li> <a data-toggle="modal" data-target=".Review_Popup" onClick="getVendorReviewDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-review"></i>Write a review</a></li>-->
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	
																	<ul>
																	    <?php
																	    $reviews = $common_model->get_see_reviews($cataskstsvendorid,$cataskststaskid);
																	    	 
																	      ?> 
								
																	</ul>
																	<?php
																}
																
																
																else if($newtasksts=='Accepted')
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Accepted</h6> <span class="status_text"> On <?php echo $taskstslogdateformat; ?></span>
																	<div class="clearfix"></div>
																	<ul>
																		<li> <a data-toggle="modal" data-target=".Payment_Popup" onClick="getVendorDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-credit-card"></i> pay now </a></li>
																	
																	<?php
																}
																
																	?>
																</div>
															</div>
															</div>
															 <div class="task_service_bottom_block d-flex w-100">
															     <div class="row">
															         
															         <div class="col-sm-6">
															             
															             	<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $tasklocation ?></h4> </div>
															         </div>
															         
															          
															         <div class="col-sm-6">
															             
															             
															             
															             
															             	<div class="task_menu_list">
																<?php
																
																if($newtasksts=='Pending' || $newtasksts=='Not Assigned')
																{
																
																?>
																	
															
																	<ul>
																		
																		
																		<li> <a data-toggle="modal" data-target=".ServiceEdit_Popup" onClick="getServiceDetails('<?php echo $taskid; ?>','<?php echo $edittaskdate; ?>','<?php echo $edittasktime; ?>')"><i class="flaticon-edit-1"></i>Edit</a></li>
																		<li> <a data-toggle="modal" data-target=".Delete_Service" onClick="getServiceId('<?php echo $taskid; ?>')"><i class="flaticon-delete"></i>Delete</a></li>
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $taskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																		
																	
																	
																	</ul>
																	<?php
																}
																else if($newtasksts=='Completed')
																{
																	?>
																
																	<ul>
																	    <?php
																	    $reviews = $common_model->get_see_reviews($cataskstsvendorid,$cataskststaskid);
																	    	
																	    	    ?>
																	    
																		
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																else if($newtasksts=='Accepted')
																{
																	?>
																
																	<ul>
																	
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																/*else if($newtasksts=='Paid')
																{
																	?>
													               
												
																	<ul>
																		
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																
																	<?php
																}*/
																	?>
																</div>
															     
															             
															             
															         </div>
															     </div>
															     
															     
															 </div>
															
															
														</div>
														
														<?php
														}
													}
													else
        											{
        												echo "Services Not Found";
        											}
													
														?>
														
													</div>
												</div>
											</div>
											<div id="inprocess" class="container tab-pane fade">
											<?php
											if(sizeof($pendingdata)>0)
											{
												for($p=0;$p<sizeof($pendingdata);$p++)
												{
													$ptaskdata=$pendingdata[$p];
															$ptaskid=$ptaskdata['tid'];
															$ptaskuser_id=$ptaskdata['user_id'];
															$ptaskcode=$ptaskdata['code'];
															$ptasktitle=$ptaskdata['title'];
															$ptaskcategory_id=$ptaskdata['category_id'];
															$ptasksub_category_id=$ptaskdata['sub_category_id'];
															$ptaskdescription=$ptaskdata['description'];
															$ptaskbudget=$ptaskdata['budget'];
															$ptaskpostal_code=$ptaskdata['postal_code'];
															$ptaskcity=$ptaskdata['city'];
															$ptaskaddress=$ptaskdata['address'];
															$ptaskland_mark=$ptaskdata['land_mark'];
															$ptaskdate=$ptaskdata['date'];
															$pedittaskdate=date('Y-m-d G:i:s',strtotime($ptaskdate));
															$ptasktime=$ptaskdata['time'];
															$pedittasktime=substr($ptasktime,0,-3);
															$ptaskverified=$ptaskdata['verified'];
															$ptaskstatus=$ptaskdata['status'];
															 $ptasklog_date_created=$ptaskdata['log_date_created'];
															$ptaskis_negotiated=$ptaskdata['is_negotiate'];
															$ptaskcname=$ptaskdata['cname'];
															$ptasksub_name=$ptaskdata['sub_name'];
														 $psubcatimg=$ptaskdata['sattachment'];
															
															$ptasklocation=$ptaskaddress.', '.$ptaskcity;
															
															$pgttaskdate=$ptaskdate.$ptasktime;
															 $pcreatedate= date('Y-m-d G:i:s', strtotime($ptasklog_date_created));
															 
															 $ptaskdatetime= date('Y-m-d G:i:s', strtotime($pgttaskdate)); 
															 
							                                 $pgettasksts=$common_model->fetch_task_status($ptaskid,$ptaskuser_id);
															 $ptasksts=$pgettasksts[0]['status'];
														     if($ptasksts!="")
															 {
																 $pnewtasksts=$ptasksts;
															 }
															 else
															 {
																 $pnewtasksts='Not Assigned';
																 $wr=" 1=1 and task_id='$ptaskid'";
																 $assignid=$common_model->fetch_one_column('task_assigned','id',$wr);
																 if($assignid!="")
																 {
																	$pnewtasksts='Pending'; 
																 }
															 }
															 
															 $quotlist=$common_model->fetch_all_quotes($user_id,$ptaskid);
															 
															 
															  $cataskstsvendorid=$pgettasksts[0]['vendor_id'];
														$cataskststaskid=$pgettasksts[0]['task_id'];
															 
															 
															 
															 
												
											?>
											<div class="task_card  flex-wrap task_inprocess">
											    
											    <div class="task_service_top_block d-flex w-100">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
										<a href="#"><img src="../uploads/subcategory/<?php echo $psubcatimg; ?>"></a>
																	<button class="task_sc"><?php echo $ptasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $ptaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $ptasktitle; ?> </a>
																		<p><?php echo substr($ptaskdescription,0,100); ?> </p>
																	</div>
																</div>
															
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $pcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $ptaskdatetime; ?></span> <span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $ptaskbudget; ?> </span> </div>
																<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> <?php echo $pnewtasksts; ?>
																	
																
																	
																	</h6>
																	<div class="clearfix"></div>
																	<ul>
																		<li> <a href="quotations.php?tid=<?php echo base64_encode($ptaskid); ?>"><i class="flaticon-budget"></i> Quotes <?php
																		if(sizeof($quotlist)>0)
																		{
																		}
																		else
																		{
																		?>
																		</br>			
																		<span style='color:red;font-size:11px;'>No Quotes</span>
																		<?php
																		}
																		?></a></li>
																	</ul>
																	
																
																</div>
															</div>
													</div>
													
													<div class="task_service_bottom_block d-flex w-100">
													    
													    <div class="row">
													        
													        <div class="col-sm-6">
													            
													            	<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $ptasklocation ?></h4> </div>
													        </div>
													        
													           <div class="col-sm-6">
													            
													            
													            <div class="task_menu_list">
													                
													                	<ul>
																		
																		
																		<li> <a data-toggle="modal" data-target=".ServiceEdit_Popup" onClick="getServiceDetails('<?php echo $ptaskid; ?>','<?php echo $pedittaskdate; ?>','<?php echo $pedittasktime; ?>')"><i class="flaticon-edit-1"></i>Edit</a></li>
																		<li> <a data-toggle="modal" data-target=".Delete_Service" onClick="getServiceId('<?php echo $ptaskid; ?>')"><i class="flaticon-delete"></i>Delete</a></li>
																	
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $ptaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																		
																	</ul>
													                
													                
													            </div>
													        </div>
													        
													    </div>
													    
													    
													    
													    
													    
													    
													    
													    
													    
													    
													    
													    
													</div>
													
													
													
														</div>

<?php
}
											}
											else
											{
												echo "Services Not Found";
											}
?>
											</div>
											<div id="accepted" class="container tab-pane fade"> 
											
											<?php
											if(sizeof($accepteddata)>0)
											{
												for($a=0;$a<sizeof($accepteddata);$a++)
												{
													$ataskdata=$accepteddata[$a];
															$ataskid=$ataskdata['tid'];
															$ataskuser_id=$ataskdata['user_id'];
															$ataskcode=$ataskdata['code'];
															$atasktitle=$ataskdata['title'];
															$ataskcategory_id=$ataskdata['category_id'];
															$atasksub_category_id=$ataskdata['sub_category_id'];
															$ataskdescription=$ataskdata['description'];
															$ataskbudget=$ataskdata['budget'];
															$ataskpostal_code=$ataskdata['postal_code'];
															$ataskcity=$ataskdata['city'];
															$ataskaddress=$ataskdata['address'];
															$ataskland_mark=$ataskdata['land_mark'];
															$ataskdate=$ataskdata['date'];
															$atasktime=$ataskdata['time'];
															$ataskverified=$ataskdata['verified'];
															$ataskstatus=$ataskdata['status'];
															 $atasklog_date_created=$ataskdata['log_date_created'];
															$ataskis_negotiated=$ataskdata['is_negotiate'];
															$ataskcname=$ataskdata['cname'];
															$atasksub_name=$ataskdata['sub_name'];
														 $asubcatimg=$ataskdata['sattachment'];
															
															$atasklocation=$ataskaddress.', '.$ataskcity;
															
															$agttaskdate=$ataskdate.$atasktime;
															 $acreatedate= date('Y-m-d G:i:s', strtotime($atasklog_date_created));
															 
															 $ataskdatetime= date('Y-m-d G:i:s', strtotime($agttaskdate)); 
															 
							$agettasksts=$common_model->fetch_task_status($ataskid,$ataskuser_id);
															 $atasksts=$agettasksts[0]['status'];
															 $ataskstslogdate=$agettasksts[0]['date'];
															 
															 $ataskstslogdateformat= date('Y-m-d G:i:s', strtotime($ataskstslogdate));
															 
														     if($atasksts!="")
															 {
																 $anewtasksts=$atasksts;
															 }
															 else
															 {
																 $anewtasksts='Not Assigned';
															 }
															 
															 $cataskstsvendorid=$agettasksts[0]['vendor_id'];
														$cataskststaskid=$agettasksts[0]['task_id'];
														
												
											?>
											<div class="task_card  task_accepted">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
										<a href="#"><img src="../uploads/subcategory/<?php echo $asubcatimg; ?>"></a>
																	<button class="task_sc"><?php echo $atasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $ataskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $atasktitle; ?> </a>
																		<p><?php echo substr($ataskdescription,0,100); ?> </p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $atasklocation ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $acreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $ataskdatetime; ?></span> <span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $ataskbudget; ?> </span> </div>
																<!--<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Accepted
																	
																		
																	</h6> <span class="status_text"> On <?php echo $ataskstslogdateformat; ?></span>
																	<div class="clearfix"></div>
																</div>-->
																
																<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Accepted</h6> <span class="status_text"> On <?php echo $ataskstslogdateformat; ?></span>
																	<div class="clearfix"></div>
																	<ul>
																		<li > <a data-toggle="modal" data-target=".Payment_Popup" onClick="getVendorDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-credit-card"></i> pay now </a></li>
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																		
																	</ul>
																</div>
																
																
															</div>
														</div>

<?php
}
											}
											else
											{
												echo "Services Not Found";
											}
?>
											</div>
											<div id="paid" class="container tab-pane fade"> 
											
											<?php
											if(sizeof($paiddata)>0)
											{
												for($pc=0;$pc<sizeof($paiddata);$pc++)
												{
													$pcataskdata=$paiddata[$pc];
															$pcataskid=$pcataskdata['tid'];
															$pcataskuser_id=$pcataskdata['user_id'];
															$pcataskcode=$pcataskdata['code'];
															$pcatasktitle=$pcataskdata['title'];
															$pcataskcategory_id=$pcataskdata['category_id'];
															$pcatasksub_category_id=$pcataskdata['sub_category_id'];
															$pcataskdescription=$pcataskdata['description'];
															$pcataskbudget=$pcataskdata['budget'];
															$pcataskpostal_code=$pcataskdata['postal_code'];
															$pcataskcity=$pcataskdata['city'];
															$pcataskaddress=$pcataskdata['address'];
															$pcataskland_mark=$pcataskdata['land_mark'];
															$pcataskdate=$pcataskdata['date'];
															$pcatasktime=$pcataskdata['time'];
															$pcataskverified=$pcataskdata['verified'];
															$pcataskstatus=$pcataskdata['status'];
															 $pcatasklog_date_created=$pcataskdata['log_date_created'];
															$pcataskis_negotiated=$pcataskdata['is_negotiate'];
															$pcataskcname=$pcataskdata['cname'];
															$pcatasksub_name=$pcataskdata['sub_name'];
														 $pcasubcatimg=$pcataskdata['sattachment'];
															
															$pcatasklocation=$pcataskaddress.', '.$pcataskcity;
															
															$pcagttaskdate=$pcataskdate.$pcatasktime;
															 $pcacreatedate= date('Y-m-d G:i:s', strtotime($pcatasklog_date_created));
															 
															 $pcataskdatetime= date('Y-m-d G:i:s', strtotime($pcagttaskdate)); 
															 
							$pcagettasksts=$common_model->fetch_task_status($pcataskid,$pcataskuser_id);
															 $pcatasksts=$pcagettasksts[0]['status'];
															 $pcataskstslogdate=$pcagettasksts[0]['date'];
															 
															 $pcataskstslogdateformat= date('Y-m-d G:i:s', strtotime($pcataskstslogdate));
															 
														     if($pcatasksts!="")
															 {
																 $pcanewtasksts=$pcatasksts;
															 }
															 else
															 {
																 $pcanewtasksts='Not Assigned';
															 }
															 
															 $cataskstsvendorid=$pcagettasksts[0]['vendor_id'];
														$cataskststaskid=$pcagettasksts[0]['task_id'];
															 
												
											?>
											<div class="task_card  task_completed">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
										<a href="#"><img src="../uploads/subcategory/<?php echo $pcasubcatimg; ?>"></a>
																	<button class="task_sc"><?php echo $pcatasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $pcataskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $pcatasktitle; ?> </a>
																		<p><?php echo substr($pcataskdescription,0,100); ?> </p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $pcatasklocation ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $pcacreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $pcataskdatetime; ?></span> <span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $pcataskbudget; ?> </span> </div>
																<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i>paid</h6>
																	<div class="clearfix"></div>
																	<ul>
																		<!--<li> <a data-toggle="modal" data-target=".Review_Popup" onClick="getVendorReviewDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-review"></i>Write a review</a></li>-->
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																</div>
															</div>
														</div>

<?php
}
											}
											else
											{
												echo "Services Not Found";
											}
?>
											</div>
											<div id="completed" class="container tab-pane fade">
<?php
											if(sizeof($completddata)>0)
											{
												for($c=0;$c<sizeof($completddata);$c++)
												{
													$cataskdata=$completddata[$c];
															$cataskid=$cataskdata['tid'];
															$cataskuser_id=$cataskdata['user_id'];
															$cataskcode=$cataskdata['code'];
															$catasktitle=$cataskdata['title'];
															$cataskcategory_id=$cataskdata['category_id'];
															$catasksub_category_id=$cataskdata['sub_category_id'];
															$cataskdescription=$cataskdata['description'];
															$cataskbudget=$cataskdata['budget'];
															$cataskpostal_code=$cataskdata['postal_code'];
															$cataskcity=$cataskdata['city'];
															$cataskaddress=$cataskdata['address'];
															$cataskland_mark=$cataskdata['land_mark'];
															$cataskdate=$cataskdata['date'];
															$catasktime=$cataskdata['time'];
															$cataskverified=$cataskdata['verified'];
															$cataskstatus=$cataskdata['status'];
															 $catasklog_date_created=$cataskdata['log_date_created'];
															$cataskis_negotiated=$cataskdata['is_negotiate'];
															$cataskcname=$cataskdata['cname'];
															$catasksub_name=$cataskdata['sub_name'];
														 $casubcatimg=$cataskdata['sattachment'];
															
															$catasklocation=$cataskaddress.', '.$cataskcity;
															
															$cagttaskdate=$cataskdate.$catasktime;
															 $cacreatedate= date('Y-m-d G:i:s', strtotime($catasklog_date_created));
															 
															 $cataskdatetime= date('Y-m-d G:i:s', strtotime($cagttaskdate)); 
															 
							                                 $cagettasksts=$common_model->fetch_task_status($cataskid,$cataskuser_id);
															 $catasksts=$cagettasksts[0]['status'];
															 $cataskstslogdate=$cagettasksts[0]['date'];
														$cataskstsvendorid=$cagettasksts[0]['vendor_id'];
														$cataskststaskid=$cagettasksts[0]['task_id'];
															 
															 $cataskstslogdateformat= date('Y-m-d G:i:s', strtotime($cataskstslogdate));
															 
														     if($catasksts!="")
															 {
																 $canewtasksts=$catasksts;
															 }
															 else
															 {
																 $canewtasksts='Not Assigned';
															 }
												
											?>
											<div class="task_card  task_completed">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
										<a href="#"><img src="../uploads/subcategory/<?php echo $casubcatimg; ?>"></a>
																	<button class="task_sc"><?php echo $catasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $cataskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $catasktitle; ?> </a>
																		<p><?php echo substr($cataskdescription,0,100); ?> </p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $catasklocation ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $cacreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $cataskdatetime; ?></span> <span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $cataskbudget; ?> </span> </div>
																<!--<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Completed</h6> <span class="status_text"> On <?php echo $cataskstslogdateformat; ?></span>
																	<div class="clearfix"></div>
																	<ul>
																		<li > <a data-toggle="modal" data-target=".Payment_Popup" onClick="getVendorDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-credit-card"></i> pay now </a></li>
																	</ul>
																</div>-->
																
																<div class="task_menu_list">
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Completed 
																	
																		
																	</h6> <span class="status_text"> On <?php echo $cataskstslogdateformat; ?></span>
																	<div class="clearfix"></div>
																	<ul>
																	    <?php
																	    $reviews = $common_model->get_see_reviews($cataskstsvendorid,$cataskststaskid);
																	    	 
																	        if(count($reviews)>0){  
																	            
																	           
																	        }
																	        else{
																	            ?>
																	            <li> <a data-toggle="modal" data-target=".Review_Popup" onClick="getVendorReviewDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-review"></i>Write a review</a></li>
																	            <?php
																	            }
																	    	    ?>
																	    
																		<!--<li> <a data-toggle="modal" data-target=".Review_Popup" onClick="getVendorReviewDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-review"></i>Write a review</a></li>-->
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="getStatusDetails('<?php echo $cataskstsvendorid; ?>','<?php echo $cataskststaskid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																</div>
															</div>
														</div>

<?php
}
											}
											else
											{
												echo "Services Not Found";
											}
?>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
include("footer.php");
?>
	
	<div class="modal fade Service_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<div class="service_info_popup">
						<div class="sip_block">
							<ul>
								
								<li>
									<label>Acepted On</label> <span id="spanacceoted"> 	12-20-2020 12:38 PM
					</span> </li>
					<li>
									<label>paid on</label> <span id="spanpaid" > 	12-20-2020 12:38 PM
					</span> </li>
								<li>
									<label>Completed on </label> <span id="spancompleted"> 	12-20-2020 12:38 PM
					</span> </li>
					
					
								
								<li>
									<label>Mode of Payment</label> <span id="spanmodfpay"> 	Card Amount
					</span> </li>
								<li>
									<label>Amount </label> <span id="spanamtsts"> 2000
					</span> </li>
								<li>
									<label>Trn Ref no</label> <span id="spanamttrno">XBd564985989</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade Payment_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
					
					<div class="payment_popup_block">
					
					<ul>
					<li> <i class="flaticon-user-5"></i> <span id="vfirstspan">Ricky Ponting, 9629221354</span></li>
						<li> <i class="flaticon-technical-support"></i> <span id="vsecondspan">Kithcen Cleaning, MTASKAAKk5486431</span></li>
					
						<li> <i class="flaticon-pin"></i> <span id="vthirdspan" >SW1A 2AA, 10 Downing Street, LONDON.</span></li>
							<li> <i class="flaticon-calendar"></i> <span id="quotdatspan">July,25 2020 10:00 AM</span></li>
					</ul>
					
					
					
					<div class="text-center">
					<button> 
                         
						<span class="pp_amount"> <i class="flaticon-euro"></i> <label id='quotamtspan'>20</label>
						 
						 Total
				
						 </span>
						 
						 <input type="hidden" id="hdnvendid" name="hdnvendid" value="" >
						 <input type="hidden" id="hdntskid" name="hdntskid" value="" >
						 
						 <input type="hidden" id="hdnamt" name="hdnamt" value="" >
						 
<span class="pp_continue" onClick="btnPayment()">
proceed <i class="fa fa-play"></i>

</span>
 
					</button>
					</div>
					</div>
					
				
				</div>
			</div>
		</div>
	</div>
	
		
	<div class="modal fade Review_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="reviewpopclose"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
					<div class="review_popup_block">
					
					<div class="review_user_info">
					<div id="imgspanrew"><img src="images/user-gravtor.jpg"></div>
					
					<h2 id="spanrevname">Mitchell Starc</h2>
				    
					<h4><div id="spancatnamerew">Kitchen Cleaning - </div><span id="spanrewtaskid">MTASK2169416 </span></h4>
					
					<p id="spanaboutrew">dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda... </p>
					</div>
					
			        
					<div class="review_user-form">
					
					<div class="text-center">
					<fieldset class="rating">
    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
    <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
    <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
    <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
    <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
</fieldset>
			</div>		
					
					<textarea placeholder="Write a Review" class="form-control" rows="4" id="textareareview"  name="textareareview"></textarea>
					
					<input type="hidden" id="hdnrewvendorid" name="hdnrewvendorid" value="" >
					<input type="hidden" id="hdnrewtaskid" name="hdnrewtaskid" value="" >
					
					<span id="sparevmsg"></span>
					<input type="submit" class="btn-st" value="Submit Review" onClick="submitReviews()">
					</div>
				
				
				
				</div>
			</div>
		</div>
	</div>
	
	</div>
	
	
	<div class="modal fade details_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<div class="services_full_info services_inprocess" id="replaceserviccedeta">
						<div class="services_info_block">
							<div class="row">
								<div class="col-md-6">
									<h2><i class="flaticon-clipboards-1"></i> Task Information </h2>
									<div class="sib_info sib_task_details">
										<ul>
											<li>
												<label> Service id </label> <span>MSG-98575</span> </li>
											<li>
												<label> title</label> <span>Lorem Ipsum Door Sit Ame</span> </li>
											<li>
												<label>Description</label>
												<p>dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda. dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda.</p>
											</li>
											<li>
												<label>Category</label> <span>Clening services</span> </li>
											<li>
												<label>Subcategory</label> <span>Kithcen Cleaning</span> </li>
											<li>
												<label>Posted on</label> <span>27th Jan 2020 15:22:30</span> </li>
											<li>
												<label>Required on</label> <span>30th Jan 2020 15:22:30</span> </li>
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<div class="sib_image"> <img src="https://hgtvhome.sndimg.com/content/dam/images/hgtv/fullset/2018/4/23/1/HUHH2018-Curb-Appeal_Seattle-WA_11.jpg.rend.hgtvcom.966.644.suffix/1524514638493.jpeg" class="img-responsive"> </div>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-md-4">
								<div class="services_info_block">
									<h2> <i class="flaticon-location-2"></i>Location Information</h2>
									<div class="sib_info">
										<ul>
											<li>
												<label>Postal Code</label> <span>521165</span> </li>
											<li>
												<label> Country</label> <span>United Kingdom</span> </li>
											<li>
												<label>City</label> <span>Manchester</span> </li>
											<li>
												<label>Landmark</label> <span>Clock tower</span> </li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="services_info_block">
									<h2> <i class="flaticon-location-2"></i>Service Status</h2>
									<div class="sib_info">
										<ul>
											<li>
												<label>Acepted On</label> <span>12-20-2020 12:38 PM</span> </li>
											<li>
												<label> Paid On</label> <span>12-20-2020 12:38 PM</span> </li>
												
			
												
											<li>
												<label>Completed On</label> <span>12-20-2020 12:38 PM</span> </li>
										
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="services_info_block">
									<h2> <i class="flaticon-calculator"></i> Payment Information </h2>
									<div class="sib_info">
										<ul>
											<li>
												<label>Amount</label> <span>5000</span> </li>
											<li>
												<label> Mode Of Payment</label> <span>Card Amount</span> </li>
												<li>
												<label> Trn Ref No</label> <span>XBd564985989</span> </li>
										</ul>
									</div>
								</div>
							</div>
							
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade Delete_Service" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="servicedeleteclose"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
					
					<div class="task_delete_popup">
					
					<h4>Are you sure, delete this service?</h4>
					<div class="otp-buttons d-flex">
					<button type="button" id="completebtnyes" name="completebtnyes" onClick="deleteService()" >Yes</button>
							
					<button type="button" id="completebtnyesno" name="completebtnyesno"   data-dismiss="modal" aria-label="Close" >No</button>
					
					<input type="hidden" id="hdndeleteaskid" name="hdndeleteaskid" value="" >
							
					</div>
					
					</div>
					
				
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade ServiceEdit_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
		    
		    <div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
			
				<div class="sq_info_budget">
			
			<div class="form_group">
		 	<label>
			Date 
			</label>
			<span>
			<input type="text" placeholder=""  id="txtservirdate" name="txtservirdate" readonly>
			
			</span>
			
			</div>
			<div class="form_group">
		 	<label>
			Time
			</label>
			<span>
			 <input type="text" placeholder="" id="txtservirtime" name="txtservirtime">
			
			</span>
			
			</div>
			
			<span id="quoteerrmsg" style="color:red"></span>
			<input type="hidden" id="hdneditserviceid" name="hdneditserviceid">
			
			<input type="submit" id="btnquote" name="btnquote" class="btn-st" onclick="submitUpdateService()" value="Update Service">
			
			</div>
			
		
			</div>
		</div>
		
			
	</div>
	
	</div>
	
	
<script>
	<?php
	if($_GET['flag']!='')
	{
		$flag=$_GET['flag'];
		?>
		$(document).ready(function () {
		 $('a#<?php echo $flag;?>').click();
		});
		<?php
	}
	?>
function getVendorDetails(vendor_id,task_id)
{
	if(task_id!='' && vendor_id!='')
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&vendor_id='+vendor_id+'&flag=get_vendor',
			success: function(data)
			{
				//alert(data);
				if(data!='')
				{
					var arr=new Array();
					var arr=data.split('@6256@');
					var name=arr[0];
					var mobile=arr[1];
					var catname=arr[2];
					var taskid=arr[3];
					var address=arr[4];
					var qdate=arr[5];
					var qamount=arr[6];
					var userid=arr[7];
					//alert(userid);
					$('#vfirstspan').html(name+','+mobile);
					$('#vsecondspan').html(catname+','+taskid);
					$('#vthirdspan').html(address);
					$('#quotdatspan').html(qdate);
					$('#quotamtspan').html(qamount);
					$('#hdnvendid').val(vendor_id);
					//$('#hdnuserid').val(userid);
					$('#hdntskid').val(task_id);
					$('#hdnamt').val(qamount);
					
				}
				else
				{
					//$('#quotespan'+quoteid).html(data);
				}
			},
		  
		});
	}
}
function btnPayment()
{
	var vendor_id=$("#hdnvendid").val();
	var task_id=$("#hdntskid").val();
	var amount=$("#hdnamt").val();
	if(vendor_id!="" && task_id!="" && amount!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&vendor_id='+vendor_id+'&amount='+amount+'&flag=payment_submit',
			success: function(data)
			{
				alert(data);
				location.reload();
				
			},
		  
		});
	}
}
function getVendorReviewDetails(vendor_id,task_id)
{
	if(task_id!='' && vendor_id!='')
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&vendor_id='+vendor_id+'&flag=get_vendor',
			success: function(data)
			{
				//alert(data);
				if(data!='')
				{
					var arr=new Array();
					var arr=data.split('@6256@');
					var name=arr[0];
					var mobile=arr[1];
					var catname=arr[2];
					var taskid=arr[3];
					var address=arr[4];
					var qdate=arr[5];
					var qamount=arr[6];
					var userid=arr[7];
					var img=arr[8];
					var about=arr[9];
					//alert(userid);
					$('#imgspanrew').html(img);
					$('#spanrevname').html(name);
					$('#spancatnamerew').html(catname+' - ');
					$('#spanrewtaskid').html(taskid);
					$('#spanaboutrew').html(about);
					
					$('#hdnrewvendorid').val(vendor_id);
					
					$('#hdnrewtaskid').val(task_id);
					
					
				}
				else
				{
					//$('#quotespan'+quoteid).html(data);
				}
			},
		  
		});
	}
}
function submitReviews()
{
	var vendor_id=$('#hdnrewvendorid').val();				
	var task_id=$('#hdnrewtaskid').val();
	//var rating=$('#rating').val();
	var rating=$('input[name="rating"]:checked').val();;
	var review=$('#textareareview').val();
	if(vendor_id!="" && task_id!="" && rating!="" && review!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&vendor_id='+vendor_id+'&rating='+rating+'&review='+review+'&flag=write_review',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					$("#sparevmsg").html(data);
					if(data=="<span style='color:green'>Review Saved Succefully</span>")
					{
					    alert("Review Saved Succefully");
				        location.reload();
					    /*setTimeout(function(){
                           document.getElementById("reviewpopclose").click();
                        }, 1000);*/
					}
				}
				
			},
		  
		});
	}
	
}
function getStatusDetails(vendor_id,task_id)
{
	if(task_id!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&vendor_id='+vendor_id+'&flag=get_task_status',
			success: function(data)
			{
				//alert(data);
				if(data!='')
				{
					/*var arr=new Array();
					var arr=data.split('@6256@');
					var accepted=arr[0];
					var completed=arr[1];
					var paid=arr[2];
					var mode=arr[3];
					var amount=arr[4];
					var refno=arr[5];
					
					$('#spanacceoted').html(accepted);
					$('#spancompleted').html(completed);
					$('#spanpaid').html(paid);
					$('#spanmodfpay').html(mode);
					$('#spanamtsts').html(amount);
					$('#spanamttrno').html(refno);*/
					
					$("#replaceserviccedeta").html(data);
					
					
				}
				else
				{
					//$('#quotespan'+quoteid).html(data);
				}
			},
		  
		});
	}
}
//$('input[name="name_of_your_radiobutton"]:checked').val();

function getServiceId(service_id)
{
    var service_id=service_id;
    $("#hdndeleteaskid").val(service_id);
}

function deleteService()
{
    var service_id=$("#hdndeleteaskid").val();
    if(service_id!='')
    {
        document.getElementById("servicedeleteclose").click();
        $.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+service_id+'&flag=delete_service',
			success: function(data)
			{
				alert(data);
				location.reload();
			},
		  
		});
    }
}

	var dateToday = new Date();     
	$('#txtservirdate').datepicker({
        clearBtn: true,
        minDate: dateToday,
        format: "dd/mm/yyyy"
    });

  $('#txtservirtime').timepicker();
  
  function getServiceDetails(taskid,taskdate,tasktime)
  {
      $("#hdneditserviceid").val(taskid);
      $("#txtservirdate").val(taskdate);
      $("#txtservirtime").val(tasktime);
  }
  function submitUpdateService()
  {
      var update=$("#txtservirdate").val();
      var uptime=$("#txtservirtime").val();
      var task_id=$("#hdneditserviceid").val();
      if(update!="" && uptime!="" && task_id!="")
      {
          $.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&update='+update+'&uptime='+uptime+'&flag=update_service',
			success: function(data)
			{
				alert(data);
				location.reload();
			},
		  
		});
      }
  }
</script>

	