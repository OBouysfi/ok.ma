<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["ProceedChange"]))
{
?>
<br>

<?php
$package=$_REQUEST["package"];
$website->$website->ms_i($package);
$arrPackage = $database->$database->DataArray("packages","id=".$package);

if($arrPackage["price"] == "0.00")
{

	$database->$database->SQLUpdate_SingleValue
	(
		"vendors",
		"id",
		$arrUser["id"],
		"plan",
		$package
	);
			
			
	$database->$database->SQLUpdate_SingleValue
	(
		"vendors",
		"id",
		$arrUser["id"],
		"type",
		$arrPackage["group_"]
	);
			
	echo "<h3>".$M_PACKAGE_SWITCH." : ".strtoupper($arrPackage["name"])."</h3><br>";
}
else
{
	$database->$database->SQLUpdate_SingleValue
	(
		"vendors",
		"id",
		$arrUser["id"],
		"new_plan",
		$package
	);
		
	$database->$database->SQLUpdate_SingleValue
	(
		"vendors",
		"id",
		$arrUser["id"],
		"payment",
		(isset($_REQUEST["payment_option"])?$_REQUEST["payment_option"]:"")
	);			
			
	if(isset($_REQUEST["payment_option"]) && $_REQUEST["payment_option"] == "alertpay")
	{
	
	
	echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
		
		".$PLEASE_CLICK_ICON_PAYPAL."
		<br><br>";
		?>
		
		<form method="post" action="https://www.alertpay.com/PayProcess.aspx" > 
			<input type="hidden" name="ap_merchant" value="<?php echo $ALERTPAY_MERCHAT_EMAIL;?>"/> 
			<input type="hidden" name="ap_purchasetype" value="subscription"/> 
			<input type="hidden" name="ap_itemname" value="<?php echo strtoupper($DOMAIN_NAME)." ".$M_PACKAGE.": ".$arrPackage["name"]; ?>"/> 
			<input type="hidden" name="ap_amount" value="<?php echo $arrPackage["price"]; ?>"/>     
			<input type="hidden" name="ap_currency" value="<?php echo $website->GetParam("CURRENCY_CODE"); ?>"/> 
			<input type="hidden" name="ap_itemcode" value="<?php echo $arrPackage["id"]; ?>"/> 
			<input type="hidden" name="ap_quantity" value="1"/> 
			<input type="hidden" name="ap_description" value="<?php echo strtoupper($DOMAIN_NAME)." ".$M_PACKAGE.": ".$arrPackage["name"]; ?>"/> 
			
			<input type="hidden" name="ap_timeunit" value="month"/> 
			<input type="hidden" name="ap_periodlength" value="<?php echo $arrPackage["billed"]; ?>"/> 
			<input type="hidden" name="ap_periodcount" value="12"/> 
			<input type="hidden" name="ap_trialtimeunit" value="day"/> 
			<input type="hidden" name="ap_trialamount" value="0"/> 
			<input type="hidden" name="ap_trialperiodlength" value="30"/> 
			
			<input type="image" src="../images/alertpay_button.gif"/>     
		</form>  
		
		
		
		<?php
		echo "<br><br>".$M_YOUR_PACKAGE_NOT_ACTIVE;
		
		echo "</div>
		";
				
	}
	else
				
				if(isset($_REQUEST["payment_option"]) && $_REQUEST["payment_option"] == "paypal")
				{
				
				
							echo "<div style='margin-left:20px;margin-right:5px;font-weight:800'>
								
								".$PLEASE_CLICK_ICON_PAYPAL."
								<br><br>";
								?>
								
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
								<input type="image" src="../images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
								 <input type="hidden" name="cmd" value="_xclick-subscriptions">
								<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>"> 
								<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$M_PACKAGE.": ".$arrPackage["id"]; ?>"> 
								<input type="hidden" name="item_number" value="<?php echo $arrPackage["id"]; ?>"> 
								<input type="hidden" name="no_note" value="1"> 
								<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE"); ?>"> 
								<input type="hidden" name="a3" value="<?php echo $arrPackage["price"]; ?>"> 
								<input type="hidden" name="p3" value="<?php echo $arrPackage["billed"]; ?>"> 
								<input type="hidden" name="t3" value="M"> 
								<input type="hidden" name="src" value="1"> 
								<input type="hidden" name="sra" value="1"> 
								<input type="hidden" name="return" value="http://www.<?php echo $DOMAIN_NAME;?>"> 
								<input type="hidden" name="cancel_return" value="http://www.<?php echo $DOMAIN_NAME;?>"> 
								<input type="hidden" name="custom" value="<?php echo $AuthUserName; ?>"> 
								<INPUT TYPE="hidden" NAME="first_name" VALUE="<?php echo $arrUser["first_name"];?>">
								<INPUT TYPE="hidden" NAME="last_name" VALUE="<?php echo $arrUser["last_name"];?>">
								</form>
								
								<?php
								echo "<br><br>".$M_YOUR_PACKAGE_NOT_ACTIVE;
								
								echo "</div>
								";
							
				}
				else
				if(isset($_REQUEST["payment_option"]) && $_REQUEST["payment_option"] == "cheque")
				{
				
						$strAmount = $website->GetParam("WEBSITE_CURRENCY").$arrPackage["price"];
						
											
						$database->SQLInsert
							( 
								"payments",
								array("date","user","method","validated","amount"),
								array(time(),$AuthUserName,"cheque","0",$arrPackage["price"])
							);
									
						echo str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_SEND_CHECK_TO)."
								<br><br>
								".$website->GetParam("CHEQUE_INFO")."
								<br><br>
								".$M_YOUR_PACKAGE_NOT_ACTIVE;
						
				}
				else
				if(isset($_REQUEST["payment_option"]) && $_REQUEST["payment_option"] == "bank_wire")
				{
						
						$strAmount = $website->GetParam("WEBSITE_CURRENCY").$arrPackage["price"];
						
												
						$database->SQLInsert
							( 
								"payments",
								array("date","user","method","validated","amount"),
								array(time(),$AuthUserName,"bank transfer","0",$arrPackage["price"])
							);
										
						echo str_replace("{AMOUNT}","<span class=redtext>".$strAmount."</span>",$M_PLEASE_MAKE_TRANSFER)."
								<br><br>
								".$website->GetParam("BANK_INFO")."
								<br><br>
								".$M_YOUR_PACKAGE_NOT_ACTIVE;
						
				}
}
?>

		
<?php
}
else
{
?>


<br/>

<?php
$arrUser = $database->$database->DataArray("vendors","username='$AuthUserName'");
$arrPackage = $database->$database->DataArray("packages","id=".$arrUser["plan"]);

if(!isset($arrPackage) || $arrPackage["id"] == "")
{

	echo "<b>".$M_PACKAGE_DELETED."</b><br><br>";

}
else
{
?>
<h3><?php echo $PACKAGE_DETAILS;?></h3>
	
		
<hr/>

<?php echo $NOM;?>: <b><?php echo $arrPackage["name"];?></b> 
&nbsp;&nbsp;&nbsp;
<?php echo $M_NUMBER_ALLOWED;?>: <b><?php echo $arrPackage["products"];?></b> 
&nbsp;&nbsp;&nbsp;
<?php echo $M_FEATURED_PRODUCTS;?>: <b><?php echo $arrPackage["featured_products"];?></b> 
&nbsp;&nbsp;&nbsp;
<?php echo $M_ADVERTISEMENTS;?>: 

<b>

<?php 
	if($arrPackage["adv"]==1)
	{
		echo $M_YES;
	}
	else
	{
		echo $M_NO;
	}
?>
</b> 
&nbsp;&nbsp;&nbsp;
<?php
echo $M_PRICE_FOR." ".$arrPackage["billed"]." ".$MM_MONTHS.":
<b>".$website->GetParam("WEBSITE_CURRENCY").$arrPackage["price"]."</b>";
	?>	

<br><br>
<?php echo $arrPackage["description"];?>


	
<?php
}
?>
<div class="clear"></div>
<br><br><br><br>
<?php
if(!$website->GetParam("FREE_WEBSITE"))
{
?>
	<h3><?php echo $M_UPGRADE_PACKAGE;?></h3>
			
	<hr/>

	<form action="index.php" method="post" style="margin-top:0px;margin-bottom:0px">
	<input type="hidden" name="action" value="<?php echo $action;?>">
	<input type="hidden" name="category" value="<?php echo $category;?>">
	<input type="hidden" name="ProceedChange" value="1">

	<script>
			function ShowPaymentOptions(x,y)
			{
				for(i=1;i<=iTotalPackages;i++)
				{ 
					if(document.getElementById("tr"+i))
					document.getElementById("tr"+i).style.background="#f1f1f1";	
					
					if(document.getElementById("table"+i))
					document.getElementById("table"+i).style.display="none";
				}
				
				
				document.getElementById("tr"+x).style.background="#a9c3d5";
				
				
				
				
				var arrItems=y.split("-"); 
				
				if(arrItems.length>1)
				{
								document.getElementById("PaymentOptions").style.display="block";
								
								for(i=0;i<arrItems.length;i++)
								{
									if(arrItems[i] != "")
									{
										document.getElementById("table"+arrItems[i]).style.display = "block";
									}
								}
								
				}
				else
				{
								document.getElementById("PaymentOptions").style.display="none";
				}
			
				
			}
			
	</script>

				
				<?php
				$tablePackages = $database->DataTable("packages","ORDER BY price");
				
				echo "<table width=\"100%\" cellpadding=0 cellspacing=0>";
				
				echo "<tr height=30>
					<td width=35></td>	
					<td width=\"50%\"><i>".$NOM."</i></td>
					<td><i>".$M_NUMBER_ALLOWED."</i></td>	
					<td><i>".$M_FEATURED_PRODUCTS."</i></td>		
					<td><i>".$M_ADVERTISEMENTS."</i></td>		
				</tr>";
				$iPCounter=1;						
				$bFirst = true;
				$iTotalPackages = 0;
				while($arrCurrentPackage = $database->fetch_array($tablePackages))
				{
						
						$iTotalPackages++;
						
						$strPaymentOptions = "";
						$strPayments = "";
						
						
					echo "<tr height=35 bgcolor='".($arrCurrentPackage["id"]==$arrPackage["id"]?"#a9c3d5":"#f1f1f1")."' id=\"tr".$iPCounter."\">";
					
					echo "
								<td>
										<input ".($arrCurrentPackage["id"]==$arrPackage["id"]?"checked":"")." type=\"radio\" name=\"package\" value=\"".$arrCurrentPackage["id"]."\">
								</td>
								<td>
										<b>".$arrCurrentPackage["name"]."</b>
								</td>
								<td>
										<b>".$arrCurrentPackage["products"]."</b>
								</td>
								<td>
										<b>".$arrCurrentPackage["featured_products"]."</b>
								</td>
								<td>
										<b>".($arrCurrentPackage["adv"]==1?$M_YES:$M_NO)."</b>
								</td>
					
					";	
					
					$bFirst = false;	
						
					echo "</tr>";
					
					echo "
							<tr height=35 bgcolor=#fafafa>
								<td colspan=6>
										<div style='margin-top:10px;margin-left:5px;margin-right:5px;margin-bottom:10px'>
							";
					
					if($arrCurrentPackage["price"] == "0.00" || $arrCurrentPackage["price"] == "")			
					{
						echo "<b>".strtoupper($M_PRICE).":
										<span class=redtext>".$M_FREE."!</span></b>";
					
					}
					else
					{
						echo "<b>".strtoupper($M_PRICE_FOR." ".$arrCurrentPackage["billed"]." ".$MM_MONTHS).":
										<span class=redtext>".$website->GetParam("WEBSITE_CURRENCY").$arrCurrentPackage["price"]."</span></b>";
						echo "
							<br><i>
							(".$M_PAID_PER." <b>".$arrCurrentPackage["billed"]."</b> ".$MM_MONTHS.", 
							".$M_AVERAGE_PRICE_MONTH.": ".$website->GetParam("WEBSITE_CURRENCY").number_format(round($arrCurrentPackage["price"]/$arrCurrentPackage["billed"],2),2,'.','')."</i>)";				
						
						
						
					}
										
					echo "			<br><br>
										<i>".$arrCurrentPackage["description"]."</i>
										</div>
								</td>
							</tr>
							<tr height=5>
								<td colspan=4>
									&nbsp;
								</td>
							</tr>
					";
					$iPCounter++;
				}
				
				echo "</table>";
				
				echo "
				<script>
				var iTotalPackages=".$iTotalPackages.";
				</script>
				";
				
				?>
				
				
				<div id="PaymentOptions">
				<b><?php echo $M_PLEASE_SELECT_YOUR_PAYMENT;?>:<br></b>
				</div>
				
				<table class=home_table id="table1">
					<tr><td  width="200" valign=middle><input type=radio checked name=payment_option value=paypal> <b><?php echo $M_PAYPAL;?></b> </td><td width=178 valign=middle ><img src='../images/paypal.gif'></td></tr>
				</table>
				
				<table class=home_table id="table2">
						<tr><td  width="200" valign="middle"><input type="radio" name="payment_option" value=cheque> <b><?php echo $M_CHEQUE;?></b> </td><td valign=middle><img src='../images/cheque.gif'></td></tr>
				</table>
				
				<table class=home_table id="table3">
						<tr><td  width="200" valign="middle"><input type="radio" name="payment_option" value=bank_wire> <b><?php echo $M_BANK_WIRE;?></b> </td><td valign=middle><img src='../images/banque.gif'></td></tr>
				</table>
				<table class=home_table id="table4">
						<tr><td  width="200" valign="middle"><input type="radio" name="payment_option" value="alertpay"> <b>AlertPay (credit card)</b> </td><td valign=middle><img src='../images/alertpay.jpg'></td></tr>
				</table>
				
				<br>
				<br>
				<input type="submit" class="adminButton" value=" <?php echo $M_NEXT;?> ">

				
	


<br>

</form>


<?php
}
?>


<?php
}
?>

