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
			"jobs",
			"my",
			$M_GO_BACK,
			"",
			"red"
		 );
	?>
</div>
<div class="clear"></div>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);

$strWhereQuery = "WHERE posting_id=".$id;

if(get_param("selected_mode") == "custom")
{
	$start_time = mktime(0,0,0,get_param("month_from"),get_param("day_from"),get_param("year_from"));
	
	$end_time = mktime(0,0,0,get_param("month_to"),get_param("day_to"),get_param("year_to"));
	
	$strWhereQuery .= " AND date>".$start_time." AND date<".$end_time;
}

?>
	
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $category;?>">
	
		<input type="hidden" name="id" value="<?php echo $id;?>">
		
		<?php
		if(isset($action))
		{
		?>
			<input type="hidden" name="action" value="<?php echo $action;?>"/>

		<?php
		}
		else
		{
		?>
		
		<input type="hidden" name="page" value="<?php echo $page;?>"/>
		<input type="hidden" name="folder" value="<?php echo $folder;?>"/>
		<?php
		}
		?>
		
		<h3 class="no-top-margin"><?php echo $M_SHOW_STATISTICS;?>:</h3>
		<br>
		<input type="radio" name="selected_mode" value="" <?php echo (get_param("selected_mode")==""?"checked":"");?>> All
		<br><br>
		<input type="radio" name="selected_mode" value="custom" <?php echo (get_param("selected_mode")=="custom"?"checked":"");?>>
		
		<?php echo $M_FROM;?>:   
		<select name="day_from" class=text>
		<?php
			for($i=1;$i<=31;$i++)
			{
				echo "<option ".(get_param("day_from") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="month_from" class=text>
		<?php
			for($i=1;$i<=12;$i++)
			{
				echo "<option ".(get_param("month_from") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="year_from" class=text>
		<?php
			for($i=12;$i<=20;$i++)
			{
				echo "<option ".(get_param("year_from") == ($i+2000)?"selected":"").">".(2000 + $i)."</option>";
			}
		?>
		</select>
		
		<br/><br/>
		&nbsp;&nbsp;&nbsp;
		<?php echo $M_TO;?>:
		&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="day_to" class=text>
		<?php
			for($i=1;$i<=31;$i++)
			{
				echo "<option ".(get_param("day_to") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="month_to" class=text>
		<?php
			for($i=1;$i<=12;$i++)
			{
				echo "<option ".(get_param("month_to") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="year_to" class=text>
		<?php
			for($i=12;$i<=20;$i++)
			{
				echo "<option ".(get_param("year_to") == ($i+2000)?"selected":"").">".(2000 + $i)."</option>";
			}
		?>
		</select>
		<br><br>
		
		<input type="submit" class="btn btn-primary" value=" <?php echo $M_SHOW;?> ">
		
		</form>
		
		<br><br><br>
		
		<?php echo $AD_SHOWN;?>
		<b>
		<?php
		echo $database->SQLCount_Query("SELECT * FROM ".$DBprefix."jobs_stat ".$strWhereQuery);
		?>
		</b> <?php echo $TIMES_FOR_SELECTED;?>
		<br><br>
		<br>
		<i><?php echo $M_DETAILED_REPORT;?></i>
		<br><br>
		<center>
			<?php
			
				RenderTable
				(
						"jobs_stat",
						array("date","ip","user"),
						array($M_DATE,$M_IP,$M_JOBSEEKER),
						"300",
						$strWhereQuery,
						"",
						"id",
						
						"index.php"
				);
				
				?>
			</center>
	

