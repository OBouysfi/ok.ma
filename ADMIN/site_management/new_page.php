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

if($language_version == "")
{
	$default_language = $database->DataArray("languages","default_language=1");
	$language_version = strtolower($default_language["code"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
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
		"hierarchy",
		$M_CHANGE_HIERARCHY,
		$M_MAKE_MAIN_SUB,
		"yellow"
	 );
?>
</div>
<br/>
<span class="medium-font"><?php echo $M_ADD_PAGE_SITE;?></span>
		
<br/>

<?php
if(isset($_REQUEST["Proceed"]))
{

	echo '
	<br/>
	<span class="medium-font">
	';

	if($_REQUEST["pLink"]=="")
	{
		echo $strLinkEmptyMessage;
	}
	else
	{
		$strPageHtml="";

		$arrNames=array("active_".$language_version,"parent_id","name_".$language_version,"description_".$language_version,"keywords_".$language_version,"link_".$language_version,"html_".$language_version);

		$arrValues=array("1",$_REQUEST["pType"],$_REQUEST["pName"],$_REQUEST["pDescription"],$_REQUEST["pKeywords"],$_REQUEST["pLink"],$strPageHtml);

		$database->SQLInsert("pages",$arrNames,$arrValues);

		echo $strNewPageSuccess;

	}

	echo '
		</span>
	';
}
?>

<div class="clear"></div>


<form action="index.php" method="post">
<input type="hidden" name="category" value="<?php echo $_REQUEST["category"];?>"/>
<input type="hidden" name="action" value="<?php echo $_REQUEST["action"];?>"/>


<br/>
<br/>
<table summary="" border="0">
	<tr>
		<td><font color=red>*</font><?php echo $str_PageLinkPage;?></td>
		<td>
		<input type="text" name="pLink" size="40" style="width:300px">
		</td>
	</tr>
	<tr>
		<td><font color=red>*</font><?php echo $str_PageTypePage;?></td>
		<td>
			<select name="pType" style="width:300px">
  				<option value="0"><?php echo $str_MainPage;?></option>
				<?php
				
					$arr_main_page_ids =array();
				
					$oTable=$database->DataTable("pages","WHERE parent_id=0 ORDER BY id");
					
					while($row=$database->fetch_array($oTable))	{

						if(trim($row['link_'.$language_version])!="")
						{
							

							echo "<option value='".$row['id']."'>$SUBPAGE_OF'".$row['link_'.$language_version]."'</option>";

						}

					}
				?>
  			</select>
  		</td>
	</tr>

	<tr>
		<td width=150><?php echo $str_PageNamePage;?></td>
		<td>
		<input type="text" name="pName" style="width:300px" maxlength="256">
  		</td>
	</tr>
	<tr>
		<td valign=top><?php echo $str_PageDescriptionPage;?></td>
		<td>
		<textarea name="pDescription" cols="30" rows="5" style="width:300px"></textarea>

		</td>
	</tr>
	<tr>
		<td valign=top><?php echo $str_PageKeywordsPage;?></td>
		<td>
		<textarea name="pKeywords" cols="30" rows="5" style="width:300px"></textarea>

		</td>
	</tr>

</table>

<table summary="" border="0">
	<tr>
		<td>


<font color=red>(*) <?php echo $str_RequiredFields;?></font>

<br><br><br>
<input type=hidden name=Proceed value="">
<input type=submit class=adminButton value="<?php echo $str_AddPage;?>">
		</td>
	</tr>
</table>
</form>
