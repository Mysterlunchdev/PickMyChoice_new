<?php include("header.php"); 
$limit='';
$id='';
$categories = $common_model->fetch_main_categories($limit);
?>
<div class="services">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="services-icons">
<?php
if(count($categories)>0)
{	
       for($i=0;$i<count($categories);$i++)
       {
            $respo = array();
            $id = $categories[$i]['id'];
            $name = $categories[$i]['name'];
            $attachment = $categories[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$categorypath.$attachment;
            }
            $description = $categories[$i]['description'];
            
              $loccount=$common_model->getLocationCountByCatId($id);
					  $loccnt=sizeof($loccount);
?>
<a href="category.php?id=<?=$id;?>&title=<?=$name?>" class="service-icon">
<div class="service-icon-img">
<?php 
   if($attachment!='')
    {
	?>
	<img src="<?=$attachment;?>">
	<?php
	}
	else
	{
		?>
		<img src="dummy_subcategory.jpg">
		<?php
	}
?>
</div>
<h2><?=ucwords($name);?></h2>
<div class="cat_location_count">
<h5><span><?=$loccnt;?></span>Locations</h5> </div>
</a>
<?php
       }
}
?>

</div>

</div>
</div>

</div>

</div>

<?php
include("footer.php");
?>
