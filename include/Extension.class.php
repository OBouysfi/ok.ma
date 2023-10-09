<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
class Extension
{
	private $file_name;
	
	private $master_page;

	function Extension($file_name)
	{
		$this->file_name = $file_name;
	}
	
	function SetMasterPage($master_page)
	{
		$this->master_page = $master_page;
	}
	
	function Process()
	{
		global $UID,$MULTI_LANGUAGE_SITE,$website,$database,$DBprefix,$DOMAIN_NAME;
		
		$HTML="";
		ob_start();
		
		if(file_exists("include/texts_".$website->lang.".php"))
		{
			include("include/texts_".$website->lang.".php");
		}
		
		
		$lang_menu_pos = strpos($website->TemplateHTML, "<site languages_menu/>");
		
		if($MULTI_LANGUAGE_SITE && $lang_menu_pos !== false)
		{
			
			$website->TemplateHTML=
				str_replace
				(
					"<site languages_menu/>",
					$website->LanguagesMenu($this->master_page),
					$website->TemplateHTML
				);
		}
		
		if(file_exists("extensions/".$this->file_name.".php"))
		{
			include("extensions/".$this->file_name.".php");
		
		}
		
		if($HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();
	
		$website->TemplateHTML = str_replace("<site content/>",$HTML,$website->TemplateHTML);
		
		
		
		if(isset($this->master_page))
		{
			$website->TemplateHTML = str_replace("<site title/>",$this->master_page->arrElementsHTML["title"],$website->TemplateHTML);
			$website->TemplateHTML = str_replace("<site description/>",$this->master_page->arrElementsHTML["description"],$website->TemplateHTML);
			$website->TemplateHTML = str_replace("<site keywords/>",$this->master_page->arrElementsHTML["keywords"],$website->TemplateHTML);
		}
	}
	
	
	function get_param($param_name)
	{
		global $_REQUEST;
		if(isset($_REQUEST[$param_name]))
		{
			return $_REQUEST[$param_name];
		}
		else
		{
			return "";
		}
	}
	
	function str_show($str, $bret = false)
	{
		$str = trim($str);
			
		$strResult = "";
		
		if(strstr($str,"{"))
		{
			$strVName = substr($str,1,strlen($str)-2);
			global $$strVName;
			$strResult = $$strVName;
		}
		else
		{
			$strResult = $str;
		}

		if($bret)
		{
			
				return $strResult;
			
		}
		
		echo $strResult;
	}

}
?>
	