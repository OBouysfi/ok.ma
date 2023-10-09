<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><li class="dropdown">
	<a target="_blank" class="white-link" href="../index.php">
	   <?php echo $M_OPEN_THE_WEBSITE;?>
	</a>
<li class="dropdown">
	<a class="dropdown-toggle white-link" data-toggle="dropdown" href="#">
		<i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
	</a>
	<ul class="dropdown-menu dropdown-messages">
		<?php
		$messages = $database->DataTable("messages","ORDER BY id DESC LIMIT 0,3");
		
		while($message=$database->fetch_array($messages))
		{
		?>
		<li>
			<a href="<?php echo CreateLink("home","messages");?>" >
				<div>
					<strong></strong>
					<span class="pull-right text-muted">
						<em><?php echo time_since($message["date"]);?></em>
					</span>
				</div>
				<div><?php 
				$show_message=stripslashes($message["subject"]);
				
				echo substr(stripslashes($show_message),0,150);
				?></div>
			</a>
		</li>
		<li class="divider"></li>
		<?php
		}
		?>
		<li class="text-center top-link-li">
			<strong>
				<?php 
				if($database->num_rows($messages)==0)
				{
					echo $M_NO_NEW_MESSAGES;
				}
				else
				{
				?>
				<a class="text-center" href="<?php echo CreateLink("home","messages");?>">
				
					<?php echo $M_READ_ALL;?>
					<i class="fa fa-angle-right"></i>
				</a>
				<?php
				}
				?>
				</strong>
				
		</li>
	</ul>
</li>


<li class="dropdown">
	<a class="dropdown-toggle white-link" data-toggle="dropdown" href="#">
	   <?php echo $AuthUserName;?> <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
	</a>
	<ul class="dropdown-menu dropdown-user">
	  
		<li><a href="index.php?category=exit&action=exit"><i class="fa fa-sign-out fa-fw"></i> <?php echo $M_LOGOUT;?></a>
		</li>
	</ul>
</li>