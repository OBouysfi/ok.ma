<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?><script>
function ShowFaq(x)
{
	
	if(document.getElementById("faq"+x).style.display=="none")
	{
		document.getElementById("faq"+x).style.display="block";
	}
	else
	{
		document.getElementById("faq"+x).style.display="none";
	}
}
</script>
<br>
<b>Frequently asked questions</b>
<br><br>
<?php
$faqTable = $database->DataTable("faq","ORDER BY date");

$iFaqCounter = 0;

while($faqArray = $database->fetch_array($faqTable))
{
	$iFaqCounter++;
	
	echo $iFaqCounter.". <a href='javascript:ShowFaq(".$iFaqCounter.")'>".stripslashes($faqArray["title"])."</a>";	
	
	echo "
	<br>
		<div id=\"faq".$iFaqCounter."\" style=\"display:none\">
		<br>
		".stripslashes($faqArray["html"])."
		<br>
		</div>
		<br><br>
	";
}
?>
