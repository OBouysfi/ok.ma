<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

?>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<div class="fright">
<?php
 echo LinkTile
 (
	"templates",
	"home_slider",
	$M_GO_BACK,
	"",
	"red"
 );
 ?>
</div>
<div class="clear"></div>
 
<?php

$background_images=$database->GetParameter(172);


if(isset($_REQUEST["current"])&&isset($_REQUEST["new"]))
{
	$current=str_replace("img","",$_REQUEST["current"]);
	$new=str_replace("img","",$_REQUEST["new"]);
	
	$pos_current=strpos($background_images,$current);
	$pos_new=strpos($background_images,$new);
	
	if
	(
		$pos_current!==false
		&&
		$pos_new!==false
	)
	{
		$current_images = $background_images;
		$current_images = str_replace($new,"###",$current_images);
		$current_images = str_replace($current,$new,$current_images);
		$current_images = str_replace("###",$current,$current_images);
		
		$database->SetParameter
		(
			172,
			$current_images
		);
		
		$background_images=$current_images;	

	}
}
else
if(isset($_REQUEST["del"]))
{
	$pos=strpos($background_images,$_REQUEST["del"]);
	
	if($pos!==false)
	{
	
		$current_images = $background_images;
		$current_images = str_replace($_REQUEST["del"],"",$current_images);
		$current_images = str_replace(",,",",",$current_images);
		$current_images = trim($current_images,",");
		
		$database->SetParameter
		(
			172,
			$current_images
		);
		
		
		
		if(file_exists("../backgrounds/".$_REQUEST["del"].".jpg"))
		{
			unlink("../backgrounds/".$_REQUEST["del"].".jpg");
		}
		$background_images=$current_images;	

	}
}

if(isset($_POST["ProceedSend"]))
{

	$path="../";
	///images processing
	$str_images_list = "";

	include("../include/images_processing_no_compress.php");
	///end images processing
	
	if($background_images != "")
	{
		$str_images_list = $background_images.",".$str_images_list;
	}
	$str_images_list=trim($str_images_list,",");
	if(trim($_POST["dele_images"]) != "")
	{
		$dele_ids = explode(",",trim($_POST["dele_images"]));
		
		foreach($dele_ids as $dele_id)
		{
			if(trim($dele_id)=="") continue;
			$website->ms_i($dele_id);
			
		
			
			if(file_exists("../backgrounds/".$dele_id.".jpg"))
			{
				unlink("../backgrounds/".$dele_id.".jpg");
			}
			
			$str_images_list=str_replace($dele_id.",","",$str_images_list);
			$str_images_list=str_replace($dele_id,"",$str_images_list);
		}
	}
		
	$database->SetParameter
	(
		172,
		trim($str_images_list,",")
	);
		
		
	$background_images=trim($str_images_list,",");	

}


$MAX_NUMBER_IMAGES=10;


if($background_images != "")
{

	$arrImgs = explode(",", $background_images);
	echo "<span class=\"medium-font\">Drag and drop the images to change their order.<br/>The first image will be used as main background.</span>";
}
else
{
	$arrImgs = array();
	echo "<span class=\"medium-font\">".$M_CURRENTLY_NO_PICS."</span><br/><br/>";
}
?>	

<script>
function Dele(x)
{
	document.location.href="index.php?category=templates&action=home_slider_images&del="+x;

}
</script>

<form action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="ProceedSend" value="1"/>
<input type="hidden" name="dele_images" id="dele_images" >
<input type="hidden" name="category" value="templates">
<input type="hidden" name="action" value="home_slider_images">

<div id="drag_images">
<?php
$iPicCounter = 0;


for($i=0;$i<sizeof($arrImgs);$i++)
{
?>


			<?php
			if(isset($arrImgs[$i]) && $arrImgs[$i]!="")	
			{
			?>
				
						
				<div  ondragstart="javascript:img_drag_start(this)" style="float:left;width:220px;min-height:180px;margin-right:20px;margin-bottom:20px;background:#ffffff;padding:10px" class="img-shadow drag_img" id="img<?php echo $arrImgs[$i];?>">
				<a class="pull-right" href="javascript:Dele('<?php echo $arrImgs[$i];?>')"><img src="images/cancel.gif" alt="<?php echo $EFFACER;?>" width="21" height="20" border="0"></a>
				<br>
				<img  src="../backgrounds/<?php echo $arrImgs[$i];?>.jpg" alt="" width="200"/>
				
			
				</div>
			<?php
			}
			?>		
		<span style="display:none">
			<input type="file" name="userfile<?php echo $i;?>">
		</span>
			
			
			<div class=""></div>
	

<?php

	$iPicCounter++;
	
}
?>
</div>
<div class="clear"></div>	


<span class="medium-font"><?php echo $M_UPLOAD_MORE;?></span>
<br/><br/>
<input class="pull-left" type="file" name="images[]" id="images"  multiple="multiple"/>

<input type="submit" value=" <?php echo $M_SUBMIT;?> " class="btn btn-primary pull-left margin-left-15"/>

</form>

<script>


function init_drag() 
{
	
	$('.drag_img').draggable( {
		containment: '#main_content',
		revert: true
    } );
	
	$('.drag_img').droppable( {
		drop: handle_drop
	} );
	
	
}
 
function handle_drop( event, ui ) 
{
	var id = $(this).attr('id');
	var draggable = ui.draggable;
  
	document.location.href="index.php?category=templates&action=home_slider_images&current="+id+"&new="+draggable.attr('id');

}
var x_index=100;
function img_drag_start(x)
{
	x_index=x_index+100;
	x.style.zIndex=x_index;
}

$(init_drag);
</script>

<div class="clearfix"></div>
<br/><br/>