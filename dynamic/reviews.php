<?php
error_reporting(0);
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
										    <div class="col-md-12">
													<ul class="nav nav-pills" role="tablist">
													    <?php
													    if($department_id==4)
													    {
													        
													    }
													    else
													    {
													        ?>
													        <li class="nav-item"> <a class="nav-link active" id="All" data-toggle="pill" href="#all">Recieved</a> </li>
													        <?php
													    }
													    ?>
														
														<li class="nav-item"> <a class="nav-link <?php if($department_id==4){ echo 'active'; }else{ echo '';} ?>" id="Pending" data-toggle="pill" href="#inprocess">Given</a></li>
													</ul>
											<div class="tab-content">
											<div id="all" class="container tab-pane <?php if($department_id==3){ echo 'active'; }else{ echo '';} ?>">
											<div class="row">
													<?php
													$list=$common_model->get_vendor_reviews($user_id);
													if(sizeof($list)>0)
													{
														for($i=0;$i<sizeof($list);$i++)
														{
															$rlist=$list[$i];
															$reviewid=$rlist['id'];
															$task_id=$rlist['task_id'];
															$rating=$rlist['rating'];
															$review=$rlist['review'];
															$name=$rlist['name'];
															$user_code=$rlist['user_code'];
															$profile_photo=$rlist['profile_photo'];
															if($profile_photo!='')
															{
																$profile_photo=$baseurl.$userpath.$profile_photo;
															}
															$date=$rlist['log_date_created'];
															$sentdate= date('Y-m-d G:i:s', strtotime($date));
															$list1=$common_model->get_task_details($task_id);
													        if(sizeof($list1)>0)
													        {
													        	$title=$list1[0]['title'];
													        	$tcode=$list1[0]['code'];
													        	$catphoto=$list1[0]['cphoto'];
													        	$subcatname=$list1[0]['sname'];
													        	if($catphoto!='')
													        	{
													        		$catphoto=$baseurl.$categorypath.$catphoto;
													        	}
													        }
													    ?>
														<div class="service_reviews task_card">
														<div class="serv_rev_info">
														<a href="#" class="serv_rev_img"> <img src="<?php echo $catphoto;?>"></a>
														<button class="task_sc"><?php echo $subcatname;?></button>
														<h4  class="serv_rev_id"><?php echo $tcode;?> </h4>
														<h2 class="serv_rev_title"><?php echo $title;?></h2>
														</div>
														<div class="serv_rev_deails">
														<div class="serv_rev_stars">
							<?php for($j=0;$j<5;$j++)
							{
								if($j<=$rating)
								{
									?>
									<i class="fas fa-star"></i>
									<?php
								}
								else
								{
									?><i class="far fa-star"></i>
									<?php
								}
								?>
								<?php
							}
							?>
							
														</div>
														
														<p><?php echo $review;?></p>
														
														<span><?php echo $sentdate;?></span>
														
														<div class="serv_rev_user">
														
														<div class="serv_rev_pic">
														<?php
														if($profile_photo!='')
														{
															?>
															<img src="<?php echo $profile_photo;?>">
															<?php
														}
														else
														{
															?>
															<img src="https://cdn4.iconfinder.com/data/icons/avatars-xmas-giveaway/128/girl_female_woman_avatar-512.png">
															<?php
														}
														?>
														
														</div>
														
														<h4><?php echo $name?> <span><?php echo $user_code;?></span></h4>	
														
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
												<!-- Second Tab-->
												<div id="inprocess" class="container tab-pane <?php if($department_id==4){ echo 'active'; }else{ echo '';} ?>">
											<div class="row">
											    
													<?php
													$list=$common_model->get_vendor_reviews_given($user_id);
													if(sizeof($list)>0)
													{
														for($i=0;$i<sizeof($list);$i++)
														{
															$rlist=$list[$i];
															$reviewid=$rlist['id'];
															$task_id=$rlist['task_id'];
															$rating=$rlist['rating'];
															$review=$rlist['review'];
															$name=$rlist['name'];
															$user_code=$rlist['user_code'];
															$profile_photo=$rlist['profile_photo'];
															if($profile_photo!='')
															{
																$profile_photo=$baseurl.$userpath.$profile_photo;
															}
															$date=$rlist['log_date_created'];
															$sentdate= date('Y-m-d G:i:s', strtotime($date));
															$list1=$common_model->get_task_details($task_id);
													        if(sizeof($list1)>0)
													        {
													        	$title=$list1[0]['title'];
													        	$tcode=$list1[0]['code'];
													        	$catphoto=$list1[0]['cphoto'];
													        	$subcatname=$list1[0]['sname'];
													        	if($catphoto!='')
													        	{
													        		$catphoto=$baseurl.$categorypath.$catphoto;
													        	}
													        }
													    ?>
														<div class="service_reviews task_card">
														<div class="serv_rev_info">
														<a href="#" class="serv_rev_img"> <img src="<?php echo $catphoto;?>"></a>
														<button class="task_sc"><?php echo $subcatname;?></button>
														<h4  class="serv_rev_id"><?php echo $tcode;?> </h4>
														<h2 class="serv_rev_title"><?php echo $title;?></h2>
														</div>
														<div class="serv_rev_deails">
														<div class="serv_rev_stars">
															<?php for($j=0;$j<5;$j++)
															{
																if($j<=$rating)
																{
																	?>
																	<i class="fas fa-star"></i>
																	<?php
																}
																else
																{
																	?><i class="far fa-star"></i>
																	<?php
																}
																?>
																<?php
															}
															?>
							
														</div>
														
														<p><?php echo $review;?></p>
														
														<span><?php echo $sentdate;?></span>
														
														<div class="serv_rev_user">
														
														<div class="serv_rev_pic">
														<?php
														if($profile_photo!='')
														{
															?>
															<img src="<?php echo $profile_photo;?>">
															<?php
														}
														else
														{
															?>
															<img src="https://cdn4.iconfinder.com/data/icons/avatars-xmas-giveaway/128/girl_female_woman_avatar-512.png">
															<?php
														}
														?>
														
														</div>
														
														<h4><?php echo $name?> <span><?php echo $user_code;?></span></h4>		
														
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
				//alert(data);
				if(data=='0')
				{
					
				}
				else
				{
					$('#quotespan'+quoteid).html(data);
				}
			},
		  
		});
	}
}
</script>	