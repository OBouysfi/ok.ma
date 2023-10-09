<?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">

	<?php
		echo LinkTile
		 (
			"application_management",
			"approved",
			$M_APPROVED_APPLICATIONS,
			"",
			"green"
		 );
	
	echo LinkTile
		 (
			"application_management",
			"rejected",
			$M_REJECTED_APPLICATIONS,
			"",
			"red"
		 );
	?>

</div>
<div class="clear"></div>
<h3>
	<?php echo $CONSULT_LIST_APPLIED;?>
</h3>

<br/>

<?php

if($database->SQLCount("jobs","WHERE employer='".$AuthUserName."' ") == 0)
{

?>
<i>
	<?php echo strtoupper($ANY_JOB_ADS);?>
</i>
<?php
}
else
{
	$_REQUEST["hide_refine_search"]=true;
?>
		
		<form action="index.php" method="post">
		
		<div id="div1">
		<i><?php echo $PLEASE_SELECT_AD;?></i>
	
	
		<br><br>
		</div>
		
		
		<input type="hidden" name="Proceed">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
		
		<?php
		
		$tableJobs=$database->Query
		("
			SELECT 
			".$DBprefix."jobs.id,
			title,
			count(title) cc  
			FROM 
			".$DBprefix."jobs,".$DBprefix."apply
			WHERE
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND
			employer='".$AuthUserName."'
			AND 
			".$DBprefix."apply.status=0
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
						
							echo "
								<a href=\"index.php?category=".$category."&action=".$action."&Proceed=1&id=".$arrJob["id"]."\"><img src=\"images/link_arrow.gif\" width=\"16\" height=\"16\" border=\"0\"></a>
										
											&nbsp; <a class=\"underline-link\" href=\"index.php?category=".$category."&action=".$action."&Proceed=1&id=".$arrJob["id"]."\"><b>".$arrJob["title"]."</b></a>
										
										, &nbsp; 
										<strong class=\"red-font\">".$arrJob["cc"]."</strong>
										".$M_APPLICATIONS." 
									
								<br><br>
								";								
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
	
	if($arrJobAd["employer"] != $AuthUserName)
	{
		die("");
	}

	if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
	{
		if(sizeof($_REQUEST["CheckList"])>0)
		{
			$website->ms_ia($_REQUEST["CheckList"]);
			$database->SQLDelete("apply","id",$_REQUEST["CheckList"]);
		}
	}

	$hideSearchFields = true;
	$strSQLQuery ="
			(SELECT ".
			 $DBprefix."jobseekers.first_name,"
			.$DBprefix."jobseekers.last_name,"
			.$DBprefix."jobseekers.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date
			FROM
			".$DBprefix."apply,".$DBprefix."jobseekers,".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
			AND
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND 
			posting_id=".$id."
			AND
			".$DBprefix."apply.status = '0')
			UNION 
			(SELECT ".
			 $DBprefix."jobseekers_guests.first_name,"
			.$DBprefix."jobseekers_guests.last_name,"
			.$DBprefix."jobseekers_guests.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date
			FROM
			".$DBprefix."apply,".$DBprefix."jobseekers_guests,".$DBprefix."jobs
			WHERE 
			".$DBprefix."jobseekers_guests.id=".$DBprefix."apply.guest_id 
			AND
			".$DBprefix."jobs.id=".$DBprefix."apply.posting_id 
			AND 
			posting_id=".$id."
			AND 
			guest=1
			AND
			".$DBprefix."apply.status = '0')
	";
	
	$strListFields = 
			 $DBprefix."jobseekers.first_name,"
			.$DBprefix."jobseekers.last_name,"
			.$DBprefix."jobseekers.id,"
			.$DBprefix."apply.id id2,"
			.$DBprefix."apply.posting_id,"
			.$DBprefix."apply.jobseeker,"
			.$DBprefix."apply.date";
	
		RenderTable
		(
			"apply,".$DBprefix."jobseekers",
			array("date","first_name","last_name","ApproveReject","JobseekerDetails"),
			array($DATE_MESSAGE,$FIRST_NAME,$LAST_NAME,"",$M_DETAILS),
			"500",
			"WHERE 
			".$DBprefix."jobseekers.username=".$DBprefix."apply.jobseeker 
			AND 
			posting_id=".$id."
			AND
			".$DBprefix."apply.status = '0' ",
			$EFFACER,
			"id2",
			"index.php?category=".$category."&action=".$action."&id=".$id."&Proceed=1",
			false,
			20,
			false,
			-1,
			"",
			$strSQLQuery
		);
}
?>




<?php
}
?>

