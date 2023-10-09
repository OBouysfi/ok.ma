<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(!isset($profil)){
	$strCurrentProfil="Producteur";
}
else{
	$strCurrentProfil=$profil;
}

if(isset($ProceedMessage)){

	SQLUpdate_SingleValue(
				"admin_users_type",
				"type",
				"'".$strCurrentProfil."'",
				"message",
				$NewMessage
			);
	$HISTORY=$USER_UPDATED_WELCOME_MSG.$strCurrentProfil;
}


$oArr=DataArray("admin_users_type","type='".trim($strCurrentProfil)."'");
?>

<script>
function NewProfilSelected(x){
	
	var strUrl="index.php?profil="+x.value+"&action=<?php echo $action;?>&category=<?php echo $category;?>";
	
	document.location.href=strUrl;
}
</script>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<tr>
		<td width=44>
			<img src="images/icons<?php echo $DN;?>/clipboard.gif" border="0" width="40" height="38" alt="">
		</td>
		<td class=basicText>
			<b><?php echo $GESTION_MESSAGE_BIENVENUE;?></b>
		</td>
	</tr>
</table>

<br><br>

<form action="index.php" method=post>
<input type=hidden name=ProceedMessage>
<input type="hidden" name="action" value="<?php echo $action;?>">
<input type="hidden" name="category" value="<?php echo $category;?>">

<?php echo $VEUILLEZ_CHOISIR_PROFIL;?>:
<br>
<br>
<font color=red>

<?php
$arrUserTypes=DataTable("admin_users_type","");

while($arrUserType=$database->fetch_array($arrUserTypes)){
	
	echo "<input onclick=\"javascript:NewProfilSelected(this)\" type=radio name=profil ".(trim($arrUserType["type"])==trim($strCurrentProfil)?"checked":"")." value=\"".$arrUserType["type"]."\">".$arrUserType["type"]." ";
	
}

?>
</font>
<br><br>
<textarea cols=63 rows=7 name="NewMessage">
<?php echo $oArr["message"];?>
</textarea>
<br><br>
<input type=submit value=" <?php echo $SAUVEGARDER;?> " class=adminButton>



</form>

<br><br>
<?php echo $LEGENDE_UTILISATEUR;?>

		</td>
	</tr>
</table>

