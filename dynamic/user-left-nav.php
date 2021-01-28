<div class="ma-left">
									<div class="ma-gravitor text-center"> 
										<div class="msg_img">
									
										<?php if($photo!='')
										{
											?> 
											    
											   
											<img src="<?=$baseurl.$userpath.$photo;?>">
									
										
											<?php
										}
										else
										{
											?>
										
											    <?php
											    if($getprofilegender=='Male')
											    {
											        $profileavtaricon='male-avatar.png';
											    }
											    else
											    {
											        $profileavtaricon='female-avatar.png';
											    }
											    ?>
											    
											<img src="http://chitfinder.com/magnificit/dynamic/images/user/user-avatar/<?php echo $profileavtaricon; ?>">
										
											<?php
										}
										?>
										<ul class="btn-act" >
											        <li><a type="button" class="" id="change-profile-pic"><i class="fad fa-edit" style="color:black;"></i></a></li>
											        <!--<li><i class="fa fa-times" ></i> </li>-->
											    
											    
											</ul>
												</div>
										<h2><?php echo $username;?></h2>
										<h4><?php echo $profiletype;?></h4>
										<h5><?php echo $usercode;?></h5>
									<!--	<button onClick="logoutButton()">Logout </button> -->
									</div>
									<div class="ma-links">
										<ul>
											<li class="<?php if($filename=='my-account.php'){ echo "active";} ?>" ><a href="my-account.php">My Profile </a> </li>
											<!--<li class="<?php if($filename=='edit-profile.php'){ echo "active";} ?>" ><a href="edit-profile.php">Edit Profile </a> </li>-->
											<li class="<?php if($filename=='my-services.php'){ echo "active";} ?>"><a href="my-services.php">My Services </a> </li>
											<li class="<?php if($filename=='my-payments.php'){ echo "active";} ?>"><a href="my-payments.php">My Payments </a> </li>
											<?php
											if($department_id==3)
											{
											?>
											<li class="<?php if($filename=='assigned-services.php'){ echo "active";} ?>"><a href="assigned-services.php">Assigned Services </a> </li>
											<li class="<?php if($filename=='my-settlements.php'){ echo "active";} ?>"><a href="my-settlements.php">My Settlements </a> </li>
											<?php
											}
											?>
											<li class="<?php if($filename=='reviews.php'){ echo "active";} ?>"><a href="reviews.php">Reviews</a> </li>
											<li class="<?php if($filename=='notifications.php'){ echo "active";} ?>"><a href="notifications.php">Notifications</a></li>
										<li class="<?php if($filename=='change_password.php'){ echo "active";} ?>"><a href="change_password.php">Change Password</a></li>

										</ul>
									</div>
								</div>
								
								<div id="profile_pic_modal" class="modal fade">
                            		<div class="modal-dialog">
                            			<div class="modal-content">
                            				<div class="modal-header">
                            				    <h5>Change Profile Picture</h5>
                            					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            				   
                            				</div>
                            				<div class="modal-body">
                            					<form id="cropimage" method="post" enctype="multipart/form-data" action="change_pic.php">
                            						<strong>Upload Image:</strong> <br><br>
                            						<input type="file" name="profile-pic" id="profile-pic" />
                            						<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="<?php echo $_SESSION['user_id'];?>" />
                            						<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
                            						<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
                            						<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
                            						<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
                            						<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
                            						<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
                            						<input type="hidden" name="action" value="" id="action" />
                            						<input type="hidden" name="image_name" value="" id="image_name" />
                            						
                            						<div id='preview-profile-pic'></div>
                            					<div id="thumbs" style="padding:5px; width:600p"></div>
                            					</form>
                            				</div>
                            				<div class="modal-footer">
                            					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            					<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
                            				</div>
                            			</div>
                            		</div>
                            	</div>