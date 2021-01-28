<?php 
header("Content-Type: text/html; charset=ISO-8859-1");

include("header.php"); 

?>


<div class="blog_section">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
					<div class="layout-blog">
						<div class="row">
						
						<?php
						
						$getblog=$common_model->getBlog();
						if(sizeof($getblog)>0)
						{
							for($b=0;$b<sizeof($getblog);$b++)
							{
								$getblogdet=$getblog[$b];
								$blog_id=$getblogdet['blogid'];
								$title=strip_tags($getblogdet['title']);
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
								
								 $bcreatedate= date('F d, Y', strtotime($blogdatetime));
								
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
						?>
							<div class="col-lg-6  col-md-6 col-xs-12 col-sm-6     <?php echo $bclass; ?> ">
								<article class="post-layout">
									<div class="list-inner">
										<div class="top-image">
											<div class="list-categories"><a href="blog-post.php?blog_id=<?php echo base64_encode($blog_id); ?>" class="categories-name"><?php echo $blogcatname; ?></a></div>
											<figure class="entry-thumb">
												<a class="post-thumbnail" href="blog-post.php?blog_id=<?php echo base64_encode($blog_id); ?>" aria-hidden="true">
													<div class="image-wrapper"><img src="<?php echo $blogpath; ?>" alt=""></div>
												</a>
											</figure>
										</div>
										<div class="col-content">
											<h4 class="entry-title"> <a href="blog-post.php?blog_id=<?php echo base64_encode($blog_id); ?>"><?php echo $title; ?></a> </h4>
											<div class="date"> <i class="flaticon-calendar"></i> <span><?php echo $bcreatedate; ?> </span></div>
											<div class="description"><?php //echo $description; ?> </div>
										</div>
										<div class="info-bottom flex-middle">
											<div class="author-wrapper flex-middle">
												<ul class="count_view">
													<li><a href="#"><i class="flaticon-visibility"> </i> <span><?php echo $views; ?></span></a> </li>
													<li><a href="#"><i class="flaticon-chat"> </i><span> <?php echo $getblogcmntcnt; ?></span></a> </li>
												</ul>
											</div>
											<div class="ali-right"> <a href="blog-post.php?blog_id=<?php echo base64_encode($blog_id); ?>" class="btn-readmore">Read More<i class="fas fa-angle-right"></i></a> </div>
										</div>
									</div>
								</article>
							</div>
							
							<?php
							}
						}
							?>
							
					
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
