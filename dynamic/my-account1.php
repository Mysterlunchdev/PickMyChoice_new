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
<div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
<?php include("user-left-nav.php"); ?>
</div>
<div class="col-xl-9 col-lg-8 col-md-8 col-sm-7" id="myaccoutview">
<div class="ma-right">
<div class="view-profile">
<div class="row">
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-name"></i>
</div>
<div class="vp_details">
<label>Fisrt Name 
<span><?php echo $getuserinfo[0]['name']; ?></span>
</div>
</label>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-identification"></i>
</div>
<div class="vp_details">
<label>last Name 
<span><?php echo $getuserinfo[0]['last_name']; ?></span></label>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-birthday"></i>
</div>
<div class="vp_details">
<label>Date of Birth 

<span><?php echo $getuserinfo[0]['dob']; ?></span></label>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-gender"></i>
</div>
<div class="vp_details">
<label>Gender

<span><?php echo $getuserinfo[0]['gender']; ?></span></label>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-smartphone"></i>
</div>
<div class="vp_details">
<label>Mobile no 

<span>+44-<?php echo $getuserinfo[0]['mobile']; ?></span></label>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-email"></i>
</div>
<div class="vp_details">
<label>Email Address 
<span><?php echo $getuserinfo[0]['email']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-postal-card"></i>
</div>
<label>Post Code
<span><?php echo $getuserinfo[0]['postcode']; ?></span></label>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>Address
<span><?php echo $getuserinfo[0]['address']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>City
<span><?php echo $getuserinfo[0]['city']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-signpost"></i>
</div>
<div class="vp_details">
<label>County
<span><?php echo $getuserinfo[0]['street']; ?></span></label>
</div>
</div>


</div>


</div>
<?php
if($department_id==3)
{
	$getcateid=$common_model->getCatBySubCatId($getuserexpinfo[0]['category_id']);
	$getcatname=$common_model->getCatnameById($getcateid[0]['category_id']);
	$getsubcatname=$common_model->fetch_sub_cat_by_catid($getcateid[0]['category_id'],$getuserexpinfo[0]['category_id'],''); 
	
	$getjobcarddet=$common_model->getjobcardById($user_id);
	$getcertificatdet=$common_model->getCerficateById($user_id);
	$getresidenproof=$common_model->getResidenseProfById($user_id);
	
	$expcertificate=$getcertificatdet[0]['attachment'];
	$expgetresiprof=$getresidenproof[0]['attachment'];
	$expgetjobcrd=$getjobcarddet[0]['attachment'];
	
?>
<p><b>Expertise Details</b></p>
<div class="row">


<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-name"></i>
</div>
<div class="vp_details">
<label>Category

<span><?php echo $getcatname[0]['name']; ?></span>
</div>
</label>

</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">

<i class="flaticon-identification"></i>

</div>
<div class="vp_details">
<label>Sub Category

<span><?php echo $getsubcatname[0]['sname']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-birthday"></i>
</div>
<div class="vp_details">
<label>Exeperience

<span><?php echo $getuserexpinfo[0]['expert_in_yrs']; ?></span></label>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-6 col-md-64">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-gender"></i>
</div>
<div class="vp_details">
<label>Ni Number

<span><?php echo $getuserexpinfo[0]['NI_number']; ?></span></label>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-smartphone"></i>
</div>
<div class="vp_details">
<label>Work Insurance Status

<span><?php echo $getuserexpinfo[0]['insurance_status']; ?></span></label>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-email"></i>
</div>
<div class="vp_details">
<label>Vehicle Status 
<span><?php echo $getuserexpinfo[0]['motor_status']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-postal-card"></i>
</div>
<label>Driving License Status
<span><?php echo $getuserexpinfo[0]['motor_licence_status']; ?></span></label>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>Vehicle Insurance Status
<span><?php echo $getuserexpinfo[0]['motor_insurance_status']; ?></span></label>
</div>
</div>


</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>Jobcard
<span>
<?php 
if($getjobcarddet[0]['attachment']!="")
{
	if(strpos($expgetjobcrd, '.pdf') !== false)
	{
		?>
		<a href="<?php echo $baseurl.$vendorpath.$expgetjobcrd; ?>" target="_blank">Click Here</a>
		<?php
	}
	else
	{
		
?>
<img src="<?php echo $baseurl.$vendorpath.$getjobcarddet[0]['attachment']; ?>" style="height:50px;width:50px;" >
<?php
	}
}
?>
</span>
</label>
</div>
</div>


</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>Certificate
<span>
<?php
if($getcertificatdet[0]['attachment']!="")
{
	if(strpos($expcertificate, '.pdf') !== false)
	{
		?>
		<a href="<?php echo $baseurl.$vendorpath.$expcertificate; ?>" target="_blank">Click Here</a>
		<?php
	}
	else
	{
		
?>
<img src="<?php echo $baseurl.$vendorpath.$getcertificatdet[0]['attachment']; ?>" style="height:50px;width:50px;" >
<?php
	}
}
?>
</span></label>
</div>
</div>


</div>

<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-location"></i>
</div>
<div class="vp_details">
<label>Residence Proof
<span>
<?php
if($getresidenproof[0]['attachment'])
{
	if(strpos($expgetresiprof, '.pdf') !== false)
	{
		?>
		<a href="<?php echo $baseurl.$vendorpath.$expgetresiprof; ?>" target="_blank">Click Here</a>
		<?php
	}
	else
	{
		
?>
<img src="<?php echo $baseurl.$vendorpath.$getresidenproof[0]['attachment']; ?>" style="height:50px;width:50px;" >
<?php
	}
}
?>
</span></label>
</div>
</div>


</div>




</div>
<p><b>Bank Details</b></p>

<div class="row">


<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-name"></i>
</div>
<div class="vp_details">
<label>Account Number

<span><?php echo $getuserbankinfo[0]['ac_no']; ?></span>
</div>
</label>

</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-64">

<div class="vp_info">
<div class="vp_icon">

<i class="flaticon-identification"></i>

</div>
<div class="vp_details">
<label>Account Holder Name

<span><?php echo $getuserbankinfo[0]['person_name']; ?></span></label>
</div>
</div>


</div>
<div class="col-xl-4 col-lg-6 col-md-6">

<div class="vp_info">
<div class="vp_icon">
<i class="flaticon-birthday"></i>
</div>
<div class="vp_details">
<label>Sort Code

<span><?php echo $getuserbankinfo[0]['short_code']; ?></span></label>
</div>
</div>
</div>

</div>

<?php
}
?>
</div>
<button class="btn-evp" type="button" onClick="showEditDive('edit')"><i class="fa fa-save"></i>Edit Details</button>
</div>


</div>


<div class="col-xl-9 col-lg-8 col-md-8 col-sm-7" id="myaccountedit" style="display:none">
								<div class="ma-right">
									<div class="view-profile">
									
									<form id="formeditprofile" name="formeditprofile" method="post">
										<div class="row">
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-name"></i> </div>
													<div class="vp_details">
														<label>Fisrt Name <span><input type="text" id="txtepfirstname" name="txtepfirstname" value="<?php echo $getuserinfo[0]['name']; ?>" required="true"></span> </div>
													</label>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-identification"></i> </div>
													<div class="vp_details">
														<label>last Name <span><input type="text" value="<?php echo $getuserinfo[0]['last_name']; ?>" required="true" id="txteplastname" name="txteplastname" > </span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-birthday"></i> </div>
													<div class="vp_details">
														<label>Date of Birth <span><input type="text" value="<?php echo $getuserinfo[0]['dob'];?>" required="true" id="txtepdob" name="txtepdob" ></span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-gender"></i> </div>
													<div class="vp_details">
														<label>Gender <span>
														<!--<input type="text" value="male">-->
														<select id="selepgender" name="selepgender" class="form-control">
														<option value="">Select</option>
														<option value="Male" <?php if($getuserinfo[0]['gender']=='Male'){ echo "selected"; } ?> >Male</option>
														<option value="Female" <?php if($getuserinfo[0]['gender']=='Female'){ echo "selected"; } ?>>Female</option>
														</select>
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-smartphone"></i> </div>
													<div class="vp_details">
														<label>Mobile no <span>
															<div class="login-group">
															<input type="text" value="<?php echo $getuserinfo[0]['mobile']; ?>" id="txtepmobile" name="txtepmobile"  readonly> 
															<div class="input-icon" style="line-height: 22px !important;">
															    <span>+44</span>
															</div>
															 </div>
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-email"></i> </div>
													<div class="vp_details">
														<label>Email Address <span> <input type="text" value="<?php echo $getuserinfo[0]['email']; ?>" id="txtepemail" name="txtepemail" required="true"></span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-postal-card"></i> </div>
													<label>Post Code <span><input type="text" value="<?php echo $getuserinfo[0]['postcode']; ?>" id="txteppostcode" name="txteppostcode" required="true"> </span></label>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-location"></i> </div>
													<div class="vp_details">
														<label>Address <span><input type="text" value="<?php echo $getuserinfo[0]['address']; ?>" id="txtepaddrs" name="txtepaddrs" required="true" ></span></label>
													</div>
												</div>
											</div>
												<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-location"></i> </div>
													<div class="vp_details">
														<label>City <span><input type="text" value=" <?php echo $getuserinfo[0]['city']; ?>" id="txtepcity" name="txtepcity" required="true" ></span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-signpost"></i> </div>
													<div class="vp_details">
														<label>County <span><input type="text" value="<?php echo $getuserinfo[0]['street']; ?>" id="txteplandmark" name="txteplandmark" ></span></label>
													</div>
												</div>
											</div>
											
										</div>
<?php
if($department_id==3)
{
?>
										
										<p><b>Expertise Details</b></p>
										<?php
										
										 $getcateid=$common_model->getCatBySubCatId($getuserexpinfo[0]['category_id']);
	$getcatname=$common_model->getCatnameById($getcateid[0]['category_id']);
	$getsubcatname=$common_model->fetch_sub_cat_by_catid($getcateid[0]['category_id'],$getuserexpinfo[0]['category_id'],''); 
	
	$getjobcarddet=$common_model->getjobcardById($user_id);
	$getcertificatdet=$common_model->getCerficateById($user_id);
	$getresidenproof=$common_model->getResidenseProfById($user_id);
	
	$expcertificate=$getcertificatdet[0]['attachment'];
	$expgetresiprof=$getresidenproof[0]['attachment'];
	$expgetjobcrd=$getjobcarddet[0]['attachment'];
	
	//$exploadcertificate=explode(".",$expcertificate);
	
	
	
												$limit='';
												$categories = $common_model->fetch_main_categories($limit);
												
												
												?>
										<div class="row">
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-name"></i> </div>
													<div class="vp_details">
														<label>Category <span><select class="selectpicker" onChange="getSubCtegory(this.value)" id="selcat" name="selcat" required="true">
														
														
															<option>Select Category </option>
															<?php
															if(count($categories)>0)
															{
																for($ci=0;$ci<count($categories);$ci++)
																{
																	$catlist=$categories[$ci];
																	$ccatid=$catlist['id'];
																	$ccatname=$catlist['name'];
																	$cimage=$catlist['attachment'];
																	$description=$catlist['description'];
																	?>
																	<option <?php if($getcateid[0]['category_id']==$ccatid){ echo "selected"; } ?> value="<?php echo $ccatid; ?>" data-content="<img src='../uploads/category/<?php echo $cimage; ?>'> <span class='option_tilte'><?php echo $ccatname ?></span>"><?php echo $ccatname; ?></option>
																	<?php
																}
															}
															?>
															
														</select></span> </div>
													</label>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-identification"></i> </div>
													<div class="vp_details">
														<label>Sub Category <span>
<select class="selectpicker" id="selsubcat" name="selsubcat">
															<option>Select Subcategory </option>
															<?php
			$subcategories = $common_model->fetch_sub_cat_by_catid("","",$limit);
			//print_r($subcategories);
        	if(count($subcategories)>0)
            {
				for($i=0;$i<count($subcategories);$i++)
                {
                     $subcatlist=$subcategories[$i];
					 $catid=$subcatlist['category_id'];
					 $subctid=$subcatlist['id'];
					 $sub_catname=$subcatlist['sname'];
					 $category_name=$subcatlist['cname'];
					 $image=$subcatlist['attachment'];
					 $description=$subcatlist['description'];
					 
					?>
					<option <?php if($getuserexpinfo[0]['category_id']==$catid){ echo "selected";} ?> value="<?php echo $subctid; ?>" data-content="<img src='../uploads/subcategory/<?php echo $image; ?>'> <span class='option_tilte'><?php echo $sub_catname; ?></span>"><?php echo $sub_catname; ?></option>
					<?php
					
				}
			}
		
		?>
														</select>
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-birthday"></i> </div>
													<div class="vp_details">
														<label>Exeperience <span><input type="text" value="<?php echo $getuserexpinfo[0]['expert_in_yrs'];?>" required="true" id="txtepwrkexp" name="txtepwrkexp" ></span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-gender"></i> </div>
													<div class="vp_details">
														<label>Ni Number <span>
														<!--<input type="text" value="male">-->
														<input type="text" value="<?php echo $getuserexpinfo[0]['NI_number'];?>" required="true" id="txtepninum" name="txtepninum" >
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-smartphone"></i> </div>
													<div class="vp_details">
														<label>Work Insurance Status<span>
															<label class="chkcontainer">
																<input type="radio" name="epradiowoinsts" value="Active" id="radioact" <?php if($getuserexpinfo[0]['insurance_status']=='Active'){ echo "checked"; } ?>  >Active <span class="chkcheckmark"></span> </label>
															<!--<label class="chkcontainer">
																<input type="radio" name="radiowoinsts" value="Renewal" id="radiorenewal">Renewal In process <span class="chkcheckmark"></span> </label>-->
															<label class="chkcontainer">
																<input type="radio" name="epradiowoinsts" value="Expired" id="radioexp" <?php if($getuserexpinfo[0]['insurance_status']=='Expired'){ echo "checked"; } ?>>Expired <span class="chkcheckmark"></span> </label>
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-email"></i> </div>
													<div class="vp_details">
														<label>Vehicle Status <span>
														<label class="chkcontainer">
																<input type="radio" name="epradiomotrsts" value="yes" <?php if($getuserexpinfo[0]['motor_status']=='yes'){ echo "checked"; } ?>>yes <span class="chkcheckmark"></span> </label>
															<label class="chkcontainer">
																<input type="radio" name="epradiomotrsts" value="no" <?php if($getuserexpinfo[0]['motor_status']=='no'){ echo "checked"; } ?>>No <span class="chkcheckmark"></span> </label>
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-postal-card"></i> </div>
													<label>Driving License Status <span>
<label class="chkcontainer">
																<input type="radio" name="epradiomotorstslicen" value="Active" <?php if($getuserexpinfo[0]['motor_licence_status']=='Active'){ echo "checked"; } ?> >Active <span class="chkcheckmark"></span> </label>
															
															<label class="chkcontainer">
																<input type="radio" name="epradiomotorstslicen" value="Expired" <?php if($getuserexpinfo[0]['motor_licence_status']=='Expired'){ echo "checked"; } ?>>Expired <span class="chkcheckmark"></span> </label>
													</span></label>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-location"></i> </div>
													<div class="vp_details">
														<label>Vehicle Insurance Status <span>
														<label class="chkcontainer">
																<input type="radio" name="epradiomotrinsts" value="Active" <?php if($getuserexpinfo[0]['motor_insurance_status']=='Active'){ echo "checked"; } ?>>Active <span class="chkcheckmark"></span> </label>
															<!--<label class="chkcontainer">
																<input type="radio" name="radiomotrinsts" value="Renewal">Renewal In process <span class="chkcheckmark"></span> </label>-->
															<label class="chkcontainer">
																<input type="radio" name="epradiomotrinsts" value="Expired" <?php if($getuserexpinfo[0]['motor_insurance_status']=='Expired'){ echo "checked"; } ?>>Expired <span class="chkcheckmark"></span> </label>
														</span></label>
													</div>
												</div>
											</div>
												<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-location"></i> </div>
													<div class="vp_details">
														<label>Jobcard <span><input type="file" class="form-control" placeholder="" id="filejobCard" name="filejobCard" ></span></label>
													</div>
													<span>
													<?php
													if(strpos($expgetjobcrd, '.pdf') !== false)
													{
														?>
														<a href="../uploads/vendor/<?php echo $expgetjobcrd; ?>" target="_blank">Click Here</a>
														<?php
													}
													else
													{	
													
													?>
													<img src="../uploads/vendor/<?php echo $getjobcarddet[0]['attachment']; ?>" style="height:50px;width:50px;" >
													<?php
													}
													?>
													</span>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-signpost"></i> </div>
													<div class="vp_details">
														<label>Certificate <span><input type="file" class="form-control" placeholder="" id="filecerti" name="filecerti" ></span></label>
													</div>
													<span>
													<?php
													if(strpos($expcertificate, '.pdf') !== false)
													{
														?>
														<a href="../uploads/vendor/<?php echo $expcertificate; ?>" target="_blank">Click Here</a>
														<?php
													}
													else
													{	
													
													?>
													<img src="../uploads/vendor/<?php echo $getcertificatdet[0]['attachment']; ?>" style="height:50px;width:50px;" >
													<?php
													}
													?>
													</span>
												</div>
												
											</div>
											
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-signpost"></i> </div>
													<div class="vp_details">
														<label>Residence Proof <span><input type="file" class="form-control" placeholder="" id="fileresprof" name="fileresprof" > </span></label>
													</div>
													<span>
													<?php
													if(strpos($expgetresiprof, '.pdf') !== false)
													{
														?>
														<a href="../uploads/vendor/<?php echo $expgetresiprof; ?>" target="_blank">Click Here</a>
														<?php
													}
													else
													{	
													
													?>
													<img src="../uploads/vendor/<?php echo $getresidenproof[0]['attachment']; ?>" style="height:50px;width:50px;" ></span>
													
													<?php
													}
													?>
												</div>
											</div>
											
										</div>
										
										
										<p><b>Bank Details</b></p>
										<div class="row">
										<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-gender"></i> </div>
													<div class="vp_details">
														<label>Account Number <span>
														<!--<input type="text" value="male">-->
														<input type="text" value="<?php echo $getuserbankinfo[0]['ac_no'];?>" required="true" id="txtaccountno" name="txtaccountno" >
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-gender"></i> </div>
													<div class="vp_details">
														<label>Account Holder Name <span>
														<!--<input type="text" value="male">-->
														<input type="text" value="<?php echo $getuserbankinfo[0]['person_name'];?>" required="true" id="txtacunthname" name="txtacunthname" >
														</span></label>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-6 col-md-6">
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-gender"></i> </div>
													<div class="vp_details">
														<label>Sort Code <span>
														<!--<input type="text" value="male">-->
														<input type="text" value="<?php echo $getuserbankinfo[0]['short_code'];?>" required="true" id="txtsortcode" name="txtsortcode" onkeypress="return issNumber(event)" onkeyup="addHyphen(this)" >
														</span></label>
													</div>
												</div>
											</div>
										
										</div>
										<input type="hidden" id="formsub_type" name="formsub_type" value="expert">
										<?php
}
										?>
									
									<input type="hidden" id="form_type" name="form_type" value="edit_profile">
									<span style="color:red;" id="eperrormsg" ></span>
									<span style="color:green;" id="epsucmsg" ></span>
									<div class="clearfix"></div>
									<button class="btn-evp" type="submit" onClick="validateEditProfile()"><i class="fa fa-save"></i>Save Details</button>
									
									</form>
									
									</div>
									<button class="btn-evp" type="button" onClick="showEditDive('view')"><i class="fa fa-save"></i>View Details</button>
								</div>
								
							</div>


</div>


</div>

</div>




</div>





</div>










</section>
	
	
	
	
	<?php include("footer.php"); ?>
	<script>
	function showEditDive(val)
	{
		if(val=='edit')
		{
			document.getElementById("myaccoutview").style.display="none";
			document.getElementById("myaccountedit").style.display="block";
		}
		if(val=='view')
		{
			document.getElementById("myaccountedit").style.display="none";
			document.getElementById("myaccoutview").style.display="block";
			
		}
		
	}
	</script>
	<script>
	// script for tab steps
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		var href = $(e.target).attr('href');
		var $curr = $(".process-model  a[href='" + href + "']").parent();
		$('.process-model li').removeClass();
		$curr.addClass("active");
		$curr.prevAll().addClass("visited");
	});
	// end  script for tab steps
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
	<script>
	$('.my-select').selectpicker();
	</script>
	
	<script>
	function validateEditProfile() {
	//alert('dfgdfg');
	var valid = true;
	$("#formeditprofile input[required=true], #formeditprofile textarea[required=true]").each(function(){
		$(this).removeClass('invalid');
		$(this).attr('title','');
		if(!$(this).val()){			
			$(this).addClass('invalid');
			
			$(this).attr('title','This field is required');

			valid = false;
			
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
  position: { my: "left+15 center", at: "right center" }
});
			
			
		}
		if($(this).attr("type")=="email" && !$(this).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
			$(this).addClass('invalid');
			$(this).attr('title','Enter valid email');
			valid = false;
		}  
	}); 
	return valid;
}

$('#formeditprofile').submit(function (e) {
 e.preventDefault();
   var formData = new FormData(this);
   $.ajax({
   type: 'POST',
           url: 'ajax.php',
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function (data) {
                 //alert(data);
				 if(data!="")
				 {
					var arr=new Array();
		            var arr=data.split('@6256@');
					var status=arr[0];
					var msg=arr[1];
					if(status=='yes')
					{
						
						$("#epsucmsg").html(msg);
					}
					else
					{
						$("#eperrormsg").html(msg);
					}
				 }
           }

   });
	//}
   });
   
   $('#txtepdob').datepicker({
        clearBtn: true,
        format: "dd/mm/yyyy",
changeMonth: true,
changeYear: true,
yearRange: "-100:+0"

    });
	
	function getSubCtegory(catid)
{
	if(catid!="")
	{
	
	$.ajax({
		url : "ajax.php",
		type: "POST",
		data : '&cat_id='+catid+'&flag=get_subcat_new',
		success: function(data)
		{
			$('#selsubcat').html(data);
			$('.selectpicker').selectpicker('refresh');
		}
	  
	});
	
	}
}
function addHyphen (element) {
    	let ele = document.getElementById(element.id);
        ele = ele.value.split('-').join('');    // Remove dash (-) if mistakenly entered.

        let finalVal = ele.match(/.{1,2}/g).join('-');
        document.getElementById(element.id).value = finalVal;
    }
    
    $("#txtsortcode").keyup(function(){
		el = $(this);
		if(el.val().length >= 8){
			el.val( el.val().substr(0, 8) );
		} 
	});
	function issNumber(evt) 
	{

		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if ( charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) 
		{
			return false;
		}
		return true;
	}
	</script>