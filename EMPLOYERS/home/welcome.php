<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["bn"]))
{
	if($_REQUEST["bn"]=="s")
	{
		$o = str_replace("b-","",str_replace("box-","",$_REQUEST["o"]));
		$n = str_replace("b-","",str_replace("box-","",$_REQUEST["n"]));
		$temp_value = $AdminUser["box_".$o];
				
		$database->SQLUpdate("employers",array("box_".$o),array($AdminUser["box_".$n]),"username='".$AuthUserName."'");
		$database->SQLUpdate("employers",array("box_".$n),array($temp_value),"username='".$AuthUserName."'");
		$AdminUser=$database->DataArray("employers","username='".$AuthUserName."'");
	}
	else
	if($_REQUEST["bn"]=="a")
	{
		$o = str_replace("b-","",str_replace("box-","",$_REQUEST["o"]));
		$n = strip_tags(stripslashes($_REQUEST["n"]));
		$current_value = $AdminUser["box_".$o];
		$p_items = explode("#",$current_value);
		$passed_value =  explode("-",$n);	
		
		if(trim($passed_value[0])!=""&&trim($passed_value[1])!="")
		{
			$new_value = $passed_value[0]."#".$passed_value[1]."#".$p_items[2];
			$database->SQLUpdate("employers",array("box_".$o),array($new_value),"username='".$AuthUserName."'");
			$AdminUser=$database->DataArray("employers","username='".$AuthUserName."'");
		}
	}
	
}
?>
<br/>
<script type="text/javascript">
function CallBack()
{
	document.getElementById("main_container").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML.trim();
	$(init);
}
</script>

	<div class="col-md-3 welcome-left-block">
	
		<span class="large-font">
		<?php echo $M_WELCOME;?> <?php echo $LoginInfo["contact_person"];?>,
		</span>
	
		
		<?php
		
			$last_login = $database->DataArray_Query("SELECT max(date) max_date FROM ".$DBprefix."login_log WHERE username='".$AuthUserName."' AND action='login' AND date<(SELECT max(date) max_date FROM ".$DBprefix."login_log WHERE username='".$AuthUserName."' AND action='login')");
			$last_date=date("F j, Y",$last_login["max_date"]);
			//$login_stat=str_replace("{show_date}","<a href=\"".CreateLink("home","connections")."\">".$last_date."</a>",$M_LOGIN_STAT_MESSAGE);
			$login_stat="";
			$strServerName=$_SERVER["SERVER_NAME"];

			
			
			$new_messages = $database->SQLCount("user_messages","WHERE user_to='".$AuthUserName."'");
			
			
			if($new_messages>0)
			{
			?>
				<br/><br/>
				<img src="../images/warning.png"/>
				<span class="home-warning-text">
					<a href="index.php?category=home&action=received"><?php echo $new_messages;?> <?php echo $M_NEW_MESSAGES;?></a>
				</span>
			<?php
			}
			else
			{
			?>
				<br/><br/>
				<span class="home-warning-text">
					<?php echo $ANY_MESSAGES;?>
				</span>
				
			<?php
			}
			
						
			if($website->GetParam("CHARGE_TYPE") == 1)
			{
			?>
				<br/><br/>
				<?php echo $M_CURRENTLY_YOU_HAVE;?>:<br/>
				<a class="underline-link" href="index.php?category=home&action=credits"><strong><?php if($arrUser["subscription"]==0) echo "0";else echo "1";?></strong></a> <?php echo $M_SUBSCRIPTION;?>, 
				<?php 
				if($arrUser["subscription"]>0)
				{
				?>
					<br/><?php echo $REMAINING_ADS;?>: 
					<strong>
					<?php
					$arrSubscription = $database->DataArray("subscriptions","id=".$arrUser["subscription"]);
	
					echo ($arrSubscription["listings"]-$database->SQLCount("jobs","WHERE employer='".$AuthUserName."'"));
					?>
					</strong>
					<?php
				}
				?>
			<?php
			}
			else
			if($website->GetParam("CHARGE_TYPE")==2)
			{
			?>
				<br/><br/>
				<?php echo $M_CURRENTLY_YOU_HAVE.': <a class="red-font underline-link" href="index.php?category=home&action=credits">'.$AdminUser["credits"].' '.$M_CREDITS.'<a>';?>
			<?php
			}
		?>
			<br/><br/>
	</div>
	<div id="home-links-area" class="col-md-9">
	
		<div class="row" style="padding:10px">
		<?php
		
		
		$arr_cache_texts=array();
		$arr_box_sizes = array("","3","3","3","3","3","3","3","3");
			
		
		if($AdminUser["box_1"]==""&&$AdminUser["box_2"]==""&&$AdminUser["box_3"]==""&&$AdminUser["box_4"]==""&&$AdminUser["box_5"]==""&&$AdminUser["box_6"]==""&&$AdminUser["box_7"]==""&&$AdminUser["box_8"]=="")
		{
			$arr_box_names = array();
			$arr_set_perms = array();
			for($i=1;$i<=6;$i++)
			{
								
					$p_items = explode("@",$currentUser->arrPermissions[$i]);
					
					if(sizeof($p_items) != 4) continue;
					if($p_items[3]=="welcome") continue;
					array_push($arr_box_names,"box_".$i);
					array_push($arr_set_perms,$p_items[2]."#".$p_items[3]."#".$i);
				
			}
			
			
			$database->SQLUpdate("employers",$arr_box_names,$arr_set_perms,"id=".$AdminUser["id"]);
			$AdminUser=$database->DataArray("employers","id=".$AdminUser["id"]);
		}
		
		for($i=1;$i<=6;$i++)
		{
			$p_items = explode("#",$AdminUser["box_".$i]);
			if(sizeof($p_items)==1) continue;
				
				$str_arr_texts = $p_items[0]."_oLinkTexts";
				$str_arr_actions = $p_items[0]."_oLinkActions";
				
				if(!isset($$str_arr_texts)||!isset($$str_arr_actions)) continue;
				
				$arr_texts = $$str_arr_texts;
				$arr_actions = $$str_arr_actions;
				$key = array_search($p_items[1], $arr_actions); 
				
				?>
				<div class="col-md-4 col-sm-6 col-xs-12 t-padding" id="box-<?php echo $i;?>">
					<div class="tile-p" id="b-<?php echo $i;?>">
					<?php
					$show_text = $arr_texts[$key];
					$b_pos = strpos($show_text, ' ');
					if($b_pos===false)
					{
						$t_key = array_search($p_items[0], $oLinkActions); 
						if(isset($oLinkTexts[$t_key]))
						{
							$show_text = $oLinkTexts[$t_key]." / ".$show_text;
						}
					}
					
					
					
					
					if($p_items[0]=="home"&&$p_items[1]=="messages")
					{
						$show_text.=" (".$new_messages.")";
					}
					
					echo LinkTile
					 (
						$p_items[0],
						$p_items[1],
						$show_text,
						"",
						"box-".(isset($p_items[2])?$p_items[2]:$i),
						"home"
					 );
					?>
					</div>
				</div>
				
				<?php
				
			
		}
		
		
		
		?>
			
		</div>
	
	</div>
<div class="clear"></div>
<br/>
<br/>

<div class="row">
 <div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<strong><?php echo $M_YOUR_LATEST_JOBS;?></strong>
		</div>
		
		<div class="panel-body">
			<div class="list-group">
			<?php
			$jobs = $database->DataTable("jobs","WHERE employer='".$AuthUserName."' ORDER BY id DESC LIMIT 0,3");
			$i_job_counter=0;
			while($job = $database->fetch_array($jobs))
			{
				if(trim($job["title"])=="") continue;
				$i_job_counter++;
			?>
			
				<a  href="index.php?category=jobs&action=details&id=<?php echo $job["id"];?>" class="list-group-item no-decoration <?php if($i_job_counter%2==0) echo 'alt-back';?>" >
					<div class="row">
						<div class="col-md-2">
							<?php echo date($website->GetParam("DATE_HOUR_FORMAT"),$job["date"]);?>
						</div>
						<div class="col-md-6">
							<strong><?php echo stripslashes($job["title"]);?></strong>
						</div>
						<div class="col-md-2 italic">
							
							<?php 
								echo "<strong>".$database->SQLCount("apply","WHERE posting_id=".$job["id"])."</strong>";
								echo " ".$M_APPLICATIONS;
							?>
							
						</div>
						<div class="col-md-2 italic">
							<?php 
								echo "<strong>".$database->SQLCount("jobs_stat","WHERE posting_id=".$job["id"])."</strong>";
								echo " ".$M_VISITS;
							?>
							
						</div>
						
					</div>
				</a>
			<?php
			}
			?>
			</div>
			
			<a href="<?php echo CreateLink("jobs","my");?>" class="btn btn-default btn-block alt-back"><?php echo $M_SEE_ALL;?></a>
		</div>
	</div>
</div>
</div>