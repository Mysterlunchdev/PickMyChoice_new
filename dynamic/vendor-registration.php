<?php
include("header.php");

$getinfo=$common_model->get_login_details_byid($user_id);
if(sizeof($getinfo)>0)
{
	for($u=0;$u<sizeof($getinfo);$u++)
	{
		$getinfouser=$getinfo[$u];
		$getuserid=$getinfouser['id'];
		$getname=$getinfouser['name'];
		$getlast_name=$getinfouser['last_name'];
		$getuser_code=$getinfouser['user_code'];
		$getemail=$getinfouser['email'];
		$getmobile=$getinfouser['mobile'];
		$getdepartment_id=$getinfouser['mobile'];
		$getgender=$getinfouser['gender'];
		$getdob=$getinfouser['dob'];
		$getpostcode=$getinfouser['postcode'];
		$getaddress=$getinfouser['address'];
		$getcity=$getinfouser['city'];
		$getstreet=$getinfouser['street'];
		$getabout=$getinfouser['about'];
		$getstatus=$getinfouser['status'];
		$getmobile_verified=$getinfouser['mobile_verified'];
		
		  $pwr1=" 1=1 and id='$getuserid'";
         $getpwd=$common_model->fetch_one_column('user','password',$pwr1);
		
		$getpwd=$getpwd;
	}
}

$getexperdet=$common_model->get_expertise($user_id);
if(sizeof($getexperdet)>0)
{
	for($ue=0;$ue<sizeof($getexperdet);$ue++)
	{
		$expertdetf=$getexperdet[$ue];
		$expertdetcategory_id=$expertdetf['category_id'];
		$experexpert_in_yrs=$expertdetf['expert_in_yrs'];
		$expertdetabout=$expertdetf['about'];
		$expertdetmotor_status=$expertdetf['motor_status'];
		$expertinsurance_status=$expertdetf['insurance_status'];
		$expertdetmotor_insurance_status=$expertdetf['motor_insurance_status'];
		$expertdetmotor_licence_status=$expertdetf['motor_licence_status'];
	}
}
?>
	<section class="task-post-block  vr-container ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form id="formvendorreg" name="formvendorreg" method="post">
					<div class="design-process-section" id="process-tab">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs process-model more-icon-preocess d-flex" role="tablist">
							<li role="presentation"  <?php if($user_id!=""){}else{ ?> class="active" <?php } ?> >
								<a <?php if($user_id!=""){}else{ ?> <?php ?> class="active" href="#Signup" <?php } ?> aria-controls="Signup" role="tab" data-toggle="tab">
									<label></label> <span>Step 1</span>
									<p>Personnel Details</p>
								</a>
							</li>
					<li role="presentation" class="<?php if($user_id!=""){ echo 'active'; } ?>">
								<!--<a href="#Shipping" aria-controls="Shipping" role="tab" data-toggle="tab">-->
								<a href="#Shipping" aria-controls="Shipping" role="tab" data-toggle="tab" id="getshippingtab">
									<label></label> <span>Step 2</span>
									<p>Expertise</p>
								</a>
							</li>
							<li role="presentation">
								<a href="#Orderreview" aria-controls="Orderreview" role="tab" data-toggle="tab" id="getbankview">
									<label></label> <span>Step 3</span>
									<p>Bank Details</p>
								</a>
							</li>
						</ul>
						<div class="tab-content">
					
							<div role="tabpanel" class="tab-pane <?php if($user_id!=""){}else{echo "active";} ?>" id="Signup">
								<div class="tp-block vr-block" >
									<div class="task-form-block">
										<div class="tfb-info" id="basicform">
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="First Name" id="txtvfirstname" name="txtvfirstname" required="true" value="<?php echo $getname; ?>" > </div>
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Last Name" id="txtvlastname" name="txtvlastname" required="true" value="<?php echo $getlast_name; ?>" > </div>
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Date of Birth" id="txtvdob" name="txtvdob" required="true" value="<?php echo $getdob ?>"> </div>
											<div class="tfb-group">
												<div class="chkContainer">
													<h4>Gender</h4>
													<label class="chkcontainer">
														<input type="radio" name="radiovgender" id="radiovgender" value="Male" <?php if($getgender=='Male'){ ?> checked <?php } if($getgender==''){ echo "checked"; } ?>>Male <span class="chkcheckmark"></span> </label>
													<label class="chkcontainer">
														<input type="radio" name="radiovgender" id="radiovgender" value="Female" <?php if($getgender=='Female'){ ?> checked <?php } ?> >Female <span class="chkcheckmark"></span> </label>
												</div>
											</div>
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Mobile No" id="txtvmobile" name="txtvmobile" required="true" onkeypress="return isNumber(event)" value="<?php echo $getmobile ?>"> </div>
											<div class="tfb-group">
												<input type="email" class="form-control" placeholder="Email Address" id="txtvemail" name="txtvemail" required="true" value="<?php echo $getemail ?>"> </div>
												<div class="tfb-group">
												<input type="password" class="form-control" placeholder="Password" id="txtvpwd" name="txtvpwd" required="true" value="<?php echo $getpwd ?>"> </div>
												<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Post Code" id="txtvpostcode" name="txtvpostcode" required="true" onBlur="getAdresDet(this.value)" value="<?php echo $getpostcode; ?>"> </div>
												<div class="tfb-group">
												 <select id='txthuseno' name='txthuseno' class='form-control' >
												 <?php
												 if($getaddress!="")
												 {
													 ?>
													 <option value='<?php echo $getaddress; ?>' selected ><?php echo $getaddress; ?></option>
													 <?php
												 }
												 else
												 {
													 ?>
													 <option value=''>Select</option>
													 <?php
												 }
												 ?>
												 
												 
												 </select> </div>
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="City" id="txttskcity" name="txttskcity"required="true" value="<?php echo $getcity; ?>" > </div>
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="County" id="txtvlandmark" name="txtvlandmark" value="<?php echo $getstreet; ?>"> </div>
												<input type="hidden" id="txtpsklat" name="txtpsklat" value="" >
								   <input type="hidden" id="txtpsklang" name="txtpsklang" value="" >
										</div>
									</div>
									<div class="form-accept">
										<label class="checkboxcontainer"> i Agree to the <a href="#"> terms & Conditions</a>
											<input type="checkbox" checked="checked"> <span class="checkboxcheckmark" id="radioterms" name="radioterms"></span> </label>
									</div>
									<input type="button" class="btn-st" value="Next" onClick="vendorValidation('basicform')"> 
									
									<!--<a href="#Shipping" aria-controls="Shipping" role="tab" data-toggle="tab" id="getshippingtab">gg</a>-->
									
									</div>
							</div>
							<div role="tabpanel" class="tab-pane <?php if($user_id!=""){ echo "active"; }else{} ?>" id="Shipping">
								<div class="tp-block vr-block">
									<div class="task-form-block ">
										<div class="tfb-info d-block" id="shipingform">
											<div class="row">
												<div class="col-xl-6 col-md-6 col-sm-6 ">
													<div class="form-group">
													
												<?php
												$limit='';
												$categories = $common_model->fetch_main_categories($limit);
												
												
												?>
														<select class="selectpicker" onChange="getSubCtegory(this.value)" id="selcat" name="selcat" required="true">
														
														
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
																	<option value="<?php echo $ccatid; ?>" data-content="<img src='../uploads/category/<?php echo $cimage; ?>'> <span class='option_tilte'><?php echo $ccatname ?></span>"><?php echo $ccatname; ?></option>
																	<?php
																}
															}
															?>
															
														</select>
												

												</div>
												</div>
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
													<select class="selectpicker" id="selsubcat" name="selsubcat">
															<option>Select Subcategory </option>
															
														</select>
												
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Experience in Years" id="txtexpyear" name="txtexpyear" required="true" onkeypress="return isNumber(event)" onblur="getExperience(this.value)"> <span id="txtexp" style="color:red"></span></div>
														
												</div>
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="text" class="form-control" placeholder="Ni Number" id="txtninumber" name="txtninumber" required="true"> </div>
												</div>
											</div>
											<div class="row">
											    	<div class="col-xl-6 col-md-6 col-sm-6">
											    	    	<div class="form-group">
													<h4>Job Card</h4>
													<input type="file" class="form-control" placeholder="" id="filejobCard" name="filejobCard" ></div> </div>
											    
												<div class="col-xl-6 col-md-6 col-sm-6">
												    	<div class="form-group">
													<h4>Upload Certificate</h4>
													<input type="file" class="form-control" placeholder="" id="filecerti" name="filecerti" required="true"> </div>
												</div>	
											</div>
											<div class="row">
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<h4>Upload Residence Proof</h4>
														<input type="file" class="form-control" placeholder="" id="fileresprof" name="fileresprof" > </div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<div class="chkContainer">
															<h4>Work Insurance Status</h4>
															<label class="chkcontainer">
																<input type="radio" name="radiowoinsts" value="Active" id="radioact" checked >Active <span class="chkcheckmark"></span> </label>
															<!--<label class="chkcontainer">
																<input type="radio" name="radiowoinsts" value="Renewal" id="radiorenewal">Renewal In process <span class="chkcheckmark"></span> </label>-->
															<label class="chkcontainer">
																<input type="radio" name="radiowoinsts" value="Expired" id="radioexp">Expired <span class="chkcheckmark"></span> </label>
														</div>
													</div>
												</div>
									
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<div class="chkContainer">
															<h4>Vehicle Status</h4>
															<label class="chkcontainer">
																<input type="radio" name="radiomotrsts" value="yes" checked>yes <span class="chkcheckmark"></span> </label>
															<label class="chkcontainer">
																<input type="radio" name="radiomotrsts" value="no">No <span class="chkcheckmark"></span> </label>
														</div>
													</div>
												</div>
												
												
												
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<div class="chkContainer">
															<h4>Driving License Status</h4>
																<label class="chkcontainer">
																<input type="radio" name="radiomotorstslicen" value="yes" checked>yes <span class="chkcheckmark"></span> </label>
															<label class="chkcontainer">
																<input type="radio" name="radiomotorstslicen" value="no">No <span class="chkcheckmark"></span> </label>
														<!--<label class="chkcontainer">
																<input type="radio" name="radiomotorstslicen" value="Active" checked>Active <span class="chkcheckmark"></span> </label>
															
															<label class="chkcontainer">
																<input type="radio" name="radiomotorstslicen" value="Expired">Expired <span class="chkcheckmark"></span> </label>-->
														</div>
													</div>
												</div>
												<div class="col-xl-6 col-md-6 col-sm-6">
													<div class="form-group">
														<div class="chkContainer">
															<h4>Vehicle Insurence Status</h4>
															<label class="chkcontainer">
																<input type="radio" name="radiomotrinsts" value="Active" checked>Active <span class="chkcheckmark"></span> </label>
															<!--<label class="chkcontainer">
																<input type="radio" name="radiomotrinsts" value="Renewal">Renewal In process <span class="chkcheckmark"></span> </label>-->
															<label class="chkcontainer">
																<input type="radio" name="radiomotrinsts" value="Expired">Expired <span class="chkcheckmark"></span> </label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<input type="button" class="btn-st" value="Next" onClick="shipValidation('shipingform')"> 
									
									</div>
									
									<!--<a href="#Orderreview" aria-controls="Orderreview" role="tab" data-toggle="tab">hh</a>-->
							</div>
							<div role="tabpanel" class="tab-pane" id="Orderreview">
								<div class="tp-block vr-block">
									<div class="task-form-block">
										<div class="tfb-info" id="accountform">
										
											<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Account Number" id="txtaccount" name="txtaccount" required="true" onkeypress="return isNumber(event)"> </div>
												<div class="tfb-group">
												<input type="text" class="form-control" placeholder="Account Holder Name" id="txtacountholder" name="txtacountholder" required="true"> </div>
											<div class="tfb-group">
												<input type="text" class="form-control" id="txtsortcode" name="txtsortcode" placeholder="Sort Code" required="true" onkeypress="return issNumber(event)" onkeyup="addHyphen(this)"> </div>
										</div>
									</div>
									<input type="submit" class="btn-st" value="Submit" onClick="accountValidation('accountform')"> </div>
									
									
								
								   <input type="hidden" id="formtype" name="formtype" value="vendor_register" >
							</div>
							<span id="veregerrmsg" style="color:red"></span>
							
						</div>
					</div>
					
					<input type="hidden" id="hdnbasic" name="hdnbasic" value="<?php if($user_id!=""){ echo 'yes'; }else{ echo 'no'; } ?> " >
					<input type="hidden" id="hdnshopping" name="hdnshopping" value="no" >
					<input type="hidden" id="hdnbankdetails" name="hdnshopping" value="no" >
			<input type="hidden" id="hdnuserid" name="hdnuserid" value="<?php echo $user_id; ?>" >
					
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 offset-md-3"> </div>
			</div>
		</div>
	</section>
	<!--<div class="modal fade successPopup" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center"> <img src="images/success.jpg">
					<h2>Your Task <span class="highlight"> No.1123MAG </span> <span class="d-block"></span>is posted successfully.</h2>
					<h2>You May reach upto  <span class="d-block"></span><span class="highlight">1000</span> potential bidders</h2> <span class="sp-close" data-dismiss="modal">Close</span> </div>
			</div>
		</div>
	</div>-->
	
	<span data-toggle="modal" data-target="#staticBackdrop" id="btntaskpopup"></span>
<div class="modal fade successPopup" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body text-center">
      
	
	
	<img src="images/success.jpg">
	
	
	<h2>Your Vendor code <span class="highlight" id="msgtaskcode"> </span> <span class="d-block"></span>is updated successfully.</h2>
	
	
	<!--<h2>You May reach upto  <span class="d-block"></span><span class="highlight">1000</span> potential bidders</h2>-->
	
	
	<a class="sp-close" href="my-services.php">Close</a>
	
	  </div>
      </div>
  
   
  </div>
</div>


	<?php
	include("footer.php");
	?>
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
	function vendorValidation(id)
	{
		var valid;	
		valid = vValidation(id);
			var i, items = $('.process-model  li'), pane = $('.tab-pane');
	
	
		
		
		if(valid)
		{
			document.getElementById('hdnbasic').value='yes';
			document.getElementById("getshippingtab").click();
			
			
                if(i < items.length - 1){
                    // for tab
                    $(items[i]).removeClass('active');
                     $(items[i]).addClass('visited');
                    $(items[i+1]).addClass('active');
                    // for pane
                    $(pane[i]).removeClass('show active');
                    $(pane[i+1]).addClass('show active');
                }
			
			
			
			
		}
		else
		{
			document.getElementById('hdnshopping').value='no';
		}
		
		
		
		
		
		
		
		
	}
	function shipValidation(id)
	{
		var valid;	
		valid = vValidation(id);
				var i, items = $('.process-model  li'), pane = $('.tab-pane');
		if(valid)
		{
			document.getElementById('hdnshopping').value='yes';
			document.getElementById("getbankview").click();
			
				
                if(i < items.length - 1){
                    // for tab
                    $(items[i]).removeClass('active');
                     $(items[i]).addClass('visited');
                    $(items[i+1]).addClass('active');
                    // for pane
                    $(pane[i]).removeClass('show active');
                    $(pane[i+1]).addClass('show active');
                }
		}
		else
		{
			document.getElementById('hdnshopping').value='no';
		}
	}
	function accountValidation(id)
	{
		var valid;	
		valid = vValidation(id);
					var i, items = $('.process-model  li'), pane = $('.tab-pane');
		if(valid)
		{
			document.getElementById('hdnbankdetails').value='yes';
				
                if(i < items.length - 1){
                    // for tab
                    $(items[i]).removeClass('active');
                     $(items[i]).addClass('visited');
                    $(items[i+1]).addClass('active');
                    // for pane
                    $(pane[i]).removeClass('show active');
                    $(pane[i+1]).addClass('show active');
                }
		}
		else
		{
			document.getElementById('hdnbankdetails').value='no';
		}
	}
	
	function vValidation(id)
	{
		var valid = true;
		$("#"+id+" input[required=true], #"+id+" textarea[required=true]").each(function(){
			$(this).removeClass('invalid');
			$(this).attr('title','');
			if(!$(this).val()){			
				$(this).addClass('invalid');
				$(this).attr('title','This field is required');
				valid = false;
			}
			if($(this).attr("type")=="email" && !$(this).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
				$(this).addClass('invalid');
				$(this).attr('title','Enter valid email');
				valid = false;
			} 
			
			if($(this).attr("id")=='txtvpwd' )
    		{
    			 var mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{2,})");

    			if(!mediumRegex.test($(this).val()))
    			{
    				$(this).addClass('invalid');
    					$(this).attr('title','Password must contains at leat one number and one special character');
    					valid = false;
    					$( ".invalid" ).tooltip({
    						   "ui-tooltip": "highlight",
    					position: { my: "left+15 center", at: "right center" }
    					});
    			}
    		}
    		
		
			//var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");

		}); 
		return valid;
	}
	function removeFunction()
	{
		//$("#getshippingtab").removeClass('active');
	}
	
function getAdresDet(postcode)
{
	var postcode=postcode;
	if(postcode!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&postcode='+postcode+'&flag=get_address',
			success: function(data)
			{
				var arr=new Array();
				var arr=data.split('@6256@');
				var latitude=arr[0];
				var langtitude=arr[1];
				var address=arr[2];
				var city=arr[3];
					var county=arr[4];
				document.getElementById('txthuseno').innerHTML=address;
				document.getElementById('txttskcity').value=city;
				document.getElementById('txtpsklat').value=latitude;
				document.getElementById('txtpsklang').value=langtitude;
				document.getElementById('txtvlandmark').value=county;
				 
			},
		  
		});
	}
}
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

$('#formvendorreg').submit(function (e) {
	
	//var basicdet=$("#hdnbasic").val();
	//var shopidet=$("#hdnshopping").val();
	//var bankdet=$("#hdnbankdetails").val(); 
//alert(basicdet);	
	//if(basicdet=='yes' && shopidet=='yes' && bankdet=='yes')
	//{
	
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
					var register=arr[0];
					var errmsg=arr[1];
					var userid=arr[2];
					var usrmob=arr[3];
					var usrtoken=arr[4];
					if(register=='yes')
					{
						//document.getElementById("closeReg").click();
						document.getElementById("loginotppop").click();
						$(".login_form").hide();
						$(".login_otp").show();
						document.getElementById("hdnuserid").value=userid;
						document.getElementById("hdnusermob").value=usrmob;
						document.getElementById("hdnusertoken").value=usrtoken;
						getTimer();
					}
					else if(register=='upd')
					{
						document.getElementById("btntaskpopup").click();
						$("#msgtaskcode").html(errmsg);
					}
					else
					{
						document.getElementById("veregerrmsg").innerHTML=errmsg;
					}
				}
           }

   });
	//}
   });
   
   $('#txtvdob').datepicker({
        clearBtn: true,
        format: "dd/mm/yyyy",
changeMonth: true,
changeYear: true,
yearRange: "-100:+0"

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
	
	$("#txtvmobile").keyup(function(){
		el = $(this);
		if(el.val().length >= 10){
			el.val( el.val().substr(0, 10) );
		} 
	});
	
	
	
	function getExperience(val){
	   if(parseInt(val)>=1 && parseInt(val)<=50){
	       document.getElementById("txtexp").innerHTML="";
		    } 
		    else{
		         
		        document.getElementById("txtexp").innerHTML="Please enter experience 1 to 50yrs";
		        document.getElementById("txtexpyear").value="";
		        }
                            	}
		
		$("#txtexpyear").keyup(function(){
		ka = $(this);
		if(ka.val().length >= 2){
			ka.val( ka.val().substr(0, 2) );
		} 
	});

	</script>
	
