<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"jobs",
			"my",
			$MY_JOB_ADS,
			"",
			"blue"
		 );
	?>
</div>
<div class="clear"></div>
<?php

if(!isset($_REQUEST["Step"])||$_REQUEST["Step"]=="")
{
	$Step=1;
}
else
{
	$Step=$_REQUEST["Step"];
	if(isset($_REQUEST["SpecialProcessAddForm"])&&$_REQUEST["SpecialProcessAddForm"]=="")
	{
		$Step--;
	}
}

?>



<h3>
	<?php echo $POST_NEW_ADD;?>
</h3>
<br/>
<?php
$show_post_form = true;


if($website->GetParam("CHARGE_TYPE") == 1)
{
	if($arrUser["subscription"]==0)
	{
		$show_post_form = false;
		?>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a>
		<?php
	}
	else
	{
		
		$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
		if(($database->SQLCount("jobs","WHERE employer='".$AuthUserName."'") + $database->SQLCount("courses","WHERE employer='".$AuthUserName."'"))>= $arrSubscription["listings"])
		{
			echo '<h4><span class="red-font">'.$M_REACHED_MAXIMUM_SUBSCR.'</span>';
			?>
			<br/><br/>
			<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PLEASE_SELECT_TO_POST;?></a></h4>
			<?php
			$show_post_form = false;
		}
	
	}
}
else
if($website->GetParam("CHARGE_TYPE") == 2)
{
	if(($arrUser["credits"]-$website->GetParam("PRICE_LISTING_CREDITS"))<=0)
	{
		echo $M_NO_CREDITS_POST;
		?>
		<br/><br/>
		<a class="underline-link" href="index.php?category=home&action=credits"><?php echo $M_PURCHASE_CREDITS_POST;?></a>
		<?php
		$show_post_form = false;
	}
	else
	{
		
	}
}

?>

<?php
if($show_post_form)
{
?>		

<script>
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

function NewJob(x)
{

	document.getElementById("job_category").value=get_cat_value("category_1");
	document.getElementById("region").value=get_cat_value("region");
	
		
	if(x.title.value=="")
	{
		alert("<?php echo $JOB_TITLE_EMPTY;?>");
		x.title.focus();
		return false;
	}
	
	var wEditor = new nicEditors.findEditor('message');
	
	
	wEditor.saveContent();
	
	if(x.message.value=="")
	{
		alert("<?php echo $JOB_DESCRIPTION_EMPTY;?>");
		x.message.focus();
		return false;
	}
	
	return true;
}

</script>

<?php

$jsValidation="NewJob";
$arrOtherValues = array(array("date",date("F j, Y, g:i a")) , array("employer",$AuthUserName));




if(isset($_POST["SpecialProcessAddForm"]))
{

	if(trim($_POST["title"]) == "")
	{
		echo "
		<span class=\"red-font\">".$JOB_TITLE_EMPTY."</span>
		<br/>";
		$doNotAdd = true;
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
	
	if(trim($_POST["message"]) == "")
	{
		echo "
		<span class=\"red-font\">".$JOB_DESCRIPTION_EMPTY."</span>";
		$doNotAdd = true;
		unset($_REQUEST["SpecialProcessAddForm"]);
	}
	
	
}



if(is_array(unserialize(aParameter(280))))
{
	$arrJobFields = unserialize(aParameter(280));
}
else
{
	$arrJobFields = array();
}	


if(isset($_POST["SpecialProcessAddForm"]))
{
	$arrPValues = array();
	
	$iFCounter = 0;
	
	foreach($arrJobFields as $arrJobField)
	{		
		
		$arrPValues[$arrJobField[0]]=$_POST["pfield".$iFCounter];
		$iFCounter++;
	}

}
else
{
?>

<?php		

	$iFCounter = 0;
	$strSpecialHiddenFieldsToAdd="";
	foreach($arrJobFields as $arrJobField)
	{
		
		$strSpecialHiddenFieldsToAdd.="<tr>";
		
		$strSpecialHiddenFieldsToAdd.= "<td ><i>".str_show($arrJobField[0], true).":</i></td>";	
		
		$strSpecialHiddenFieldsToAdd.= "<td >";
		
		if(trim($arrJobField[2]) != "")
		{
				$strSpecialHiddenFieldsToAdd.= "<select  name=\"pfield".$iFCounter."\" style=\"width:150px\">";
				
				
				$arrFieldValues = explode("\n", trim($arrJobField[2]));
						
							
				if(sizeof($arrFieldValues) > 0)
				{
					foreach($arrFieldValues as $strFieldValue)
					{
						$strFieldValue = trim($strFieldValue);
						if(strstr($strFieldValue,"{"))
						{
						
							$strVName = substr($strFieldValue,1,strlen($strFieldValue)-2);
							
							$strSpecialHiddenFieldsToAdd.= "<option ".(trim($$strVName)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($$strVName)."</option>";
							
						}
						else
						{
							$strSpecialHiddenFieldsToAdd.= "<option ".(isset($arrPropFields[$arrJobField[0]])&&trim($strFieldValue)==$arrPropFields[$arrJobField[0]]?"selected":"").">".trim($strFieldValue)."</option>";
						}		
					
					}
				}
				
				$strSpecialHiddenFieldsToAdd.= "</select>";
		}
		else
		{
				$strSpecialHiddenFieldsToAdd.= "<input value=\"".(isset($arrPropFields[$arrJobField[0]])?$arrPropFields[$arrJobField[0]]:"")."\" type=text name=\"pfield".$iFCounter."\" style=\"width:150px\">";
		}
		
		$strSpecialHiddenFieldsToAdd.= "</td>";
		
		
			$strSpecialHiddenFieldsToAdd.= "</tr>";
		
	
		$iFCounter++;		
	}
	
	$_REQUEST["strSpecialHiddenFieldsToAdd"]=$strSpecialHiddenFieldsToAdd;
}
		
if($website->GetParam("CHARGE_TYPE")==3)
{
	$_REQUEST["arrNames2"] = array("status","date","employer","expires");
	$_REQUEST["arrValues2"] = array("0",time(),$AuthUserName, (time() + $website->GetParam("EXPIRE_DAYS")*86400) );

}
else
{
	$_REQUEST["arrNames2"] = array("date","employer","expires");
	$_REQUEST["arrValues2"] = array(time(),$AuthUserName, (time() + $website->GetParam("EXPIRE_DAYS")*86400) );
}

if(isset($arrPValues))
{
	array_push($_REQUEST["arrNames2"],"more_fields");
	array_push($_REQUEST["arrValues2"],serialize($arrPValues));
}

$iLId = -1;

$strJobType="";

foreach($website->GetParam("arrJobTypes") as $key=>$value)
{

	$strJobType.="_".$value."^".$key;
}
?>
<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','forecolor','fontFamily','link','unlink','left','center','right','justify','ol','ul','removeformat','indent','outdent','hr','bgcolor','underline','html'],iconsPath : 'js/nicEditorIcons.gif'}).panelInstance('message');
});
</script>
<?php

$arrLines = explode("\n",implode('', file('../locations/locations.php')));

if(isset($region)) $region=str_replace("~",".",$region);


$_REQUEST["message-column-width"]=120;
$_REQUEST["select-width"]=400;

$_REQUEST["hide_form"]=true;




$insertID = AddNewForm
(
	array
	(
		$M_CATEGORY.":",
	
		$M_JOB_TYPE.":",
		$M_TITLE.":",
		$M_DESCRIPTION.":",
		$M_REGION.":",
		$M_ZIP.":",
		$M_SALARY.":",
		$M_DATE_AVAILABLE.":",
		$ACTIVE.":"
	),
	array
	(
		"job_category",
		
		"job_type",
		"title",
		"message",
		"region",
		"zip",
		"salary",
		"date_available",
		"active"
	),
	array
	(
		"global_category",
		
		"combobox".$strJobType,
		"textbox_67",
	
		"textarea_75_10",
		"global_location",
		"textbox_8",
		"textbox_8",
		"textbox_8",
		"combobox_".$M_YES."^YES_".$M_NO."^NO"
	),
	$M_SUBMIT,
	"jobs",
	'<a class="underline-link" href="index.php?category=jobs&action=my">'.$NEW_POSTING_ADDED.'</a>',
	false,
	array(),
	"NewJob"
);



if($insertID > 0)	
{
	if(!isset($doNotAdd))
	{
	
		
		if($website->GetParam("ENABLE_EMAIL_NOTIFICATIONS"))
		{

			$headers  = "From: \"".$website->GetParam("SYSTEM_EMAIL_FROM")."\"<".$website->GetParam("SYSTEM_EMAIL_ADDRESS").">\n";
					
			$tableRules = $database->DataTable("rules","WHERE ".(isset($_POST["region"])?"region='".$_POST["region"]."' AND ":"")." job_category='".$_POST["job_category"]."' ");
			
			while($arrRule = $database->fetch_array($tableRules))
			{
				if($arrRule["rule"] == "")
				{
					if(trim($arrRule["user"]) != "")
					{
						mail($arrRule["user"],"$NEW_JOB_AD_CRITERIA","http://www.".$DOMAIN_NAME."/index.php?mod=search&job=".$iLId , $headers);	
					}
				}
				else
				{
					if(strstr($message,$arrRule["rule"]) || strstr($title,$arrRule["rule"]) )
					{
						if(trim($arrRule["user"]) != "")
						{
							mail($arrRule["user"],"$NEW_JOB_AD_CRITERIA","http://www.".$DOMAIN_NAME."/index.php?mod=search&job=".$iLId , $headers);	
						}
					}
				}
				
			}
				
		}		
					
		if($website->GetParam("CHARGE_TYPE")==2)
		{	
			$database->SQLUpdate_SingleValue
			(
				"employers",
				"id",
				$AdminUser["id"],
				"credits",
				(intval($AdminUser["credits"])-$website->GetParam("PRICE_LISTING_CREDITS"))
			);
		}
		
		
		if($website->GetParam("CHARGE_TYPE")==3)
		{	
			?>
			<?php
			if(trim($website->GetParam("PAYPAL_ID"))!="")
			{
			?>
				<br/><br/>				
				<form id="paypal_form" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>">
				<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>">
				<input type="hidden" name="item_name" value="<?php echo "Payment for job #".$insertID." on ".$DOMAIN_NAME;?> ">
				<input type="hidden" name="item_number" value="<?php echo $insertID;?>">
				<input type="hidden" name="amount" value="<?php echo number_format($website->GetParam("PRICE_JOB"), 2, '.', '');?>">
				<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn_job.php";?>">
				<input type="hidden" name="return" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS/index.php?category=jobs&action=my";?>">
				<input type="hidden" name="cancel_return" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS/index.php?category=jobs&action=my";?>">
				<input type="image"  src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
				</form>
				<script>
				document.getElementById("paypal_form").submit();
				</script>
				<br><br><br>
			<?php
			}
			?>
			
			
			
			<?php
		}
				
	}

}
	
?>


<?php
}
?>
