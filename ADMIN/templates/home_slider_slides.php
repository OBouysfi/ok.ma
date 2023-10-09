<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
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

<h3>Set the titles and texts of the slides</h3>
<br/>
<?php

$_REQUEST["message-column-width"]="125";
$_REQUEST["select-width"]="200";

$values_list="173,174,175,176,177,178,179,180,181,182,183,184,185,186,187";

EditParams
(
	$values_list,
	array
	(
	
		"textbox_75",
		"textarea_63_4",
		"textbox_75",
		"textbox_75",
		"textarea_63_4",
		"textbox_75",
		"textbox_75",
		"textarea_63_4",
		"textbox_75",
		"textbox_75",
		"textarea_63_4",
		"textbox_75",
		"textbox_75",
		"textarea_63_4",
		"textbox_75",
	),
		$M_SAVE,
		$M_NEW_VALUES_SAVED
);

?>
<br/>
