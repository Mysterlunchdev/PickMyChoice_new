<div class="sidebar">
    
    <div class="row">
        
        <div class="col-sm-6 col-md-6 col-lg-12">
					    <div class="widget">
							<h2 class="widget-title">Most popular Posts</h2>
							<div class="blog-list-widget">
								<div class="list-group">
								
								<?php
								$getblogp=$common_model->getPopularBlog();
								if(sizeof($getblogp)>0)
								{
									for($bp=0;$bp<sizeof($getblogp);$bp++)
									{
										$pgetblogdet=$getblogp[$bp];
										$pblog_id=$pgetblogdet['blogid'];
										$ptitle=$pgetblogdet['title'];
										$pdescription=strip_tags($pgetblogdet['description']);
										$pattachment=$pgetblogdet['attachment'];
										$pblogpath="../uploads/blog/".$pattachment;
										
										$pblogdatetime=$pgetblogdet['blogdatetime'];
										$pbcreatedate= date('d M, Y', strtotime($pblogdatetime));
									
								?>
									<a href="blog-post.php?blog_id=<?php echo base64_encode($pblog_id); ?>" class="list-group-item ">
										<div class="rp_item"> <img src="<?php echo $pblogpath; ?>" alt="" class="img-fluid float-left">
											<h5 class="mb-1"><?php echo $ptitle; ?> <small><?php echo $pbcreatedate; ?></small></h5> </div>
									</a>
									<?php
									}
								}
									?>
									
									
								</div>
							</div>
							<!-- end blog-list -->
						</div>
					</div>

        
        <div class="col-sm-6 col-md-6 col-lg-12">
    
    
    <div class="widget">
							<h2 class="widget-title">Recent Posts</h2>
							<div class="blog-list-widget">
								<div class="list-group">
								<?php
								$rgetblogp=$common_model->getRecentBlog();
								if(sizeof($getblogp)>0)
								{
									for($rbp=0;$rbp<sizeof($rgetblogp);$rbp++)
									{
										$rpgetblogdet=$rgetblogp[$rbp];
										$rpblog_id=$rpgetblogdet['blogid'];
										$rptitle=$rpgetblogdet['title'];
										$rpdescription=strip_tags($rpgetblogdet['description']);
										$rpattachment=$rpgetblogdet['attachment'];
										$rpblogpath="../uploads/blog/".$rpattachment;
										
										$rpblogdatetime=$rpgetblogdet['blogdatetime'];
										$rpbcreatedate= date('d M, Y', strtotime($rpblogdatetime));
									
								?>
									<a href="blog-post.php?blog_id=<?php echo base64_encode($rpblog_id); ?>" class="list-group-item ">
										<div class="rp_item"> <img src="<?php echo $rpblogpath; ?>" alt="" class="img-fluid float-left">
											<h5 class="mb-1"><?php echo $rptitle; ?> <small><?php echo $rpbcreatedate; ?></small></h5> </div>
									</a>
									
								<?php
									}
								}
								?>								
									
								</div>
							</div>
							<!-- end blog-list -->
						</div>
					
					</div>
				
        
        <div class="col-sm-6 col-md-6 col-lg-12">
						<div class="widget link-widget">
							<h2 class="widget-title">Popular Categories</h2>
							<ul>
							<?php
							$getblogcat=$common_model->getBlogCategories();
							if(sizeof($getblogcat)>0)
							{
								for($c=0;$c<sizeof($getblogcat);$c++)
								{
									$getblogcatf=$getblogcat[$c];
									$getblogcatid=$getblogcatf['id'];
									$getblogcatname=$getblogcatf['name'];
									
									$getblogcnt=$common_model->getBlogCategoryById($getblogcatid);
									$getblogcntcnt=sizeof($getblogcnt);
									if($getblogcntcnt=='')
									{
										$getblogcntcnt=0;
									}
								
							?>
								<li><a href="#"><?php echo $getblogcatname; ?> <span>(<?php echo $getblogcntcnt; ?>)</span></a></li>
								
								<?php
								}
							}
								?>
								
							</ul>
						</div>
						
						</div>
						</div>
					</div>