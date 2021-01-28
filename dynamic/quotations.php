<?php
 include("header.php");
$task_id=base64_decode($_REQUEST['tid']); 
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
									
									
									<h2 class="quotations_list_title">Quotations List </h2>
										
												<div class="row">
													<div class="col-md-12">
													
													<?php
													$quotlist=$common_model->fetch_all_quotes($user_id,$task_id);
													if(sizeof($quotlist)>0)
													{
														for($i=0;$i<sizeof($quotlist);$i++)
														{
															$quotlist_f=$quotlist[$i];
															$quoteid=$quotlist_f['id'];
															$vendor_id=$quotlist_f['vendor_id'];
															$category_id=$quotlist_f['category_id'];
															$ucode=$quotlist_f['code'];
															$ufname=$quotlist_f['uname'];
															$ulname=$quotlist_f['lastname'];
															$postcode=$quotlist_f['postcode'];
															$address=$quotlist_f['address'];
															$city=$quotlist_f['city'];
															$about=$quotlist_f['about'];
															$expert_in_yrs=$quotlist_f['expert_in_yrs'];
															
															$amount=$quotlist_f['amount'];
															$description=$quotlist_f['description'];
															$date=$quotlist_f['date'];
															$quotedate= date('Y-m-d G:i:s', strtotime($date));
															
															$status=$quotlist_f['status'];
															
															
															
	$getcateid=$common_model->getCatBySubCatId($category_id);
	$getcatname=$common_model->getCatnameById($getcateid[0]['category_id']);
	$getsubcatname=$common_model->fetch_sub_cat_by_catid($getcateid[0]['category_id'],$category_id,'');
															
														
													?>
														<div class="task_card">
															<div class="task_card_top d-flex">
																<div class="task_cat_icon">
																	<a href="#"> <img src="../uploads/subcategory/<?php echo $getsubcatname[0]['attachment']; ?>"></a>
																	<button class="task_sc"><?php echo $getsubcatname[0]['sname']; ?></button>
																</div>
																<div class="task_card_info task_user_info">
																	<h5 class="task_id"><?php echo $ucode; ?></h5>
																	<div class="task_title"> <a href="#" class="task_user_name d-flex"> <i class="flaticon-user-5"></i><span><?php echo $ufname.' '.$ulname; ?> </span> </a>
																		<p class="d-flex">				<i class="flaticon-technical-support"></i><span><?php echo $description; ?> <!--<a href="#">Floor Cleaning</a>, <a href="#">Kitchen Cleaning...</a>-->	</span>													</p>
																	</div>
																</div>
																<div class="task_location">
																	<h4><i class="flaticon-pin"></i> <?php echo $address; ?></h4> </div>
															</div>
															<div class="d-flex task_card_bottom ">
																<div class="task_date"> <span class="task_sch"> <label>Dated on</label><?php echo $quotedate; ?></span>
																
																<div class="vendor_quoted_amount">
																<h5> Quoted Amount</h5>
															 <span class="service_quoted_price">	<i class="flaticon-euro"></i> <label><?php echo $amount; ?></label></span>
																</div>
																</div>
																
																
																
																<div class="task_menu_list task_btn_actions">
																	
																	<?php
																	if($status=='Accepted')
																	{
																		?>
																		<button class="btn_accept btn_accepted" >Accepted</button>
																		<?php
																	}
																	else
																	{
																	    
																	?>
																	<button class="btn_accept" onClick="quoteAction('<?php echo $quoteid; ?>','<?php echo $task_id; ?>','<?php echo $vendor_id; ?>','Accepted')">Accept</button>
																	   <?php
																	   if($status=='Rejected')
																	    {
																	        ?>
																		<button class="btn_accept btn_accepted" >Rejected</button>
																		<?php
																	    }
																	    else
																	    {
																	        ?>
																	 <button  class="btn_reject" onClick="quoteAction('<?php echo $quoteid; ?>','<?php echo $task_id; ?>','<?php echo $vendor_id; ?>','Rejected')">Decline</button>
																	   <?php
																	    }
																	   ?>
																	
																	<?php
																	}
																	?>
																	
																	<!--<button class="btn_accept btn_accepted" >Accepted</button>-->
																</div>
																
																
															</div>
															<span id="quotespan<?php echo $quoteid; ?>"></span>
														</div>
														
														<?php
														
															
														}
													}
													else
													{
														echo "No records found";
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
	<div class="modal fade Service_Popup " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<div class="service_info_popup">
						<div class="sip_block">
							<ul>
								<!-- 
					<li>
					<label>Serive ID</label>
				<span> 	MSG-98575 
					</span>
					
					</li>
					<li>
					<label>Serivce Title</label>
				<span>  lorem ipsum door sit amet 
					</span>
					
					</li>
					<li>
					<label>Serive info</label>
				<span> dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda... 
					</span>
					
					</li>
					<li>
					<label>Location</label>
				<span>W1A 2AA, 10 Downing Street, LONDON.
					</span>
					
					</li>
					<li>
					<label>Created Date & Time</label>
				<span>July,25 2020 10:00 AM
					</span>
					
					</li>
					<li>
					<label>Required Date & Time</label>
				<span> July,25 2020 10:00 AM
					</span>
					
					</li>
					<li>
					<label>Budget Information</label>
				<span> 	5000
					</span>
					
					</li> -->
								<li>
									<label>Acepted On</label> <span> 	12-20-2020 12:38 PM
					</span> </li>
								<li>
									<label>Completed on </label> <span> 	12-20-2020 12:38 PM
					</span> </li>
								<li>
									<label>paid on</label> <span> 	12-20-2020 12:38 PM
					</span> </li>
								<li>
									<label>Mode of Payment</label> <span> 	Card Amount
					</span> </li>
								<li>
									<label>Amount </label> <span> 2000
					</span> </li>
								<li>
									<label>Trn Ref no</label> <span>XBd564985989</span> </li>
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
							<li> <i class="flaticon-user-5"></i> <span>Ricky Ponting, 9629221354</span></li>
							<li> <i class="flaticon-technical-support"></i> <span>Kithcen Cleaning, MTASKAAKk5486431</span></li>
							<li> <i class="flaticon-pin"></i> <span>SW1A 2AA, 10 Downing Street, LONDON.</span></li>
							<li> <i class="flaticon-calendar"></i> <span>July,25 2020 10:00 AM</span></li>
						</ul>
						<div class="text-center">
							<button> <span class="pp_amount"> <i class="flaticon-euro"></i> <label>20</label>
						 
						 Total
				
						 </span> <span class="pp_continue">
proceed <i class="fa fa-play"></i>

</span> </button>
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
					<div class="review_popup_block">
						<div class="review_user_info"> <img src="images/user-gravtor.jpg">
							<h2>Mitchell Starc</h2>
							<h4>Kitchen Cleaning - <span>MTASK2169416 </span></h4>
							<p>dliadjad idod adiad adioad audd api duad aduad adaid aodac f a pdaaudd api duad aduad adaid aodac f a pda... </p>
						</div>
						<div class="review_user-form">
							<div class="text-center">
								<fieldset class="rating">
									<input type="radio" id="star5" name="rating" value="5" />
									<label class="full" for="star5" title="Awesome - 5 stars"></label>
									<input type="radio" id="star4half" name="rating" value="4 and a half" />
									<label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
									<input type="radio" id="star4" name="rating" value="4" />
									<label class="full" for="star4" title="Pretty good - 4 stars"></label>
									<input type="radio" id="star3half" name="rating" value="3 and a half" />
									<label class="half" for="star3half" title="Meh - 3.5 stars"></label>
									<input type="radio" id="star3" name="rating" value="3" />
									<label class="full" for="star3" title="Meh - 3 stars"></label>
									<input type="radio" id="star2half" name="rating" value="2 and a half" />
									<label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
									<input type="radio" id="star2" name="rating" value="2" />
									<label class="full" for="star2" title="Kinda bad - 2 stars"></label>
									<input type="radio" id="star1half" name="rating" value="1 and a half" />
									<label class="half" for="star1half" title="Meh - 1.5 stars"></label>
									<input type="radio" id="star1" name="rating" value="1" />
									<label class="full" for="star1" title="Sucks big time - 1 star"></label>
									<input type="radio" id="starhalf" name="rating" value="half" />
									<label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
								</fieldset>
							</div>
							<textarea placeholder="Write a Review" class="form-control" rows="4"></textarea>
							<input type="submit" class="btn-st" value="Submit Review"> </div>
					</div>
				</div>
			</div>
		</div>
<script>
function quoteAction(quoteid,task_id,vendor_id,status)
{
	//alert('');
	//var flag='quote_update';
	if(quoteid!='' && task_id!='' && vendor_id!='' &&  status!='')
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&task_id='+task_id+'&quote_id='+quoteid+'&vendor_id='+vendor_id+'&status='+status+'&flag=quote_update',
			success: function(data)
			{
			
			//location.reload();
				if(data=='1')
				{
					location.href="my-services.php";
				}
				else
				{
				    alert(data);
				    location.reload();
					//$('#quotespan'+quoteid).html(data);
				}
				
				
			},
		  
		});
	}
}
</script>	