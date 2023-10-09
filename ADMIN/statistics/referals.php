<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["stat_day"]))
{
	$stat_day = $_REQUEST["stat_day"];
}

if(isset($_REQUEST["stat_month"]))
{
	$stat_month = $_REQUEST["stat_month"];
}

if(isset($_REQUEST["stat_year"]))
{
	$stat_year = $_REQUEST["stat_year"];
}
?>
<script>
function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}
</script>

<div class="fright">

	<?php
	echo LinkTile
		 (
			"statistics",
			"referals-clear=all",
			$M_CLEAR,
			$M_CLEAR_LOG,
			"red"
		 );
		 
			echo LinkTile
				 (
					"statistics",
					"reports",
					$H_REPORTS,
					"",
					
					"lila"
				 );
	
			
		?>
		
	
</div>

<?php
if(isset($_REQUEST["clear"])&&$_REQUEST["clear"]=="all")
{
	$database->Query("DELETE FROM ".$DBprefix."statistics");
}
?>

<div class="clear"></div>
<br/><br/>

<?php
$strWhereQuery="";

$strServerName=$_SERVER["SERVER_NAME"];
$strDomainName=str_ireplace("www.","",$website->domain);

if(isset($_REQUEST["ProceedFilter"]))
{

	
	if($stat_day=="All"&&$stat_month=="All"&&$stat_year=="All")
	{
		
	}
	else
	if($stat_day!="All"&&$stat_month!="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month." ".$stat_day.", ".$stat_year."%'";
	}
	else
	if($stat_day!="All"&&$stat_month=="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '% ".$stat_day.",%'";
	}
	else
	if($stat_day=="All"&&$stat_month!="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month."%'";
	}
	else
	if($stat_day=="All"&&$stat_month=="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '%".$stat_year."%'";
	}
	else
	if($stat_day!="All"&&$stat_month!="All"&&$stat_year=="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month." ".$stat_date."%'";
	}
	else
	if($stat_day!="All"&&$stat_month=="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '%".$stat_day.", ".$stat_year."%'";
	}
	else
	if($stat_day=="All"&&$stat_month!="All"&&$stat_year!="All")
	{
		$strWhereQuery = "WHERE date like '".$stat_month."%".$stat_year."%'";
	}
	
	if($strWhereQuery=="")
	{
		$strWhereQuery .= "WHERE referer <> '' AND referer NOT LIKE '%$strServerName%' ";
	}
	else
	{
		$strWhereQuery .= "AND referer <> ''  AND referer NOT LIKE '%$strServerName%' ";
	}
}

?>


		
		<b>
		
		
		
			<form action="index.php" method="post">
			<input type="hidden" name="ProceedFilter" value="1">
			<input type="hidden" name="category" value="<?php echo $category;?>">
			<input type="hidden" name="action" value="<?php echo $action;?>">
			
			
			<?php echo $FILTER_REFERALS;?>: &nbsp;
			
			<select name=stat_day>
				<option><?php echo $M_ALL;?></option>
				<option <?php if(isset($stat_day)&&$stat_day==1) echo "selected";?>>1</option>
				<option <?php if(isset($stat_day)&&$stat_day==2) echo "selected";?>>2</option>
				<option <?php if(isset($stat_day)&&$stat_day==3) echo "selected";?>>3</option>
				<option <?php if(isset($stat_day)&&$stat_day==4) echo "selected";?>>4</option>
				<option <?php if(isset($stat_day)&&$stat_day==5) echo "selected";?>>5</option>
				<option <?php if(isset($stat_day)&&$stat_day==6) echo "selected";?>>6</option>
				<option <?php if(isset($stat_day)&&$stat_day==7) echo "selected";?>>7</option>
				<option <?php if(isset($stat_day)&&$stat_day==8) echo "selected";?>>8</option>
				<option <?php if(isset($stat_day)&&$stat_day==9) echo "selected";?>>9</option>
				<option <?php if(isset($stat_day)&&$stat_day==10) echo "selected";?>>10</option>
				<option <?php if(isset($stat_day)&&$stat_day==11) echo "selected";?>>11</option>
				<option <?php if(isset($stat_day)&&$stat_day==12) echo "selected";?>>12</option>
				<option <?php if(isset($stat_day)&&$stat_day==13) echo "selected";?>>13</option>
				<option <?php if(isset($stat_day)&&$stat_day==14) echo "selected";?>>14</option>
				<option <?php if(isset($stat_day)&&$stat_day==15) echo "selected";?>>15</option>
				<option <?php if(isset($stat_day)&&$stat_day==16) echo "selected";?>>16</option>
				<option <?php if(isset($stat_day)&&$stat_day==17) echo "selected";?>>17</option>
				<option <?php if(isset($stat_day)&&$stat_day==18) echo "selected";?>>18</option>
				<option <?php if(isset($stat_day)&&$stat_day==18) echo "selected";?>>19</option>
				<option <?php if(isset($stat_day)&&$stat_day==20) echo "selected";?>>20</option>
				<option <?php if(isset($stat_day)&&$stat_day==21) echo "selected";?>>21</option>
				<option <?php if(isset($stat_day)&&$stat_day==22) echo "selected";?>>22</option>
				<option <?php if(isset($stat_day)&&$stat_day==23) echo "selected";?>>23</option>
				<option <?php if(isset($stat_day)&&$stat_day==24) echo "selected";?>>24</option>
				<option <?php if(isset($stat_day)&&$stat_day==25) echo "selected";?>>25</option>
				<option <?php if(isset($stat_day)&&$stat_day==26) echo "selected";?>>26</option>
				<option <?php if(isset($stat_day)&&$stat_day==27) echo "selected";?>>27</option>
				<option <?php if(isset($stat_day)&&$stat_day==28) echo "selected";?>>28</option>
				<option <?php if(isset($stat_day)&&$stat_day==29) echo "selected";?>>29</option>
				<option <?php if(isset($stat_day)&&$stat_day==30) echo "selected";?>>30</option>
				<option <?php if(isset($stat_day)&&$stat_day==31) echo "selected";?>>31</option>
				
			</select>
			/
			<select name=stat_month>
				<option><?php echo $M_ALL;?></option>
				<option <?php if(isset($stat_month)&&$stat_month=="January") echo "selected";?>>January</option>
				<option <?php if(isset($stat_month)&&$stat_month=="February") echo "selected";?>>February</option>
				<option <?php if(isset($stat_month)&&$stat_month=="March") echo "selected";?>>March</option>
				<option <?php if(isset($stat_month)&&$stat_month=="April") echo "selected";?>>April</option>
				<option <?php if(isset($stat_month)&&$stat_month=="May") echo "selected";?>>May</option>
				<option <?php if(isset($stat_month)&&$stat_month=="June") echo "selected";?>>June</option>
				<option <?php if(isset($stat_month)&&$stat_month=="July") echo "selected";?>>July</option>
				<option <?php if(isset($stat_month)&&$stat_month=="August") echo "selected";?>>August</option>
				<option <?php if(isset($stat_month)&&$stat_month=="September") echo "selected";?>>September</option>
				<option <?php if(isset($stat_month)&&$stat_month=="Octobery") echo "selected";?>>October</option>
				<option <?php if(isset($stat_month)&&$stat_month=="November") echo "selected";?>>November</option>
				<option <?php if(isset($stat_month)&&$stat_month=="December") echo "selected";?>>December</option>
			</select>
			/
			<select name="stat_year">
				<option><?php echo $M_ALL;?></option>
				<?php
				for($i=2013;$i<=2023;$i++)
				{
				?>
					<option <?php if(isset($_REQUEST["stat_year"])&&$_REQUEST["stat_year"]==$i) echo "selected";?>><?php echo $i;?></option>
				
				<?php				
				}
				?>
				
			</select>
			
			
			<input type="submit" value=" <?php echo $FILTER;?> " class="btn btn-default"/>
			
			</form>
		</b>
	
<br>
<?php

$arrTDSizes=array(150,"*");
RenderTable
(
	"statistics",
	array("timestamp","referer"),
	array($DATE_MESSAGE,$REFERER),
	750,
	($strWhereQuery!=""?$strWhereQuery:"WHERE trim(referer) <> ''  AND referer NOT LIKE '%".$strServerName."%' AND referer NOT LIKE '%".$strDomainName."%'") ,
	"",
	"",
	"index.php",
	true,20,false,-1,"ORDER BY id DESC"
);
?>

