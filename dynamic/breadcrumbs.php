<?php
$flag='Yes';
if($filename=='post-task.php')
{
    $bredcumbname='Post Service';
}
else if($filename=='my-services.php')
{
    $bredcumbname='My Services';
    $flag='No';
}
else if($filename=='assigned-services.php')
{
    $bredcumbname='Assigned Services';
}
else if($filename=='blog.php')
{
    $bredcumbname='Blog';
    $flag='No';
}
else if($filename=='my-account.php')
{
    $bredcumbname='My Account';
    $flag='No';
}
else if($filename=='subcategory.php')
{
    $bredcumbname='Subcategory';
}
else if($filename=='notifications.php')
{
    $bredcumbname='Notifications';
}
else if($filename=='reviews.php')
{
    $bredcumbname='Reviews';
}
else if($filename=='my-payments.php')
{
    $bredcumbname='Payments';
}
else if($filename=='my-settlements.php')
{
    $bredcumbname='Settlements';
}
else if($filename=='edit-profile.php')
{
    $bredcumbname='My Account';
    $flag='No';
}
else if($filename=='vendor-registration.php')
{
    $bredcumbname='Vendor Registration';
    $flag='No';
}
else if($filename=='blog-post.php')
{
    $bredcumbname='Blog Post';
    $flag='No';
}
else if($filename=='services.php')
{
    $bredcumbname='Services';
    $flag='No';
}
else
{
    $bredcumbname='Services';
}
if($_GET['title']!='')
{
  $bredcumbname=$_GET['title'];
  if($_GET["cat_id"]!="")
  {
      $getbreadcatname1=$common_model->getCatnameById($_GET["cat_id"]);
      $getbreadcatname=$getbreadcatname1[0]['name'];
  }
}
?>
<div class="inner-page-header">
  
  <div class="nav-breadcrumbs">
  
  
  <div class="container">
  
  <div class="row">
  
  
  <div class="col-md-6 col-sm-6">
  
  
  <h1><?php echo $bredcumbname;?></h1>
  
  
  </div>
  
  
  <div class="col-md-6 col-sm-6">
    <?php
    if($flag=='Yes')
    {
      ?>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
    <?php
    if($_GET['title']!='')
    {
    ?>
    <li class="breadcrumb-item"><a href="services.php">Services</a></li>
    <?php
    }
    if($getbreadcatname!="")
    {
        $catid=$_GET["cat_id"];
        
        $gtcaturl="category.php?id=$catid&title=$getbreadcatname";
        ?>
        <li class="breadcrumb-item"><a href="<?php echo $gtcaturl; ?>"><?php echo $getbreadcatname; ?></a></li>
        <?php
    }
    ?>
    
    
    <li class="breadcrumb-item active" aria-current="page"><?php echo $bredcumbname; ?></li>
  </ol>
</nav>
   <?php
    }
   ?>
  
  </div>
  
  
  </div>
  
  
  
  
  </div>
  
  
  </div>
  
  
  </div>