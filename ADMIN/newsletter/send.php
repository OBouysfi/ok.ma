<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
					"newsletter",
					"home",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>

<?php

if(isset($_REQUEST["ProceedSend"])&&isset($_REQUEST["newsletter_id"]))
{
	$arrNewsletter = $database->DataArray("newsletter","id=".$_REQUEST["newsletter_id"]);

	$strMessageBody = $arrNewsletter["html"];


	$strMessageSubject = $arrNewsletter["subject"];
	$strMessageHeaders = "From: \"".$website->params[3003]."\"<".$website->params[3003].">\n";

	$arrEmails = array();

	$iSuccessCounter = 0;
	
	
	
	if($_REQUEST["recepients"] == 1)
	{
		
		$arrMailingList = $database->DataTable("employers","WHERE newsletter=1");	

		while($arrMailing = $database->fetch_array($arrMailingList))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
		$arrMailingList2 = $database->DataTable("jobseekers","WHERE newsletter=1");	

		while($arrMailing = $database->fetch_array($arrMailingList2))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
	}
	else
	if($_REQUEST["recepients"] == 2)
	{
		
		$arrMailingList = $database->DataTable("employers","");	

		while($arrMailing = $database->fetch_array($arrMailingList))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
		$arrMailingList2 = $database->DataTable("jobseekers","");	

		while($arrMailing = $database->fetch_array($arrMailingList2))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
	}
	else
	if($_REQUEST["recepients"] == 3)
	{
		
		$arrMailingList = $database->DataTable("employers","WHERE newsletter=1");	

		while($arrMailing = $database->fetch_array($arrMailingList))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
		
	}
	else
	if($_REQUEST["recepients"] == 4)
	{
		
		
		
		$arrMailingList2 = $database->DataTable("jobseekers","WHERE newsletter=1");	

		while($arrMailing = $database->fetch_array($arrMailingList2))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
	}
	else
	if($_REQUEST["recepients"] == 5)
	{
		
		$arrMailingList = $database->DataTable("employers","");	

		while($arrMailing = $database->fetch_array($arrMailingList))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
		
	}
	else
	if($_REQUEST["recepients"] == 6)
	{
		
	
		$arrMailingList2 = $database->DataTable("jobseekers","");	

		while($arrMailing = $database->fetch_array($arrMailingList2))
		{
		
			if(in_array($arrMailing["username"],$arrEmails))
				{
					continue;
				}
				
				array_push($arrEmails,$arrMailing["username"]);
		}
		
	}
	else
	if($_REQUEST["recepients"] == 7)
	{
		$arrLines = explode("\n", $_REQUEST["recepient_textarea"]);
		
		foreach($arrLines as $arrLine)
		{
			if(in_array(trim($arrLine),$arrEmails))
				{
					continue;
				}
				
			array_push($arrEmails, trim($arrLine));
		}
	}
	
	$strMessageBody = str_replace("{NAME}",$arrMailing["name"],$strMessageBody);
	
	
	
	foreach($arrEmails as $strEmail)
	{	
		$bSuccess = mail($strEmail, $strMessageSubject,$strMessageBody, $strMessageHeaders);
			
		if($bSuccess)
		{
			$iSuccessCounter++; 
		}
		
		$database->SQLInsert
		(
			"newsletter_log",
			array("email","date","newsletter_id","status"),
			array($strEmail, time(), $_REQUEST["newsletter_id"],($bSuccess?"success":"error"))
			
		);
	}
	
	echo '
		<br>
		<span class="medium-font">'.$NEWSLETTER_SENT.' '.$iSuccessCounter.' users (from '.sizeof($arrEmails).'). You may look at the <a href="index.php?category=newsletter&action=log">log</a> for details. </span>
		<br>
		<br>
 	';
}

?>


<br>
<span class="medium-font">
Send a newsletter
</span>
<br><br><br>

<form action="index.php">
<input type="hidden" name="ProceedSend" value="1">
<input type="hidden" name="action" value="<?php echo $_REQUEST["action"];?>">
<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>">


1. <b><?php echo $CHOOSE_NEWSLETTER;?></b>:
<select name="newsletter_id">
<?php
$tableNewsletter = $database->DataTable ("newsletter","");

while($arrNewsletter = $database->fetch_array($tableNewsletter))
{
	echo "<option value=\"".$arrNewsletter["id"]."\">[".$arrNewsletter["id"]."] ".$arrNewsletter["subject"]."</option>";
}

?>
</select>
<br><br>
2. <b><?php echo  $CHOOSE_RECEPIENTS;?></b>:
<br><br>

<input class="no-margin" type=radio name=recepients value=1 checked/>


All the users who subscribed for the newsletter


<br><br>

<input class="no-margin" type=radio name=recepients value=2/>


All the users (employers and jobseekers)


<br><br>

<input class="no-margin" type=radio name=recepients value=3/>


All the employers who subscribed for the newsletter


<br><br>

<input class="no-margin" type=radio name=recepients value=4/>

All the jobseekers who subscribed for the newsletter

<br><br>

<input class="no-margin" type=radio name=recepients value=5/>

All the employers


<br><br>

<input class="no-margin" type=radio name=recepients value=6/>

All the jobseekers


<br><br>

<input type=radio name=recepients value=7 > 
Or paste a list of emails to which you would like to send the newsletter:
<br>
<textarea style="width:400px;height:90px" cols=40 rows=6 name=recepient_textarea></textarea>


<br><br>
<br>
<input type="submit" class="adminButton" value=" <?php echo $ENVOYER;?> ">

</form>
