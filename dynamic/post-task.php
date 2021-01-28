<?php 
function curPageURL() 
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
}
$pagerdurl=curPageURL();
$current_page=$pagerdurl;
//echo $_COOKIE['redirect_to'] = $current_page;
setcookie("redirect_to", $current_page );
//include_once("session_exist.php");
include("header.php"); 
?>
<section class="task-post-block ptb-60">
<div class="container">
<div class="row">
<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
<div class="tp-block">
<form id="frmposttask" name="frmposttask" method="post">
	  <h2>Service Information </h2>  
	  <div class="task-form-block">
	  <div class="tfb-icon">
	  <i class="flaticon-clipboards-1"></i>
	  </div>
	    <div class="tfb-info">
		<?php
		$limit='';
			 $categories = $common_model->fetch_main_categories($limit); 
			?>
		<select class="selectpicker" onChange="getSubCtegory(this.value)" id="selcat" name="selcat" required="true" class="form-control">
			<option>Select Category </option>
			<?php
			if(count($categories)>0)
						{
						 for($i=0;$i<count($categories);$i++)
						       {
						       	$catid = $categories[$i]['id'];
					            $catname = $categories[$i]['name'];
					            $image = $categories[$i]['attachment'];
					            if($image!='')
					            {
					              $image=$baseurl.$categorypath.$image;
					            }
						?>
						<option value="<?php echo $catid; ?>" data-content="<img src='<?php echo $image; ?>'> <span class='option_tilte'><?php echo $catname ?></span>"><?php echo $catname; ?></option>
						<?php
				}
			}
			?>
			</select>
			
			<select class="selectpicker" id="selsubcat" name="selsubcat" required="true" class="form-control">
				<option value=''>Select Subcategory </option>
				<?php
				
				$subcategories = $common_model->fetch_sub_cat_by_catid($_GET['cat_id'],$id,$limit);
			//print_r($subcategories);
        	if(count($subcategories)>0)
            {
				for($i=0;$i<count($subcategories);$i++)
                {
                     $subcatlist=$subcategories[$i];
					 $catid=$subcatlist['category_id'];
					 $subctid=$subcatlist['id'];
					 $sub_catname=$subcatlist['sname'];
					 $category_name=$subcatlist['cname'];
					 $image=$subcatlist['attachment'];
					 $description=$subcatlist['description'];
					 
					?>
					<option value="<?php echo $subctid; ?>" data-content="<img src='../uploads/subcategory/<?php echo $image; ?>'> <span class='option_tilte'><?php echo $sub_catname; ?></span>"><?php echo $sub_catname; ?></option>
					<?php
					
				}
			}
		
				?>
			</select>
		
	

	  <input type="text" class="form-control" id="txttitle" name="txttitle"  placeholder="Title" required="true"
	  autocomplete="off">
	  <textarea class="form-control"  id="txtabtask" name="txtabtask" rows="2" placeholder="About service (Maximum 50 Words)" required="true"></textarea>
	  
	  <input  type="file" class="form-control" id="fileattachment" name="fileattachment" accept="image/*,application/pdf">
	  
	  <input type="text" class="form-control" id="txtdate" name="txtdate" placeholder="Date" required="true" autocomplete="off" readonly>
	  <input type="text" class="form-control" id="txttime" name="txttime"  placeholder="Time" required="true" autocomplete="off">
	  </div>
	  </div>
	  	  
	  <h2>Budget Information </h2>
	  <div class="task-form-block">

	  
	  
	   <div class="tfb-icon">
	  <i class="flaticon-money-bag-2"></i>
	  </div>
	  	    <div class="tfb-info">
	  <input type="text" class="form-control"  placeholder="Amount" id="txtamt" name="txtamt" required="true"   autocomplete="off" onkeypress="return issDotNumber(event)" >
	  
	  
	  <div class="chkContainer">
	  
	  <h4>is the budget amount negotiable?</h4>
	  <label class="chkcontainer">
	  
	  <input type="radio" name="budget_plan" value="Yes" checked>Yes
	  <span class="chkcheckmark"></span>
	  </label>
	  
	    <label  class="chkcontainer">
	  
	  <input type="radio"  name="budget_plan" value="No">No
	  <span class="chkcheckmark"></span>
	  </label>
	 
	  </div>
	  </div>
	  </div>

	  
	    <h2>Location Information </h2>
	   	  <div class="task-form-block tfb-last-child">
	 <div class="tfb-icon">
	  <i class="flaticon-location-2"></i>
	  </div>
	  
	  	  	    <div class="tfb-info">
		  <input type="text" class="form-control"  placeholder="Postal Code" required="true" id="txtpostalcode" name="txtpostalcode" value="<?php echo $getuserinfo[0]['postcode'] ?>" onBlur="getAdresDet(this.value)" autocomplete="off">
	   <!--<input type="text" class="form-control"  placeholder="House Number" required="true" id="txthuseno" name="txthuseno">-->
	   <select id='txthuseno' name='txthuseno' class='form-control'><option value='<?php echo trim($getuserinfo[0]['address']); ?>'><?php echo trim($getuserinfo[0]['address']);?></option></select>
	   <input type="text" class="form-control"  placeholder="City" required="true" id="txttskcity" name="txttskcity" value="<?php echo trim($getuserinfo[0]['city']);?>">
	   	   <input type="text" class="form-control"  placeholder="County" id="txtlndmrk" name="txtlndmrk" value="<?php echo trim($getuserinfo[0]['street']);?>">
		   
		   <input type="hidden" id="txtpsklat" name="txtpsklat" value="" >
		   <input type="hidden" id="txtpsklang" name="txtpsklang" value="" >
		   <input type="hidden" id="formtype" name="formtype" value="addtask" >
	  </div>
	
	</div>
	<span style="color:red;margin-left: 69px;" id="addtaskerr"></span>

	
	<input type="<?php if($user_id==''){ ?>button<?php }else{ ?>submit<?php } ?>"  class="btn-st" value="Submit"  <?php if($user_id==""){ ?> data-toggle="modal" data-target=".loginPopup" <?php }else{ ?>onClick="validateTask()" <?php } ?> id="btnposttask" name="btnposttask" style="display:block">
	
    
     <div class="lds-default" style="display:none" id="loadingicon"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    
    
	</form>	
</div>
</div>
</div>


</section>

<span data-toggle="modal" data-target="#staticBackdrop" id="btntaskpopup"></span>
<div class="modal fade successPopup" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body text-center">
      
	
	
	<img src="images/success.jpg">
	
	
	<h2>Your Service <span class="highlight" id="msgtaskcode"> No.1123MAG </span> <span class="d-block"></span>is posted successfully.</h2>
	
	
	<h2>You May reach upto  <span class="d-block"></span><span class="highlight">1000</span> potential bidders</h2>
	
	
	<a class="sp-close" href="my-services.php">Close</a>
	
	  </div>
      </div>
  
   
  </div>
</div>

<?php include("footer.php"); ?>
<script>
	// script for tab steps
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		var href = $(e.target).attr('href');
		var $curr = $(".process-model  a[href='" + href + "']").parent();
		$('.process-model li').removeClass();
		$curr.addClass("active");
		$curr.prevAll().addClass("visited");
	});
	// end  script for tab steps
	</script>

	<script>
	

	
	$('.my-select').selectpicker();
	function getSubCtegory(catid)
	{
		if(catid!="")
		{
		    $.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&cat_id='+catid+'&flag=get_subcat_new',
			success: function(data)
			{
			    $('#selsubcat').html(data);
				$('.selectpicker').selectpicker('refresh');
			}
		  
		});
		
		}
	}
	<?php
	if($_GET['cat_id']!='' && $_GET['sub_cat']!='')
	{
		?>
		//$('select[name=selcat]').val(<?=$_GET['cat_id'];?>);
        $("#selcat").selectpicker('val', <?=$_GET['cat_id'];?>);
        //getSubCtegory(<?=$_GET['cat_id']?>);
        //$('.selectpicker').selectpicker('refresh');
        $("#selsubcat").selectpicker('val', <?=$_GET['sub_cat'];?>)
        
        document.getElementById("selsubcat").value=<?=$_GET['sub_cat'];?>
        //alert(<?=$_GET['sub_cat'];?>);
        //$('select[name=selsubcat]').val(<?=$_GET['sub_cat'];?>);
		<?php
	}
	?>
$(function() {
    $( document ).tooltip({
		position: {my: "right top", at: "right top"},
	  items: "input[required=true], textarea[required=true]",
      content: function() { return $(this).attr( "title" ); }
    });
  });
  
function getAdresDet(postcode)
{
	var postcode=postcode;
	if(postcode!="")
	{
		$.ajax({
			url : "ajax.php",
			type: "POST",
			data : '&postcode='+postcode+'&flag=get_address',
			success: function(data)
			{
				var arr=new Array();
				var arr=data.split('@6256@');
				var latitude=arr[0];
				var langtitude=arr[1];
				var address=arr[2];
				var city=arr[3];
				var county=arr[4];
				document.getElementById('txthuseno').innerHTML=address;
				document.getElementById('txttskcity').value=city;
				document.getElementById('txtpsklat').value=latitude;
				document.getElementById('txtpsklang').value=langtitude;
				document.getElementById('txtlndmrk').value=county;
				 
			},
		  
		});
	}
}

$('#frmposttask').submit(function (e) {
    
    var validd=validateTask();
    //alert(validd);
    if(validd)
    {
        document.getElementById("btnposttask").style.display="none";
        document.getElementById("loadingicon").style.display="block";
 e.preventDefault();
   var formData = new FormData(this);
   $.ajax({
   type: 'POST',
           url: 'ajax.php',
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function (data) {
                 //alert(data);
				 if(data!="")
				 {
				      document.getElementById("loadingicon").style.display="none";
				       document.getElementById("btnposttask").style.display="block";
                       
        
					var arr=new Array();
		            var arr=data.split('@6256@');
					var status=arr[0];
					var msg=arr[1];
					if(status=='Yes')
					{
						document.getElementById("btntaskpopup").click();
						$("#msgtaskcode").html(msg);
					}
					else
					{
						$("#addtaskerr").html(msg);
					}
				 }
           }

   });
	}
	else
	{
	    return false;
	}
   });

function validateTask() {
	//alert('dfgdfg');
	var valid = true;
	$("#frmposttask input[required=true], #frmposttask textarea[required=true]").each(function(){
		$(this).removeClass('invalid');
		$(this).attr('title','');
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
		if($(this).attr("id")=="txttime" && $(this).val()!="")
		{
		    var gettimeval=$(this).val();
		    
		    var arr=new Array();
            var arr=gettimeval.split(':');
			var gettimevalhr=arr[0];
		
					
					
		    var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();
            
            var output = ((''+month).length<2 ? '0' : '') + month + '/' +
                 ((''+day).length<2 ? '0' : '') + day + '/' +
                d.getFullYear();
                //alert(output);
                
            var getdatepickval=$("#txtdate").val();   
            //alert(getdatepickval);
            
            var hoursn=d.getHours();
            //alert(hours);
            if(output==getdatepickval)
            {
                //alert(hours);
                //alert(hoursn);
                
                var hours=parseInt(hoursn)+1;
                  //alert(hours);
                if(parseInt(hours)>=parseInt(gettimevalhr))
                {
                    //alert('yes');
                    $('#txttime').addClass('invalid');
            			$('#txttime').attr('title','Select time one hour from now');
            			valid = false;
            			$( ".invalid" ).tooltip({
            			       "ui-tooltip": "highlight",
                        position: { my: "left+15 center", at: "right center" }
                        });
                }
                
               
            }
		}
	}); 
	
	return valid;
}   

    // INITIALIZE DATEPICKER PLUGIN


</script>
	
	
	<script>
	var dateToday = new Date();     
	$('#txtdate').datepicker({
        clearBtn: true,
        minDate: dateToday,
        format: "dd/mm/yyyy"
    });

  //$('#txttime').timepicker();
  $('#txttime').timepicker({ 
             //format : 'DD/MM/YYYY HH:mm',
            //minDate: moment().add(1, 'h'),
            //enabledHours: [10, 11, 12, 13, 14, 15, 16,17]
            minTime: 0
             //format: 'LT'
        });
                


function issDotNumber(evt) 
	{

		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if ( charCode > 31 && (charCode < 48 || charCode > 57)) 
		{
			return false;
		}
		return true;
	}
	
	 $("#txtamt").keyup(function(){
		el = $(this);
		if(el.val().length >= 6){
			el.val( el.val().substr(0, 6) );
		} 
	});

	</script>


</body>

</html>