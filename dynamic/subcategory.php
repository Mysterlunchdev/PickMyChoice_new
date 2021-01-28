<?php include("header.php"); 
$limit='';
$limit='';
$id='';
$id=$_GET['id'];
$cat_id=$_GET['cat_id'];
$subcategories = $common_model->fetch_sub_cat_by_catid($cat_id,$id,$limit);
if(count($subcategories)>0)
{
       for($i=0;$i<count($subcategories);$i++)
       {
            $id='';
            $name='';
            $id = $subcategories[$i]['id'];
            $category_name = $subcategories[$i]['cname'];
            $name = $subcategories[$i]['sname'];
            $attachment = $subcategories[$i]['big_image'];
            $file=$subcategories[$i]['attachment'];
            if($attachment!='')
            {
              $attachment=$baseurl.$subcategorypath.$attachment;
            }
            $description=$subcategories[$i]['description']; 
            $instruction=$subcategories[$i]['instruction'];
        }
}
?>
<section class="ser_details ptb-40">
<div class="ser_banner ">
<div class="container">

<div class="row">


<div class="col-md-12">
<div id="demo" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>

  </ul>
  <div class="carousel-inner">
    <?php
    if($attachment!='')
    {
      ?>
      <div class="carousel-item active">
      <img src="<?=$attachment;?>" alt="<?=$name;?>" >
      </div>
      <?php
    }
    ?>
    </div>
  </div>
</div>
</div>
</div>
</div>
<div class="ser_info">
<div class="container">

<div class="row">


<div class="col-md-12">

<div class="row">

<div class="col-md-7 col-sm-7">
<h2><?=$name;?></h2>
<h4><?php echo $common_model->get_vendor_count($id);?> Vendors</h4>
</div>
<div class="col-md-5 col-sm-5 text-right">

<a  class="btn-pt  btn-services-post"  href="post-task.php?cat_id=<?=$cat_id;?>&sub_cat=<?=$id;?>">Post Service </a>

</div>
</div>

<?=$description;?>
<h4><b>Instructions</b></h4>
<ul>


<?=$instruction;?>
</ul>





</div>

</div>


</div>
</div>
</div>
</section>
<?php include("footer.php"); ?>