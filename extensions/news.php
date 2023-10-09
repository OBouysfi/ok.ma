<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
echo '<style>img{margin-right:10px}</style>';
if (!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["id"]))
{
	$news_id = $_REQUEST["id"];
	$website->ms_i($news_id);
	$arrNews = $database->DataArray("news","id=".$news_id);
	
	if(!isset($arrNews["id"]))
	{
		die("");
	}
	
	
	$website->Title(strip_tags(stripslashes($arrNews["title"])));
	$website->MetaDescription($website->text_words(strip_tags(stripslashes($arrNews["html"])),25));
	$website->MetaKeywords($website->format_keywords($website->text_words(strip_tags(stripslashes($arrNews["html"])),35)));
	
	echo "<div class=\"pull-right\">".date($website->GetParam("DATE_FORMAT"),$arrNews["date"])."</div>";
	
	echo '
	<h2 class="news-title">
		'.stripslashes($arrNews["title"]).'
	</h2>
	<hr/>
	<div class="news-content">
		'.stripslashes($arrNews["html"]).'
	</div>';
}
else
{
	$tableNews=$database->DataTable("news","WHERE active='YES' ORDER BY id DESC");

	while($arrNews = $database->fetch_array($tableNews))
	{
		echo "<div class=\"pull-right\">".date($website->GetParam("DATE_FORMAT"),$arrNews["date"])."</div>";
		
		echo "<a class=\"underline-link\" href=\"".$website->news_link($arrNews["id"],$arrNews["title"])."\"><h2>".stripslashes(strip_tags($arrNews["title"]))."</h2></a>
		<span class=\"sub-text\">
		".$website->text_words(stripslashes(strip_tags($arrNews["html"])),40);
		
		if(trim(strip_tags($arrNews["html"]))!="")
		{
			echo "<a title=\"".stripslashes($arrNews["title"])."\" href=\"".($website->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/news-".$arrNews["id"]."-".$website->format_str($arrNews["title"]).".html":"index.php?mod=news&id=".$arrNews["id"])."\">...</a>";
		}
		echo "
		</span>
		<br/>";
	}

}
?>