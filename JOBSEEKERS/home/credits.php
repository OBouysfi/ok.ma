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
		
		<table summary="" border="0" width="100%">
  			<tr>
  				<td align="right">
						<table summary="" border="0">
				      	<tr>
				      		<td><img src="images/link_arrow.gif" width="16" height="16" alt="" border="0"></td>
				      		<td><a href="index.php?category=home&folder=credits&page=history" style="color:#6d6d6d"><?php echo $M_CREDITS_HISTORY_INVOICES;?></a></td>
				      	</tr>
				      </table>	
				</td>
  			</tr>
  	</table>
		
		<br>
		<i>
			<?php echo $M_CREDITS_EXPL_JOBSEEKER;?>
		</i>
		<br><br><br><br>
		
		<span style="font-size:13px;font-weight:800">
		
		<?php echo $M_CURRENTLY_YOU_HAVE;?> <font color=red><?php echo $arrUser["credits"];?> <?php echo $M_CREDITS;?> </font>
		&nbsp;
		,&nbsp; <?php echo $M_PRICE_FOR;?> 1 <?php echo $M_CREDIT;?> 
		<font color=red>
		<?php echo $CURRENCY_SYMBOL;?><?php echo aParameter(700);?>
		</font>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="index.php?category=home&folder=credits&page=purchase">[<?php echo $M_PURCHASE_CREDITS;?>]</a>
		
		</span>
		<br><br><br><br><br>
		<b><?php echo $M_VIEW_CANCEL_PENDING_PAYMENTS;?>:</b>
		<br><br>
		<center>
		<?php
		
		if(isset($Delete)&&isset($CheckList))
		{
			if(sizeof($CheckList)>0)
			{
				$website->ms_ia($CheckList);
				SQLDeletePlus("jobseeker","","credits_jobseeker","id",$CheckList);
			}
		}
		
		if($database->SQLCount("credits_jobseeker","WHERE jobseeker='$AuthUserName' and status=0   ")==0)
		{
		
				echo "</center><br>[".$M_ANY_PENDING_PAYMENTS."]<center>";
		
		}
		else
		{
			
			RenderTable
			(
				"credits_jobseeker",
				array("date_start","credits","amount","payment"),
				array($DATE_MESSAGE,$M_CREDITS,$M_AMOUNT,$M_PAYMENT),
				650,
				"WHERE jobseeker='$AuthUserName' and status=0   ",
				"Cancel",
				"id",
				"index.php?action=".$action."&category=".$category
			);
			
		}
				
		?>
		</center>
		
		<br><br><br><br><br>
		<b><?php echo $M_PRICES_CREDITS;?>:</b>
		<br><br>
		<ul>
			
			
			
			<li><i style="font-size:13px"><?php echo $M_APPLY_FOR_A_JOB;?></i></li>
			
			<center>
			<?php echo $M_PER_JOB;?> - <?php echo $M_CREDITS;?>: <font color=red><b><?php echo aParameter(705);?></b></font>
			</center>
		</ul>
		


