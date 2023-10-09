<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!isset($iKEY)||$iKEY!="AZ8007") die("ACCESS DENIED");


?>
<script>
function DeleteTemplate(x)
{
	document.location.href="index.php?category=users&action=reviews&del="+x;

}


function CallBack()
{
	document.getElementById("main-content").innerHTML =
	top.frames['ajax-ifr'].document.body.innerHTML;
	HideLoadingIcon();
}
$(function(){
	var offsetX = 20;
	var offsetY = -200;
	$('a.hover').hover(function(e){	
		var href = $(this).attr('href');
		$('<img id="largeImage" src="' + href + '" alt="image" />')
			.css({'top':e.pageY + offsetY,'left':e.pageX + offsetX})
			.appendTo('body');
	}, function(){
		$('#largeImage').remove();
	});
	$('a.hover').mousemove(function(e){
		$('#largeImage').css({'top':e.pageY + offsetY,'left':e.pageX + offsetX});
	});
	$('a.hover').click(function(e){
		e.preventDefault();
	});
});
</script>
<?php
if(isset($_REQUEST["del"]))
{
	$website->ms_i($_REQUEST["del"]);
	$database->SQLDelete("company_reviews","id",array($_REQUEST["del"]));
}

?>


<div class="fright">

		
	<?php
	
	
	
		 
		?>
		
	
</div>
<div class="clear"></div>
<br/>
<span class="medium-font">
List of the current reviews
</span>
<br/>
<?php


RenderTable
(
	"company_reviews",
	array("EditNote","date","title","html","author","vote","DeleteTemplate"),
	array($MODIFY,"Date","Title",$DESCRIPTION,"User","Vote",$EFFACER),
	750,
	"",
	"",
	"id",
	"index.php",
	true,
	20,
	false,
	-1,
	"ORDER BY ID desc"
);
?>

