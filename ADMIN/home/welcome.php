<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
 <div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-info">
		<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="white-link fa fa-list-alt fa-5x"></i>
					</div>
					
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $database->SQLCount("jobs","");?></div>
						<div><?php echo $M_JOBS;?></div>
					</div>
				</div>
			</div>
			<a href="<?php echo CreateLink("jobs","list");?>">
			
				<div class="panel-footer gray-gradient">
					<span class="pull-left"><?php echo $M_VIEW_DETAILS;?></span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-users fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $database->SQLCount("jobseekers","");?></div>
						<div><?php echo $M_JOBSEEKERS;?></div>
					</div>
				</div>
			</div>
			<a href="<?php echo CreateLink("users","jobseekers");?>">
				<div class="panel-footer gray-gradient">
					<span class="pull-left"><?php echo $M_VIEW_DETAILS;?></span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-institution fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $database->SQLCount("employers","");?></div>
						<div><?php echo $M_EMPLOYERS;?></div>
					</div>
				</div>
			</div>
			<a href="<?php echo CreateLink("users","employers");?>">
				<div class="panel-footer gray-gradient">
					<span class="pull-left"><?php echo $M_VIEW_DETAILS;?></span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-bar-chart-o fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $database->SQLCount_Query("SELECT ".$DBprefix."apply.id FROM ".$DBprefix."apply,".$DBprefix."jobs WHERE ".$DBprefix."apply.posting_id=".$DBprefix."jobs.id");?></div>
						<div><?php echo $JOBSEEKERS_APPLIED;?></div>
					</div>
				</div>
			</div>
			<a href="<?php echo CreateLink("jobs","applications");?>">
				<div class="panel-footer gray-gradient">
					<span class="pull-left"><?php echo $M_VIEW_DETAILS;?></span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>

<div class="row">

<div class="col-lg-12">
 <div class="panel panel-default">
	<div class="panel-heading gray-gradient">
		<i class="fa fa-briefcase fa-fw"></i> 
		<?php echo $M_LATEST_EMPLOYERS;?>
	</div>
	<!-- /.panel-heading -->
	<div style="padding:10px" class="btn-block">
	<div class="xpanel-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php echo $DATE_MESSAGE;?></th>
						<th><?php echo $M_COMPANY;?></th>
						<th><?php echo $CONTACT_PERSON;?></th>
						<th><?php echo $M_ADDRESS;?></th>
						<th><?php echo $TELEPHONE;?></th>
						<th><?php echo $M_WEBSITE;?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$employers=$database->DataTable("employers","ORDER BY id DESC LIMIT 0,4");
				
				while($employer = $database->fetch_array($employers))
				{
				?>
					<tr onclick="document.location.href='index.php?category=users&folder=employers&page=edit&id=<?php echo $employer["id"];?>'" style="cursor: pointer">
						<td><?php echo time_since($employer["date"])." ".$M_AGO;?></td>
						<td><?php echo stripslashes($employer["company"]);?></td>
						<td><?php echo stripslashes($employer["contact_person"]);?></td>
						<td><?php echo stripslashes($employer["address"]);?></td>
						<td><?php echo stripslashes($employer["phone"]);?></td>
						<td><?php echo stripslashes($employer["website"]);?></td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
		
	</div>
	
		<a href="<?php echo CreateLink("users","employers");?>" class="btn btn-default btn-block"><?php echo $M_VIEW_ALL;?></a>
	</div>
	
</div>
</div>

</div>


<div class="row">
<div class="col-lg-8">
	
<div class="panel panel-default">
	<div class="panel-heading gray-gradient">
		<i class="fa fa-bar-chart-o"></i> 
		<?php echo $M_JOB_STATISTICS;?>
	</div>

	<div class="panel-body">
		<br/>
		<div class="flot-chart">
			<div class="flot-chart-content" id="flot-bar-chart"></div>
		</div>
	</div>
	
</div>

	
</div>
 
	 <div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading gray-gradient">
				<i class="fa fa-calendar fa-fw"></i> <?php echo $M_LATEST_JOBS;?>
			</div>
			
			<div class="panel-body">
				<div class="list-group">
				<?php
				$jobs = $database->DataTable("jobs","ORDER BY id DESC LIMIT 0,10");
				
				while($job = $database->fetch_array($jobs))
				{
				?>
				
					<a href="index.php?category=jobs&action=list_edit&id=<?php echo $job["id"];?>" class="list-group-item">
					
						<i class="fa fa-list-alt"></i>
						
						<?php echo stripslashes($job["title"]);?>
						
						<span class="pull-right text-muted small"><em><?php echo time_since($job["date"])." ".$M_AGO;?></em>
						</span>
						<div class="clearfix"></div>
					</a>
				<?php
				}
				?>
				</div>
				
				<a href="<?php echo CreateLink("jobs","list");?>" class="btn btn-default btn-block"><?php echo $M_VIEW_ALL;?></a>
			</div>
		</div>
	</div>
	
</div>			

<script src="js/excanvas.min.js"></script>
<script src="js/jquery.flot.min.js"></script>
 
 <?php
 
 $arr_data=array();
 $k_sort_data=array();
 $flot_data="";
 
 $tot_jobs=$database->Query
(
	"SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%M %e') 
	AS for_date,
    COUNT(id) AS total_jobs, date
	FROM   ".$DBprefix."jobs
	GROUP BY DATE(FROM_UNIXTIME(date))
	ORDER BY date 
	LIMIT 0,7"
);
while($tot_job=$database->fetch_array($tot_jobs))
{
	if(trim($tot_job["for_date"])=="") continue;
	 $arr_data[$tot_job["for_date"]][0]=$tot_job["total_jobs"];
	 $arr_data[$tot_job["for_date"]]["date"]=$tot_job["date"];
	//$k_sort_data[$tot_job["date"]]=$tot_job["for_date"]; 
}


$tot_jobs=$database->Query
(
	"SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%M %e') 
	AS for_date,
    COUNT(id) AS total_jobs, date
	FROM   ".$DBprefix."jobseekers
	GROUP BY DATE(FROM_UNIXTIME(date))
	ORDER BY date 
	LIMIT 0,7"
);
while($tot_job=$database->fetch_array($tot_jobs))
{
	if(trim($tot_job["for_date"])=="") continue;
	
	 $arr_data[$tot_job["for_date"]][1]=$tot_job["total_jobs"];
	 
	 $arr_data[$tot_job["for_date"]]["date"]=$tot_job["date"];
	// $k_sort_data[$tot_job["date"]]=$tot_job["for_date"]; 
}



$tot_jobs=$database->Query
(
	"SELECT DATE_FORMAT(FROM_UNIXTIME(date),'%M %e') 
	AS for_date,
    COUNT(id) AS total_jobs, date
	FROM   ".$DBprefix."employers
	GROUP BY DATE(FROM_UNIXTIME(date))
	ORDER BY date 
	LIMIT 0,7"
);

while($tot_job=$database->fetch_array($tot_jobs))
{
	if(trim($tot_job["for_date"])=="") continue;
	
	 $arr_data[$tot_job["for_date"]][2]=$tot_job["total_jobs"];
	 $arr_data[$tot_job["for_date"]]["date"]=$tot_job["date"];
	 //$k_sort_data[$tot_job["date"]]=$tot_job["for_date"]; 
}


$str_data_1="";
$str_data_2="";
$str_data_3="";
$str_ticks="";
$i_step=0;
$max_value=0;

function DateSort($a, $b) 
{
    return $a["date"] - $b["date"];
}

uasort($arr_data, 'DateSort');

foreach($arr_data as $key=>$data)
{
	if($str_data_1!="") $str_data_1.=",";
	if($str_data_2!="") $str_data_2.=",";
	if($str_data_3!="") $str_data_3.=",";
	if($str_ticks!="") $str_ticks.=",";
	
	$str_ticks.='['.$i_step.', "'.$key.'"]';
	
	if(isset($data[0]))
	{
		$str_data_1.='['.($i_step+0).', '.$data[0].']';
		if($data[0]>$max_value) $max_value=$data[0];
	}
	else
	{
		$str_data_1.='['.($i_step+0).', "0"]';
	}
	
	if(isset($data[1]))
	{
		$str_data_2.='['.($i_step+1).', '.$data[1].']';
		if($data[1]>$max_value) $max_value=$data[1];
	}
	else
	{
		$str_data_2.='['.($i_step+1).', "0"]';
	}
	
	if(isset($data[2]))
	{
		$str_data_3.='['.($i_step+2).', '.$data[2].']';
		if($data[2]>$max_value) $max_value=$data[2];
	}
	else
	{
		$str_data_3.='['.($i_step+2).', "0"]';
	}
	
	$i_step+=4;
}


function y_ceiling($number, $significance = 1)
{
    return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
}

$y_top=y_ceiling($max_value,5);
$y_step=$y_top/5;
$y_ticks="";
for($i=0;$i<=5;$i++)
{
	$y_value=$i*$y_step;
	if($y_ticks!="") $y_ticks.=",";
	$y_ticks.='['.$i.', "'.$y_value.'"]';
	
}


?>
<!-- Javascript -->
<script type="text/javascript">
$(function () {    
    var data1 = [
       <?php echo $str_data_1;?>
    ];
    var data2 = [
        <?php echo $str_data_2;?>
    ];
	var data3 = [
       <?php echo $str_data_3;?>
    ];
	
	var ticks = [
       <?php echo $str_ticks;?>
    ];
	
	var y_ticks = [
       <?php echo $y_ticks;?>
    ];
 
    var data = [{
        label: "<?php echo $M_NEW_JOBS;?>",
        data: data1,
        bars: 
		{
			barWidth: 0.8,
			show: true
		}
    },{
        label: "<?php echo $M_JOBSEEKERS;?>",
        data: data2,
        bars:
		{
		  barWidth: 0.8,
          show:true
        }
    },{
        label: "<?php echo $M_EMPLOYERS;?>",
        data: data3,
        bars:
		{
		  barWidth: 0.8,
          show:true
        }
    }];
 
    var options = {
            xaxis: {
                ticks: ticks
            },
			yaxis: {
                ticks: y_ticks
            },
            grid:{
                backgroundColor: {colors: ["#969696", "#5C5C5C"] }
            }
    };
 
    var plot = $.plot($("#flot-bar-chart"), data, options);  
});
</script>
 
<!-- HTML -->
<div id="example-section25">
    <div id="flotcontainer" style="width: 600px;height:200px; text-align: center; margin:0 auto;">
    </div>
</div>
		