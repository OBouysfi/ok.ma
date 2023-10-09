<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<h3>
	<?php echo $M_CREDIT_PURCHASE;?>
</h3>
<br/>
		
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

		function PriceChanged()
		{
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
		if(isset($ProceedPurchase2))
		{
		
			if($number_credits < aParameter(701))
			{
				$number_credits = aParameter(701);
			}
			
			if($number_credits > aParameter(702))
			{
				$number_credits = aParameter(702);
			}
			
							include( "authorize_net.php" );
				
							$auth = new AuthorizeNet(); 
							
							$price = $number_credits*aParameter(700);
							
							
							$auth->setLoginId( $LOGIN_ID );
				    		$auth->setTranKey( $TRANSACTION_KEY );
				 
							
							$auth->setCustomerEmail( $CustomerEmail );
							$auth->setAddress( $CustomerAddress );  
							
							$auth->setCountry( "USA" );
							$auth->setPhone( $Phone );
							$auth->setFirstName( $FirstName );
							$auth->setLastName( $LastName );
							$auth->setAmount( $price );
							$auth->setCardNumber( $CardNumber );
							$auth->setExpireDate( $month.$year );
							
										
							if( $auth->process() )
							{
								$database->SQLUpdate_SingleValue
								(
									"jobseekers",
									"username",
									"'".$AuthUserName."'",
									"credits",
									($arrUser["credits"] + $number_credits)
								);
								
								 $insertId = SQLInsert
								(
									"credits_jobseeker",
									array("date_start","jobseeker","credits","payment","amount","status"),
									array(time(),$AuthUserName,$number_credits,"authorize.net",$price,"1")
								);
								
								echo "<b>Thank you! <font color=\"red\">".$number_credits." has been added successfully to your account!</font> </b>";
								
							}
							else
							{
								 print "Error: " . $auth->error(); 
								 
								 $insertId = SQLInsert
								(
									"credits_jobseeker",
									array("date_start","jobseeker","credits","payment","amount"),
									array(time(),$AuthUserName,$number_credits,"authorize.net",$price)
								);
							
							}
							
		}
		else
		if(isset($ProceedPurchase))
		{
		
			if($number_credits < aParameter(701))
			{
				$number_credits = aParameter(701);
			}
			
			if($number_credits > aParameter(702))
			{
				$number_credits = aParameter(702);
			}
		
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
		
		<input type="hidden" name="number_credits" id="number_credits" value="<?php echo $number_credits;?>" >
		
					
					<table summary="" border="0">
				  	<tr height="24">
				  		<td width="140"><b><?php echo $M_CREDIT_CARD;?>:</b></td>
				  		<td><input type="text" name="CardNumber" id="CardNumber" size="30" value=""></td>
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
								<option label="2007" value="07">2007</option>
								<option label="2008" value="08">2008</option>
								<option label="2009" value="09">2009</option>
								<option label="2010" value="10">2010</option>
								<option label="2011" value="11">2011</option>
								<option label="2012" value="12">2012</option>
								<option label="2013" value="13">2013</option>
								<option label="2014" value="14">2014</option>
								<option label="2015" value="15">2015</option>
								<option label="2016" value="16">2016</option>
								<option label="2017" value="17">2017</option>
								<option label="2018" value="18">2018</option>
								<option label="2019" value="19">2019</option>
								<option label="2020" value="20">2020</option>
						</select>
						
						</td>
				  	</tr>
				  	<tr height="24">
				  		<td><b><?php echo $FIRST_NAME;?>:</b></td>
				  		<td><input type="text" name="FirstName" id="FirstName" size="30" value=""></td>
				  	</tr>
				  	<tr height="24">
				  		<td><b><?php echo $LAST_NAME;?>:</b></td>
				  		<td><input type="text" name="LastName" id="LastName" size="30" value=""></td>
				  	</tr>
					
					
				  	<tr height="24">
				  		<td><b><?php echo $M_ADDRESS;?>:</b></td>
				  		<td><textarea name="CustomerAddress" style="width:205px" rows="3" cols="30"><?php echo $arrUser["address"];?></textarea></td>
				  	</tr>
				  	
				  	
				  	<tr height="24">
				  		<td><b><?php echo $M_PHONE;?>:</b></td>
				  		<td><input type="text" name="Phone" size="30" value="<?php echo $arrUser["phone"];?>"></td>
				  	</tr>
					  <tr height="24">
				  		<td><b><?php echo $M_EMAIL;?>:</td>
				  		<td><input type="text" name="CustomerEmail" size="30" value="<?php echo $AuthUserName;?>"></td>
				  	</tr>
				  </table>
				
						
						<br><br>
						
						<input type="submit" value=" <?php echo $ENVOYER;?> " class="adminButton">
						
						</b>
						</form>
						<br><br>
		
		
			
			
			<!--AUTHORIZE.NET END-->
			<?php
			}
			else
			{
			
			$price = $number_credits*aParameter(700);
			
			$insertId = SQLInsert
								(
									"credits_jobseeker",
									array("date_start","jobseeker","credits","payment","amount"),
									array(time(),$AuthUserName,$number_credits,$payment_method,$price)
								);
			
			
			
			
			
		?>
		
		
		<b><?php echo $M_SELECTED_PAYMENT_OPTION;?>:</b>
		<br><br>
		
		
			<?php
										if($ACCEPT_PAYPAL&&$payment_method=="paypal")
										{
										?>
										
										<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
										<br><br>
										
												<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
												<input type="hidden" name="cmd" value="_xclick">
												<input type="hidden" name="business" value="<?php echo $PAYPAL_ACCOUNT;?>">
												<input type="hidden" name="currency_code" value="<?php echo $PAYPAL_CURRENCY_CODE;?>">
												<input type="hidden" name="item_name" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?> ">
												<input type="hidden" name="item_number" value="<?php echo $insertId;?>">
												<input type="hidden" name="amount" value="<?php echo number_format($price, 2, '.', '');?>">
												<input type="hidden" name="notify_url" value="<?php echo "http://www.".$DOMAIN_NAME."/ipn.php";?>">
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
										
										<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
										<br><br>
										
																<form target="_blank" action=https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c method=post>
																<input type=hidden name="sid" value="<?php echo $_2CHECKOUT_SID;?>"> 
																<input type=hidden name="cart_order_id" value="<?php echo $insertId;?>"> 
																<input type=hidden name="total" value="<?php echo number_format($arrSelectedPackage["price"], 2, '.', '');?>">
																<input type="image" src="../ADMIN/images/2checkout.gif" width="190" height="54" alt="" border="0">
																</form>
														<br><br><br>
										<?php
										}
										?>
										
										<?php
										if($ACCEPT_ALERTPAY&&$payment_method=="alertpay")
										{
										?>
										
										<i><?php echo $M_CLICK_ICON_MAKE_PAYMENT;?></i>
										<br><br>
											<form method="post" action="https://www.alertpay.com/PayProcess.aspx" > 
										<input type="hidden" name="ap_merchant" value="<?php echo $ALERTPAY_MERCHAT_EMAIL;?>"/> 
										<input type="hidden" name="ap_purchasetype" value="subscription"/> 
										<input type="hidden" name="ap_itemname" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?>"/> 
										<input type="hidden" name="ap_amount" value="<?php echo $arrSelectedPackage["price"]; ?>"/>     
										<input type="hidden" name="ap_currency" value="<?php echo $PAYPAL_CURRENCY_CODE; ?>"/> 
										<input type="hidden" name="ap_itemcode" value="<?php echo $arrSelectedPackage["id"]; ?>"/> 
										<input type="hidden" name="ap_quantity" value="1"/> 
										<input type="hidden" name="ap_description" value="<?php echo $DOMAIN_NAME." ".$number_credits." credits";?>"/> 
										
										<input type="hidden" name="ap_timeunit" value="month"/> 
										<input type="hidden" name="ap_periodlength" value="<?php echo $arrSelectedPackage["billed"]; ?>"/> 
										<input type="hidden" name="ap_periodcount" value="12"/> 
										<input type="hidden" name="ap_trialtimeunit" value="day"/> 
										<input type="hidden" name="ap_trialamount" value="0"/> 
										<input type="hidden" name="ap_trialperiodlength" value="30"/> 
										
										<input type="image" src="../EMPLOYERS/images/alertpay_button.gif"/>
														<br><br><br>
										<?php
										}
										?>
										
										
										
										<?php
										if($ACCEPT_CHECK&&$payment_method=="check")
										{
										?>
												<i><?php echo $M_PLS_SEND_CHEQUE;?></i>
												<br><br>	
													<?php echo $CHEQUE_ADDRESS;?> 
													<br><br><br>
										<?php
										}
										?>
										
										<?php
										if($ACCEPT_BANK_WIRE_TRANSFER&&$payment_method=="bank")
										{
										?>
										
												<i><?php echo $M_FIND_BANK_DETAILS;?></i>		
												
												<?php
										
										
												echo $BANK_WIRE_TRANSFER_INFO;
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
		if($ENABLE_AUTHORIZE_NET_AIM_PAYMENTS)
		{
		?>
		https://www.<?php echo $DOMAIN_NAME;?>/
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
		<input type="hidden" name="page" value="<?php echo $page;?>">
		<input type="hidden" name="folder" value="<?php echo $folder;?>">
		
		<i><?php echo $M_PLS_CREDITS_NUMBER;?>
		</i>
		
		<br><br>
		<b>
		
		<?php echo $M_CREDITS;?>: <input type=text name="number_credits" id="number_credits" value="0" onmouseout="PriceChanged()" style="width:40px">
		&nbsp;
		<?php echo $M_PRICE;?>: 
		<font color=red><?php echo $CURRENCY_SYMBOL;?></font><span id="span_price" style="color:red">0</span>
		&nbsp;
		<?php echo $M_PAYMENT;?>:
		
		<?php
		
		$bFirstChecked = false;
		
		if($ENABLE_AUTHORIZE_NET_AIM_PAYMENTS)
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="authorize">
				<?php echo $M_CC_AUTHORIZE;?>
				&nbsp;
				
		<?php
		$bFirstChecked = true;
		}
		
		
		if($ACCEPT_PAYPAL)
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="paypal">
				PayPal
				&nbsp;
				
		<?php
		$bFirstChecked = true;
		}
		?>

		<?php
		if($ACCEPT_2CHECKOUT)
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
		if($ACCEPT_ALERTPAY)
		{
		
		?>
				<input type="radio" <?php if(!$bFirstChecked) echo "checked";?> name="payment_method" value="alertpay">
				AlertPay
				&nbsp;
						
		<?php
		$bFirstChecked = true;
		}
		?>

		<?php
		if($ACCEPT_CHECK)
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
		if($ACCEPT_BANK_WIRE_TRANSFER)
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
		
		<input type=submit value=" <?php echo $M_PURCHASE;?> " class=adminButton>
		
		</b>
		</form>
		<br><br><br>
		
		<i><?php echo $M_PRICE_1_CREDIT;?>: <font color=red><?php echo $CURRENCY_SYMBOL.aParameter(700);?></font></i>
		
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
										if($ENABLE_AUTHORIZE_NET_AIM_PAYMENTS)
										{
										?><td valign="top">
												<img src="images/authorize.gif" width="270" height="106" alt="" border="0">
												</td>
										<?php
										}
										else
										{
										?>
		
  		
		<?php
										if($ACCEPT_PAYPAL)
										{
										?><td valign="top">
												<img src="../ADMIN/images/paypal.gif" border="0" width="117" height="35" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
												</td>
										<?php
										}
										?>
		
  		
		<?php
										if($ACCEPT_2CHECKOUT)
										{
										?><td valign="top">
												<img src="../ADMIN/images/2checkout.gif" width="190" height="54" alt="" border="0">
												</td>		
										<?php
										}
										?>
		
		
										<?php
										if($ACCEPT_ALERTPAY)
										{
										?><td valign="top">
												<img src="../ADMIN/images/alertpay.gif" alt="" border="0">
												</td>		
										<?php
										}
										?>
		
  		
		<?php
										if($ACCEPT_CHECK)
										{
										?>
													<td valign="top">
													<img src="../ADMIN/images/cheque.gif" width="100" height="55" alt="" border="0">
											</td>
											<?php
										}
										?>
	
  		
										<?php
										if($ACCEPT_BANK_WIRE_TRANSFER)
										{
										?><td valign="top">
												
												<img src="../ADMIN/images/banque.gif" width="66" height="80" alt="" border="0">
												</td>
										<?php
										}
										}
										?>
		
		
  	</tr>
  </table>
		
		
		<?php
		}
		?>
		
