<?php
//include_once('social_auth/gconfig.php'); 
//include_once('social_auth/fb-config.php');
//$permissions = array('email'); // Optional permissions
//$loginUrl = $helper->getLoginUrl('https://chitfinder.com/magnificit/dynamic/social_auth/fb-callback.php', $permissions);
?>
<a class="nav-link" data-toggle="modal" data-target=".resetPassword" id="rsploginotppop"> </a>

<footer class="footer clearfix" style="background-image:url(./images/maps8.png); background-size:cover; background-repeat:no-repeat; background-attachment:scroll; background-position:center center; background-color:#eee" id="footer">
		<div class="footer_top-area">
			
			
			<div class="container">
				<div class="inner-container">
					<div class="row">
						<div class="col-xl-2 col-lg-4  col-md-6 col-sm-6 col-12 footer-w1">
							<div class="footer-widget">
								<div class="widget-title">
									<h3>Categories</h3> </div>
								<!-- /.widget-title -->
								<ul class="links-list">
									<?php
			                        $limit=6;
			                        $categories = $common_model->fetch_main_categories($limit); 
									if(count($categories)>0)
									{	
									    for($i=0;$i<6;$i++)
									       {
									       	$id = $categories[$i]['id'];
								            $name = $categories[$i]['name'];l
								            ?>
									<li><a href="category.php?id=<?=$id;?>&title=<?=$name;?>"><?=$name;?></a></li>
									       <?php
									   }
									}
									?>
								</ul>
							</div>
							<!-- /.footer-widget -->
						</div>
						<!-- /.col-lg-3 -->
						<div class="col-xl-4 col-lg-8 col-md-6 col-sm-6 col-12 footer-w2">
							<div class="footer-widget">
								<div class="widget-title">
									<h3>Get in touch</h3> </div>
								<!-- /.widget-title -->
								<ul class="footer-ca">
									<li><i class="fa fa-home"> </i> 17 -18 Berkeley Square, Bristol, United Kingdom, BS8 1HP. </li>
									<li> <i class="fa fa-headphones"> </i>  <a href="tel:">0117 318 5754</a></li>
									<li> <i class="fa fa-envelope"> </i> <a href="tel:">info@pickmychoice.co.uk</a></li>
								</ul>
							</div>
							<!-- /.footer-widget -->
						</div>
						<!-- /.col-lg-2 -->
						<div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 footer-w3">
							<div class="footer-widget">
								<div class="widget-title">
									<h3>Connect With Us</h3> </div>
								<!-- /.widget-title -->
								<ul class="links-list">
									<li><a href=""><span class="mail"><i class="fa fa-envelope"></i></span> Contact Support</a></li>
									<li><a href=""><span class="twitter"><i class="fab fa-twitter"></i></span> Twitter</a></li>
									<li><a href=""><span class="facebook"><i class="fab fa-facebook"></i></span> Facebook</a></li>
									<li><a href=""><span class="instagram"><i class="fab fa-instagram"></i></span> Instagram</a></li>
									<li><a href=""><span class="gplus"><i class="fab fa-google-plus"></i></span> Google+</a></li>
								</ul>
							</div>
							<!-- /.footer-widget -->
						</div>
						<!-- /.col-lg-2 -->
						<div class="col-xl-4 col-lg-8 col-md-6 col-sm-6 col-12 footer-w4">
							<div class="footer-widget">
								<div class="widget-title">
									<h3>Pickmychoice Services On Mobile </h3> </div>
								<!-- /.widget-title -->
								<p>Download the Pickmychoice app today so you can find your services anytime, anywhere</p>
								<a href="#"><img src="images/download-as-b.png"></a>
								<a href="#"><img src="images/download-gp-b.png"></a>
								
								<!-- /.social-block -->
							</div>
							<!-- /.footer-widget -->
						</div>
						<!-- /.col-lg-3 -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.inner-container -->
				<div class="bottom-footer text-center">
					<div class="container">
						<div class="bottom-footer-left">
							<p style="margin: 15px 0px 10px">Copyright © 2020, <a href="#" style="font-weight: bold; color:#000;">PickMyChoice.</a> All Rights Reserved.</p>
						</div>
						<div class="bottom-footer-right">
							<!--<p style="margin: 15px 0px 10px">Design by <a href="#" style="font-weight: bold;color:#000;">Aakruti.</a></p-->						</div>
					</div>
					<!-- /.container -->
				</div>
				<!-- /.bottom-footer -->
			</div>
			<!-- /.container -->
		</div>
	</footer>
	
	
	
	
	
	
	
	<div class="modal fade resetPassword" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center no-pad">
				<button type="button" class="top-close close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<!--<form>-->
					
						<div class="login-block reset_form text-center">
							
							<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
							<h2>Reset Password</h2>
							
								<form name="rsfrmlogin" id="rsfrmlogin" method="post" autocomplete="on">
									<div class="login-group">
								<div class="input-icon" ><i class="flaticon-key"></i></div>
								<input type="password" class="form-control" id="rstxtlogpassword" name="rstxtlogpassword" placeholder="Enter Password"></div>
								
								<div class="login-group">
								<div class="input-icon" ><i class="flaticon-key"></i></div>
								<input type="password" class="form-control" id="rstxtclogpassword" name="rstxtclogpassword" placeholder="Enter Confirm Password"></div>
								
								 <input type="hidden" id="rspphdnuserid" name="rspphdnuserid" value="<?php echo $reqfid; ?>" >
							<button type="button" class="loginBtn" onclick="resetButton()">Continue <i class="fa fa-chevron-right"></i></button>
							
							<span id="rsploginerrmsg" style="color:red"></span>
							</form>
							
							
						</div>
					
						
						<div class="login-block reset_otp" >
						<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
						<h2>Enter OTP</h2>
						<div class="login-group otp-box"> <span id="rsptimerspan">00:30</span>
							<form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
							<div class="rspdigitview">
								<input type="text" id="rsdigit1" name="rsdigit1" placeholder="0" data-next="rsdigit2" maxlength="1" />
								<input type="text" id="rsdigit2" name="rsdigit2" placeholder="0" data-next="rsdigit3" data-previous="rsdigit1" maxlength="1" />
								<input type="text" id="rsdigit3" name="rsdigit3" placeholder="0" data-next="rsdigit4" data-previous="rsdigit2" maxlength="1" />
								<input type="text" id="rsdigit4" name="rsdigit4" placeholder="0" data-next="rsdigit5" data-previous="rsdigit3" maxlength="1" /> 
								</div>
								</form>
						</div>
						 <input type="hidden" id="rsphdnuserid" name="rsphdnuserid" value="" >
						   <input type="hidden" id="rsphdnusermob" name="rsphdnusermob" value="" >
						<div class="otp-buttons d-flex">
						  
						   
							<button type="button" id="rspbtnverifyotp" name="rspbtnverifyotp" class="otp-submit" onClick="verifyRSPOtp()">Submit</button>
							
						<!--	<button type="button" id="rspbtnresendotpdis" name="rspbtnresendotp" style="display:block" >Resend</button> -->
							
							<button type="button" id="rspbtnresendotpena" name="rspbtnresendotp" onClick="resendRSPOTP()" class="otp-submit" style="display:none;background: #FCBB3D;
    border-color: #FCBB3D;" >Resend</button>
							
						</div>
						<span id="rspotperrmsg" style="color:red"></span>
						<span id="rspotpsuccmsg" style="color:green"></span>
					</div>
					<!--</form>-->
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="modal fade forgotPassword" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center no-pad">
				<button type="button" class="top-close close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<!--<form>-->
					
						<div class="login-block forgot_form text-center">
							
							<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
							<h2>Forgot Password?</h2>
							
								<form name="frmlogin" id="frmlogin" method="post" autocomplete="on">
									<div class="login-group">
								<input type="text" class="form-control" id="ftxtlogmobile" name="ftxtlogmobile" placeholder="Enter Mobile no" onkeypress="return isNumber(event)" >
								<div class="input-icon">
								    <span>+44</span>
								</div></div>
								
								 
							<button type="button" class="loginBtn" onclick="forgotButton()">Continue <i class="fa fa-chevron-right"></i></button>
							
							<span id="floginerrmsg" style="color:red"></span>
							</form>
							
							
						</div>
					
						
						<div class="login-block forgot_otp" >
						<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
						<h2>Enter OTP</h2>
						<div class="login-group otp-box"> <span id="ftimerspan">00:30</span>
							<form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
							<div class="ftdigitview">
								<input type="text" id="fdigit1" name="fdigit1" placeholder="0" data-next="fdigit2" maxlength="1" />
								<input type="text" id="fdigit2" name="fdigit2" placeholder="0" data-next="fdigit3" data-previous="fdigit1" maxlength="1" />
								<input type="text" id="fdigit3" name="fdigit3" placeholder="0" data-next="fdigit4" data-previous="fdigit2" maxlength="1" />
								<input type="text" id="fdigit4" name="fdigit4" placeholder="0" data-next="fdigit5" data-previous="fdigit3" maxlength="1" /> 
								</div>
								</form>
						</div>
						<div class="otp-buttons d-flex">
						   <input type="hidden" id="fphdnuserid" name="fphdnuserid" value="" >
						   <input type="hidden" id="fphdnusermob" name="fphdnusermob" value="" >
						   
							<button type="button" id="fpbtnverifyotp" name="fpbtnverifyotp" class="otp-submit" onClick="verifyFPOtp()">Submit</button>
							
							<button type="button" id="fpbtnresendotpdis" name="fpbtnresendotp" style="display:block" >Resend</button>
							
							<button type="button" id="fpbtnresendotpena" name="fpbtnresendotp" onClick="resendFPOTP()" class="otp-submit" style="display:none;background: #FCBB3D;
    border-color: #FCBB3D;" >Resend</button>
							
						</div>
						<span id="fpotperrmsg" style="color:red"></span>
						<span id="fpotpsuccmsg" style="color:green"></span>
					</div>
					<!--</form>-->
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div class="modal fade loginPopup" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
				<button type="button" class="close top-close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<!--<form>-->
					
						<div class="login-block login_form text-center">
							
							<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
							<h2>Signin With</h2>
							
								<form name="frmlogin" id="frmlogin" method="post" autocomplete="on">
									<div class="login-group">
								<input type="text" class="form-control" id="txtlogmobile" name="txtlogmobile" placeholder="Enter Mobile no" onkeypress="return isNumber(event)" value="<?php if(isset($_COOKIE["member_mobile"])) { echo $_COOKIE["member_mobile"]; } ?>" >
								<div class="input-icon">
								    <span>+44</span>
								</div></div>
								<div class="login-group">
								<div class="input-icon" ><i class="flaticon-key"></i></div>
								<input type="password" class="form-control" id="txtlogpassword" name="txtlogpassword" placeholder="Enter Password" value="<?php if(isset($_COOKIE["member_pwd"])) { echo $_COOKIE["member_pwd"]; } ?>"></div>
								 
								 <input type="hidden" id="hdncryptpwd" name="hdncryptpwd" value="<?php if(isset($_COOKIE["member_pwd"])) { echo $_COOKIE["member_pwd"]; } ?>" >
								 
							<button type="button" class="loginBtn mb-3" onclick="loginButton()">Continue <i class="fa fa-chevron-right"></i></button>
							<!-- <input type="submit" value=""> -->
							<span id="loginerrmsg" style="color:red;" class="mb-0"></span>
							</form>
							<div class="d-flex">
							<div class="text-left sl-regi mb-4 w-50"><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["member_mobile"])) { ?> checked <?php } ?>/>
		<label for="remember-me">Remember me</label> </div>
		
								<div class="text-right  w-50  sl-regi mb-4"> <a  data-toggle="modal" data-target=".forgotPassword" id="fploginotppop">Forgot Password?  </a> </div>
								<div class="clearfix"></div></div>
							<div class="login_alt_text"> <span> Easy Login with </span> </div>
							<div class="text-center login-social">
								
							</div>
							<div class="text-center sl-regi"> <a  data-toggle="modal" data-target="#RegisterModal" data-dismiss="modal">Don't have an account? <span >Register Now</span> </a> </div>
					
						</div>
					
						
						<div class="login-block login_otp" >
						<div class="login_logo">
								<a href="#"> <img src="images/logo-icon.png"></a>
							</div>
						<h2>Enter OTP</h2>
						<div class="login-group otp-box"> <span id="timerspan">00:30</span>
							<form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
							<div class="digitview">
								<input type="text" id="digit1" name="digit1" placeholder="0" data-next="digit2" maxlength="1" />
								<input type="text" id="digit2" name="digit2" placeholder="0" data-next="digit3" data-previous="digit1" maxlength="1" />
								<input type="text" id="digit3" name="digit3" placeholder="0" data-next="digit4" data-previous="digit2" maxlength="1" />
								<input type="text" id="digit4" name="digit4" placeholder="0" data-next="digit5" data-previous="digit3" maxlength="1" /> 
								</div>
								</form>
						</div>
						<div class="otp-buttons d-flex">
						   <input type="hidden" id="hdnuserid" name="hdnuserid" value="" >
						   <input type="hidden" id="hdnusermob" name="hdnusermob" value="" >
						   <input type="hidden" id="hdnusertoken" name="hdnusertoken" value="" >
							<button type="button" id="btnverifyotp" name="btnverifyotp" class="otp-submit" onClick="verifyOtp()">Submit</button>
							
							<button type="button" id="btnresendotpdis" name="btnresendotp" style="display:block" >Resend</button>
							
							<button type="button" id="btnresendotpena" name="btnresendotp" onClick="resendOTP()" class="otp-submit" style="display:none;background: #FCBB3D;
    border-color: #FCBB3D;" >Resend</button>
							
						</div>
						<span id="otperrmsg" style="color:red"></span>
						<span id="otpsuccmsg" style="color:green"></span>
					</div>
					<!--</form>-->
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	<div class="modal right fade registerModal" id="RegisterModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
	<form id="registerform" name="registerform"  method="post" autocomplete="off">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeReg" ><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<h4 class="modal-title" id="myModalLabel2">User Registration</h4>
				</div>

				<div class="modal-body">
					
					
					
					
					<div class="tp-block">



      
	  
	  <div class="task-form-block tfb-last-child">
	 
	  <div class="tfb-icon">
	  <i class="flaticon-clipboards-1"></i>
	  </div>
	    <div class="tfb-info">
	  <input type="text" class="form-control" <?php if(isset($_SESSION['g_name']) && !empty($_SESSION['g_name'])){ ?> value="<?=$_SESSION['g_name']?>" <?php } ?> id="txtfirstname" name="txtfirstname" placeholder="First Name" required="true">
	  <input type="text" class="form-control" <?php if(isset($_SESSION['g_last_name']) && !empty($_SESSION['g_last_name'])){ ?> value="<?=$_SESSION['g_last_name']?>" <?php } ?> id="txtlastname" name="txtlastname" placeholder="Last Name" required="true">
      <input type="text" class="form-control" id="txtdob" name="txtdob" placeholder="Date of Birth"  required="true">
      
      <input type="hidden" name="fb_token" <?php if(isset($_SESSION['token']) && !empty($_SESSION['token'])){ ?> value="<?=$_SESSION['token']?>" <?php } ?> >
	<div class="chkContainer">
	  
	  <h4>Gender</h4>
	  <label class="chkcontainer">
	  <input type="radio" name="gender" id="gender" value="Male" checked >Male
	  <span class="chkcheckmark"></span>
	  </label>
	  
	  <label class="chkcontainer">
	  <input type="radio" name="gender" id="gender" value="Female" >Female
	  <span class="chkcheckmark"></span>
	  </label>
	  

	  </div>
	  </div>
	
	 <div class="tfb-icon">
	  <i class="flaticon-location-2"></i>
	  </div>
	  	  	    <div class="tfb-info">
	  	  	    	<div class="login-group">
					  <input type="text" id="txtmobile" name="txtmobile" class="form-control" placeholder="Mobile No" onkeypress="return isNumber(event)" required="true">
					  <div class="input-icon">
								    <span>+44</span>
					  </div></div>
	   <input type="email" class="form-control" id="txtemail" <?php if(isset($_SESSION['g_email']) && !empty($_SESSION['g_email'])){ ?> value="<?=$_SESSION['g_email']?>" <?php } ?> name="txtemail" placeholder="Email Address" required="true">
				    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="true" minlength="6">
				      <input type="text" id="txtpostcode" name="txtpostcode" class="form-control" placeholder="Postcode" required="true" onBlur="getAddressDetails(this.value)">
				 <!--<input type="text" id="txtaddress" name="txtaddress" class="form-control" placeholder="Addresss" required="true">-->
				 <select id='txtaddress' name='txtaddress' class='form-control' ><option value=''>Select</option></select>
				 	   <input type="text" id="txtcity" name="txtcity" class="form-control" placeholder="City" required="true">
					   	   <input type="text" id="txtlandmark" name="txtlandmark" class="form-control" placeholder="County">
	

	   	  <input type="hidden" id="hdnlat" name="hdnlat" value="455" >
	   	  <input type="hidden" id="hdnlagt" name="hdnlagt" value="788" >
		
	  </div>
	
	</div>
	  </div>
	  	  

	  

	   	  <div class="task-form-block tfb-last-child">
	<div class="form-accept">
	
	
<label class="checkboxcontainer"> I Agree to the <a href="#"> terms &amp; Conditions</a>
  <input type="checkbox" checked="checked">
  <span class="checkboxcheckmark"></span>
</label>
	
	<span id="regerrmsg" style="color:red"></span>
	</div>
	
	
</div>

				</div>

				
									
	<input type="button" class="btn-reg" value="Submit" onClick="sendContact()">	
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
		</form>
		
	</div><!-- modal -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
	
	<!--<script src="assets/js/jquery.validate.js"></script>-->
	<script>
	
			function isNumber(evt) 
			{
	
				evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) 
				{
					return false;
				}
				return true;
			}
	</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/plugins/timepicker/timepicker.js"></script>

	<script src="assets/owl/js/owl.carousel.min.js"></script>
	<script src="assets/scripts/scripts.js"></script>
	<?php
	if($filename=='index.php')
	{
		$marginy=30;
		$marginx=30;
		$setx=280;
		$sety=210;
	}
	if($filename=='vendor-registration.php' || $filename=='services.php')
	{
		$marginy=30;
		$marginx=30;
		$setx=200;
		$sety=100;
	}
	
	?>
	<script>
	$(document).ready(function() {
		var scroll_pos = 0;
		$(document).scroll(function() {
			scroll_pos = $(this).scrollTop();
			if(scroll_pos > 0) {
				$(".main_navigation").addClass("nav-bg");
			} else {
				$(".main_navigation").removeClass("nav-bg");
			}
		});
	});
	    
	$('#txtdob').datepicker({
        clearBtn: true,
        format: "dd/mm/yyyy",
        maxDate: 0
    });
	</script>
	
	<script type="text/javascript" src="assets/plugins/covering/js/coveringBad.js"></script>
	<script type="text/javascript">
	$('.first').coveringBad({
		marginY: <?php echo $marginy; ?>,
		marginX: <?php echo $marginx; ?>,
		setX: <?php echo $setx; ?>,
		setY: <?php echo $sety; ?>,
		direction: "horizontal"
	});
	</script>
	<script src="assets/plugins/testimonials/jquery.bxslider.min.js"></script>
	<script src="assets/plugins/testimonials/wow.js"></script>
	<script src="assets/plugins/testimonials/theme.js"></script>
	<script>
		$(document).ready(function() {
		
		
		
		$('.sl-regi a').click(function(){
		
		
		
		$('.loginPopup').modal('hide');
		});
		
		
		
		
		});

	</script>
	
	<script>
	$(document).ready(function(){
    $(".login_otp").hide();
    $(".loginBtn").on("click",function(){

	
	 //$(".login_form").hide();
       // $(".login_otp").show();
       
    });
  
});
	
	
	</script>
	
	 
	<!-- Vendor reg page scripts start -->

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
	
	<!-- Vendor reg page scripts end -->
	
	
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<style>
/*body{width:610px;}*/
#frmContact {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#frmContact div{margin-bottom: 15px}
#frmContact div label{margin-left: 5px}
.demoInputBox{padding:10px; border:#F0F0F0 1px solid; border-radius:4px;}
.btnAction{background-color:#2FC332;border:0;padding:10px 40px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px;}

</style>

<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>-->
<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
	


<script>
function sendContact() {
	
	var valid;	
	valid = validateContact();
	//alert(valid);
	
	var firstname=$("#txtfirstname").val();
	var lastname=$("#txtlastname").val();
	var dob=$("#txtdob").val();
	var gender=$("#gender").val();
	var mobile=$("#txtmobile").val();
	var email=$("#txtemail").val();
	var password=$("#password").val();
	/*if(password!='')
	{
		cript();
		var password=$("#password").val();
	}*/
	var postcode=$("#txtpostcode").val();
	var address=$("#txtaddress").val();
	var city=$("#txtcity").val();
	var landmark=$("#txtlandmark").val();
	
	var latitue=$("#hdnlat").val();
	var langitude=$("#hdnlagt").val();
	
	var fb_token = $('input[name=fb_token]').val();
	
	if(valid) {
		//alert('yes');
		var flag='yes';				
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : 'fb_token='+fb_token+'&firstname='+firstname+'&lastname='+lastname+'&dob='+dob+'&gender='+gender+'&mobile='+mobile+'&email='+email+'&postcode='+postcode+'&address='+address+'&city='+city+'&landmark='+landmark+'&latitue='+latitue+'&langitude='+langitude+'&password='+password+'&flag=registration',
			success: function(data)
			{
				
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
						document.getElementById("closeReg").click();
						document.getElementById("loginotppop").click();
						$(".login_form").hide();
						$(".login_otp").show();
						document.getElementById("hdnuserid").value=userid;
						document.getElementById("hdnusermob").value=usrmob;
						document.getElementById("hdnusertoken").value=usrtoken;
						getTimer();
					}
					else
					{
						document.getElementById("regerrmsg").innerHTML=errmsg;
					}
				}
				
				
			},
		  
		});
	}
}

function validateContact() {
	var valid = true;
	$("#registerform input[required=true], #registerform textarea[required=true], #registerform select[required=true]").each(function(){
		$(this).removeClass('invalid');
		$(this).attr('title','');
		
		//alert($(this).attr("id"));
		if(!$(this).val()){			
			$(this).addClass('invalid');
			$(this).attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
		}
		if($(this).attr("id")=='txtfirstname' || $(this).attr("id")=='txtlastname' || $(this).attr("id")=='txtpostcode' || $(this).attr("id")=='txtcity' || $(this).attr("id")=='txtlandmark')
		{
			var iChars = "!`@#$%^&*()+=-[]\\\';/{}|\":<>?~_";
			var dataval=$(this).val();
			for (var i = 0; i < dataval.length; i++)
			{
				if (iChars.indexOf(dataval.charAt(i)) != -1)
				{ 
					$(this).addClass('invalid');
					$(this).attr('title','Invalid Data');
					valid = false;
					$( ".invalid" ).tooltip({
						   "ui-tooltip": "highlight",
					position: { my: "left+15 center", at: "right center" }
					});
				}
			}
		}
		
		if($(this).attr("id")=='txtdob')
		{
			var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
			if(!pattern.test($(this).val()))
			{
				$(this).addClass('invalid');
					$(this).attr('title','Invalid Date Format');
					valid = false;
					$( ".invalid" ).tooltip({
						   "ui-tooltip": "highlight",
					position: { my: "left+15 center", at: "right center" }
					});
			}
		}
		if($(this).attr("id")=='txtmobile')
		{
			var phone = $(this).val();
			var intRegex = /[0-9 -()+]+$/;
			if((phone.length!=10) || (!intRegex.test(phone)))
			{
				 $(this).addClass('invalid');
					$(this).attr('title','Invalid Mobile Number');
					valid = false;
					$( ".invalid" ).tooltip({
						   "ui-tooltip": "highlight",
					position: { my: "left+15 center", at: "right center" }
					});
			}	
		}
		if($(this).attr("type")=="email" && !$(this).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
			$(this).addClass('invalid');
			$(this).attr('title','Enter valid email');
			valid = false;
		}
		
		
			if($(this).attr("id")=='password' )
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
		
		
		
	}); 
	return valid;
}

function validateContact_login() {
	var valid = true;
	$('#txtlogmobile').removeClass('invalid');
	$('#txtlogmobile').attr('title','');
	$('#txtlogpassword').removeClass('invalid');
	$('#txtlogpassword').attr('title','');
	var phone=document.getElementById('txtlogmobile').value;
	if(document.getElementById('txtlogmobile').value=='') 
	{
		
		$('#txtlogmobile').removeClass('invalid');
		$('#txtlogmobile').attr('title','');
        $('#txtlogmobile').addClass('invalid');
			$('#txtlogmobile').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
            
    }
	/*else if(document.getElementById('txtlogmobile').value!='') 
	{
		if((phone.length!=10) || (!intRegex.test(phone)))
		{
			$('#txtlogmobile').removeClass('invalid');
		$('#txtlogmobile').attr('title','');
        $('#txtlogmobile').addClass('invalid');
			$('#txtlogmobile').attr('title','Invalid mobile number');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
		}
	}*/
    if(document.getElementById('txtlogpassword').value=='') 
	{
		
		$('#txtlogpassword').removeClass('invalid');
		$('#txtlogpassword').attr('title','');
        $('#txtlogpassword').addClass('invalid');
			$('#txtlogpassword').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });

    }
	if(document.getElementById('txtlogmobile').value!='') 
	{
		var intRegex = /[0-9 -()+]+$/;
		if((phone.length!=10) || (!intRegex.test(phone)))
		{
			$('#txtlogmobile').removeClass('invalid');
		$('#txtlogmobile').attr('title','');
        $('#txtlogmobile').addClass('invalid');
			$('#txtlogmobile').attr('title','Invalid mobile number');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
		}
	}
	return valid;
}

  /*$(function() {
    $( document ).tooltip({
		position: {my: "right top", at: "right top"},
	  items: "input[required=true], textarea[required=true]",
      content: function() { return $(this).attr( "title" ); }
    });
  });*/

  $("#digit1").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#digit2").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#digit3").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});
	$("#digit4").keyup(function(){
		el = $(this);
		if(el.val().length >= 1){
			el.val( el.val().substr(0, 1) );
		} 
	});

function verifyOtp()
{
	var digitone=document.getElementById("digit1").value;
	var digittwo=document.getElementById("digit2").value;
	var digitthr=document.getElementById("digit3").value;
	var digitfour=document.getElementById("digit4").value;
	var user_id=document.getElementById("hdnuserid").value;
	var mobile=document.getElementById("hdnusermob").value;
	var token=document.getElementById("hdnusertoken").value;
	if(digitone!="" && digittwo!="" && digitthr!="" && digitfour!="" && user_id!="" && mobile!="" && token!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : 'digitone='+digitone+'&digittwo='+digittwo+'&digitthr='+digitthr+'&digitfour='+digitfour+'&user_id='+user_id+'&mobile='+mobile+'&token='+token+'&flag=verify_otp',
			success: function(data)
			{
				//alert(data);
				if(data!="")
				{
					
					if(data=='yes')
					{
						location.href="my-account.php";
					}
					else
					{
						document.getElementById("otperrmsg").innerHTML=data;
					}
				}
				
				
			},
		  
		});
	}
	else
	{
	}
}
function loginButton()
{
	var valid;	
	
	valid = validateContact_login();
	//alert(valid);
	var mobile=document.getElementById("txtlogmobile").value;
	var password=document.getElementById("txtlogpassword").value;
	
	var hdncryptpwd=document.getElementById("hdncryptpwd").value;
	var rememberval='';
	if ($('#remember').is(":checked"))
	{
		rememberval='yes';
	}
	else
	{
		rememberval='no';
	}
	//alert(rememberval);
	
	if(valid) 
	{
		if(password!='')
		{
			if(password==hdncryptpwd)
			{
				
			}
			else
			{
				cript1();
			}
			var password=document.getElementById("txtlogpassword").value;
		}
		if(mobile!="" && password!='')
		{
			$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&mobile='+mobile+'&password='+password+'&rememberval='+rememberval+'&flag=login',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var register=arr[0];
					var errmsg=arr[1];
					var userid=arr[2];
					var usrmob=arr[3];
					var usrtoken=arr[4];
					if(register=='yes')
					{
						$(".login_form").hide();
						$(".login_otp").hide();
						document.getElementById("hdnuserid").value=userid;
						document.getElementById("hdnusermob").value=usrmob;
						document.getElementById("hdnusertoken").value=usrtoken;
						//getTimer();
						//alert('<?php echo $_COOKIE['redirect_to']; ?>');
						<?php
			if(isset($_COOKIE['redirect_to']))
			{
			   $urlre = $_COOKIE['redirect_to'];
			   setcookie("redirect_to", "");
			   unset($_COOKIE['redirect_to']);
			   ?>
			 //alert('<?php echo $urlre; ?>');
			 location.href="<?php echo $urlre; ?>";
			 <?php
			}
			else
			{
			    ?>
			    document.getElementById("frmlogin").action = 'my-account.php';
						document.getElementById("frmlogin").submit();
						//location.href="my-account.php";
			    <?php
			}
			?>
						
					}
					else
					{

						document.getElementById("txtlogpassword").value='';
						document.getElementById("loginerrmsg").innerHTML=errmsg;
					}
				}
				
			},
		  
		});
	}
	else
    {
   	return false;
    }
   }
   else
   {
   	return false;
   }
}

function logoutButton()
{
	location.href="logout.php"
}

var container = document.getElementsByClassName("digitview")[0];
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

function goto_result()
{
	var type=document.getElementById("hdnstype").value;
	var id=document.getElementById("hdnsid").value;
	var name=document.getElementById("hdnsname").value;
	if(type=='category')
	{
      location.href="category.php?id="+id+"&title="+name;
	}
	else if(type=='subcategory')
	{
		location.href="subcategory.php?id="+id+"&title="+name;
	}
}

function getTimer()
{
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
  
  $('#timerspan').html(minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
  if(seconds==00)
  {
	  $('#timerspan').html('00:00');
	   clearInterval(interval);
	  doSomething();
  }
}, 1000);

}

function doSomething() {
    //alert("Hi");
	document.getElementById("btnresendotpdis").style.display="none";
	document.getElementById("btnresendotpena").style.display="block";
}

function resendOTP()
{
	var user_id=document.getElementById("hdnuserid").value;
	var mobile=document.getElementById("hdnusermob").value;
	var token=document.getElementById("hdnusertoken").value;
	if(user_id!="" && mobile!="" && token!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&mobile='+mobile+'&user_id='+user_id+'&token='+token+'&flag=resend_otp',
			success: function(data)
			{
				var arr=new Array();
				var arr=data.split('@6256@');
				var otpresent=arr[0];
				var errmsg=arr[1];
				var userid=arr[2];
				var usrmob=arr[3];
				var usrtoken=arr[4];
					
				if(data!="")
				{
					if(otpresent=='yes')
					{
						document.getElementById("btnresendotpena").style.display="none";
						document.getElementById("btnresendotpdis").style.display="block";
						document.getElementById("otpsuccmsg").innerHTML=errmsg;
						getTimer();
					}
					else
					{
						document.getElementById("otperrmsg").innerHTML=errmsg;
						
					}
					
				}
				
			},
		  
		});
	}
}
function getAddressDetails(postcode)
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
				document.getElementById('txtaddress').innerHTML=address;
				document.getElementById('txtcity').value=city;
				document.getElementById('hdnlat').value=latitude;
				document.getElementById('hdnlagt').value=langtitude;
				document.getElementById('txtlandmark').value=county;
			},
		  
		});
	}
}	
</script>
<?php
if($_REQUEST['flag']!='' && $_REQUEST['flag']=='login' && $user_id=="")
{
	?>
	<script>
	$(".loginPopup ").modal('show');
    </script>
	<?php
}

if(isset($_SESSION['g_signup']) && !empty($_SESSION['g_signup']))
{ ?>
    <script>
        $('#RegisterModal').modal('show');
    </script>
<?php } ?>




<script>
$(document).ready(function(){
    $(".forgot_otp").hide();
    
});

$(document).ready(function(){
    $(".reset_otp").hide();
});

function forgotButton()
{
	var valid;	
	
	valid = validateForgot();
	var mobile=$("#ftxtlogmobile").val();
	if(valid)
	{
		$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&mobile='+mobile+'&flag=forgot_pwd',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					var userid=arr[2];
					var usrmob=arr[3];
					//var usrtoken=arr[4];
					if(sts=='yes')
					{
						$(".forgot_form").hide();
						$(".forgot_otp").show();
						document.getElementById("fphdnuserid").value=userid;
						document.getElementById("fphdnusermob").value=usrmob;
						fgetTimer()	
					}
					else
					{
						document.getElementById("floginerrmsg").innerHTML=errmsg;
					}
				}
				
			},
		  
		});
	}
}
function validateForgot()
{
	var valid = true;
	$('#ftxtlogmobile').removeClass('invalid');
	$('#ftxtlogmobile').attr('title','');
	$('#txtlogpassword').removeClass('invalid');
	$('#txtlogpassword').attr('title','');
	var phone=document.getElementById('ftxtlogmobile').value;
	if(document.getElementById('ftxtlogmobile').value=='') 
	{
		
		$('#ftxtlogmobile').removeClass('invalid');
		$('#ftxtlogmobile').attr('title','');
        $('#ftxtlogmobile').addClass('invalid');
			$('#ftxtlogmobile').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
            
    }
	if(document.getElementById('ftxtlogmobile').value!='') 
	{
		var intRegex = /[0-9 -()+]+$/;
		if((phone.length!=10) || (!intRegex.test(phone)))
		{
			$('#ftxtlogmobile').removeClass('invalid');
		$('#ftxtlogmobile').attr('title','');
        $('#ftxtlogmobile').addClass('invalid');
			$('#ftxtlogmobile').attr('title','Invalid mobile number');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
		}
	}
	return valid;
}

function fgetTimer()
{
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
  
  $('#ftimerspan').html(minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
  if(seconds==00)
  {
	  $('#ftimerspan').html('00:00');
	   clearInterval(interval);
	  fdoSomething();
  }
}, 1000);

}

function fdoSomething() {
    //alert("Hi");
	document.getElementById("fpbtnresendotpdis").style.display="none";
	document.getElementById("fpbtnresendotpena").style.display="block";
}
function resendFPOTP()
{
	var mobile=$("#ftxtlogmobile").val();
	if(mobile!="")
	{
		$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&mobile='+mobile+'&flag=forgot_pwd',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					var userid=arr[2];
					var usrmob=arr[3];
					//var usrtoken=arr[4];
					if(sts=='yes')
					{
						//$(".forgot_form").hide();
						//$(".forgot_otp").show();
						document.getElementById("fphdnuserid").value=userid;
						document.getElementById("fphdnusermob").value=usrmob;
						
						document.getElementById("fpbtnresendotpena").style.display="none";
						document.getElementById("fpbtnresendotpdis").style.display="block";
						document.getElementById("fpotpsuccmsg").innerHTML=errmsg;
						
						fgetTimer()	
					}
					else
					{
						document.getElementById("fpotperrmsg").innerHTML=errmsg;
					}
				}
				
			},
		  
		});
	}
}
function verifyFPOtp()
{
	var mobile=$("#fphdnusermob").val();
	var userid=$("#fphdnuserid").val();
	var digitone=$("#fdigit1").val();
	var digittwo=$("#fdigit2").val();
	var digitthr=$("#fdigit3").val();
	var digitfour=$("#fdigit4").val();
	var otp=digitone+''+digittwo+''+digitthr+''+digitfour;
	
	
	if(mobile!="" && userid!="")
	{
		$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&mobile='+mobile+'&userid='+userid+'&otp='+otp+'&flag=forgot_otp_verify',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					//var userid=arr[2];
					//var usrmob=arr[3];
					//var usrtoken=arr[4];
					if(sts=='yes')
					{
						//document.getElementById("fpotpsuccmsg").innerHTML=errmsg;
						//document.getElementById("fpotperrmsg").innerHTML="";
						
						alert(errmsg);
						location.reload();
						
					}
					else
					{
						document.getElementById("fpotperrmsg").innerHTML=errmsg;
						document.getElementById("fpotpsuccmsg").innerHTML="";
					}
				}
				
			},
		  
		});
	}
}
</script>
<?php
if($reqfid!="")
{
	?>
	<script>
	document.getElementById("rsploginotppop").click();
	</script>
	<?php
}
?>
<script>
function resetButton()
{
	var paswd=$("#rstxtlogpassword").val();
	var cpaswd=$("#rstxtclogpassword").val();
	var userid=$("#rspphdnuserid").val();
	valid=validateReset();
	//alert(valid);
	if(valid)
	{
		if(paswd!=cpaswd)
		{
			//alert('invalid pwd');
			
			$("#rsploginerrmsg").html("Password should match with confirm password");
			
		}
		else
		{
			$("#rsploginerrmsg").html("");
			
			$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&password='+paswd+'&userid='+userid+'&flag=reset_password',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					//var userid=arr[2];
					//var usrmob=arr[3];
					//var usrtoken=arr[4];
					if(sts=='yes')
					{
						$(".reset_form").hide();
						$(".reset_otp").show();
						//document.getElementById("fphdnuserid").value=userid;
						//document.getElementById("fphdnusermob").value=usrmob;
						rspgetTimer()
						
					}
					else
					{
						document.getElementById("rsploginerrmsg").innerHTML=errmsg;
						
					}
				}
				
			},
		  
		});
			
		}
	}
}

function validateReset()
{
	var valid = true;
	$('#rstxtlogpassword').removeClass('invalid');
	$('#rstxtlogpassword').attr('title','');
	$('#rstxtclogpassword').removeClass('invalid');
	$('#rstxtclogpassword').attr('title','');
	//var phone=document.getElementById('rstxtlogpassword').value;
	if(document.getElementById('rstxtlogpassword').value=='') 
	{
		
		$('#rstxtlogpassword').removeClass('invalid');
		$('#rstxtlogpassword').attr('title','');
        $('#rstxtlogpassword').addClass('invalid');
			$('#rstxtlogpassword').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
            
    }
	if(document.getElementById('rstxtclogpassword').value=='') 
	{
		
		$('#rstxtclogpassword').removeClass('invalid');
		$('#rstxtclogpassword').attr('title','');
        $('#rstxtclogpassword').addClass('invalid');
			$('#rstxtclogpassword').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
			       "ui-tooltip": "highlight",
            position: { my: "left+15 center", at: "right center" }
            });
            
    }
	
	return valid;
}


function rspgetTimer()
{
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
  
  $('#rsptimerspan').html(minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
  if(seconds==00)
  {
	  $('#rsptimerspan').html('00:00');
	   clearInterval(interval);
	  rsdoSomething();
  }
}, 1000);

}

function rsdoSomething() {
    //alert("Hi");
	document.getElementById("rspbtnresendotpdis").style.display="none";
	document.getElementById("rspbtnresendotpena").style.display="block";
}

function resendRSPOTP()
{
	$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&flag=reset_password_otprs',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					
					if(sts=='yes')
					{
						
						document.getElementById("rspotpsuccmsg").innerHTML=errmsg;
						
						document.getElementById("rspbtnresendotpena").style.display="none";
						document.getElementById("rspbtnresendotpdis").style.display="block";
						
						rspgetTimer()
						
					}
					else
					{
						document.getElementById("rspotperrmsg").innerHTML=errmsg;
						
					}
				}
				
			},
		  
		});
}
function verifyRSPOtp()
{
	//var mobile=$("#fphdnusermob").val();
	//var userid=$("#fphdnuserid").val();
	var digitone=$("#rsdigit1").val();
	var digittwo=$("#rsdigit2").val();
	var digitthr=$("#rsdigit3").val();
	var digitfour=$("#rsdigit4").val();
	var otp=digitone+''+digittwo+''+digitthr+''+digitfour;
	
	
	if(otp!="")
	{
		$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&otp='+otp+'&flag=reset_otp_verify',
				success: function(data)
				{
				if(data!="")
				{
					//alert(data);
					var arr=new Array();
		            var arr=data.split('@6256@');
					var sts=arr[0];
					var errmsg=arr[1];
					//var userid=arr[2];
					//var usrmob=arr[3];
					//var usrtoken=arr[4];
					if(sts=='yes')
					{
						//document.getElementById("fpotpsuccmsg").innerHTML=errmsg;
						//document.getElementById("fpotperrmsg").innerHTML="";
						
						alert(errmsg);
						location.href="index.php";
						
					}
					else
					{
						document.getElementById("rspotperrmsg").innerHTML=errmsg;
						document.getElementById("rspotpsuccmsg").innerHTML="";
					}
				}
				
			},
		  
		});
	}
}

var container = document.getElementsByClassName("rspdigitview")[0];
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

var container = document.getElementsByClassName("ftdigitview")[0];
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

<script src="cropping/dist_files/jquery.imgareaselect.js" type="text/javascript"></script>
<script src="cropping/dist_files/jquery.form.js"></script>
<link rel="stylesheet" href="cropping/dist_files/imgareaselect.css">
<script src="cropping/functions.js"></script>

