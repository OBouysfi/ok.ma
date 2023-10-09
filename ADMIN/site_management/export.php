<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(isset($_REQUEST["Proceed"]))
{
	$tableLanguages=$database->DataTable("languages","");

	$arr_languages=array();
	
	while($arrLanguages=$database->fetch_array($tableLanguages))
	{
		array_push($arr_languages,strtolower($arrLanguages["code"]));
			
	}
	$url_prefix ="";
	//$url_prefix ="http://www.netartmedia.net/";
		
	$oRows=$database->Query("select * from $DBprefix"."pages"." order by parent_id,id");
						
	while ($row = $database->fetch_array($oRows))
	{
		foreach($arr_languages as $str_language)
		{
			
			$strDownloadLink="index.php?not_include=1&page=".urlencode($str_language."_".stripslashes($row["link_".$str_language]));
			$strSaveLink=urlencode($str_language."_".stripslashes($row["link_".$str_language])).".html";
		
			$content = file_get_contents("http://".$_SERVER["SERVER_NAME"]."/".str_replace("ADMIN/index.php","",$_SERVER["URL"])."/".$strDownloadLink);
			file_put_contents("../exported_html/".$strSaveLink, $content);
			echo $strSaveLink." successfully exported!<br>";
		}
	}
}
	
?>

<div class="fright">
	<?php
	echo LinkTile
	 (
		"site_management",
		"pages_pro",
		$H_WEBSITE,
		$M_WEBSITE_MANAGEMENT,
		"blue"
	 );
	 ?>
</div>
<div class="clear"></div>

<br>
Exporting the website content as static html page
increases the website performace, since
future requests for these pages on the front site can be served faster
(the saved content for the page is used).
<br><br>
The exported pages are saved in the folder /exported_html,
currently there are 
<?php
$files = scandir("../exported_html");
echo count($files)-2;
?> 
files in this folder.
<br><br>
Click on the button below to export the website content:
<br><br>
<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>"/>
<input type="hidden" name="action" value="<?php echo $_REQUEST["action"];?>"/>
<input type="hidden" name="Proceed" value="1"/>

<input class="adminButton" type="submit" value="<?php echo $M_EXPORT;?>">
</form>



