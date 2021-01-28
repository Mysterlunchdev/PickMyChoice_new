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
								    
									<form  name="frmpassword" id="frmpassword" method="POST">
									<div class="my-task-list">
										<h4>Change Password</h4><br>
							
							<div class="row">
	  
	                            <div class="col-xl-4 col-lg-6 col-md-6">
	                                 
	                                         	<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-pin-code "></i> </div>
													<div class="vp_details">
														<label>Old Password <span><input type="password"  id="txtoldpwd" name="txtoldpwd" required="true"></span></label>
													</div>
												</div>
										
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-password"></i> </div>
													<div class="vp_details">
														<label>New Password <span><input type="password"  id="txtnewpwd" name="txtnewpwd" required="true" ></span></label>
													</div>
												</div>
									  
												<div class="vp_info">
													<div class="vp_icon"> <i class="flaticon-code"></i> </div>
													<div class="vp_details">
														<label>Confirm Password <span><input type="password"  id="txtcnewpwd" name="txtcnewpwd" required="true" ></span></label>
													</div>
												</div>
											  
	                            </div>
	                            <div class="clearfix"></div>
	                           
		                   </div>
		                    <span id="cngrsploginerrmsg" style="color:red;">
</span>
<div class="clearfix"></div>
	                            <span id="cngrsploginsucmsg" style="color:green;">
</span>
		     <div class="clearfix"></div>
	   <button class="btn-evp" type="button" name="btn_submit" id="btn_submit" onClick="changePassword()"><i class="fa fa-save"></i> Update </button>
							</div>
						</form>
									 
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

<script>
    
function changePassword()
{
	var oldpwd=$("#txtoldpwd").val();
	var paswd=$("#txtnewpwd").val();
	var cpaswd=$("#txtcnewpwd").val();
	valid=validatepwd();
	//alert(valid);
	if(valid)
	{
		if(paswd!=cpaswd)
		{
			//alert('invalid pwd');
			
			$("#cngrsploginerrmsg").html("Password should match with confirm password");
			
		}
		else
		{
			$("#cngrsploginerrmsg").html(""); 
			
			$("#cngrsploginsucmsg").html("");
			
			$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&password='+paswd+'&oldpwd='+oldpwd+'&flag=change_pwd',
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
					
						document.getElementById("cngrsploginsucmsg").innerHTML=errmsg;
						$("#txtoldpwd").val('');
						$("#txtnewpwd").val('');
						$("#txtcnewpwd").val('');
						location.href="logout.php";
					}
					else
					{
						document.getElementById("cngrsploginerrmsg").innerHTML=errmsg;
						
					}
				}
				
			},
		  
		});
			
		}
	}
}

function validatepwd()
{
	var valid = true;
	$("#frmpassword input[required=true], #frmpassword textarea[required=true], #frmpassword select[required=true]").each(function(){
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
		if($(this).attr("type")=="email" && !$(this).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
			$(this).addClass('invalid');
			$(this).attr('title','Enter valid email');
			valid = false;
		}  
	}); 
	return valid;
}
</script>

	
	
	