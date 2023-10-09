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
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
	
	?>

</div>
<div class="clear"></div>

<?php

if(isset($_POST["ProceedNewPassword"]))
{
	
	$oArr=$database->DataArray("employers","username='$AuthUserName'");
	
	if($oArr["password"]!=$_POST["oldpassword"])
	{
		echo '<i class="red-text">
			'.$PWD_WRONG.'
			</i>';
	}
	else
	if($_POST["newpassword1"]!=$_POST["newpassword2"])
	{
			echo '<i>
			'.$PWD_MISMATCH.'
			</i>';
			
		
	}
	else
	{
	
		$database->SQLUpdate_SingleValue(
				"employers",
				"username",
				"'".$AuthUserName."'",
				"password",
				$_POST["newpassword1"]
			);
			
			echo '<i>
			'.$PWD_CHANGED.'
			</i><br><br>';
			

			
			echo "
						<script>
							setTimeout(\"document.location.href='logout.php?show_login=1'\",1000);
						</script>
			";
	}

}

?>

<h3>
	<?php echo $CHANGE_PWD_FOR_USER; ?>
</h3>
<br>
		<form action="index.php" method=post>
		<input type="hidden" name="ProceedNewPassword"/>
		<input type="hidden" name="category" value="home"/>
		<input type="hidden" name="action" value="password"/>
		
		<table summary="" border="0">
  	<tr>
  		<td><?php echo $CURRENT_PWD;?>:</td>
  		<td><input type="password" name="oldpassword" size="20"/></td>
  	</tr>
	<tr height=30>
  		<td>&nbsp;</td>
  		<td>&nbsp;</td>
  	</tr>
  	<tr>
  		<td><?php echo $NEW_PWD;?>:</td>
  		<td><input type="password" name="newpassword1" size="20"/></td>
  	</tr>
  	<tr>
  		<td><?php echo $CONFIRM_PWD;?>: </td>
  		<td><input type="password" name="newpassword2" size="20"/></td>
  	</tr>
  </table>
  
		<br><br>
	
		<input class="btn btn-primary" type="submit" value=" <?php echo $M_SAVE;?> " class="adminButton"/>
		</form>
		
		</td>
	</tr>
</table>


