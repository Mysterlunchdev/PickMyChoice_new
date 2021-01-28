<?php include("header.php"); 
$limit='';
$id='';
$catid=$_GET['id'];
if($_GET['id']!='')
{
	$catid=$_GET['id'];
}
else
{
	$catid=6;
}
$subcategories = $common_model->fetch_sub_cat_by_catid($catid,$id,$limit);
?>
<section class="services-list ptb-40">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="services-list-container d-flex">
<?php
if(count($subcategories)>0)
{
	for($i=0;$i<count($subcategories);$i++)
       {
       	$id='';
       	$name='';
       	    $id = $subcategories[$i]['id'];
            $category_name = $subcategories[$i]['cname'];
            $name = $subcategories[$i]['sname'];
            $attachment = $subcategories[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$subcategorypath.$attachment;
            }
?>
<a class="services-list-info" href="subcategory.php?id=<?=$id;?>&title=<?=$name;?>&cat_id=<?=$catid;?>">
<div class="services-list-img">
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
<div class="services-list-details">
<h2><?=$name;?></h2>
<p><?php echo $common_model->get_vendor_count($id);?> Vendors</p>
</div>
</a>
<?php
      }
}
?>

</div>

</div>

</div>



</div>




</section>

<?php include("footer.php"); ?>
