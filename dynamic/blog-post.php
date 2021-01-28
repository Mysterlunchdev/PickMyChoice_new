<?php 
header("Content-Type: text/html; charset=ISO-8859-1");

include("header.php");

/*function curPageURL1() 
	{
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") 
		 {
		 $pageURL .= "s";
		 }
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") 
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } 
		 else 
		 {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
        return $pageURL;
    }*/
	$socialurl=$getpageurl;
	
$blog_id=base64_decode($_GET['blog_id']);
					
$getblog=$common_model->getBlog($blog_id);

if(sizeof($getblog)>0)
{
	for($b=0;$b<sizeof($getblog);$b++)
	{
		$getblogdet=$getblog[$b];
		$blog_id=$getblogdet['blogid'];
		 $title=$getblogdet['title'];
		$description=strip_tags($getblogdet['description']);
		$attachment=$getblogdet['attachment'];
		$blogpath="../uploads/blog/".$attachment;
		$tags=$getblogdet['tags'];
		$category=$getblogdet['category'];
		$meta_title=$getblogdet['meta_title'];
		$meta_keywords=$getblogdet['meta_keywords'];
		$meta_description=$getblogdet['meta_description'];
		$views=$getblogdet['views'];
		$blogdatetime=$getblogdet['blogdatetime'];
		$blogcatname=$getblogdet['blogcat'];
		
		$blogcreatedby=$getblogdet['blogcreatedby'];
		$getbuserinfo=$common_model->fetch_user_details($blogcreatedby);
		$profile_photo=$getbuserinfo[0]['profile_photo'];
		$profile_name=$getbuserinfo[0]['name'];
		if($profile_photo=='')
		{
		    $profile_photo='logo-icon.png';
		    
		}
		$profile_photopath=$baseurl.$userpath.$profile_photo;
		
		
		$bcreatedate= date('F d, Y', strtotime($blogdatetime));
		
		if($getcommentuserid!="")
		{	
		
		$cgetbuserinfo=$common_model->fetch_user_details($getcommentuserid);
		$cprofile_photo=$cgetbuserinfo[0]['profile_photo'];
		$cprofile_name=$cgetbuserinfo[0]['name'];
		$cprofile_lname=$cgetbuserinfo[0]['last_name'];
		$cpname=$cprofile_name.' '.$cprofile_lname;
		$cprofile_photopath='../uploads/user/'.$cprofile_photo;
		}
		else
		{
			$cpname=$getcommentcommentbcname;
			$cprofile_photopath="";
		}
		
		$updatevew=$common_model->updateBlogViews($blog_id);
		
		$bclass="";
		if($b%2==1)
		{
			$bclass="md-clearfix  sm-clearfix";
		}
		$getblogcmnt=$common_model->getBlogComments($blog_id);
		$getblogcmntcnt=sizeof($getblogcmnt);
		if($getblogcmntcnt=="")
		{
			$getblogcmntcnt=0;
		}
	}
}
 ?>
<div class="blog_section">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
					<div class="post_details">
						<div class="entry-content-detail ">
							<div class="list-categories"><a href="#" class="categories-name"><?php echo $blogcatname; ?></a></div>
							<h1 class="entry-title"> <?php echo $title; ?> </h1>
							<div class="top-detail-info">
								<div class="author-wrapper">
									<div class="flex-middle">
										<div class="avatar-img"> <img src="<?php echo $profile_photopath; ?>" width="40" height="40" alt="" class="avatar avatar-40 wp-user-avatar wp-user-avatar-40 photo avatar-default"> </div>
										<div class="right-inner">
											<h4 class="author-title"> <a href="#"> <?php echo $profile_name; ?> </a> </h4> </div>
									</div>
								</div>
								<div class="date"> <i class="flaticon-calendar"></i> <span><?php echo $bcreatedate; ?></span> </div> <span class="comments"><i class="flaticon-chat"> </i> <span><?php echo $getblogcmntcnt; ?> Comments</span> </span>
							</div>
							<div class="entry-thumb">
								<div class="post-thumbnail">
									<div class="image-wrapper image-loaded"><img src="<?php echo $blogpath; ?> " class="attachment-full size-full unveil-image" alt=""></div>
								</div>
							</div>
							<div class="single-info info-bottom">
								<div class="entry-description">
									<?php
									echo $description;
									?>
								</div>
								<!-- /entry-content -->
								<div class="tag-social flex-middle-sm">
									<div class="apus-social-share">
										<div class="bo-social-icons bo-sicolor social-radius-rounded"> <strong>Share Link </strong> <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $socialurl; ?>" data-original-title="facebook" class="bo-social-facebook addthis_button_facebook at300b" title="Facebook"><i class="fab fa-facebook-f"></i></a> <a target="_blank" href="https://twitter.com/share?url=<?php echo $socialurl; ?>" data-original-title="twitter" class="bo-social-twitter addthis_button_twitter at300b" title="Twitter"><i class="fab fa-twitter"></i></a> <a  href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $socialurl; ?>" data-original-title="linkedin" class="bo-social-linkedin addthis_button_linkedin at300b" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a> <a href="https://api.whatsapp.com/send?text=Check%20out%20my%20blog%20: <?php echo $title.' at '.$socialurl;?>" data-original-title="linkedin" class="bo-social-linkedin addthis_button_linkedin at300b" target="_blank" title="LinkedIn"><i class="fab fa-whatsapp"></i></a> </div>
									</div>
									<div class="ali-right"> <span class="entry-tags-list"><strong>Tags: </strong> <?php echo $tags; ?> </span> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="post-comment">
						<h2>Comments</h2>
						<?php
					
						$getcomments=$common_model->getBlogComments($blog_id);
						if(sizeof($getcomments)>0)
						{
							
							for($cm=0;$cm<sizeof($getcomments);$cm++)
							{
								$getcommentsf=$getcomments[$cm];
								$getcommentid=$getcommentsf['id'];
								$getcommentuserid=$getcommentsf['bcuserid'];
								$getcommentcomment=$getcommentsf['comment'];
								$getcommentcommentdate=$getcommentsf['commentdate'];
								
								$getcommentcommentbcname=$getcommentsf['bcname'];
								$getcommentcommentbcemail=$getcommentsf['bcemail'];
								
								$getcomentdate= date('d M, Y', strtotime($getcommentcommentdate));
								if($getcommentuserid!="" && $getcommentuserid!="0")
								{	
								
								$cgetbuserinfo=$common_model->fetch_user_details($getcommentuserid);
								$cprofile_photo=$cgetbuserinfo[0]['profile_photo'];
								$cprofile_name=$cgetbuserinfo[0]['name'];
								$cprofile_lname=$cgetbuserinfo[0]['last_name'];
								$cpname=$cprofile_name.' '.$cprofile_lname;
								$cprofile_photopath='../uploads/user/'.$cprofile_photo;
								}
								else
								{
									$cpname=$getcommentcommentbcname;
									$cprofile_photopath="";
								}
		//$updatevew=$common_model->updateBlogViews($blog_id);
		
						
						?>
						<div class="comment-box">
							<div class="comment-box-left">
								<a href="#"> <img class="img-responsive" src="<?php echo $cprofile_photopath; ?>"> </a>
							</div>
							<div class="comment-box-body">
								<div class="comment-box-heading">
									<div class="cbh-left">
										<h4><span><?php echo $cpname; ?></span><?php echo $getcomentdate; ?></h4> </div>
									
								</div>
								<p><?php echo $getcommentcomment; ?> </p>
							</div>
						</div>
						
						<?php
							}
						}
						?>
						
						<div class="comment_upload" id="Submit_Content">
							<h2> Leave a comment</h2>
							<form action="#" method="post">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<div class="form-group ">
											<label class="hidden">Name</label>
											<input type="text" name="txtcmtname" placeholder="Name" class="form-control" id="txtcmtname" value="<?php echo $getuserinfo[0]['name'].' '.$getuserinfo[0]['last_name']; ?>" aria-required="true"> </div>
									</div>
									<div class="col-sm-6 col-xs-12">
										<div class="form-group ">
											<label class="hidden">Email</label>
											<input id="txtcmtemail" name="txtcmtemail" placeholder="Email" class="form-control" type="text" value="<?php echo $getuserinfo[0]['email']; ?>" aria-required="true"> </div>
									</div>
								</div>
								<div class="form-group space-comment">
									<label class="hidden">Comment</label>
									<textarea rows="8" id="txtbcomment" placeholder="Write Your Comment" class="form-control" name="txtbcomment" aria-required="true"></textarea>
								</div>
								<span style="color:red" id="errormsgcmt"></span>
								<span style="color:green" id="sucesmsgcmt"></span>
								<p class="form-submit">
			<input name="button" type="button" id="submit" name="submit" class="btn btn-theme " value="Submit Comment" onClick="validateCommentPost()">
									<input type="hidden" name="comment_post_ID" value="250" id="comment_post_ID">
									<input type="hidden" name="comment_parent" id="comment_parent" value="<?php echo $blog_id; ?>"> </p>
							</form>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
					<?php include("blog_side_nav.php"); ?>
				</div>
			</div>
		</div>
	</div>
	
	
	<?php include("footer.php"); ?>
	
	<script>
	function validateCommentPost()
	{
		var valid = true;
		$('#txtcmtname').removeClass('invalid');
		$('#txtcmtname').attr('title','');
		$('#txtcmtemail').removeClass('invalid');
		$('#txtcmtemail').attr('title','');
		
		$('#txtbcomment').removeClass('invalid');
		$('#txtbcomment').attr('title','');
		var email=$("#txtcmtemail").val();
		//var phone=document.getElementById('txtcmtname').value;
		if(document.getElementById('txtcmtname').value=='') 
		{
			
			$('#txtcmtname').removeClass('invalid');
			$('#txtcmtname').attr('title','');
			$('#txtcmtname').addClass('invalid');
				$('#txtcmtname').attr('title','This field is required');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});
				
		}
		if(document.getElementById('txtcmtemail').value=='') 
		{
			
			$('#txtcmtemail').removeClass('invalid');
			$('#txtcmtemail').attr('title','');
			$('#txtcmtemail').addClass('invalid');
				$('#txtcmtemail').attr('title','This field is required');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});

		}
		if(document.getElementById('txtbcomment').value=='') 
		{
			
			$('#txtbcomment').removeClass('invalid');
			$('#txtbcomment').attr('title','');
			$('#txtbcomment').addClass('invalid');
				$('#txtbcomment').attr('title','This field is required');
				valid = false;
				$( ".invalid" ).tooltip({
					   "ui-tooltip": "highlight",
				position: { my: "left+15 center", at: "right center" }
				});

		}
		if(email!="" && !email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
			//alert("sdfsd");
			$('#txtcmtemail').addClass('invalid');
			$('#txtcmtemail').attr('title','This field is required');
			valid = false;
			$( ".invalid" ).tooltip({
				   "ui-tooltip": "highlight",
			position: { my: "left+15 center", at: "right center" }
			});
			valid = false;
		}
		

		//return valid;
		if(valid)
		{
			var name=$("#txtcmtname").val();
			var email=$("#txtcmtemail").val();
			var comment=$("#txtbcomment").val();
			var blog_id=$("#comment_parent").val();
			if(name!="" && email!="" && comment!="" && blog_id!="")
			{
				$.ajax({
				url : "ajax.php",
				type: "POST",
				data : '&name='+name+'&email='+email+'&comment='+comment+'&blog_id='+blog_id+'&flag=blog_comment',
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
						
						$("#errormsgcmt").html("");
						$("#sucesmsgcmt").html(errmsg);
						$("#txtcmtname").val("");
						$("#txtcmtemail").val("");
						$("#txtbcomment").val("");
			
					}
					else
					{
						$("#sucesmsgcmt").html("");
						$("#errormsgcmt").html(errmsg);
						
					}
				}
				
			},
		  
		});
			}
		}
	}
	</script>
	