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
		 
		 
	echo LinkTile
	 (
		"profile",
		"edit",
		$EDIT_YOUR_PROFILE,
		"",
		"green"
	 );
	 

?>
</div>
<div class="clear"></div>
<?php
$strWhereQuery = "WHERE jobseeker='".$AuthUserName."'";

if(get_param("selected_mode") == "custom")
{
	$start_time = mktime(0,0,0,get_param("month_from"),get_param("day_from"),get_param("year_from"));
	
	$end_time = mktime(0,0,0,get_param("month_to"),get_param("day_to"),get_param("year_to"));
	
	$strWhereQuery .= " AND date>".$start_time." AND date<".$end_time;
}

?>
<style>
.small-drop-down
{
	width:100px !important;
}
</style>
		
		<form action="index.php" method="post">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">

		<h4><?php echo $M_SHOW_STATISTICS;?></h4>
	
		<input type="radio" name="selected_mode" value="" <?php echo (get_param("selected_mode")==""?"checked":"");?>> <?php echo $M_ALL;?>
		<br><br>
		<input type="radio" name="selected_mode" value="custom" <?php echo (get_param("selected_mode")=="custom"?"checked":"");?>>
		
		<?php echo $M_FROM;?>:   
		<select name="day_from" class="small-drop-down">
		<?php
			for($i=1;$i<=31;$i++)
			{
				echo "<option ".(get_param("day_from") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="month_from" class="small-drop-down">
		<?php
			for($i=1;$i<=12;$i++)
			{
				echo "<option ".(get_param("month_from") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="year_from" class="small-drop-down">
		<?php
			for($i=15;$i<=25;$i++)
			{
				echo "<option ".(get_param("year_from") == ($i+2000)?"selected":"").">".(2000 + $i)."</option>";
			}
		?>
		</select>
		
		<br/><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $M_TO;?>:
		
			<select name="day_to" class="small-drop-down">
		<?php
			for($i=1;$i<=31;$i++)
			{
				echo "<option ".(get_param("day_to") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="month_to" class="small-drop-down">
		<?php
			for($i=1;$i<=12;$i++)
			{
				echo "<option ".(get_param("month_to") == $i?"selected":"").">".$i."</option>";
			}
		?>
		</select>
		/
		<select name="year_to" class="small-drop-down">
		<?php
			for($i=15;$i<=25;$i++)
			{
				echo "<option ".(get_param("year_to") == ($i+2000)?"selected":"").">".(2000 + $i)."</option>";
			}
		?>
		</select>
		<br><br>
		
		<input type="submit" class="btn btn-primary" value="<?php echo $M_SHOW;?>">
		
		</form>
		
		<br><br><br>
		
		<?php echo $PROFILE_SELECTED;?>
		<b>
		<?php
		echo $database->SQLCount_Query("SELECT * FROM ".$DBprefix."jobseekers_stat ".$strWhereQuery);
		?>
		</b><?php echo $TIMES_FOR_SELECTED;?>
		<br><br>
		<br>
		<i><?php echo $M_DETAILED_REPORT;?></i>
		<br><br>
		<center>
			<?php
			
				$QUERY_TO_EXECUTE =
				"
					SELECT 
					".$DBprefix."jobseekers_stat.date,
					".$DBprefix."employers.id,
					".$DBprefix."employers.company,
					".$DBprefix."jobseekers_stat.ip
					FROM ".$DBprefix."jobseekers_stat,
					".$DBprefix."employers
					".$strWhereQuery."
					AND
					".$DBprefix."jobseekers_stat.employer=
					".$DBprefix."employers.username
					ORDER BY ".$DBprefix."jobseekers_stat.date DESC
				";
				RenderTable
				(
						"jobseekers_stat,".$DBprefix."employers",
						array("company","date","ip","EmployerLink"),
						array($M_COMPANY,$M_DATE,$M_IP,$M_DETAILS),
						"100%",
						$strWhereQuery,
						"",
						"id",
						
						"index.php?category=".$category."&action=".$action,
						false,
						20,
						false,
						-1,
						"",
						$QUERY_TO_EXECUTE
				);
				
				?>
			</center>
	
