<?php include("header.php"); ?>
	<section class="ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="my-acount">
						<div class="row">
							<div class="col-md-3">
								<?php include('user-left-nav.php'); ?>
							</div>
							<div class="col-md-9">
								<div class="ma-right">
									<div class="my-task-list">
										<ul class="nav nav-pills" role="tablist">
											<li class="nav-item"> <a class="nav-link active" data-toggle="pill" href="#all">All</a> </li>
											<li class="nav-item"> <a class="nav-link" data-toggle="pill" href="#quote-sent">Quote Sent</a> </li>
										
											<li class="nav-item"> <a class="nav-link" data-toggle="pill" href="#accepted">Accepted</a> </li>
												<li class="nav-item"> <a class="nav-link" data-toggle="pill" href="#inprocess">Rejected</a> </li>
											<li class="nav-item"> <a class="nav-link" data-toggle="pill" href="#completed">Started</a> </li>
											<li class="nav-item"> <a class="nav-link" data-toggle="pill" href="#paid">Completed</a> </li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div id="all" class="container tab-pane active">
												<div class="row">
													<div class="col-md-12">
													<?php
													$asservdata=$common_model->fetch_all_assigned_data($user_id);
													if(sizeof($asservdata)>0)
													{
														for($as=0;$as<sizeof($asservdata);$as++)
														{
															$assigndata=$asservdata[$as];
															$asid=$assigndata['id'];
															$astaskid=$assigndata['task_id'];
															$astaskuserid=$assigndata['user_id'];
															$astaskvendid=$assigndata['vendor_id'];
															$astaskassdate=$assigndata['assigndate'];
															$astaskasstime=$assigndata['assigntime'];
															
															$astaskcode=$assigndata['code'];
															$astasktitle=$assigndata['title'];
															$astaskcode=$assigndata['code'];
															$astaskcatid=$assigndata['category_id'];
															$astasksubcatid=$assigndata['sub_category_id'];
															$astaskdesc=$assigndata['description'];
															$astaskbudget=$assigndata['budget'];
															$astaskpostal_code=$assigndata['postal_code'];
															$astaskcity=$assigndata['city'];
															$astaskaddress=$assigndata['address'];
															$astaskland_mark=$assigndata['land_mark'];
															$astaskdate=$assigndata['date'];
															$astasktime=$assigndata['time'];
															$astaskcredatetime=$assigndata['log_date_created'];
															$astaskis_negotiate=$assigndata['is_negotiate'];
															$astaskcname=$assigndata['cname'];
															$astasksub_name=$assigndata['sub_name'];
															$sattachment=$assigndata['sattachment'];
															
															$gttaskdate=$astaskdate.$astasktime;
															
															$taskcreatedate= date('Y-m-d G:i:s', strtotime($astaskcredatetime));
															
															$taskdatetime= date('Y-m-d G:i:s', strtotime($gttaskdate));
															
															$assign_date = date('Y-m-d G:i:s',strtotime($astaskassdate))." ".$astaskasstime;
															
														  $sts='';
														  $amount='';
														  $status_new='';
														  $status=$common_model->fetch_vendor_task_quote($astaskid,$user_id);
														  if(count($status)>0)
														  {
															   $sts=$status[0]['status'];
															  $amount=$status[0]['amount'];
															  if($sts=='Rejected')
															  {
																  $status_new='Rejected';
																  $rejectedarr[]=$assigndata;
															  }
															  else if($sts=='Accepted')
															  {
																  $status_new='Accepted';
															  }
															  else if($sts=="Active")
															  {
																  
																   $status_new='Quote Send';
															  }
															  else
															  {
																  $status_new='';
															  }
															  $quotedate     = date('Y-m-d G:i:s',strtotime($status[0]['date']));
														  }
														if($sts=='Accepted')
														{
															$status_new1 = $common_model->fetch_vendor_task_status($astaskid,$user_id);
															 if(count($status_new1)>0)
															 {
															   $sts_new=$status_new1[0]['status'];
															  if($sts_new=='Accepted')
															  {
																$status_new='Accepted';
																$acceptedarr[]=$assigndata;
																$divclass="task_accepted";
																  
															  }
															  if($sts_new=='Started')
															  {
																  $status_new='Started';
																  $startedarr[]=$assigndata;
																  $divclass="task_paid";
																  
															  }
															  if($sts_new=='Paid')
															  {
																  //$status_new='Paid';
																  $status_new='Accepted';
																  $acceptedarr[]=$assigndata;
																  $divclass="task_accepted";
																  
															  }
															  if($sts_new=='Completed')
															  { 
																  $status_new='Completed'; 
																  $completedarr[]=$assigndata;
																  $divclass="task_completed";
																  
																  
															  }
															  $statusdatetime= date('Y-m-d G:i:s',strtotime($status_new1[0]['date']));
															 }
														}
														else if($sts=='Rejected')
														{
															$status_new='Rejected';
															$status_new1 = $common_model->fetch_vendor_task_status($astaskid,$user_id);
															if(count($status_new1)>0)
															{
																$statusdatetime= date('Y-m-d G:i:s',strtotime($status_new1[0]['date'])); $divclass="task_rejected"; 
															}
														}
														else if($sts=='Active')
														{
														  $status_new='Quote Send';
														  $quotearr[]=$assigndata;
														  $assignedate = $assign_date;
														  $divclass="task_inprocess";
														}
														else
														{
															$status_new="";
															$divclass="task_inprocess";
														}
														$sattachmentpath="<img src='$sattachment'>";
		  
		  //echo $status_new;
														
													?>
														<div class="task_card  <?php echo $divclass; ?>">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $sattachment; ?>"></a>
																	<button class="task_sc"><?php echo $astasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $astaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $astasktitle; ?> </a>
																		<p><?php echo substr($astaskdesc0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $astaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $taskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $taskdatetime; ?></span><span class="task_sch"> <label>User Quotation</label><i class="flaticon-euro"></i><?php echo $astaskbudget; ?></span>  </div>
																<div class="task_menu_list">
																<?php 
																if($status_new=='Quote Send')
																{
																	?>
																	<div class="vendor_quoted_amount">
																
															 <span class="service_quoted_price">	<i class="flaticon-euro"></i> <label><?php echo $astaskbudget; ?></label></span>
																</div>
																
																<div class="user_quoted_amount">
																	
																<h5>Quoted Amount</h5>																	
																 <span class="service_quoted_price"><i class="flaticon-euro"></i><label><?php echo $amount;?></label></span>
															<span class="status_text"> On <?php echo $quotedate; ?></span>	 
																 	<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																 
																</div>
																
																<!--<div class="vendor_quoted_amount">
																
															 <span class="service_quoted_price"><i class="flaticon-euro"></i> <label><?php echo $astaskbudget; ?></label></span>
																</div>-->
																	<?php
																}
																else if($status_new=="Accepted")
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Accepted
																		
																		
																	</h6> <!--<span class="status_text"> On <?php echo $statusdatetime; ?></span>-->
																	<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	
																	<?php
																	if($sts_new=='Paid')
																	{
																		?>
																		<span class="vendor_quote_btn" data-toggle="modal" data-target=".Start_Service" onClick="sendServiceStartOtp('<?php echo $astaskid; ?>')"  > Start Service</span>
																		
																		<span class="status_text"> Paid On <?php echo $statusdatetime; ?></span>
																			<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																		<?php
																	}
																	else
																	{
																		?>
																		<span class="vendor_quote_btn"  style="background:#d6d0d0" > Start Service</span>
																		<br/>
																		<span style='color:red;font-size:11px;'>Not Paid</span>
																		<?php
																	}
																	?>
																	
																	
																	
																	
																	<div class="clearfix"></div>
																	<?php
																}
																else if($status_new=="Rejected")
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Rejected
																	
																		
																	</h6> <span class="status_text"> On <?php echo $statusdatetime; ?></span>
																	<div class="clearfix"></div>
																	<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																else if($status_new=="Started")
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Started
																	
																		
																	</h6> <!--<span class="status_text"> On <?php echo $statusdatetime; ?></span>-->
																	
																	<span class="vendor_quote_btn" data-toggle="modal" data-target=".Complete_Service" onClick="getcompletServiceId('<?php echo $astaskid; ?>')"> Completed ?</span>
																	
																	<div class="clearfix"></div>
																	<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																else if($status_new=="Completed")
																{
																	?>
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i>Completed</h6>
																	<div class="clearfix"></div>
																	<ul>
																	  <?php
																	    $reviews = $common_model->get_see_reviews($user_id,$astaskid);
																	    	 
																	                if(count($reviews)>0){ 
																	                         ?>
																	                         <li> <a data-toggle="modal" data-target=".Review_Popup" onClick="viewVendorReview('<?php echo $astaskid; ?>')"><i class="flaticon-review"></i>View Review</a></li>
																	           
																	                        
					
																	    	                <?php
																	                         }
																	                         ?>
																	    
																	    
							
																		
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																else
																{
																	?>
																	<div class="vendor_quoted_amount">
																
															 <span class="service_quoted_price"><i class="flaticon-euro"></i> <label><?php echo $astaskbudget; ?></label></span>
																</div>
																
																<span class="vendor_quote_btn send_qte" data-toggle="modal" data-target=".Send_Quotation_Popup" onClick="getTaskDetails('<?php echo $asid; ?>','<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>','<?php echo $astasksub_name; ?>','<?php echo $astaskdesc; ?>','<?php echo $astaskbudget; ?>','<?php echo $astaskis_negotiate; ?>')" > Send Quote</span>
																	<ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $astaskid; ?>','<?php echo $astaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																}
																?>
																
																
																
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
											
											
											<div id="quote-sent" class="container tab-pane fade">
											
											<?php
											//print_r(quotearr);
											if(sizeof($quotearr)>0)
											{
												for($q=0;$q<sizeof($quotearr);$q++)
												{
													$qassigndata=$quotearr[$q];
													$qasid=$qassigndata['id'];
													$qastaskid=$qassigndata['task_id'];
													$qastaskuserid=$qassigndata['user_id'];
													$qastaskvendid=$qassigndata['vendor_id'];
													$qastaskassdate=$qassigndata['assigndate'];
													$qastaskasstime=$qassigndata['assigntime'];
													
													$qastaskcode=$qassigndata['code'];
													$qastasktitle=$qassigndata['title'];
													$qastaskcode=$qassigndata['code'];
													$qastaskcatid=$qassigndata['category_id'];
													$qastasksubcatid=$qassigndata['sub_category_id'];
													$qastaskdesc=$qassigndata['description'];
													$qastaskbudget=$qassigndata['budget'];
													$qastaskpostal_code=$qassigndata['postal_code'];
													$qastaskcity=$qassigndata['city'];
													$qastaskaddress=$qassigndata['address'];
													$qastaskland_mark=$qassigndata['land_mark'];
													$qastaskdate=$qassigndata['date'];
													$qastasktime=$qassigndata['time'];
													$qastaskcredatetime=$qassigndata['log_date_created'];
													$qastaskis_negotiate=$qassigndata['is_negotiate'];
													$qastaskcname=$qassigndata['cname'];
													$qastasksub_name=$qassigndata['sub_name'];
													$qsattachment=$qassigndata['sattachment'];
													
													$qgttaskdate=$qastaskdate.$qastasktime;
													
													$qtaskcreatedate= date('Y-m-d G:i:s', strtotime($qastaskcredatetime));
													
													$qtaskdatetime= date('Y-m-d G:i:s', strtotime($qgttaskdate));
													
													$qassign_date = date('Y-m-d G:i:s',strtotime($qastaskassdate))." ".$qastaskasstime;

													$qstatus_new='Quote Send';
												  
													$qassignedate = $qassign_date;
													//$divclass="task_inprocess";
													
													$sts='';
														  $amount='';
														  $status_new='';
														  $status=$common_model->fetch_vendor_task_quote($qastaskid,$user_id);
														  if(count($status)>0)
														  {
															   $sts=$status[0]['status'];
															  $amount=$status[0]['amount'];
															  if($sts=='Rejected')
															  {
																  $status_new='Rejected';
																  $rejectedarr[]=$assigndata;
															  }
															  else if($sts=='Accepted')
															  {
																  $status_new='Accepted';
															  }
															  else if($sts=="Active")
															  {
																  
																   $status_new='Quote Send';
															  }
															  else
															  {
																  $status_new='';
															  }
															  $quotedate     = date('m-d-Y H:i:s',strtotime($status[0]['date']));
														  }
													
													
													?>
													<div class="task_card  task_inprocess">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $qsattachment; ?>"></a>
																	<button class="task_sc"><?php echo $qastasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $qastaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $qastasktitle; ?> </a>
																		<p><?php echo substr($qastaskdesc,0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $qastaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $qtaskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $qtaskdatetime; ?></span> <span class="task_sch"> <label>Budget Information</label><i class="flaticon-euro"></i><?php echo $qastaskbudget; ?></span> </div>
																<div class="task_menu_list">
																
																	<div class="vendor_quoted_amount">
																
															 <span class="service_quoted_price">	<i class="flaticon-euro"></i> <label><?php echo $qastaskbudget; ?></label></span>
																</div>
																
																<div class="user_quoted_amount">
																	
																<h5>Quoted Amount</h5>																	
																 <span class="service_quoted_price"><i class="flaticon-euro"></i><label><?php echo $amount;?></label></span>
															<span class="status_text"> On <?php echo $quotedate; ?></span>	
																
														
																</div>
																
																    <ul>
																	<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $qastaskid; ?>','<?php echo $qastaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																
																<!--<div class="vendor_quoted_amount">
																
															 <span class="service_quoted_price"><i class="flaticon-euro"></i> <label><?php echo $astaskbudget; ?></label></span>
																</div>-->
																	
																
																
																
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
											if(sizeof($acceptedarr)>0)
											{
												for($ac=0;$ac<sizeof($acceptedarr);$ac++)
												{
													//$accepteddata=$acceptedarr[$ac];
													
													$acassigndata=$acceptedarr[$ac];
													$acasid=$acassigndata['id'];
													$acastaskid=$acassigndata['task_id'];
													$acastaskuserid=$acassigndata['user_id'];
													$acastaskvendid=$acassigndata['vendor_id'];
													$acastaskassdate=$acassigndata['assigndate'];
													$acastaskasstime=$acassigndata['assigntime'];
													
													$acastaskcode=$acassigndata['code'];
													$acastasktitle=$acassigndata['title'];
													$acastaskcode=$acassigndata['code'];
													$acastaskcatid=$acassigndata['category_id'];
													$acastasksubcatid=$acassigndata['sub_category_id'];
													$acastaskdesc=$acassigndata['description'];
													$acastaskbudget=$acassigndata['budget'];
													$acastaskpostal_code=$acassigndata['postal_code'];
													$acastaskcity=$acassigndata['city'];
													$acastaskaddress=$acassigndata['address'];
													$acastaskland_mark=$acassigndata['land_mark'];
													$acastaskdate=$acassigndata['date'];
													$acastasktime=$acassigndata['time'];
													$acastaskcredatetime=$acassigndata['log_date_created'];
													$acastaskis_negotiate=$acassigndata['is_negotiate'];
													$acastaskcname=$acassigndata['cname'];
													$acastasksub_name=$acassigndata['sub_name'];
													$acsattachment=$acassigndata['sattachment'];
													
													$acgttaskdate=$acastaskdate.$acastasktime;
													
													$actaskcreatedate= date('Y-m-d G:i:s', strtotime($acastaskcredatetime));
													
													$actaskdatetime= date('Y-m-d G:i:s', strtotime($acgttaskdate));
													
													$acassign_date = date('Y-m-d G:i:s',strtotime($acastaskassdate))." ".$acastaskasstime;
													
												  $acsts='';
												  $acamount='';
												  $acstatus_new='';
												  $acstatus=$common_model->fetch_vendor_task_quote($acastaskid,$user_id);
												  if(count($acstatus)>0)
												  {
													   $acsts=$acstatus[0]['status'];
													   $amount=$acstatus[0]['amount'];
													  
														$acquotedate     = date('Y-m-d G:i:s',strtotime($acstatus[0]['date']));
												  }
													if($acsts=='Accepted')
													{
														
														$acstatus_new1 = $common_model->fetch_vendor_task_status($acastaskid,$user_id);
													 if(count($acstatus_new1)>0)
													 {
													   $acsts_new=$acstatus_new1[0]['status'];
													  if($acsts_new=='Accepted')
													  {
														$acstatus_new='Accepted';
														
														$acdivclass="task_accepted";
														  
													  }
													  if($acsts_new=='Paid')
													  {
														  $acstatus_new='Accepted';
													  }
													  $acstatusdatetime= date('Y-m-d G:i:s',strtotime($acstatus_new1[0]['date']));
													 }
													}
												?>
												
												<div class="task_card  task_accepted">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $acsattachment; ?>"></a>
																	<button class="task_sc"><?php echo $acastasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $acastaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $acastasktitle; ?> </a>
																		<p><?php echo substr($acastaskdesc,0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $acastaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $actaskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $actaskdatetime; ?></span><span class="task_sch"> <label>Budget Information</label><i class="flaticon-euro"></i><?php echo $acastaskbudget; ?></span>  </div>
																<div class="task_menu_list">
																
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Accepted
																	
																		
																	</h6> 
																	
																	<?php
																	if($acsts_new=='Paid')
																	{
																		?>
																		<span class="vendor_quote_btn" data-toggle="modal" data-target=".Start_Service"  > Start Service</span>
																		
																		<span class="status_text"> Paid On <?php echo $acstatusdatetime; ?></span>
																		<?php
																	}
																	else
																	{
																		?>
																		<span class="vendor_quote_btn"  style="background:#d6d0d0" > Start Service</span>
																		<br/>
																		<span style='color:red;font-size:11px;'>Not Paid</span>
																		<?php
																	}
																	?>
																	
																	
																	
																	
																	<div class="clearfix"></div>
																		<ul>
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $acastaskid; ?>','<?php echo $acastaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
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
											<div id="inprocess" class="container tab-pane fade">
										<?php
										if(sizeof($rejectedarr)>0)
										{
											for($r=0;$r<sizeof($rejectedarr);$r++)
											{
												$rassigndata=$rejectedarr[$r];
												$rasid=$rassigndata['id'];
												$rastaskid=$rassigndata['task_id'];
												$rastaskuserid=$rassigndata['user_id'];
												$rastaskvendid=$rassigndata['vendor_id'];
												$rastaskassdate=$rassigndata['assigndate'];
												$rastaskasstime=$rassigndata['assigntime'];
												
												$rastaskcode=$rassigndata['code'];
												$rastasktitle=$rassigndata['title'];
												$rastaskcode=$rassigndata['code'];
												$rastaskcatid=$rassigndata['category_id'];
												$rastasksubcatid=$rassigndata['sub_category_id'];
												$rastaskdesc=$rassigndata['description'];
												$rastaskbudget=$rassigndata['budget'];
												$rastaskpostal_code=$rassigndata['postal_code'];
												$rastaskcity=$rassigndata['city'];
												$rastaskaddress=$rassigndata['address'];
												$rastaskland_mark=$rassigndata['land_mark'];
												$rastaskdate=$rassigndata['date'];
												$rastasktime=$rassigndata['time'];
												$rastaskcredatetime=$rassigndata['log_date_created'];
												$rastaskis_negotiate=$rassigndata['is_negotiate'];
												$rastaskcname=$rassigndata['cname'];
												$rastasksub_name=$rassigndata['sub_name'];
												$rsattachment=$rassigndata['sattachment'];
												
												$rgttaskdate=$rastaskdate.$rastasktime;
												
												$rtaskcreatedate= date('Y-m-d G:i:s', strtotime($rastaskcredatetime));
												
												$rtaskdatetime= date('Y-m-d G:i:s', strtotime($rgttaskdate));
												
												$rassign_date = date('Y-m-d G:i:s',strtotime($rastaskassdate))." ".$rastaskasstime;
												
											  $rsts='';
											  $ramount='';
											  $rstatus_new='';
											  $rstatus=$common_model->fetch_vendor_task_quote($rastaskid,$user_id);
											  if(count($rstatus)>0)
											  {
												   $rsts=$rstatus[0]['status'];
												  $ramount=$rstatus[0]['amount'];
												  if($rsts=='Rejected')
												  {
													  $rstatus_new='Rejected';
												  }
												  $rquotedate     = date('Y-m-d G:i:s',strtotime($rstatus[0]['date']));
											  }
											
											if($rsts=='Rejected')
											{
												$rstatus_new='Rejected';
												$rstatus_new1 = $common_model->fetch_vendor_task_status($rastaskid,$user_id);
												if(count($rstatus_new1)>0)
												{
													$rstatusdatetime= date('Y-m-d G:i:s',strtotime($rstatus_new1[0]['date']));
												}
											}
											
											?>
											
											<div class="task_card task_rejected">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $rsattachment; ?>"></a>
																	<button class="task_sc"><?php echo $rastasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $rastaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $rastasktitle; ?> </a>
																		<p><?php echo substr($rastaskdesc,0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $rastaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $rtaskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $rtaskdatetime; ?></span><span class="task_sch"> <label>Budget Information</label><i class="flaticon-euro"></i><?php echo $rastaskbudget; ?></span>  </div>
																<div class="task_menu_list">
																
																
																
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Rejected
																	
																		
																	</h6> <span class="status_text"> On <?php echo $rstatusdatetime; ?></span>
																	
															
																	
																	<div class="clearfix"></div>
																	<ul>
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $rastaskid; ?>','<?php echo $rastaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
																	</ul>
																	<?php
																
																
																
																?>
																
																
																
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
										if(sizeof($startedarr)>0)
										{
											for($c=0;$c<sizeof($startedarr);$c++)
											{
												$cassigndata=$startedarr[$c];
												$casid=$cassigndata['id'];
												$castaskid=$cassigndata['task_id'];
												$castaskuserid=$cassigndata['user_id'];
												$castaskvendid=$cassigndata['vendor_id'];
												$castaskassdate=$cassigndata['assigndate'];
												$castaskasstime=$cassigndata['assigntime'];
												
												$castaskcode=$cassigndata['code'];
												$castasktitle=$cassigndata['title'];
												$castaskcode=$cassigndata['code'];
												$castaskcatid=$cassigndata['category_id'];
												$castasksubcatid=$cassigndata['sub_category_id'];
												$castaskdesc=$cassigndata['description'];
												$castaskbudget=$cassigndata['budget'];
												$castaskpostal_code=$cassigndata['postal_code'];
												$castaskcity=$cassigndata['city'];
												$castaskaddress=$cassigndata['address'];
												$castaskland_mark=$cassigndata['land_mark'];
												$castaskdate=$cassigndata['date'];
												$castasktime=$cassigndata['time'];
												$castaskcredatetime=$cassigndata['log_date_created'];
												$castaskis_negotiate=$cassigndata['is_negotiate'];
												$castaskcname=$cassigndata['cname'];
												$castasksub_name=$cassigndata['sub_name'];
												$csattachment=$cassigndata['sattachment'];
												
												$cgttaskdate=$castaskdate.$castasktime;
												
												$ctaskcreatedate= date('Y-m-d G:i:s', strtotime($castaskcredatetime));
												
												$ctaskdatetime= date('Y-m-d G:i:s', strtotime($cgttaskdate));
												
												$cassign_date = date('Y-m-d G:i:s',strtotime($castaskassdate))." ".$castaskasstime;
												
											  $csts='';
											  $camount='';
											  $cstatus_new='';
											  $cstatus=$common_model->fetch_vendor_task_quote($castaskid,$user_id);
											  if(count($cstatus)>0)
											  {
												   $csts=$cstatus[0]['status'];
												   $camount=$cstatus[0]['amount'];
												  
												  if($csts=='Accepted')
												  {
													  $cstatus_new='Accepted';
												  }
												  
												  $cquotedate     = date('Y-m-d G:i:s',strtotime($cstatus[0]['date']));
											  }
												if($csts=='Accepted')
												{
													$cstatus_new1 = $common_model->fetch_vendor_task_status($cstaskid,$user_id);
													 if(count($cstatus_new1)>0)
													 {
													   $csts_new=$cstatus_new1[0]['status'];
													  if($csts_new=='Started')
													  {
														  $cstatus_new='Started';
														  
														  $cdivclass="task_paid";
														  
													  }
													  $cstatusdatetime= date('Y-m-d G:i:s',strtotime($cstatus_new1[0]['date']));
													 }
												}
												
												
												?>
												
												
												<div class="task_card task_paid">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $csattachment; ?>"></a>
																	<button class="task_sc"><?php echo $castasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $castaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $castasktitle; ?> </a>
																		<p><?php echo substr($castaskdesc,0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $castaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $ctaskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $ctaskdatetime; ?></span><span class="task_sch"> <label>Budget Information</label><i class="flaticon-euro"></i><?php echo $castaskbudget; ?></span>  </div>
																<div class="task_menu_list">
																
																
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i> Started
																	
																		
																	</h6> <!--<span class="status_text"> On <?php echo $cstatusdatetime; ?></span>-->
																	
																	<span class="vendor_quote_btn" data-toggle="modal" data-target=".Complete_Service" onClick="getcompletServiceId('<?php echo $castaskid; ?>')" > Completed</span>
																	<div class="clearfix"></div>
																	<ul>
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $castaskid; ?>','<?php echo $castaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
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
											if(sizeof($completedarr)>0)
											{
												for($cp=0;$cp<sizeof($completedarr);$cp++)
												{
													$passigndata=$completedarr[$cp];
													$pasid=$passigndata['id'];
													$pastaskid=$passigndata['task_id'];
													$pastaskuserid=$passigndata['user_id'];
													$pastaskvendid=$passigndata['vendor_id'];
													$pastaskassdate=$passigndata['assigndate'];
													$pastaskasstime=$passigndata['assigntime'];
													
													$pastaskcode=$passigndata['code'];
													$pastasktitle=$passigndata['title'];
													$pastaskcode=$passigndata['code'];
													$pastaskcatid=$passigndata['category_id'];
													$pastasksubcatid=$passigndata['sub_category_id'];
													$pastaskdesc=$passigndata['description'];
													$pastaskbudget=$passigndata['budget'];
													$pastaskpostal_code=$passigndata['postal_code'];
													$pastaskcity=$passigndata['city'];
													$pastaskaddress=$passigndata['address'];
													$pastaskland_mark=$passigndata['land_mark'];
													$pastaskdate=$passigndata['date'];
													$pastasktime=$passigndata['time'];
													$pastaskcredatetime=$passigndata['log_date_created'];
													$pastaskis_negotiate=$passigndata['is_negotiate'];
													$pastaskcname=$passigndata['cname'];
													$pastasksub_name=$passigndata['sub_name'];
													$psattachment=$passigndata['sattachment'];
													
													$pgttaskdate=$pastaskdate.$pastasktime;
													
													$ptaskcreatedate= date('Y-m-d G:i:s', strtotime($pastaskcredatetime));
													
													$ptaskdatetime= date('Y-m-d G:i:s', strtotime($pgttaskdate));
													
													$passign_date = date('Y-m-d G:i:s',strtotime($pastaskassdate))." ".$pastaskasstime;
													
												  $psts='';
												  $pamount='';
												  $pstatus_new='';
												  $pstatus=$common_model->fetch_vendor_task_quote($pastaskid,$user_id);
												  if(count($pstatus)>0)
												  {
													   $psts=$pstatus[0]['status'];
													  $pamount=$pstatus[0]['amount'];
													  
													  if($psts=='Accepted')
													  {
														  $pstatus_new='Accepted';
													  }
													  
													  $pquotedate     = date('Y-m-d G:i:s',strtotime($pstatus[0]['date']));
												  }
												if($psts=='Accepted')
												{
													$pstatus_new1 = $common_model->fetch_vendor_task_status($pastaskid,$user_id);
													 if(count($pstatus_new1)>0)
													 {
													   $psts_new=$pstatus_new1[0]['status'];
													  
													  if($psts_new=='Completed')
													  { 
														  $pstatus_new='Completed'; 
														  
														  $pdivclass="task_completed";
														  
														  
													  }
													  $pstatusdatetime= date('Y-m-d G:i:s',strtotime($pstatus_new1[0]['date']));
													 }
												}
												
												?>
												<div class="task_card  task_completed">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $psattachment; ?>"></a>
																	<button class="task_sc"><?php echo $pastasksub_name; ?></button>
																</div>
																<div class="task_card_info ">
																	<h5 class="task_id"><?php echo $pastaskcode; ?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $pastasktitle; ?> </a>
																		<p><?php echo substr($pastaskdesc,0,100); ?></p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $pastaskaddress; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom">
																<div class="task_date"> <span class="task_sch"> <label>Created Date & Time</label><?php echo $ptaskcreatedate; ?></span><span class="task_sch"> <label>Required Date & Time</label><?php echo $ptaskdatetime; ?></span><span class="task_sch"> <label>Budget Information</label><i class="flaticon-euro"></i><?php echo $pastaskbudget; ?></span>  </div>
																<div class="task_menu_list">
																
																
																
																	<h6 class="task_sch_status"> <i class="fas fa-circle"></i>Completed</h6>
																	<div class="clearfix"></div>
																	<ul>
																	     <?php
																	    $reviews = $common_model->get_see_reviews($user_id,$pastaskid);
																	    	 
																	                if(count($reviews)>0){ 
																	                         ?>
																	                         <li> <a data-toggle="modal" data-target=".Review_Popup" onClick="viewVendorReview('<?php echo $pastaskid; ?>')"><i class="flaticon-review"></i>View Review</a></li>
																	           
																	                        
					
																	    	                <?php
																	                         }
																	                         ?>
																	   
															<!--<li> <a data-toggle="modal" data-target=".Review_Popup" onClick="viewVendorReview('<?php echo $pastaskid; ?>')" ><i class="flaticon-review"></i>View Review</a></li>-->
																		<li> <a data-toggle="modal" data-target=".details_Popup" onClick="viewPaymentDetails('<?php echo $pastaskid; ?>','<?php echo $pastaskuserid; ?>')"><i class="flaticon-information"></i>view Details</a></li>
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
	<?php include("footer.php"); ?>
	
	<div class="modal fade Start_Service " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<div class="login-block" >
					<span id="otpspancusmsg" style="color:green;"></span>
						<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
						<h2>Enter OTP</h2>
						<div class="login-group otp-box"> <span id="qtimerspan">00:30</span>
							<form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
							<div class="digitviewstart">
								<input type="text" id="qdigit1" name="qdigit1" placeholder="0" data-next="qdigit2" maxlength="1" />
								<input type="text" id="qdigit2" name="qdigit2" placeholder="0" data-next="qdigit3" data-previous="qdigit1" maxlength="1" />
								<input type="text" id="qdigit3" name="qdigit3" placeholder="0" data-next="qdigit4" data-previous="qdigit2" maxlength="1" />
								<input type="text" id="qdigit4" name="qdigit4" placeholder="0" data-next="qdigit5" data-previous="qdigit3" maxlength="1" /> 
								</div>
								</form>
						</div>
						<div class="otp-buttons d-flex">
						   <input type="hidden" id="qhdnuserid" name="qhdnuserid" value="" >
						   <input type="hidden" id="qhdnusermob" name="qhdnusermob" value="" >
						   
							<button type="button" id="qbtnverifyotp" name="qbtnverifyotp" class="otp-submit" onClick="qverifyOtp()">Submit</button>
							
							<button type="button" id="qbtnresendotpdis" name="qbtnresendotp" style="display:block" >Resend</button>
							
							<button type="button" id="qbtnresendotpena" name="qbtnresendotp" onClick="qresendOTP()" class="otp-submit" style="display:none;background: #FCBB3D;
    border-color: #FCBB3D;" >Resend</button>
							
						</div>
						
						<input type="hidden" id="hdnotptaskid" name="hdnotptaskid" value="" >
						<span id="qotperrmsg" style="color:red"></span>
						<span id="qotpsuccmsg" style="color:green"></span>
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>
	
	</div>
	
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
									<label>paid on</label> <span id="spanpaid"> 	12-20-2020 12:38 PM
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
	
	<div class="modal fade Complete_Service" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
					
					<div class="task_delete_popup">
					
						<h4>Are you sure, this service completed ?<h4>
					<div class="otp-buttons d-flex">
					<button type="button" id="completebtnyes" name="completebtnyes" class="otp-submit"   onClick="serviceComplete()" >Yes</button>
							
					<button type="button" id="completebtnyesno" name="completebtnyesno"  class="otp-submit" data-dismiss="modal" aria-label="Close" >No</button>
					
					<input type="hidden" id="hdncompletetaskid" name="hdncompletetaskid" value="" >
							
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
					<li> <i class="flaticon-user-5"></i> <span>Ricky Ponting, 9629221354</span></li>
						<li> <i class="flaticon-technical-support"></i> <span>Kithcen Cleaning, MTASKAAKk5486431</span></li>
					
						<li> <i class="flaticon-pin"></i> <span>SW1A 2AA, 10 Downing Street, LONDON.</span></li>
							<li> <i class="flaticon-calendar"></i> <span>July,25 2020 10:00 AM</span></li>
					</ul>
					
					
					
					<div class="text-center">
					<button> 
                         
						<span class="pp_amount"> <i class="flaticon-euro"></i> <label>20</label>
						 
						 Total
				
						 </span>
						 
<span class="pp_continue">
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
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
					<div class="review_popup_block review_user_view" >
					    <span id="spannoreviews"></span>
					
					<div class="review_user_info ">
					<span id="reviewspanimg" ><img src="images/user-gravtor.jpg"></span>
					
					
					
					<h2 id="reviewspanname">Johnson</h2>
				    
			
					
					<p id="reviewspandesc">dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda...</p>
					</div>
					
			        
					<div class="review_user-form">
					
					<div class="text-center review_stars" id="reviewspanstarat">
			    
				
				<i class="fa fa-star"></i>
				
				<i class="fa fa-star"></i>
				
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				
				<i class="fa fa-star"></i>
				
			</div>		
					
					<h4 id="reviewspanrting">5.0</h4>
				
					</div>
				
				
				
				</div>
			</div>
		</div>
	</div>
	</div>
	
		
		
	<div class="modal fade Send_Quotation_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
		<!--<form id="formquote" name="formquote" method="post">-->
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
			<div class="sq_info">
			
			<div class="sq_info_icon">
			<i class="flaticon-technical-support"></i>
			</div>
					<div class="sq_info_data">
					
					<h4 id="spansubcat">Kitchen Cleaning</h4>
					<p id="spandesc">Lorem Ipsum is simply dummy text of
the printing and typesetting industry....</p>




					</div>
			
			</div>
				<div class="sq_info_budget">
			
			<div class="form_group">
		 	<label>
			user budget <span id="spannegotia"></span>
			</label>
			<span>
			<i class="flaticon-euro"></i> <input type="text" placeholder="20" value="20" id="txtquotebusject" name="txtquotebusject" readonly>
			
			</span>
			
			</div>
			<div class="form_group">
		 	<label>
			Your quote
			</label>
			<span>
			<i class="flaticon-euro"></i> <input type="text" placeholder="" id="txtquoteamt" name="txtquoteamt">
			
			</span>
			
			</div>
			<div class="form_group">
			
			<textarea placeholder="Describe The Reasons" rows="4" id="txtareareason" name="txtareareason"></textarea>
			
			</div>
			<span id="quoteerrmsg" style="color:red"></span>
			<input type="hidden" id="hdnquotetaskid" name="hdnquotetaskid" value="" >
			<input type="hidden" id="hdnquoteuserid" name="hdnquoteuserid" value="" >
			<input type="hidden" id="hdnquoteasid" name="hdnquoteasid" value="" >
			<input type="submit" id="btnquote" name="btnquote" class="btn-st" onClick="submitReview()" value="Submit Quote">
			
			</div>
			
		
			</div>
		</div>
		<!--</form>-->
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
	<script>
	function getTaskDetails(asid,task_id,user_id,subcat,desc,budjet,negotiate)
	{
		//alert(task_id);
		//alert(user_id);
		//alert(subcat);
		//alert(budjet);
		//alert(negotiate);
		if(task_id!="" && user_id!="" && subcat!="" && budjet!="")
		{
			//alert("dff");
			if(negotiate=='Yes')
			{
				negotiate='Negotiate';
			}
			$("#spansubcat").html(subcat);
			$("#spandesc").html(desc);
			$("#spannegotia").html(negotiate);
			$("#txtquotebusject").val(budjet);
			
			$("#hdnquotetaskid").val(task_id);
			$("#hdnquoteuserid").val(user_id);
			$("#hdnquoteasid").val(asid);
			
		}
	}
	
	function submitReview()
	{
		//alert('jhh');
		var valid = true;
		$('#txtquoteamt').removeClass('invalid');
		$('#txtquoteamt').attr('title','');
		$('#txtlogpassword').removeClass('invalid');
		$('#txtlogpassword').attr('title','');
		var phone=document.getElementById('txtquoteamt').value;
		if(document.getElementById('txtquoteamt').value=='') 
		{
			
			$('#txtquoteamt').removeClass('invalid');
			$('#txtquoteamt').attr('title','');
			$('#txtquoteamt').addClass('invalid');
				$('#txtquoteamt').attr('title','This field is required');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});
				
		}
		if(document.getElementById('txtareareason').value=='') 
		{
			
			$('#txtareareason').removeClass('invalid');
			$('#txtareareason').attr('title','');
			$('#txtareareason').addClass('invalid');
				$('#txtareareason').attr('title','This field is required');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});

		}
		if(document.getElementById('txtquoteamt').value!='') 
		{
			var intRegex = /[0-9 -()+]+$/;
			if(!intRegex.test(phone))
			{
				$('#txtquoteamt').removeClass('invalid');
				$('#txtquoteamt').attr('title','');
				$('#txtquoteamt').addClass('invalid');
				$('#txtquoteamt').attr('title','Invalid Amount');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});
			}
		}
		//return valid;
		//alert(valid);
		if(valid)
		{
			var quoteamt=$("#txtquoteamt").val();
			//alert(quoteamt);
			var taskid=$("#hdnquotetaskid").val();
			var user_id=$("#hdnquoteuserid").val();
			var asid=$("#hdnquoteasid").val();
			var desc=$("#txtareareason").val();
			if(quoteamt!="" && taskid!="" && user_id!="" && desc!="")
			{
				$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&quoteamt='+quoteamt+'&task_id='+taskid+'&user_id='+user_id+'&asid='+asid+'&desc='+desc+'&flag=sent_quote',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					var arr=new Array();
		            var arr=data.split('@6256@');
					var quotests=arr[0];
					var errmsg=arr[1];
					
					if(quotests=='Yes')
					{
						alert(errmsg);
						location.reload();
					}
					else
					{
						document.getElementById("quoteerrmsg").innerHTML=errmsg;
					}
				}
				
				
			},
		  
		});
			}
		}
	
	}
	function sendServiceStartOtp(taskid)
	{
		if(taskid!="")
		{
			$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+taskid+'&flag=sent_start_otp',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					
					/*var arr=new Array();
		            var arr=data.split('@6256@');
					var quotests=arr[0];
					var errmsg=arr[1];*/
					
					$("#hdnotptaskid").val(taskid);
						document.getElementById("otpspancusmsg").innerHTML=data;
						//document.getElementById("qbtnresendotpena").style.display="none";
						//document.getElementById("qbtnresendotpdis").style.display="block";
						//document.getElementById("otpsuccmsg").innerHTML=errmsg;
						getQTimer();
					
				}
				
				
			},
		  
		});
		}
	}
	
	$("#qdigit1").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#qdigit2").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#qdigit3").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#qdigit4").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});

function qverifyOtp()
{
	var digitone=document.getElementById("qdigit1").value;
	var digittwo=document.getElementById("qdigit2").value;
	var digitthr=document.getElementById("qdigit3").value;
	var digitfour=document.getElementById("qdigit4").value;
	var task_id=document.getElementById("hdnotptaskid").value;
	if(digitone!="" && digittwo!="" && digitthr!="" && digitfour!=""  && task_id!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : 'digitone='+digitone+'&digittwo='+digittwo+'&digitthr='+digitthr+'&digitfour='+digitfour+'&task_id='+task_id+'&flag=verify_service_otp',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					
					var arr=new Array();
		            var arr=data.split('@6256@');
					var quotests=arr[0];
					var errmsg=arr[1];
					if(quotests=='yes')
					{
						alert(errmsg);
						location.reload();
					}
					else
					{
						$("#qotperrmsg").html(errmsg);
					}
				}
				
				
			},
		  
		});
	}
	else
	{
	}
}
function qresendOTP()
{
	var taskid=$("#hdnotptaskid").val();
	if(taskid!="")
		{
			$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+taskid+'&flag=sent_start_otp',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					
					/*var arr=new Array();
		            var arr=data.split('@6256@');
					var quotests=arr[0];
					var errmsg=arr[1];*/
					
					$("#hdnotptaskid").val(taskid);
						document.getElementById("otpspancusmsg").innerHTML=data;
						document.getElementById("qbtnresendotpena").style.display="none";
						document.getElementById("qbtnresendotpdis").style.display="block";
						//document.getElementById("otpsuccmsg").innerHTML=errmsg;
						getQTimer();
					
				}
				
				
			},
		  
		});
		}
}

function getQTimer()
{
	//alert();
var timer2 = "00:30";
var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  //var minutes = 0;
  var seconds = parseInt(timer[1], 10);
  --seconds;
  //minutes = (seconds < 0) ? --minutes : minutes;
  if (minutes < 0) clearInterval(interval);
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  
  minutes = (minutes < 10) ? '0' + minutes : minutes;
  
  $('#qtimerspan').html(minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
  if(seconds==00)
  {
	  $('#qtimerspan').html('00:00');
	   clearInterval(interval);
	  doSomething();
  }
}, 1000);

}

function doSomething() {
    //alert("Hi");
	document.getElementById("qbtnresendotpdis").style.display="none";
	document.getElementById("qbtnresendotpena").style.display="block";
}
function getcompletServiceId(taskid)
{
	if(taskid!="")
	{
		$("#hdncompletetaskid").val(taskid);
	}
	
}
function serviceComplete()
{
	
	var task_id=$("#hdncompletetaskid").val();
	//alert(task_id);
	if(task_id!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : 'task_id='+task_id+'&flag=service_complete',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					
					alert(data)
					location.reload();
					
					
					
				}
				
				
			},
		  
		});
	}
	
}

function viewVendorReview(task_id)
{
	//alert(task_id);
	var task_id=task_id;
	if(task_id!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&flag=see_service_review',
			success: function(data)
			{
				
		if(data!="")
		{
			
			var arr=new Array();
			var arr=data.split('@6256@');
			var sts=arr[0];
			var errmsg=arr[1];
			var taskid=arr[2];
			var name=arr[3];
			var usercode=arr[4];
			var attachment=arr[5];
			var rating=arr[6];
			var reviews=arr[7];
			var starsrating=arr[8];
			if(sts=='yes')
			{
				//alert(errmsg);
				//location.reload();
				$("#reviewspanimg").html(attachment);
				$("#reviewspanname").html(name);
				$("#reviewspandesc").html(reviews);
				$("#reviewspanrting").html(rating);
				$("#reviewspanstarat").html(starsrating);
				
					$("#spannoreviews").html('');
				
			}
			else
			{
				$("#spannoreviews").html(errmsg);
				
				$("#reviewspanimg").html('');
				$("#reviewspanname").html('');
				$("#reviewspandesc").html('');
				$("#reviewspanrting").html('');
				$("#reviewspanstarat").html('');
			}
		}
			}
		});
	}
}
function viewPaymentDetails1(task_id)
{
	var task_id=task_id;
	if(task_id!="")
	{
		
	}
}

function viewPaymentDetails(task_id, userid)
{
	if(userid!="" && task_id!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&userid='+userid+'&flag=get_vendor_task_status',
			success: function(data)
			{
				//alert(data);
				if(data!='')
				{
				    $("#replaceserviccedeta").html(data);
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
					
					
				}
				else
				{
					
					//$('#quotespan'+quoteid).html(data);
				}
			},
		  
		});
	}
}

var container = document.getElementsByClassName("digitviewstart")[0];
container.onkeyup = function(e) {
    var target = e.srcElement;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null)
                break;
            if (next.tagName.toLowerCase() == "input") {
                next.focus();
                break;
            }
        }
    }
}
</script>
	
