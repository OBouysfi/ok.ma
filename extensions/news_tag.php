<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
$tableNews=$this->db->DataTable("news","WHERE active='YES' ORDER BY id DESC LIMIT 0,2");

while($arrNews = $this->db->fetch_array($tableNews))
{
	echo "<a href=\"".(isset($_REQUEST["p"])&&trim($_REQUEST["p"])!=""?$_REQUEST["p"]."-":"").($this->GetParam("SEO_URLS")==1?$M_SEO_NEWS."-".$arrNews["id"]."-".$this->format_str($arrNews["title"]).".html":"index.php?mod=news&id=".$arrNews["id"].($MULTI_LANGUAGE_SITE?"&lang=".$this->lang:""))."\"><h4>".stripslashes(strip_tags($arrNews["title"]))."</h4></a>
	<span class=\"sub-text\">
	".$this->text_words(stripslashes(strip_tags($arrNews["html"])),40);
	
	if(trim(strip_tags($arrNews["html"]))!="")
	{
		echo "<a title=\"".stripslashes($arrNews["title"])."\" href=\"".($this->GetParam("SEO_URLS")==1?"http://".$DOMAIN_NAME."/news-".$arrNews["id"]."-".$this->format_str($arrNews["title"]).".html":"index.php?mod=news&id=".$arrNews["id"])."\">...</a>";
	}
	echo "
	</span>
	<br/>";
}
?>