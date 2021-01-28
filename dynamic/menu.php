<?php
if($user_id=='')
{
    $addflg='?flag=login';
}
else
{
   $addflg='';
}
?>

<nav class="navbar navbar-expand-lg main_navigation   fixed-top">
			<div class="container">
				<a class="navbar-brand" href="index.php"><img src="images/logo.png"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="fas fa-bars"></span> </button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"> <a class="nav-link" href="index.php">Home </a> </li>
						<li class="nav-item"> <a class="nav-link" href="services.php">Services</a> </li>
						<?php
						if($department_id!=3)
						{
						?>
						<li class="nav-item"> <a class="nav-link" href="vendor-registration.php"> Register as a Vendor </a> </li>
						<?php
						}
						?>
						<li class="nav-item"> <a class="nav-link" href="blog.php"> Blog</a> </li>
					
					</ul>
				</div>
				
				
				
				
				
				
				
		<ul class="navbar-nav navbar-icons">
					    
					    
						<li class="nav-item highlighted show-desk"> <a class="nav-link " href="post-task.php<?php echo $addflg; ?>">Post Service </a> </li>
					    
					 <?php
						if($user_id=="")
						{
						
						
						?>
							
						<li class="nav-item "> <a class="nav-link" data-toggle="modal" data-target=".loginPopup" id="loginotppop"><i class="flaticon-user"></i> </a> </li>
							
						<?php
						
						
						
			
						}
						else
						{
						    $rcount=$common_model->fetch_unread_count($user_id);
						    if($rcount==0 || $rcount=='' || $filename=='notifications.php')
						    {
						        $rcount='';
						    }
						    else
						    {
						    }
						    ?>
						    
						    	<li class="nav-item icon-alert">  <a class="nav-link" href="notifications.php"> 
						    	<?php if($rcount==0 || $rcount==''){ }else{  ?> <span><?php echo $rcount; ?></span> <?php } ?><i class="fa fa-bell"></i> </a> </li>
						    <?php
						    
							if($photo!='')
							{
								?>
								<li class="nav-item  dropdown"> <span class=" dropdown-toggle"   data-toggle="dropdown" style="cursor:pointer">
									<img src="<?=$baseurl.$userpath.$photo;?>" class="round-image"></span> <a  href="my-account.php" class="myaccount-text"><span class="nav_name">  <?=$getuserinfo[0]['name'];?> </span></a> 
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <a class="dropdown-item" onClick="logoutButton()">Logout</a>
                               </div>
									</li>
								
								<!--<li class="nav-item  dropdown"> <a class="nav-link  dropdown-toggle"   data-toggle="dropdown"  href="my-account.php">
									<img src="<?=$baseurl.$userpath.$photo;?>" class="round-image"> <span class="nav_name">  <?=$getuserinfo[0]['name'];?> </span></a> 
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <a class="dropdown-item" onClick="logoutButton()">Logout</a>
                               </div>
									</li>-->
								<?php
							}
							else
							{
							    if($getprofilegender=='Male')
							    {
							        $profileavtaricon='male-avatar.png';
							    }
							    else
							    {
							        $profileavtaricon='female-avatar.png';
							    }
								?>
								
								<!--<li class="nav-item">
								<a class="nav-link" href="my-account.php"   ><i class="flaticon-user-24"></i> <span class="nav_name"> <?=$getuserinfo[0]['name'];?></span></a>
								</li>-->
								
								<li class="nav-item  dropdown"> <span class=" dropdown-toggle"   data-toggle="dropdown"   style="cursor:pointer">
									<img src="http://chitfinder.com/magnificit/dynamic/images/user/user-avatar/<?php echo $profileavtaricon; ?>" class="round-image"></span> <a  href="my-account.php" class="myaccount-text"><span class="nav_name">  <?=$getuserinfo[0]['name'];?> </span></a> 
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <a class="dropdown-item" onClick="logoutButton()">Logout</a>
                               </div>
									</li>
								
								<!--<li class="nav-item  dropdown"> <a class="nav-link  dropdown-toggle"   data-toggle="dropdown"  href="my-account.php">
									<img src="http://chitfinder.com/magnificit/dynamic/images/user/user-avatar/<?php echo $profileavtaricon; ?>" class="round-image"> <span class="nav_name">  <?=$getuserinfo[0]['name'];?> </span></a> 
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                 <a class="dropdown-item" onClick="logoutButton()">Logout</a>
                               </div>
									</li>-->
									
									
								<?php
							}
						}
						?>
					
					
					    
					    </ul>
				
			
				
				
			</div>
		</nav>