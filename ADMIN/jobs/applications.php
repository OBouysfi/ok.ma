<?php
// Jobs Portal All Rights Reserved
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
			"list",
			$M_ADS_LIST,
			"",
			
			"green"
		 );
		 
		 
		echo LinkTile
		 (
			"users",
			"jobseekers",
			$M_JOBSEEKERS,
			"",
			
			"yellow"
		 );
?>
</div>
<div class="clear"></div>

<h3>
	<?php echo $JOBSEEKERS_APPLIED;?>
</h3>

<br/>

<?php

if($database->SQLCount("jobs","") == 0)
{

?>
<br><br><i>
			<?php echo strtoupper($ANY_JOB_ADS);?>
			</i>
		
<?php
}
else
{
?>
	
		<form action="index.php" method="post">
		
		<div id="div1">
		<i><?php echo $PLEASE_SELECT_AD;?></i>
	
	
		<br><br>
		</div>
		
		
		<input type=hidden name="Proceed">
		<input type=hidden name="category" value="<?php echo $category;?>">
		<input type=hidden name="action" value="<?php echo $action;?>">
		
		
		<?php
		
		$tableJobs=$database->Query(
		"SELECT 
		".$DBprefix."jobs.id,
		".$DBprefix."jobs.employer,
		".$DBprefix."jobs.title, 
		count(".$DBprefix."jobs.title) cc  
		FROM 
		".$DBprefix."jobs,
		".$DBprefix."apply,
		".$DBprefix."jobseekers
		WHERE
		".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
		AND
		".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
	 
		 GROUP BY ".$DBprefix."jobs.id
		 ");
		
		
		if($database->num_rows($tableJobs) == 0)
		{
		
				echo "<br><i>".$M_NO_CANDIDATES_APPLIED."</i>
				<script>
				
				document.getElementById(\"div1\").style.display=\"none\";				
				</script>
				
				";
		
		}
		else
		{
		
						while($arrJob=$database->fetch_array($tableJobs))
						{
							if($arrJob["cc"]>0)
							{
							echo "
								<table>
									<tr>
										<td>
											<img src=\"images/link_arrow.gif\" width=\"16\" height=\"16\" border=\"0\">
										</td>
										<td>
											<a href=\"index.php?category=".$category."&action=".$action."&Proceed=1&id=".$arrJob["id"]."\"><b>".$arrJob["title"]."</b></a>
										</td>
										<td>
										Employer: 
										
										<b>".$arrJob["employer"]."</b>
										</td>
										<td>
										Applications: 
										
										<b>".$arrJob["cc"]."</b>
										</td>
												
									</tr>
								</table>		
								
								<br><br>
								";	

							}								
						}
		
		}
		
		?>
		
		
		</form>
		
		

<?php
}
?>

<?php
if(isset($_REQUEST["Proceed"]))
{
?>


<br>

<?php

if(isset($_REQUEST["id"]) && $_REQUEST["id"] != "")
{
	$id=$_REQUEST["id"];
	$website->ms_i($id);
	$arrJobAd = $database->DataArray("jobs","id=".$id);


	$hideSearchFields = true;
	$QUERY_TO_EXECUTE ="
			SELECT ".
			 $DBprefix."jobseekers.first_name,"
			.$DBprefix."jobseekers.last_name,"
			.$DBprefix."jobseekers.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.status,"
			.$DBprefix."apply.date
			FROM
			".$DBprefix."apply,".$DBprefix."jobseekers,".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
			AND
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND 
			posting_id=".$id."
			
			
	";

	
	RenderTable
	(
		"apply,".$DBprefix."jobseekers",
		array("date","jobseeker_status","first_name","last_name","JobseekerDetails"),
		array($DATE_MESSAGE,$STATUS,$FIRST_NAME,$LAST_NAME,$M_JOBSEEKER),
		"100%",
		"WHERE 
		".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
		AND 
		posting_id=".$id."
		 ",
		"",
		"id",
		"index.php?category=".$category."&action=".$action."&id=".$id."&Proceed=1",
		false,
		20,
		false,
		-1,
		"",
		$QUERY_TO_EXECUTE
	);
}
?>




<?php
}
?>

