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
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
		 
		 echo LinkTile
		 (
			"documents",
			"add",
			$ADD_A_NEW,
			"",
			"green"
		 );
	
	
	?>

</div>
<div class="clear"></div>

<h3>
	<?php echo $MANAGE_DOCUMENTS;?>
</h3>
<br/>


<?php

if(isset($_POST["Delete"])&&isset($_POST["CheckList"])&&sizeof($_POST["CheckList"])>0)
{
	$website->ms_ia($_POST["CheckList"]);
	$database->SQLDelete("files","file_id",$_POST["CheckList"]);
	
	foreach($_POST["CheckList"] as $CheckID)
	{
		foreach($website->GetParam("ACCEPTED_FILE_TYPES") as $c_file_type)
		{	
			if(file_exists("../user_files/".$CheckID.".".$c_file_type[1]))
			{
				unlink("../user_files/".$CheckID.".".$c_file_type[1]);
			}
		}
	}
	
}
?>

<?php

if($database->SQLCount("files","WHERE user='".$AuthUserName."'","file_id") == 0)
{
	echo "<br>
		<i>".$ANY_DOCUMENTS."</i>
	";
}
else
{

 RenderTable
 (
	"files",
	array("ShowFormEdit","file_date","file_size","file_name","description","is_resume","JobFileType"),
	array($MODIFY,$DATE_MESSAGE,$SIZE,$NOM,$DESCRIPTION,$M_CV,$M_OPEN),
	"100%",
	"WHERE user='".$AuthUserName."'",
	$EFFACER,
	"file_id",
	"index.php"
	);
						
}
?>
