<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width=40>
		
		<img src="images/icons2/wallet.png" width="48" height="48" alt="" border="0">
		
		
		</td>
		
		<td class=basictext>
		<span class="header_title">
			<?php echo $ADD_NEW_PACKAGE;?>
		</span>
		</td>
	</tr>
</table>
<br>

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
			<?php echo $IN_ORDER_TO_ADD;?>
		</td>
	</tr>
</table>
<br>
<?php

if(isset($ProceedBuy))
{

	if(!isset($package)||$package=="")
	{
		echo "
			<script>
				alert('".$SELECT_PACKAGE."');
			</script>
		";
	}
	else
	{
					
					$website->ms_i($package);
					$arrSelectedPackage = $database->DataArray("packages","id=$package");
				
					
					if($arrSelectedPackage["price"]>$arrUser["credits"])
					{
						
						echo "<br><b><font color=red>".$M_NOT_ENOUGH_CREDITS."</font></b>";
						
					}
					else
					{
					
							
					
							$database->SQLUpdate_SingleValue
							(
								"employers",
								"username",
								"'".$AuthUserName."'",
								"credits",
								$arrUser["credits"]-$arrSelectedPackage["price"]
							);	
								
									SQLInsert
									(
										"packages_employer",
										array("employer","package_id","ads","valid","price","active","payment"),
										array($AuthUserName,$package,$arrSelectedPackage["ads"],$arrSelectedPackage["valid"],$arrSelectedPackage["price"],
										($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT?"1":"1"),
										($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT?"":"credits"))
									);
									
									?>
									
									<table summary="" border="0" width="100%">
				    				 	<tr>
				     						<td>
											
												<b>
											
											<?php
											if($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT)
											{
												if($SEND_PAYMENT_EMAILS)
												{
												
													$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
								
													$PAYMENT_EMAIL_TEXT = str_replace("[AMOUNT]",$arrSelectedPackage["price"],$PAYMENT_EMAIL_TEXT);
													
													mail($AuthUserName,$PAYMENT_EMAIL_SUBJECT,$PAYMENT_EMAIL_TEXT , $headers);	
												
													echo "<br>".$PAYMENT_EMAIL_TEXT;
												}
											}
											else
											{
											
											
												echo "<br><b>".$M_THANK_YOU_PACKAGE_ADDED."</b>";
											
											
											}
											?>
													</b>
													
											</td>
				     					</tr>
				    				 </table>
									 
									<?php
					}
	}
	
}
else
{
?>
<br>
<table width="100%"><tr><td class="basictext">
<i><?php echo $LIST_AVAILBALE_PACKAGES;?>:</i>


<br><br>

<form action="index.php" method="post">
<input type="hidden" name="ProceedBuy" value="1">
<input type="hidden" name="category" value="<?php echo $category; ?>">
<input type="hidden" name="action" value="<?php echo $action; ?>">
<?php


$packages = $database->DataTable("packages","WHERE active='YES' ORDER BY ads");
$flag = true;
while($oPackage = $database->fetch_array($packages))
{
	echo 
	"
		<input type=radio name=package ".($flag?"checked":"")." value=\"".$oPackage["id"]."\">
		".$M_ADS.": <b>".$oPackage["ads"]."</b>
		&nbsp;&nbsp;
		".$VALID_MONTHS.": <b>".$oPackage["valid"]." ".$M_DAYS."</b>
		&nbsp;&nbsp;
		".$M_PRICE.": <b>".$oPackage["price"]." ".$M_CREDITS."</b>
		<br><br>
	";
	
	$flag = false;
}
?>
<br>
	

<input type=submit value=" <?php echo $M_BUY;?> " class=adminButton>


</form>	

  <br>
</td></tr></table>

<?php
}
?>
<br><br>

<table width="100%" class=basictext><tr><td class=basictext>
<i><?php echo $CURRENTLY_FOLLOWING;?>:</i>
</td></tr></table>
<br>
<center>
<?php

RenderTable(
						"packages_employer",
						array("ads","price","package_status"),
						array($REMAINING_ADS,$PACKAGE_PRICE,$STATUS),
						"500",
						" WHERE employer = '$AuthUserName' AND ads>0",
						"",
						"id",
						
						"index.php?category=".$category."&action=".$action
						);
?>
</center>
<br><br>
<table width="100%"><tr><td class=basictext>
<i>
<?php echo $NOTICE_AD_PACKAGE;?>
</i>
</td></tr></table>



