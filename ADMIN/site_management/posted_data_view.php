<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">
	<?php
	echo LinkTile
	 (
		"site_management",
		"posted_data",
		$M_GO_BACK,
		"",
		"red"
	 );
	 
	 echo LinkTile
	 (
		"site_management",
		"manage",
		$M_MANAGE_THE_FORMS,
		"",
		"blue"
	 );
?>
</div>
<?php

if(isset($_REQUEST["ProceedDelete"]))
{
	$del_id=$_REQUEST["del_id"];
	$website->ms_i($del_id);
	$database->SQLDelete("forms_data","id",array($del_id));
}

$id=$_REQUEST["id"];

$website->ms_i($id);

$arrForm=$database->DataArray("forms","id=".$id);

if(!isset($arrForm["id"]))
{
	die("");
}


$dataTable=$database->DataTable("forms_data","WHERE form_id=".$id);


?>

	

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>
		
		<span class="medium-font">
		<?php echo $arrForm["name"];?>
		</span>
		
		<br>
		<?php 
		
		if(trim($arrForm["description"])!=""){
			echo $arrForm["description"];
		}
		else
		{
			
		}
		
		?>
		<br><br>
		
		<table cellpadding=0 cellspacing=0 width="100%" style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>
		<tr bgcolor=#efefef height=32>
			<td width=80 class=oHeader>&nbsp;<?php echo $EFFACER;?></td>
			<td width=250 class=oHeader><?php echo $DATE_MESSAGE;?></td>
			<td width=100 class=oHeader><?php echo $IP_MESSAGE;?></td>
			<td class=oHeader><?php echo $DATA_MESSAGE;?></td>
		</tr>
		<?php
		
		$bColor=true;
		
		while($arrData=$database->fetch_array($dataTable)){
			echo "<tr bgcolor=".($bColor?"#ffffff":"#e7dfef")." height=32>";
			
			echo "<td  class=oMain valign=top>&nbsp;
			<a href='index.php?category=$category&folder=$folder&page=$page&ProceedDelete=true&id=$id&del_id=".$arrData['id']."' >
			<img src='images/cancel.gif' border=0>
			</a>
			</td>";
			
			echo "<td  class=oMain valign=top>".$arrData["date"]."</td>";
			echo "<td  class=oMain valign=top>".$arrData["ip"]."</td>";
			
			echo "<td  class=oMain valign=top>";
			
			$arrValues=unserialize($arrData["data"]);
			
			echo "<table width=\"100%\" cellpadding=0 cellspacing=0>";
			
			$bSColor=true;
			
			foreach($arrValues as $key=>$value){
				
				if(trim($value)!=""){
				
					echo "<tr height=26 bgcolor=".($bColor?($bSColor?"#fff4ff":"#ffffff"):($bSColor?"#e7dfef":"#e8dfef")).">";
					echo "<td class=oMain><i>$key:</i> $value</td>";
					echo "</tr>";
					
					$bSColor=!$bSColor;
					
				}
			}
			
			echo "</table>";
			
			echo "</td>";
			
			echo "</tr>";
			
			$bColor=!$bColor;
		}
		?>
		</table>
		
		</td>
	</tr>
</table><br>

