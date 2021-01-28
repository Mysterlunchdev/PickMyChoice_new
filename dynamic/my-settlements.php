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
										
										<div class="row">
													<div class="col-md-12">
													<?php
													$transaction_list=$common_model->fetch_all_transactions($user_id);
													if(sizeof($transaction_list)>0)
													{
														for($i=0;$i<sizeof($transaction_list);$i++)
														{
															
															
									$paymentid = $transaction_list[$i]['id'];
									$userid= $transaction_list[$i]['user_id'];
									$amount_paid = $transaction_list[$i]['amount_paid'];
									$waived_amount= $transaction_list[$i]['waived_amount'];
									$total_amount= $transaction_list[$i]['total_amount'];
									$commission_amount= $transaction_list[$i]['commission_amount'];
									$paid_date= date('Y-m-d G:i:s',strtotime($transaction_list[$i]['paid_date']));
									$transaction_no= $transaction_list[$i]['transaction_no'];
									$transaction_date= date('Y-m-d G:i:s',strtotime($transaction_list[$i]['transaction_date']));
									$narration= $transaction_list[$i]['narration'];
															?>
														  <div class="task_card  d-block  task_settelment_card task_inprocess" >
															<div class="row">
																
																<div class="col-sm-3 ">
																	<h5 class="task_id">Paid On: <br> <?php echo $transaction_date;?></h5>
																	<div class="task_title"> <a href="#"> <?php echo $title;?> </a>
																	
																	
																	
																		
																	</div>
																</div>
																<div class="col-sm-3 col-6">
																	
																<p>	Total Amount <br>
																	<button class="task_sc"><?php echo $total_amount;?></button><p>
																	</div>
																		<div class="col-sm-3 col-6">
																	<p>Waived Amount </br>  
																	<button class="task_sc"><?php echo $waived_amount;?></button> </p>
																	
																
																</div>
															
													
															<div class="col-sm-3 col-6">
															<p>Commission </br> 
																	<button class="task_sc"><?php echo $commission_amount;?></button> </p>
															<p>
															    
															    </div>
															    	<div class="col-sm-3 col-6 offset-sm-3">
																Amount Paid <br>
																	<button class="task_sc"><?php echo $amount_paid;?></button></p>
																	<div class="clearfix"></div>
															
																</div>
															
																
																	
																	   	<div class="col-sm-3 col-6 3">
																	        
																	        
																	        		<p>Transaction No <br/> 
																	<button class="task_sc"><?php echo $transaction_no;?></button>
															 </p>	
																	        
																	    </div>
																	   	<div class="col-sm-3 col-6">
																	        
																	        		<p>	Narration </br> 
																	<button class="task_sc"><?php echo $narration;?></button>
</p>
												
																	        
																	    </div>
															
													
															</div>
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
									<label>Completed on </label> <span id="spancompleted"> 	12-20-2020 12:38 PM
					</span> </li>
								<li>
									<label>paid on</label> <span id="spanpaid" > 	12-20-2020 12:38 PM
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
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					
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
					<div class="services_full_info services_inprocess">
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
									<h2> <i class="flaticon-calculator"></i> budget Information </h2>
									<div class="sib_info">
										<ul>
											<li>
												<label>Amount</label> <span>5000</span> </li>
											<li>
												<label> Budget Negotiable</label> <span>Yes</span> </li>
										</ul>
									</div>
								</div>
							</div>
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
									<div class="sib_info ">
										<ul class="sib_actions_list">
											<li> <a href="quotations.html"><i class="flaticon-budget"></i> Quotes </a></li>
											<li> <a data-toggle="modal" data-target=".Payment_Popup" ><i class="flaticon-credit-card"></i> pay now </a></li>
											<li> <a data-toggle="modal" data-target=".Review_Popup"><i class="flaticon-review"></i>Write a review</a></li>
											<li><a data-toggle="modal" data-target=".Service_Popup"><i class="flaticon-information"></i>Pay Details</a></li>
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
	
	
	