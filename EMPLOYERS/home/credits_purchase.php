<?php
if(!defined('IN_SCRIPT')) die("");
?>

	<div class="fright">

	<?php
		echo LinkTile
		 (
			"home",
			"credits",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>

</div>
<div class="clear"></div>

<h3><?php echo $M_CREDIT_PURCHASE;?></h3>

		
		<script>
		function isInt (str)
		{
					var i = parseInt (str);
				
					if (isNaN (i))
						return false;
				
					i = i . toString ();
					if (i != str)
						return false;
				
					return true;
		}

		String.prototype.trim = function() {
			return this.replace(/^\s+|\s+$/g,"");
		}

		function PriceChanged()
		{
		
			document.getElementById("number_credits").value=document.getElementById("number_credits").value.trim();
			
			if(document.getElementById("number_credits").value.trim()=="")
			{
			
			}
			else
			if(isInt(document.getElementById("number_credits").value))
			{
				iValue = parseInt(document.getElementById("number_credits").value);
				
				if(iValue<<?php echo aParameter(701);?>)
				{
					iValue = <?php echo aParameter(701);?>;
					document.getElementById("number_credits").value= "<?php echo aParameter(701);?>";
				}
				else
				if(iValue><?php echo aParameter(702);?>)
				{
					iValue = <?php echo aParameter(702);?>;
					document.getElementById("number_credits").value= "<?php echo aParameter(702);?>";
				}
					
				document.getElementById("span_price").innerHTML= iValue*<?php echo aParameter(700);?>;
				
			}
			else
			{
				document.getElementById("number_credits").value= "0";
				document.getElementById("span_price").innerHTML= "0";
			 
			}
		}
		
		</script>
		
		<br>
		<br>
		<?php 
		if(isset($_REQUEST["ProceedPurchase2"]))
		{
		
			include( "include/authorize_net.php" );
			$number_credits=$_POST["number_credits"];
			$auth = new AuthorizeNet(); 
			
			$price = $number_credits*aParameter(700);
			
			
			$auth->setLoginId($website->GetParam("AUTHORIZE_ID"));
			$auth->setTranKey($website->GetParam("AUTHORIZE_KEY"));
 
			
			$auth->setCustomerEmail($_POST["CustomerEmail"]);
			$auth->setAddress($_POST["CustomerAddress"]);  
			
			$auth->setCountry("USA");
			$auth->setPhone($_POST["Phone"]);
			$auth->setFirstName($_POST["FirstName"]);
			$auth->setLastName($_POST["LastName"]);
			$auth->setAmount($price);
			$auth->setCardNumber($_POST["CardNumber"]);
			$auth->setExpireDate($_POST["month"].$_POST["year"]);
			
						
			if( $auth->process() )
			{
				$database->SQLUpdate_SingleValue
				(
					$strTable,
					"username",
					"'".$AuthUserName."'",
					"credits",
					($arrUser["credits"] + $number_credits)
				);
				
				echo "<b>Thank you! <font color=\"red\">".$number_credits." has been added successfully to your account!</font> </b>";
				
			}
			else
			{
				 print "Error: " . $auth->error(); 
				 
				 $insertId = $database->SQLInsert
				(
					"credits",
					array("date_start","employer","credits","payment","amount"),
					array(time(),$AuthUserName,$number_credits,"authorize.net",$price)
				);
			
			}
							
		}
		else
		if(isset($_POST["ProceedPurchase"]))
		{
			$payment_method = $_POST["payment_method"];
			
			if($payment_method == "authorize")
			{
			?>
			<!--AUTHORIZE.NET-->
			
			<script>
		
		function SubmitPaymentForm(x)
		{
			if(x.CardNumber.value == "")
			{
				alert("The credit card number can not be empty!");			
				x.CardNumber.focus();
				return false;
			}

			if(x.FirstName.value == "")
			{
				alert("The first name can not be empty!");			
				x.FirstName.focus();
				return false;
			}
			
			if(x.LastName.value == "")
			{
				alert("The last name can not be empty!");			
				x.LastName.focus();
				return false;
			}		
		
			return true;
		}
		
		</script>
		
		
		<form action="index.php" method="post" onsubmit="return SubmitPaymentForm(this)">
		<input type="hidden" name="ProceedPurchase2" value="1">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="page" value="<?php echo $page;?>">
		<input type="hidden" name="folder" value="<?php echo $folder;?>">
		
		<i><?php echo $M_BILLING_INFORMATION;?></i>
		
		<br><br>
		<b>
		<?php
		
		?>
		
		<input type="hidden" name="number_credits" id="number_credits" value="<?php echo $number_credits;?>" >
		
					
					<table summary="" border="0" cellspacing="5" style="border-spacing:5px;border-collapse: separate;">
				  	<tr height="24">
				  		<td width="140"><b><?php echo $M_CREDIT_CARD;?>:</b></td>
				  		<td><input type="text" name="CardNumber" id="CardNumber" size="33" value=""></td>
				  	</tr>
				  	<tr height="24">
				  		<td><b><?php echo $M_EXP_DATE;?>:</b></td>
				  		<td>
						
						 <select name="month" id="hide">
								<option label="January" value="01">January</option>
								<option label="February" value="02">February</option>
								<option label="March" value="03">March</option>
								<option label="April" value="04">April</option>
								<option label="May" value="05">May</option>
								<option label="June" value="06">June</option>
								<option label="July" value="07">July</option>
								<option label="August" value="08">August</option>
								<option label="September" value="09">September</option>
								<option label="October" value="10">October</option>
								<option label="November" value="11">November</option>
								<option label="December" value="12">December</option>
						</select>
				
				      <select name="year" id="hide">
							
								
								<option label="2015" value="15">2015</option>
								<option label="2016" value="16">2016</option>
								<option label="2017" value="17">2017</option>
								<option label="2018" value="18">2018</option>
								<option label="2019" value="19">2019</option>
								<option label="2020" value="20">2020</option>
								<option label="2021" value="20">2021</option>
								<option label="2022" value="20">2022</option>
								<option label="2023" value="20">2023</option>
								<option label="2024" value="20">2024</option>
								<option label="2025" value="20">2025</option>
						</select>
						
						</td>
				  	</tr>
				  	<tr height="24">
				  		<td><b><?php echo $FIRST_NAME;?>:</b></td>
				  		<td><input type="text" name="FirstName" id="FirstName" size="33" value=""></td>
				  	</tr>
				  	<tr height="24">
				  		<td><b><?php echo $LAST_NAME;?>:</b></td>
				  		<td><input type="text" name="LastName" id="LastName" size="33" value=""></td>
				  	</tr>
					
					
				  	<tr height="24">
				  		<td><b><?php echo $M_ADDRESS;?>:</b></td>
				  		<td><textarea name="CustomerAddress" style="width:287px" rows="3" cols="30"><?php echo $arrUser["address"];?></textarea></td>
				  	</tr>
				  	
				  	
				  	<tr height="24">
				  		<td><b><?php echo $M_PHONE;?>:</b></td>
				  		<td><input type="text" name="Phone" size="33" value="<?php echo $arrUser["phone"];?>"></td>
				  	</tr>
					  <tr height="24">
				  		<td><b><?php echo $M_EMAIL;?>:</td>
				  		<td><input type="text" name="CustomerEmail" size="33" value="<?php echo $arrUser["username"];?>"></td>
				  	</tr>
				  </table>
				
						
						<br><br>
						
						<input type="submit" value=" <?php echo $ENVOYER;?> " class="btn btn-default btn-gradient">
						
						</b>
						</form>
						<br><br>
		
		
			
			
			<!--AUTHORIZE.NET END-->
			<?php
			}
			else
			{
				$number_credits=$_POST["number_credits"];
				
				$price = $number_credits*aParameter(700);
			
				$insertId = $database->SQLInsert
				(
					"credits",
					array("date_start","employer","credits","payment","amount"),
					array(time(),$AuthUserName,$number_credits,$_POST["payment_method"],$price)
				);
		
		?>
			
		
			<?php
			if(trim($website->GetParam("PAYPAL_ID"))!=""&&$payment_method=="paypal")
			{
			?>
			
			<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
			<br><br>
			
					<form id="paypal_form" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="business" value="<?php echo $website->GetParam("PAYPAL_ID");?>">
					<input type="hidden" name="currency_code" value="<?php echo $website->GetParam("CURRENCY_CODE");?>">
					<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?> ">
					<input type="hidden" name="item_number" value="<?php echo $insertId;?>">
					<input type="hidden" name="custom" value="<?php echo $insertId; ?>"> 
					<input type="hidden" name="amount" value="<?php echo number_format($price, 2, '.', '');?>">
					<input type="hidden" name="notify_url" value="<?php echo "http://".$DOMAIN_NAME."/ipn.php";?>">
					<input type="hidden" name="return" value="<?php echo "http://".$DOMAIN_NAME."/EMPLOYERS";?>">
					<input type="image"  src="../images/paypal.gif" border="0" width="117" height="35" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					</form>
					<script>
					document.getElementById("paypal_form").submit();
					</script>
					<br><br><br>
			<?php
			}
			?>
			
			
			<?php
			if(trim($website->GetParam("MONEYBOOKERS_ID"))!=""&&$payment_method=="skrill")
			{
			?>
			
			<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
			<br><br>
			
				<form id="skrill_form" action="https://www.moneybookers.com/app/payment.pl" method="post"> 
				<input type="hidden" name="pay_to_email" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
				<input type="hidden" name="status_url" value="<?php echo $website->GetParam("MONEYBOOKERS_ID");?>"> 
				<input type="hidden" name="transaction_id" value="<?php echo $insertId;?>"> 
				<input type="hidden" name="language" value="EN"> 
				<input type="hidden" name="amount" value="<?php echo number_format($price, 2, '.', '');?>"> 
				<input type="hidden" name="currency" value="<?php echo $website->GetParam("CURRENCY_CODE");?>"> 
				<input type="hidden" name="detail1_description" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?>"> 
				<input type="hidden" name="detail1_text" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?>"> 
				<input type="hidden" name="confirmation_note" value=""> 
				<input type="image"  src="../images/skrill.jpg" border="0">
				</form> 
					
						<script>
					document.getElementById("skrill_form").submit();
					</script>
					<br><br><br>
				
				
			<?php
			}
			?>
			
			<?php
			if(trim($website->GetParam("PAYMATE_ID"))!=""&&$payment_method=="paymate")
			{
			?>
				<script>
					document.location.href="https://www.paymate.com/PayMate/ExpressPayment?mid=<?php echo $website->GetParam("PAYMATE_ID");?>&ref=<?php echo urlencode("".$DOMAIN_NAME." ".$number_credits." ".$M_CREDITS);?>&amt=<?php echo number_format($price, 2, '.', '');?>";
				</script>
			
			<?php
			}
			?>
			
			<?php
			if(trim($website->GetParam("2CHECKOUT_ID"))!=""&&$payment_method=="2co")
			{
			?>
			
			<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
			<br><br>
			
				<form id="2co_form" action="https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c" method="post">
				<input type="hidden" name="sid" value="<?php echo $website->GetParam("2CHECKOUT_ID");?>"> 
				<input type="hidden" name="cart_order_id" value="<?php echo $insertId;?>"> 
				<input type="hidden" name="total" value="<?php echo number_format($price, 2, '.', '');?>">
				<input type="hidden" name="skip_landing" value="1"> 
				<input type="image" src="../images/2checkout.gif" width="190" height="54" alt="" border="0">
				</form>
				<script>
				document.getElementById("2co_form").submit();
				</script>
				<br><br><br>
			<?php
			}
			?>
			
			<?php
			if($payment_method=="check")
			{
			?>
					<i><?php echo $M_PLS_SEND_CHEQUE;?></i>
					<br><br>	
						<?php
							echo "<h4>".nl2br(stripslashes($website->GetParam("CHEQUES_ADDRESS")))."</h4>";
						?> 
						<br><br><br>
			<?php
			}
			?>
			
			<?php
			if($payment_method=="bank")
			{
			?>
			
					<i><?php echo $M_FIND_BANK_DETAILS;?></i>		
					<br><br>	
					<?php
			
			
				echo "<h4>".nl2br(stripslashes($website->GetParam("BANK_ACCOUNT")))."</h4>";
					?>
					
					<br><br><br>
			<?php
			}
			?>
		
		<?php
			}
		}
		else
		{
		?>
		<script>
		function vform(x)
		{
			if(x.number_credits.value==""||x.number_credits.value==0)
			{
				alert("<?php echo $M_CREDITS_ZERO;?>");
				x.number_credits.focus();
				return false;
			}
			return true;
		}
		</script>
		<?php
		if($website->GetParam("AUTHORIZE_ID")!="")
		{
		?>
	
		<form action="index.php" method="post" onsubmit="return vform(this)">
		<?php
		}
		else
		{
		?>
		<form action="index.php" method="post" onsubmit="return vform(this)">
		<?php
		}
		?>

		<input type="hidden" name="ProceedPurchase" value="1">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<?php
		if(isset($_REQUEST["action"]))
		{
		?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<?php
		}
		else
		{
		?>
		<input type="hidden" name="page" value="<?php echo $page;?>">
		<input type="hidden" name="folder" value="<?php echo $folder;?>">
		<?php
		}
		?>
		<i><?php echo $M_PLS_CREDITS_NUMBER;?>
		</i>
		
		<br><br>
		<b>
		
		<?php echo $M_CREDITS;?>: <input type="text" name="number_credits" id="number_credits" value="0" onkeyup="PriceChanged()" style="min-width:60px !important;width:60px !important">
		&nbsp;
		<?php echo $M_PRICE;?>: 
		<font color=red><?php echo $website->GetParam("WEBSITE_CURRENCY");?></font><span id="span_price" style="color:red">0</span>
		&nbsp;
		<?php echo $M_PAYMENT;?>:
		
		<?php
		
		$bFirstChecked = false;
		
		if($website->GetParam("AUTHORIZE_ID")!="")
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="authorize">
				<?php echo $M_CC_AUTHORIZE;?>
				&nbsp;
				
		<?php
		$bFirstChecked = true;
		}
	
		
		if(trim($website->GetParam("PAYPAL_ID"))!="")
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="paypal">
				PayPal
				&nbsp;
				
		<?php
		$bFirstChecked = true;
		}
		
		
		if(trim($website->GetParam("PAYMATE_ID"))!="")
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="paymate">
				Paymate 
				&nbsp;
				
		<?php
		$bFirstChecked = true;
		}
		?>

		<?php
		if(trim($website->GetParam("2CHECKOUT_ID"))!="")
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="2co">
				2checkout
				&nbsp;
						
		<?php
		$bFirstChecked = true;
		}
		?>
		
		<?php
		if(trim($website->GetParam("MONEYBOOKERS_ID"))!="")
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="skrill">
				Skrill
				&nbsp;
						
		<?php
		$bFirstChecked = true;
		}
		?>

		<?php
		if(trim($website->GetParam("CHEQUES_ADDRESS"))!="")
		{
		
		?>
					
					<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="check">
					<?php echo $M_CHECK;?>
					&nbsp;
		<?php
		$bFirstChecked = true;
		}
		?>

		<?php
		if(trim($website->GetParam("BANK_ACCOUNT"))!="")
		{
		
		?>
				
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="bank">
				<?php echo $M_BANK_WIRE_TRANSFER;?>
				&nbsp;
		<?php
		$bFirstChecked = true;
		}
		?>
		
		<br><br><br>
		
		<input type=submit value=" <?php echo $M_PURCHASE;?> " class=btn btn-default btn-gradient>
		
		</b>
		</form>
		<br><br><br>
		
		<i><?php echo $M_PRICE_1_CREDIT;?>: <font color=red><?php echo $website->GetParam("WEBSITE_CURRENCY").aParameter(700);?></font></i>
		
		<br><br>
		<i><?php echo $M_MIN_CREDITS_PURCHASED;?>: <font color=red><?php echo aParameter(701);?></font></i>
		<br><br>
		<i><?php echo $M_MAX_CREDITS_PURCHASED;?>: <font color=red><?php echo aParameter(702);?></font></i>
		
		<br><br>
		<i><?php echo $M_PAYMENT_OPTIONS2;?>:</i>
		<br><br>
		
		<table summary="" border="0" width="100%">
  	<tr>
		
		

<?php
		if(trim($website->GetParam("PAYPAL_ID"))!="")
		{
		?><td valign="top">
				<img src="../images/paypal.gif" border="0" width="117" height="35" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
				</td>
		<?php
		}
		
		
		if(trim($website->GetParam("AUTHORIZE_ID"))!="")
		{
		?><td valign="top">
				<img src="../images/authorize.gif" border="0" width="117" height="35" name="submit" alt="">
				</td>
		<?php
		}
		?>
		
		<?php
		if(trim($website->GetParam("PAYMATE_ID"))!="")
		{
		?><td valign="top">
				<img src="../images/paymate.gif" border="0">
				</td>
		<?php
		}
		?>


	<?php
		if(trim($website->GetParam("2CHECKOUT_ID"))!="")
		{
		?><td valign="top">
				<img src="../images/2checkout.gif" width="190" height="54" alt="" border="0">
				</td>		
		<?php
		}
		?>
		
  		
		<?php
										if(trim($website->GetParam("CHEQUES_ADDRESS"))!="")
										{
										?>
													<td valign="top">
													<img src="../images/cheque.gif" width="100" height="55" alt="" border="0">
											</td>
											<?php
										}
										?>
	
  		
										<?php
										if(trim($website->GetParam("BANK_ACCOUNT"))!="")
										{
										?><td valign="top">
												
												<img src="../images/banque.gif" width="66" height="80" alt="" border="0">
												</td>
										<?php
										}
										?>
		
		
  	</tr>
  </table>
		
		
		<?php
		}
		?>
		
	