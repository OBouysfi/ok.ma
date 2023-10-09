<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>

<div class="fright">
	<?php
	echo LinkTile
		 (
			"cv",
			"edit",
			$M_TEXT_EDITOR,
			"",
			"yellow"
		 );
		 
		 
	echo LinkTile
	 (
		"cv",
		"resume_creator",
		$M_RESUME_CREATOR,
		"",
		"green"
	 );
	 

?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $M_CREATE_ONLINE_RESUME;?>
</h3>
<br/>
		
		
<?php 
$M_OFFER_TWO_OPTIONS=str_replace("{upload_link}","<a class=\"underline-link\" href=\"index.php?category=documents&action=add&resume=1\">",$M_OFFER_TWO_OPTIONS);
$M_OFFER_TWO_OPTIONS=str_replace("{end_upload_link}","</a>",$M_OFFER_TWO_OPTIONS);
echo $M_OFFER_TWO_OPTIONS;
?>:
<br><br><br>

<div class="row">
	<div class="col-md-6">
		<b>1. <a href="index.php?category=cv&action=edit"><?php echo $M_TEXT_EDITOR;?></a></b>
		<br><br>
		
		<i><?php echo $M_TEXT_EDITOR_EXPL;?></i>
		<br/><br/>
		
		<a class="img-responsive" href="index.php?category=cv&action=edit"><img src="images/cv_text.gif" width="300" height="253" alt="" border="0"></a>
	</div>
			
	<div class="col-md-6">
		<b>2. <a href="index.php?category=cv&action=resume_creator"><?php echo $M_RESUME_CREATOR;?></a></b>
		
		<br><br>
		<i><?php echo $M_RESUME_CREATOR_EXPL;?></i>
		
		<br><br>
	
		<a class="img-responsive" href="index.php?category=cv&action=resume_creator"><img src="images/creator.gif" width="300" height="254" alt="" border="0"></a>
	</div>
  </div>
		
	
