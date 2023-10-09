<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>


<link href="css/basic.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/EnhanceJS/enhance.js"></script>		
<script type="text/javascript">
	// Run capabilities test
	enhance({
		loadScripts: [
			'js/excanvas.js',
			'js/jquery.min.js',
			'js/visualize.jQuery.js',
			'js/example.js'
		],
		loadStyles: [
			'css/visualize.css',
			'css/visualize-light.css'
		]	
	});   
</script>

<div class="fright">

	<?php
	
	echo LinkTile
		 (
			"statistics",
			"reports-clear=all",
			$M_CLEAR,
			$M_CLEAR_STAT,
			"red"
		 );
		 
		echo LinkTile
			 (
				"statistics",
				"referals",
				$H_REFERALS,
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
<span class="medium-font"><?php echo $M_STATISTICS_REPORTS;?></span>

<br><br>


<?php

$number_days=10;
$check_all=1;
$strServerName=$_SERVER["SERVER_NAME"];

$arrStatValues	= array();
$arrStatValues2	= array();


$all_visits = $database->Query
("
	select date,count(*) cnt
	from ".$DBprefix."statistics
	group by date
	ORDER BY id DESC
	limit 0,6
");	

while($visit_day = $database->fetch_array($all_visits))
{
	$arrStatValues[$visit_day["date"]]=$visit_day["cnt"];
}

$reload_visits = $database->Query
("
	select date,count(*) cnt
	from ".$DBprefix."statistics
	where referer like '%".$strServerName."%'
	group by date
	ORDER BY id DESC
	limit 0,6
");	

while($visit_day = $database->fetch_array($reload_visits))
{
	$arrStatValues2[$visit_day["date"]]=$visit_day["cnt"];
}


$iScale = 1;

$arrStatValues = array_reverse($arrStatValues, true);

$arrStatValues2 = array_reverse($arrStatValues2, true);


?>	


<table>
	
	<thead>
		<tr>
			<td></td>
			
			<?php
			foreach($arrStatValues as $key=>$value)
			{
				echo "<th scope=\"col\">".$key."</th>";
			}
			?>
		
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="row">Total Visits</th>
				<?php
				foreach($arrStatValues as $key=>$value)
				{
					echo "<td>".$value."</td>";
				}
				?>
		</tr>
		
		<tr>
			<th scope="row">Unique Visits</th>
				<?php
				foreach($arrStatValues as $key=>$value)
				{
					if(isset($arrStatValues2[$key]))
					{
						$value = $value - $arrStatValues2[$key];
					}
					
					echo "<td>".$value."</td>";
				}
				?>
		</tr>
		
		<tr>
			<th scope="row">Reloads</th>
				<?php
				foreach($arrStatValues as $key=>$value)
				{
					if(isset($arrStatValues2[$key]))
					{
						echo "<td>".$arrStatValues2[$key]."</td>";
					}
					else
					{
						echo "<td>0</td>";
					}
				}
				?>
		</tr>
	</tbody>
</table>