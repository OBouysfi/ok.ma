<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>


<div class="fright">

	<?php
			echo LinkTile
				 (
					"site_management",
					"menu",
					$H_NAVIGATION_MENU,
					"",
					
					"lila"
				 );
		?>
		
	
</div>
<div class="clear"></div>

<span class="medium-font">
<?php echo $MENU_PERSONNALISE;?>
-
<?php echo $M_SETTINGS;?>
</span>
<br/>
<br/>
<?php
EditParams
(
	"333",
	array("textarea_70_6"),
	$M_SAVE,
	$M_NEW_VALUES_SAVED
);
	
?>
<br>
