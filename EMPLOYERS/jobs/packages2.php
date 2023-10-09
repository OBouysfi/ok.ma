<?php
// Jobs Portal All Rights Reserved
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
		<b>
			<?php echo $ADD_NEW_PACKAGE;?>
		</b>
		</td>
	</tr>
</table>
<br>

<table summary="" border="0" width=95%>
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
					$arrSelectedPackage = $database->DataArray("packages","id=$package");
				
				
				
					SQLInsert
					(
						"packages_employer",
						array("employer","package_id","ads","valid","price","active","payment"),
						array($AuthUserName,$package,$arrSelectedPackage["ads"],$arrSelectedPackage["valid"],$arrSelectedPackage["price"],
						($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT?"1":"0"),
						($JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT?"":$payment_method))
					);
					
					?>
					
					<table summary="" border="0" width="95%">
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
								
								}
							}
							else
							{
							?>
							
								<?php
									echo "<br><br>".$M_SELECTED_PAYMENT_METHOD.":<br><br>";
								?>
					
					
								
										<?php
										if($ACCEPT_PAYPAL&&$payment_method=="paypal")
										{
										?>
												<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
												<input type="hidden" name="cmd" value="_xclick">
												<input type="hidden" name="business" value="<?php echo $PAYPAL_ACCOUNT;?>">
												<input type="hidden" name="currency_code" value="<?php echo $PAYPAL_CURRENCY_CODE;?>">
												<input type="hidden" name="item_name" value="<?php echo $arrSelectedPackage["ads"];?> ads package [<?php echo $AuthUserName;?>]">
												<input type="hidden" name="amount" value="<?php echo number_format($arrSelectedPackage["price"], 2, '.', '');?>">
												<input type="image"  src="../ADMIN/images/paypal.gif" border="0" width="117" height="35" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
												</form>
												<br><br><br>
										<?php
										}
										?>
										
										<?php
										if($ACCEPT_2CHECKOUT&&$payment_method=="2co")
										{
										?>
																<form target="_blank" action=https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c method=post>
																<input type=hidden name=sid value="<?php echo $_2CHECKOUT_SID;?>"> 
																<input type=hidden name=cart_order_id value="<?php echo $arrSelectedPackage["ads"];?> ads package [<?php echo $AuthUserName;?>]"> 
																<input type=hidden name=total value="<?php echo number_format($arrSelectedPackage["price"], 2, '.', '');?>">
																<input type="image" src="../ADMIN/images/2checkout.gif" width="190" height="54" alt="" border="0">
																</form>
														<br><br><br>
										<?php
										}
										?>
										
										<?php
										if($ACCEPT_CHECK&&$payment_method=="check")
										{
										?>
													
													<?php echo $CHEQUE_ADDRESS;?> 
													<br><br><br>
										<?php
										}
										?>
										
										<?php
										if($ACCEPT_BANK_WIRE_TRANSFER&&$payment_method=="bank")
										{
										?>
												<?php
												
												echo $BANK_WIRE_TRANSFER_INFO;
												?>
												
												<br><br><br>
										<?php
										}
										?>
										
								

					
								<?php
									
									echo "<br>".$PACKAGE_ADD_EXPL;
								?>
									</b>
									
									
									<?php
									}
									?>
									
									
							</td>
     					</tr>
    				 </table>
					 
					<?php
	}
	
}
else
{
?>
<br>
<table width=95%><tr><td class=basictext>
<b><?php echo $LIST_AVAILBALE_PACKAGES;?>:</b>


<br><br>

<form action=index.php method=post>
<input type=hidden name=ProceedBuy>
<input type=hidden name=category value="<?php echo $category; ?>">
<input type=hidden name=action value="<?php echo $action; ?>">
<?php


$packages = $database->DataTable("packages","ORDER BY ads");
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
		".$M_PRICE.": <b>".$website->GetParam("CURRENCY")."".$oPackage["price"]."</b>
		<br><br>
	";
	
	$flag = false;
}
?>
<br>

<?php
if(!$JOB_PACKAGES_AND_BANNERS_ACTIVATED_BY_DEFAULT)
{
?>

<i><?php echo $M_PAYMENT_OPTIONS2;?>:</i>
<br><br>
<?php
						if($ACCEPT_PAYPAL)
						{
						?>
										<input type="radio" name="payment_method" value="paypal" checked>
										<b><?php echo $M_PAYPAL;?></b>
										
						<?php
						}
						?>
						
						<?php
						if($ACCEPT_2CHECKOUT)
						{
						?>
										<input type="radio" name="payment_method" value="2co" >
										<b><?php echo $M_2CO;?></b>
										
						<?php
						}
						?>
						
						<?php
						if($ACCEPT_CHECK)
						{
						?>
										<input type="radio" name="payment_method" value="check">
										<b><?php echo $M_CHECK;?>  </b>
									
						<?php
						}
						?>
						
						<?php
						if($ACCEPT_BANK_WIRE_TRANSFER)
						{
						?>
										<input type="radio" name="payment_method" value="bank">
										<b><?php echo $M_BANK_WIRE_TRANSFER;?> </b>
										
						<?php
						}
						?>
						
						<br><br><br>
						
<?php
}
?>		
			

<input type=submit value=" <?php echo $M_BUY;?> " class=adminButton>
</form>
<?php
}
?>
<br><br>

<table width=95% class=basictext><tr><td class=basictext>
<b><?php echo $CURRENTLY_FOLLOWING;?>:</b>
</td></tr></table>
<br>
<center>
<?php

RenderTable(
						"packages_employer",
						array("ads","price","package_status"),
						array($REMAINING_ADS,$PACKAGE_PRICE." (".$website->GetParam("CURRENCY").")",$STATUS),
						"500",
						" WHERE employer = '$AuthUserName' AND ads>0",
						"",
						"id",
						
						"index.php?category=".$category."&action=".$action
						);
?>
</center>
<br><br>
<table width=95%><tr><td class=basictext>
<?php echo $NOTICE_AD_PACKAGE;?>
</td></tr></table>

<br>
</td></tr></table>

