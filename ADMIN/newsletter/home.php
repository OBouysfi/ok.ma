<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<span class="medium-font">Newsletter Module</span>
<br><br>


<br>
The newsletter module lets you send newsletter to the 
website users

<div class="clear"></div>
<br><br>
	<?php
		 
	echo LinkTile
	(
		"newsletter",
		"newsletter2",
		$M_NEWSLETTER,
		"create newsletters",
		"green"
	 );
	 
	 echo LinkTile
	(
		"newsletter",
		"send",
		$ENVOYER,
		"send a newsletter",
		"blue"
	 );
	 
	 echo LinkTile
	(
		"newsletter",
		"settings",
		$M_SETTINGS,
		"manage the settings",
		"yellow"
	 );
	?>	 
