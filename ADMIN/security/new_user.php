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

<div class="fright">

	<?php
		echo LinkTile
			 (
				"security",
				"permissions",
				$M_ACCESS_RIGHTS,
				"",
				"blue"
			 );
	?>
		
	<?php
		echo LinkTile
			 (
				"security",
				"admin",
				$M_USERS_LIST,
				"",
				"red"
			 );
	?>
		
</div>
<div class="clear"></div>
<span class="medium-font" id="page-header">
<?php echo $AJOUTER_NOUVEL_UTILISATEUR;?>
</span>

<br/>
<br/>

<script>
function CallBack()
{
	lock_check = false;
	loadPage("#security-admin");
}
</script>

<script>
function ContainsSpecialSymbols(strInput){
	
	
	var reg = new RegExp("#|%|'");

	if (reg.test(strInput)){
		
		return true;
	}
	else{
		
		return false;
	}
  		
}

function ValidateForm(x)
{
 
	if(ContainsSpecialSymbols(x.username.value))
	{
		x.username.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"<?php echo $NOM_UTILISATEUR_CARACTERES;?>!";
		return false;
	}
	
	if(x.username.value=="")
	{
		x.username.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"<?php echo $NOM_UTILISATEUR_VIDE;?>!";
		return false;
	}
	
	if(x.password.value=="")
	{
		x.password.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"<?php echo $MOT_DE_PASSE_VIDE;?>!";
		return false;
	}
	 
	if(x.email.value=="")
	{
		x.email.style.background="#edeff3";
		
		document.getElementById("page-header").innerHTML=
		"<?php echo $CHAMP_EMAIL_VIDE;?>!";
		return false;
	}
	
	
	
	return true;
}

</script>

<?php

$MessageTDLength=120;


AddNewForm
(
		array($M_TYPE.":",$M_USERNAME.":",$MOT_DE_PASSE.":",$TELEPHONE.":",$EMAIL.":"),
		
		array("type","username","password","telephone","email"),

		array("combobox_table~admin_users_type~type~type","textbox_20","password_20","textbox_20","textbox_20"),

		$AJOUTER_UTILISATEUR,
		"admin_users",
		$NOUVEL_UTILISATEUR_SUCCES,
		true,
		array(),
		"ValidateAddNewUser"
);
	
?>
