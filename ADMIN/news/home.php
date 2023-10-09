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
					"news",
					"news",
					$M_ADD_NEWS,
					"",
					"green",
					"small",
					true
				 );
		?>
	
</div>
<div class="clear"></div>
		<br>
		<b>News Module Brief Overview</b>
		<br><br>
		The News module provides functionality to manage and publish
		news on the website handled by WebSiteAdmin.
		For every news the administrator can enter its Title and Content. 
		The list with the current news can be managed from 
		
		<a href="index.php?category=news&action=news">this page</a>.
		<br><br>
		<b>There are two basic options to use this module:</b>
		<br><br>
		<ul type="disc">
				  	<li><i>to use a custom tag</i>
					<br>
					This is suitable when you would like to have the list with the news
					always visible in a selected part of the website (for example a little
					box located at some of the corners of all the pages). In this case
					you should add a new custom tag, for example "news" and set for it
					the file <font face=Courier>news_tag.php</font>.
					<br>
					This could be done from <a href="index.php?category=extensions&action=tags">Extensions->Custom Tags</a> page:
					
					<br>
					Then you need to insert the custom tag you've added (for example &lt;wsa news/>)
					in the current template you are using at the position where you would
					like that the list with the news shows up.
					<br><br>
					</li>
					<li><i>to set it as extension on a selected page</i>
					<br>
					In this case you simply need to set the file <font face=Courier>news.php</font>
					as extension of the page where you would like that the news show up.
					You may do this from <a href="index.php?category=site_management">Management</a> - you need to drag the icon Settings
					over a page and then select news.php in the Extensions DropDown menu
					(in the settings page which will be opened).
					
					<br><br>
					Or from <a href="index.php?category=site_management&action=pages_pro">Management Pro</a>, to select the page and then from the context menu 
					choose "Set Custom Extension" and select news.php
					<br>
					<center>
					<img src="images/setextension.gif" width="400" height="272" alt="" border="0">
					</center>
					</li>
  		</ul>
		

