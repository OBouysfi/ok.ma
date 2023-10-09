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
		"apply",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>
<div class="clear"></div>
<h3>
	<?php echo $M_JOB_DETAILS;?>
</h3>
<br/>

<?php  

$id=$_REQUEST["id"];
$website->ms_i($id);
$arrApplication=$database->DataArray("apply","id=".$id);
$arrPosting=$database->DataArray("jobs","id=".$arrApplication["posting_id"]);
$arrEmployer = $database->DataArray("employers","username='".$arrPosting["employer"]."' ");
echo "<b>".$JOB_TITLE.":</b><br>";
echo "".stripslashes($arrPosting["title"])."  ";
echo "<br/><br/>";
	
echo "<b>".$DESCRIPTION.":</b><br>";

 echo stripslashes($arrPosting["message"]); 

echo "<br><br>";
echo "<b>$M_JOB_TYPE:</b><br> ";

echo $website->job_type($arrPosting["job_type"]);

echo "<br><br>";
echo "<b>$M_REGION:</b><br> ".$website->show_full_location($arrPosting["region"]);
echo "<br><br>";
echo "<b>$M_SALARY:</b><br> ".(trim($arrPosting["salary"])!=""&&trim($arrPosting["salary"])!="0"?$arrPosting["salary"]:"[n/a]");
echo "<br><br>";
echo "<b>$M_DATE_AVAILABLE:</b><br> ".(trim($arrPosting["date_available"])!=""?$arrPosting["date_available"]:"[n/a]");

if(trim($arrPosting["more_fields"]) != "")
{
$arrFields = array();

if(is_array(unserialize($arrPosting["more_fields"])))
{
	$arrFields = unserialize($arrPosting["more_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrFields)) 
{
	echo "<br><br>";
	echo "<b>";
	str_show($key);
	echo ":</b>"; 
	echo "<br> ";
	str_show($val);
}
}

echo "<br><br>";
echo "<b>$M_COMPANY:</b><br> ".(trim($arrEmployer["company"])!=""?stripslashes($arrEmployer["company"]):"[n/a]");
echo "<br><br>";
echo "<b>$COMPANY_DESCRIPTION:</b><br> ".stripslashes(trim($arrEmployer["company_description"])!=""?$arrEmployer["company_description"]:"[n/a]");
echo "<br><br>";
echo "<b>$COMPANY_WEBSITE:</b><br> ".(trim($arrEmployer["website"])!=""?$arrEmployer["website"]:"[n/a]");

if(trim($arrEmployer["employer_fields"]) != "")
{
$arrFields = array();

if(is_array(unserialize($arrEmployer["employer_fields"])))
{
	$arrFields = unserialize($arrEmployer["employer_fields"]);
}

$bFirst = true;
while (list($key, $val) = each($arrFields)) 
{
	echo "<br><br>";
	echo "<b>";
	str_show($key);
	echo ":</b>"; 
	echo "<br> ";
	str_show($val);
}
}


		


echo "<br><br>";
?>
		