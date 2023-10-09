<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<br/>
<span class="medium-font">
<?php echo $M_MODULES;?>
</span>
<br/><br/><br/>
<?php
	echo LinkTile
		 (
			"news",
			"news",
			$M_NEWS,
			"",
			"blue"
		 );

		 echo LinkTile
		 (
			"faq_manager",
			"home",
			$M_FAQ_MANAGER,
			"",
			"lila"
		 );
	?>

<?php	 
		

		 echo LinkTile
		 (
			"newsletter",
			"home",
			$M_NEWSLETTER,
			"",
			"red"
		 );
		 
		
		 
?>
		