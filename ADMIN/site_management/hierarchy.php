<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["ProceedChangeLanguage"]))
{
	$language_version=strtolower($_REQUEST["ProceedChangeLanguage"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
else
{
	$language_version = $LoginInfo["bo_lang"];
	
}
?>
<div class="fright">
	<?php
	echo LinkTile
	 (
		"site_management",
		"pages_pro",
		$M_GO_BACK,
		"",
		"red"
	 );
				 
	echo LinkTile
	 (
		"site_management",
		"new_page",
		$M_NEW_PAGE,
		$M_ADD_NEW_PAGE,
		"green"
	 );
		?>
</div>
<div class="clear"></div>

<?php
if(isset($_REQUEST["ProceedPageHierarchy"])){

	if($_REQUEST["NewPageType"]==$_REQUEST["CurrentPageId"]){
	
	}
	else
	{
		$NewPageType = $_REQUEST["NewPageType"];
		$CurrentPageId = $_REQUEST["CurrentPageId"];
		$website->ms_i($NewPageType);
		$website->ms_i($CurrentPageId);
		
		
		$database->SQLUpdate("pages",array("parent_id"),array($NewPageType)," id=".$CurrentPageId);
	
		echo "<span class=\"medium-font\">".$M_NEW_VALUES_SAVED."</span><br/><br/><br/>";
	
	}

}
?>

<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>"/>
<input type="hidden" name="action" value="<?php echo $_REQUEST["action"];?>"/>
<input type="hidden" name="ProceedPageHierarchy" value="1"/>

<span class="medium-font"><?php echo $M_CHANGE_HIEARARCHY;?></span>

<br/><br/>
<br/>
<table summary="" border="0">
	<tr>

		<td><b><?php echo $str_Make;?> </b></td>
		<td>
			<select name="CurrentPageId" style="width:230">
  				<?php
					$oTable=$database->DataTable("pages","ORDER BY parent_id,id");
					while($row=$database->fetch_array($oTable))	{

						if($row['link_'.$language_version]=="") continue;

						echo "<option value='".$row['id']."'>\"".$row['link_'.$language_version]."\" Page</option>";
					}
				?>
  			</select>
  		</td>
		<td width=10>&nbsp;</td>
		<td>
			<select name="NewPageType" style="width:230">
  				<option value="0"><?php echo $str_MainPage;?></option>
				<?php
					$oTable=$database->DataTable("pages","WHERE parent_id=0 ORDER BY id");
					while($row=$database->fetch_array($oTable))	{

						if($row['link_'.$language_version]=="") continue;

						echo "<option value='".$row['id']."'>$SUBPAGE_OF \"".$row['link_'.$language_version]."\"</option>";
					}
				?>
  			</select>
</td>
		<td align="right">
			<input type="submit" class="adminButton" value="<?php echo $M_CHANGE_HIEARARCHY;?>"/>
		</td>
	</tr>
</table>
<br/>

</form>