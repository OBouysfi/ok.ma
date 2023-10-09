<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<table summary="" border="0" width=750>
	<tr>
		<td>
		<b>
		<?php
		echo $URL_EXPLA;
		?>
			</b>
		</td>
	</tr>
</table>
<?php

if(isset($ProceedSave))
{
	SetParameter(
	1111,
	$url_format
	);
	
	$HISTORY = $FORMAT_CHANGED.$url_format;
	
	if(isset($lng_format))
	{
		SetParameter(
		1112,
		"NO"
		);
	}
	else
	{
		SetParameter(
		1112,
		"YES"
		);
	}
}

EnsureParams();
$urlType = aParameter(1111);
$urlLanguage = aParameter(1112);
?>
<form action=index.php method=post>
<input type=hidden name=category value=site_management>
<input type=hidden name=action value=urls>
<input type=hidden name=ProceedSave>
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<table border="0" cellpadding="0" cellspacing="0">
		  	<tr>
		  		<td><input type=radio  value="1" name=url_format <?php if($urlType==1) echo "checked";?>></td>
		  		<td>&nbsp;
				<b>
				<?php echo $URL_FORMAT1;?>
				</b>
				</td>
		  	</tr>
		  </table>
  
		<br>
		<font class=hl_text size=3 style="font-size:12">
		
		<b>
		&nbsp;&nbsp;index.php?page=[LANGUAGE]_[PAGE_LINK]
		</b>
		</font>
		,<?php echo $FOR_EXAMPLE;?>  index.php?page=en_contact
		</td>
	</tr>
	
</table>
<!--
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<table border="0" cellpadding="0" cellspacing="0">
		  	<tr>
		  		<td><input type=radio  value="2" name=url_format <?php if($urlType==2) echo "checked";?>></td>
		  		<td>&nbsp;
				<b>
				<?php echo $URL_FORMAT2;?>
				
				</b>
				</td>
		  	</tr>
		  </table>
  
		<br>
		<font color=#ff6500 size=3 style="font-size:12">
		
		<b>
		&nbsp;&nbsp;p/[LANGUAGE]_[PAGE_LINK].php
		</b>
		</font>
		, <?php echo $FOR_EXAMPLE;?> yoursite.com/p/en_contact
		</td>
	</tr>
	
</table>
-->
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<table border="0" cellpadding="0" cellspacing="0">
		  	<tr>
		  		<td><input type=radio   value="3" name=url_format <?php if($urlType==3) echo "checked";?>></td>
		  		<td>&nbsp;
				<b><?php echo $URL_FORMAT3;?></b>
				</td>
		  	</tr>
		  </table>
  
		<br>
		<font class=hl_text size=3 style="font-size:12">
		
		<b>
		&nbsp;&nbsp;[LANGUAGE]_[PAGE_LINK].html
		</b>
		</font>
		, <?php echo $FOR_EXAMPLE;?>  yoursite.com/en_contact.html
		</td>
	</tr>
	
</table>
<!--
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<table border="0" cellpadding="0" cellspacing="0">
		  	<tr>
		  		<td><input type=radio value="4"  name=url_format <?php if($urlType==4) echo "checked";?>></td>
		  		<td>&nbsp;
				<b><?php echo $URL_FORMAT4;?></b>
				</td>
		  	</tr>
		  </table>
  
		<br>
		<font color=#ff6500 size=3 style="font-size:12">
		
		<b>
		&nbsp;&nbsp;/[LANGUAGE]_[PAGE_LINK]
		</b>
		</font>
		, <?php echo $FOR_EXAMPLE;?>  yoursite.com/en_contact
		</td>
	</tr>
	
</table>
-->
<br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		<input type=checkbox name=lng_format <?php if($urlLanguage=="NO") echo "checked"; ?>>
		</td>
		<td>
		<i>
		<?php echo $LNG_INFO;?>
			</i>
		</td>
	</tr>
</table>
<br><br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		<input type=submit value=" <?php echo $SAVE_URLS;?> " class=adminButton>
		</td>
	</tr>
</table>
</form>

<script>
var HTType="2";
var HTMessage="<?php echo $HT_URLS;?>";
document.onmousedown = HTMouseDown;
</script>
