<?php
include("header.php");
?>
	<div class="categories-section ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section_title">
						<h2><span>Popular</span> Categories</h2>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
					</div>
					<div class="row">
                        <?php
                        $limit=6;
                        $categories = $common_model->fetch_main_categories($limit); 
						if(count($categories)>0)
						{	
						    for($i=0;$i<4;$i++)
						       {
						       	$id = $categories[$i]['id'];
					            $name = $categories[$i]['name'];
					            $attachment = $categories[$i]['attachment'];
					            if($attachment!='')
					            {
					              $attachment=$baseurl.$categorypath.$attachment;
					            }
					            
					  $loccount=$common_model->getLocationCountByCatId($id);
					  $loccnt=sizeof($loccount);
                        ?>
						<div class="col-lg-3 col-md-4 col-sm-4  col-6">
							<a class="cat-block" href="category.php?id=<?=$id;?>&title=<?=$name;?>">
								<div class="cat_info"> 
									 <div class="cat_info_ima"> 
                                       <img src="<?=$attachment;?>">
                                     </div>
									<h4><?=$name;?></h4> </div>
								<div class="cat_location_count">
									<h5><span><?=$loccnt;?></span>Locations</h5> </div>
							</a>
						</div>
						<?php
						 }
						 }
						 ?>

						<?php
                       
						if(count($categories)>0)
						{	
						    for($i=4;$i<count($categories);$i++)
						       {
						       	$id = $categories[$i]['id'];
					            $name = $categories[$i]['name'];
					            $attachment = $categories[$i]['attachment'];
					            if($attachment!='')
					            {
					              $attachment=$baseurl.$categorypath.$attachment;
					            }
                        ?>
                         
						<div class="col-lg-3 <?php if($i==4) echo 'offset-lg-3';?> col-md-4  col-sm-4  col-6">
							<a class="cat-block" href="category.php?id=<?=$id;?>&title=<?=$name;?>">
								<div class="cat_info"> 
									<div class="cat_info_ima"> 
                                       <img src="<?=$attachment;?>">
                                     </div>
									<h4><?=$name;?></h4> </div>
								<div class="cat_location_count">
									<h5><span><?=$loccnt;?></span>Locations</h5> </div>
							</a>
						</div>
						<?php
						        }
						 }
						 ?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="vertical-tabs ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section_title">
						<h2><span>Popular</span> Categories</h2>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
					</div>
					<div class="vtabs">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<?php
							$limit=4;
                            $categories = $common_model->fetch_main_categories_limit(1,4); 
						    if(count($categories)>0)
						    {	
						    for($i=0;$i<count($categories);$i++)
						       {
						       	$id = $categories[$i]['id'];
					            $name = $categories[$i]['name'];
					            $attachment = $categories[$i]['attachment'];
					            if($attachment!='')
					            {
					              $attachment=$baseurl.$categorypath.$attachment;
					            }
							?>
							<li class="nav-item"> <a class="nav-link <?php if($i==0) echo 'active';?>" data-toggle="tab" href="#<?=str_replace(" ","-",$name);?>" role="tab" aria-controls="<?=str_replace(" ","-",$name);?>"><span><i class="flaticon-massage"></i> </span> <label><?=$name;?></label></a> </li>
							   <?php
								}
							}
						    ?>
						</ul>
						<div class="tab-content">
							<?php
                            $categories = $common_model->fetch_main_categories_limit(1,4); 
						    if(count($categories)>0)
						    {	
						    for($k=0;$k<count($categories);$k++)
						       {
						       	$catid = $categories[$k]['id'];
					            $name = $categories[$k]['name'];
					            ?>
							<div class="tab-pane <?php if($k==0) echo 'active';?>" id="<?=str_replace(" ","-",$name);?>" role="tabpanel">
								<div class="vtbs-cat">
									<div class="row">
										<?php
										$limit=6;
										$cat_id=$catid;
										$subcategories = $common_model->fetch_sub_cat_by_catid($catid,'',$limit);
										$m=count($subcategories);
										if(count($subcategories)>0)
									    {	
									    for($j=0;$j<count($subcategories);$j++)
									       {
									       	$sid=$subcategories[$j]['id'];
									       	$sname=$subcategories[$j]['sname'];
									       	$sattachment = $subcategories[$j]['attachment'];
								            if($sattachment!='')
								            {
								              $sattachment=$baseurl.$subcategorypath.$sattachment;
								            }
										    ?>
										<?php
										/*if($j==0)
										//{
										?>
										<div class="col-md-4  col-sm-4 col-6">
										<div class="row">
										<?php
										//}*/
										?>
												<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-6">
													<a href="subcategory.php?id=<?=$sid;?>&title=<?=$sname;?>&cat_id=<?=$catid;?>"> <img src="<?=$sattachment;?>"
														>
														<div class="vtbs-cat-title">
														<h4><?php echo ucwords($sname);?></h4> </div>
													</a>
												</div>
										<?php
									  /*if($j==1 && $m>2)
										{
										?>
									    </div>
								        </div>
										<div class="col-md-4">
										<div class="row">
										<?php
										}
										else if($m>4 && $j==3)
										{
											
											?>
											</div>
								            </div>
								            <div class="col-md-4">
										    <div class="row">
											<?php
										}
										else if($m==6 && $j==5) 
										{
											?>
											</div>
								            </div>
											<?php
										}*/

									}
								}
										?>
										
									</div>
								</div>
							</div>
						<?php
						}
						}
						?>
					
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="how-it-works ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section_title">
						<h2><span>How it</span> Works</h2>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
					</div>
					<div class="hit-container d-flex">
						<div class="hit-block"> <img src="images/hit/1.png">
							<h4>Find a service</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipis cing elit, sed do eiusmod tempor. </p>
						</div>
						<div class="hit-block"> <img src="images/hit/2.png">
							<h4>Find a service</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipis cing elit, sed do eiusmod tempor. </p>
						</div>
						<div class="hit-block"> <img src="images/hit/3.png">
							<h4>Find a service</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipis cing elit, sed do eiusmod tempor. </p>
						</div>
						<div class="hit-block"> <img src="images/hit/4.png">
							<h4>Find a service</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipis cing elit, sed do eiusmod tempor. </p>
						</div>
						<div class="hit-block"> <img src="images/hit/5.png">
							<h4>Find a service</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipis cing elit, sed do eiusmod tempor. </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="why-choose-us ptb-40">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section_title">
						<h2><span>Why Choose </span> Pickmychoice Services</h2>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry </p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="covered first" data-passive="images/b2.jpg" data-active="images/b1.jpg">
						<div class="handle"></div>
						<div class="changeable"></div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="hexa-box">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="hexa-container">
									<div class="hexagon one animate" data-anim-type="spinLeft" data-anim-delay="300"><img src="images/hit/2.png">
										<h4>Find a service</h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod incididunt. </p>
									</div>
								</div>
							</div>
							<div class="col-md-6  col-sm-6">
								<div class="hexa-container">
									<div class="hexagon one animate" data-anim-type="spinLeft" data-anim-delay="300"><img src="images/hit/5.png">
										<h4>Find a service</h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod incididunt. </p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 offset-md-3  col-sm-6 offset-sm-3">
								<div class="hexa-container hexa-third">
									<div class="hexagon six animate" data-anim-type="spinLeft" data-anim-delay="300"><img src="images/hit/3.png">
										<h4>Find a service</h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod incididunt. </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-download">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-sm-6">
					<h2>Service at your fingertip...

<span><strong>Download Pickmychoice</strong> App Now</span>	 
</h2>
					<p>All it takes 30 seconds to download. Your Mobile app for services fast, simple &amp; Delightful</p> <a href="#" class="ios"><i class="fab fa-apple"></i> App Store </a> <a href="#" class="ga"><i class="fab fa-google-play"></i> Google play</a> </div>
				<div class="col-lg-5 col-md-5 offset-lg-1 offset-md-1 col-sm-6"> <img src="images/app/app-screen.png" class="mobileapp-image"> </div>
			</div>
		</div>
	</div>
	<section class="testimonials-style-one  ">
		<!-- <img src="images/map-1-1.png" alt="Awesome Image" class="map-img" />  -->
		<div class="container testimonials">
			<div class="row ">
				<div class="col-lg-6  col-md-6 d-flex ">
					<div class="my-auto">
						<!-- <img src="images/testi-1-1.png" alt="Awesome Image" class="testi-img" /> -->
						<div id="testimonials-slider-pager">
							<div class="testimonials-slider-pager-one">
								<a href="#" class="pager-item active" data-slide-index="0"><img src="images/testimonials/testi-1-1.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="1"><img src="images/testimonials/testi-1-2.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="2"><img src="images/testimonials/testi-1-3.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="3"><img src="images/testimonials/testi-1-4.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="4"><img src="images/testimonials/testi-1-5.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="5"><img src="images/testimonials/testi-1-6.jpg" alt="Awesome Image" /></a>
							</div>
							<!-- /.testimonials-slider-pager-one -->
							<div class="testimonials-slider-pager-two">
								<a href="#" class="pager-item active" data-slide-index="0"><img src="images/testimonials/testi-1-1.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="1"><img src="images/testimonials/testi-1-2.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="2"><img src="images/testimonials/testi-1-3.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="3"><img src="images/testimonials/testi-1-4.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="4"><img src="images/testimonials/testi-1-5.jpg" alt="Awesome Image" /></a>
								<a href="#" class="pager-item" data-slide-index="5"><img src="images/testimonials/testi-1-6.jpg" alt="Awesome Image" /></a>
							</div>
							<!-- /.testimonials-slider-pager-two -->
						</div>
						<!-- /#testimonials-slider-pager -->
					</div>
					<!-- /.my-auto -->
				</div>
				<!-- /.col-lg-6 -->
				<div class="col-lg-6 col-md-6">
					<div class="block-title ">
						<h2><span>What's our users are </span> Saying</h2> </div>
					<!-- /.block-title -->
					<ul class="slider testimonials-slider">
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4><span>- M.Ramesh,</span> Hyderabad</h4> </div>
							</div>
						</li>
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4>- M.Ramesh, <span>Hyderabad</span></h4> </div>
							</div>
						</li>
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4>- M.Ramesh, <span>Hyderabad</span></h4> </div>
							</div>
						</li>
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4>- M.Ramesh, <span>Hyderabad</span></h4> </div>
							</div>
						</li>
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4>- M.Ramesh, <span>Hyderabad</span></h4> </div>
							</div>
						</li>
						<li class="slide-item">
							<div class="single-testi-one">
								<p>Lorem ipsum dolor sit amet consectetur adipiscing elit, urna consequat felis vehicula class ultricies mollis dictumst, aenean non a in donec nulla. Phasellus ante pellentesque erat cum risus consequat imperdiet aliquam, integer placerat et turpis mi eros nec lobortis taciti, vehicula nisl litora tellus ligula porttitor metus. Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis sit, euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante, eleifend lectus nullam dapibus netus feugiat curae curabitur est ad. Massa curae fringilla porttitor quam sollicitudin iaculis aptent leo ligula euismod dictumst, orci penatibus mauris eros etiam praesent erat volutpat posuere hac. Metus fringilla nec ullamcorper odio aliquam lacinia conubia mauris tempor, etiam ultricies proin quisque lectus sociis id tristique, integer phasellus taciti pretium adipiscing tortor sagittis ligula. </p>
							</div>
							<!-- /.single-testi-one -->
							<div class="testi-bottom">
								<div class="testi-star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
								<div class="testi-name">
									<h4>- M.Ramesh, <span>Hyderabad</span></h4> </div>
							</div>
						</li>
					</ul>
				</div>
				<!-- /.col-lg-6 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
	</section>
	<!-- /.testimonials-style-one -->
	
		<a href="post-task.php" class="post_flt_btn">Post Service</a>
<?php
include_once("footer.php");
?>	
   <script>
    
    $(document).ready(function(){

    $("#searchInput").autocomplete({
        source: "ajax.php",
        minLength: 3,
        maxShowItems: 6,   
        delay:500, 
        classes: {
        "ui-autocomplete": "home-search-dd",
        },
        select: function(event, ui) {
            $("#searchInput").val(ui.item.value);
            $("#hdnsid").val(ui.item.id);
            $("#hdnsname").val(ui.item.value);
            $("#hdnstype").val(ui.item.type);
        }
    }).data("ui-autocomplete")._renderItem = function( ul, item ) {
    return $( "<li class='ui-autocomplete-row'></li>" )
        .data( "item.autocomplete", item )
        .append( item.label )
        .appendTo( ul );
    };
});
</script>
</script>