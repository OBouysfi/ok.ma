<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
class Page
{
	
	var $templateHTML="";
	var $pageHTML="";
	public $page;
	
	var $arrElements=array("title","content","keywords","description");
	var $arrElementsHTML=array();
	var $templateID=0;
	var $arrPage;
	
	function Page($page_name)
	{
		$this->page = $page_name;
	}
	
	function LoadPageData()
	{
		global $lang,$database,$website;
		
		if($this->page == "")
		{
			$this->page = $website->DefaultPage;
		}
	
		list($lang,$link)=explode("_",urldecode($this->page),2);
		
		if(trim($lang)!="" && strlen($lang)==2)
		{
			$website->SetLanguage($lang);
		}
		
		$this->arrPage=$database->DataArray("pages","link_".$lang."='".$database->escape_string($link)."'");
		
		
		if(!isset($this->arrPage["name_".$lang]))
		{
			
		}
			
		$this->arrElementsHTML["title"]=stripslashes($this->arrPage["name_".$lang]);
		$this->arrElementsHTML["keywords"]=stripslashes($this->arrPage["keywords_".$lang]);
		$this->arrElementsHTML["description"]=stripslashes($this->arrPage["description_".$lang]);
		
		$this->arrElementsHTML["content"]="";
		
		if(trim($this->arrPage["html_".$lang])!="")
		{
			$this->arrElementsHTML["content"]="<div class=\"page-wrap\">".str_replace("../uploaded_images/","uploaded_images/",stripslashes($this->arrPage["html_".$lang]))."</div>";
		}
		
		$this->templateID = $this->arrPage["template_id"];
		
		
		
	}
	
	function Process()
	{
		
		global $UID,$MULTI_LANGUAGE_SITE,$website,$database,$DBprefix,$_POST,$DOMAIN_NAME;
				
		$this->pageHTML=$website->TemplateHTML;
		
		if(trim($this->arrPage["custom_link_".$website->lang])!="")
		{
	
			$HTML="";
			ob_start();
			if(file_exists("include/texts_".$website->lang.".php"))
			{
				include("include/texts_".$website->lang.".php");
			}
			if(file_exists("extensions/".$this->arrPage["custom_link_".$website->lang].".php"))
			{
				include("extensions/".$this->arrPage["custom_link_".$website->lang].".php");
			
			}
			
			if($HTML=="")
			{
				$HTML = ob_get_contents();
			}
			ob_end_clean();
			
			$this->arrElementsHTML["content"] .= 
			
			(trim($this->arrElementsHTML["content"])!=""?"<br/>":"")
			.$HTML;
		}
		
		foreach($this->arrElements as $element)
		{
		
			if(isset($this->arrElementsHTML[$element]))
			{
				$this->pageHTML=str_replace
				(
					"<site ".$element."/>",
					$this->arrElementsHTML[$element],
					$this->pageHTML
				);
			}
		}		
		
		
		$this->pageHTML=str_replace("../image.php?id=","image.php?id=",$this->pageHTML);
		
		$lang_menu_pos = strpos($this->pageHTML, "<site languages_menu/>");
		
		if($MULTI_LANGUAGE_SITE && $lang_menu_pos !== false)
		{
			
			
			$this->pageHTML=
			str_replace
			(
				"<site languages_menu/>",
				$website->LanguagesMenu($this->arrPage),
				$this->pageHTML
			);
		}
			
		
		$website->TemplateHTML=$this->pageHTML;
			
		
	}
	
	
	
}
?>
