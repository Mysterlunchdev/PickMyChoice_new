<?php include("header.php"); ?>
	<section class=" ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="login-block text-center">
						<h2>Signin With</h2>
						<div class="login-group">
							<input type="text" placeholder="Enter Mobile no"> </div>
						<!-- <input type="submit" value=""> --><span> Easy Login with </span>
						<div class="text-center login-social">
							<button class="btn-sl"> <i class="fab fa-google"></i></button>
							<button class="btn-sl"> <i class="fab fa-facebook"></i></button>
						</div>
						<div class="text-center sl-regi"> <a href="user-registration.html">Don't have an account? <span>Register Now</span> </a> </div>
					</div>
					<div class="login-block " style="margin-top:60px;">
						<h2>Enter OTP</h2>
						<div class="login-group otp-box"> <span>05:56</span>
							<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
								<input type="text" id="digit-1" name="digit-1" placeholder="5" data-next="digit-2" />
								<input type="text" id="digit-2" name="digit-2" placeholder="5" data-next="digit-3" data-previous="digit-1" />
								<input type="text" id="digit-3" name="digit-3" placeholder="5" data-next="digit-4" data-previous="digit-2" />
								<input type="text" id="digit-4" name="digit-4" placeholder="5" data-next="digit-5" data-previous="digit-3" /> </form>
						</div>
						<div class="otp-buttons">
							<button class="otp-submit">Submit</button>
							<button>Resend</button>
						</div>
					</div>
				</div>
			</div>
	</section>
	<div class="modal fade successPopup" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center"> <img src="images/success.jpg">
					<h2>Your Task <span class="highlight"> No.1123MAG </span> <span class="d-block"></span>is posted successfully.</h2>
					<h2>You May reach upto  <span class="d-block"></span><span class="highlight">1000</span> potential bidders</h2> <span class="sp-close" data-dismiss="modal">Close</span> </div>
			</div>
		</div>
	</div>
<?php include("footer.php"); ?>