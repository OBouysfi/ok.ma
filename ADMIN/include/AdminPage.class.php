<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
class AdminPage
{
	
	var $templateHTML="";
	var $pageHTML="";
	public $page;
	
	var $arrElements=array("title","menu","content","keywords","description");
	var $arrElementsHTML=array();
	var $templateID=0;
	var $arrPage;
	
	function AdminPage($page_name="")
	{
		$this->page = $page_name;
		
	}
	
	
	function Process($is_mobile=false)
	{
		global $is_mobile;
		global $DOMAIN_NAME,$lang,$AdminUser,$LoginInfo,$currentUser;

		
		include("../include/texts_".$lang.".php");
		include("texts_".$lang.".php");
		include("pages_structure.php");
		include("wysiwyg/detect_browser.php");
		
		global $AuthUserName,$lang,$website,$database, $_REQUEST, $DBprefix;
		$iKEY = "AZ8007";
		$DN=2;
		$this->pageHTML=$website->TemplateHTML;
		include("include/check_php_version.php");
		
		if(isset($_REQUEST["category"]))
		{
			$category = $_REQUEST["category"];
		}
		else
		{
			$category = "home";
		}
		$website->ms_w($category);
		
		$HTML="";
		ob_start();
		
	
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$folder = $_REQUEST["folder"];
			$page = $_REQUEST["page"];
			$website->ms_w($folder);
			$website->ms_w($page);
			
			if($this->CheckPermissions($category,$folder)
			&&file_exists($category."/".$folder."_".$page.".php"))
			{
			
				include($category."/".$folder."_".$page.".php");
				
			}
		}
		else
		{
			if(isset($_REQUEST["action"]))
			{
				$action = $_REQUEST["action"];
			}
			else
			{
				$action = "welcome";
			}
		
			$website->ms_w($action);
	
			if($this->CheckPermissions($category,$action)
			&&file_exists($category."/".$action.".php"))
			{
				include($category."/".$action.".php");
			}
			else
			{
				
			}
		}
		
		if($HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();

		if($is_mobile)
		{
			$mobile_start = strpos($HTML, '<!--mobile-start-->');
			$mobile_end   = strpos($HTML, '<!--mobile-end-->', $mobile_start);
			
			if($mobile_start !== false && $mobile_end !== false) 
			{
				$HTML   = substr($HTML, $mobile_start, ($mobile_end - $mobile_start));
			}
		}

		
		$this->pageHTML = str_replace("<admin content/>",$HTML,$this->pageHTML);
				
		
			$this->pageHTML=
			str_replace
			(
				"<admin languages_menu/>",
				$this->LanguagesMenu(),
				$this->pageHTML
			);
			
			$this->pageHTML=
			str_replace
			(
				"<admin menu/>",
				$this->StartMenu(),
				$this->pageHTML
			);
			
		$HTML="";
		ob_start();	
		include("include/top_bar_links.php");
		$HTML = ob_get_contents();
		ob_end_clean();
		$this->pageHTML=
		str_replace
		(
			"<admin top_bar_links/>",
			$HTML,
			$this->pageHTML
		);
		
		$website->TemplateHTML=$this->pageHTML;
		
		$str_page_link = "";
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$str_page_link = "index.php?category=".$_REQUEST["category"]."&page=".$_REQUEST["page"]."&folder=".$_REQUEST["folder"]."&";
		}
		else
		if(isset($_REQUEST["category"])&&isset($_REQUEST["action"]))
		{
			$str_page_link = "index.php?category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&";	
		}
		else
		{
			$str_page_link = "index.php?";
		}
		
		if($is_mobile)
		{
			$website->TemplateHTML = 
			str_replace("[MOBILE-LINK]",$str_page_link."switch_mobile=0",$website->TemplateHTML);
			include("include/help_tips.php");
		}
		else
		{
			$website->TemplateHTML = 
			str_replace("[MOBILE-LINK]",$str_page_link."switch_mobile=1",$website->TemplateHTML);
			include("include/help_tips.php");
		}
		
	}
	
	
	function CheckPermissions($category, $action)
	{
		global $currentUser;
		
		
		if
		(
			$currentUser->AuthGroup == "Administrators"
			|| $category == "exit"
		)
		{
			return true;
		}
		else
		if(array_search("@".$currentUser->AuthGroup."@".$category."@".$action, $currentUser->arrPermissions,false))
		{
			return true;
		}
		else
		if($category != "" && $action=="")
		{
			$vr2 = ($category."_oLinkActions");	
			global $$vr2;
			$evLinkActions = $$vr2;

			if(isset($evLinkActions))
			{
				foreach($evLinkActions as $evAction)
				{
					if(array_search("@".$currentUser->AuthGroup."@".$category."@".$evAction, $currentUser->arrPermissions,false))
					{
						return true;
					}
				}
			}
			
			return false;
		}
		else
		{
			return false;
		}
		
	}
	
	function GetHTML()
	{
		global $is_mobile;
		global $lang,$AdminUser,$LoginInfo,$currentUser;
		
		include("../include/texts_".$lang.".php");
		include("texts_".$lang.".php");
		include("pages_structure.php");
		include("wysiwyg/detect_browser.php");
		
		global $AuthUserName, $lang,$website,$database, $_REQUEST, $DBprefix;
		$iKEY = "AZ8007";
		$DN=2;
		
		if(isset($_REQUEST["category"]))
		{
			$category = $_REQUEST["category"];
		}
		else
		{
			$category = "home";
		}
		$website->ms_w($category);
		
		$HTML="";
		ob_start();
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$folder = $_REQUEST["folder"];
			$page = $_REQUEST["page"];
			$website->ms_w($folder);
			$website->ms_w($page);
			
			if($this->CheckPermissions($category,$folder)
			&&file_exists($category."/".$folder."_".$page.".php"))
			{
				include($category."/".$folder."_".$page.".php");
			}
		}
		else
		{
			if(isset($_REQUEST["action"]))
			{
				$action = $_REQUEST["action"];
			}
			else
			{
				$action = "welcome";
			}
		
			$website->ms_w($action);
			
			if($this->CheckPermissions($category,$action)
			&&file_exists($category."/".$action.".php"))
			{
				include($category."/".$action.".php");
			}
		}
		
		if($HTML=="")
		{
			$HTML = ob_get_contents();
		}
		ob_end_clean();

		return $HTML;
		
	}
	
	function StartMenu()
	{
		global $_REQUEST,$M_START,$M_ADD_ON,$lang;
		
		include("../include/texts_".$lang.".php");
		include("texts_".$lang.".php");
		
		include("pages_structure.php");
		$menu_html = "";
		$bottom_menu = "";
		echo "<script>var current_cat=\"".(isset($_REQUEST["category"])?$_REQUEST["category"]:"")."\";</script>";
		
		if(
			(isset($_REQUEST["action"])&&$_REQUEST["action"]=="news")
			||
			(isset($_REQUEST["folder"])&&$_REQUEST["folder"]=="news")
		)
		{
			echo '<style>#main_navigation{visibility:visible !important}</style>';			
		}
			
		
		for($i=0;$i<count($oLinkTexts);$i++)
		{
			$vr1 = ($oLinkActions[$i]."_oLinkTexts");		
			$vr2 = ($oLinkActions[$i]."_oLinkActions");	
		
			$evSLinkTexts=$$vr1;
			$evSLinkActions=$$vr2;
			
			if($this->CheckPermissions($oLinkActions[$i], $evSLinkActions[0]))
			{
				if($oLinkActions[$i]=="home"&&$evSLinkActions[0]=="welcome")
				{
					$menu_html.="\n<li><a class=\"f-level\" id=\"link_".$oLinkActions[$i]."\" href=\"index.php\">".$oLinkTexts[$i]."</a>";
					$bottom_menu.="\n<li><a href=\"index.php\">".$oLinkTexts[$i]."</a></li>";
				}
				else
				{
					$menu_html.="\n<li><a class=\"f-level\" id=\"link_".$oLinkActions[$i]."\"  href=\"#\">".$this->get_fa_icon($oLinkActions[$i])." ".$oLinkTexts[$i]."".(sizeof($evSLinkTexts)>1?'<span class="fa arrow"></span>':'')."</a>";
					$bottom_menu.="\n<li><a href=\"index.php?category=".$oLinkActions[$i]."&action=".$evSLinkActions[0]."\">".$oLinkTexts[$i]."</a></li>";
				}
			}
			
			if(sizeof($evSLinkTexts)>0)
			{
				//".(isset($_REQUEST["category"])&&$_REQUEST["category"]==$oLinkActions[$i]?"style=\"display:block\"":"")."
				$menu_html.="\n<ul class=\"nav nav-second-level\" >";
		
				for($j=0;$j<count($evSLinkTexts);$j++)
				{
					if(!strstr($evSLinkTexts[$j],$M_ADD_ON))
					{
						if($this->CheckPermissions($oLinkActions[$i], $evSLinkActions[$j]))
						{
							$no_ajax = false;
							if(strpos($evSLinkActions[$j],"_")!==false||strpos($evSLinkActions[$j],"-")!==false)
							{
								$no_ajax = true;
							}
							
							if($evSLinkActions[$j] == "types"||$evSLinkActions[$j] == "logo"||$evSLinkActions[$j] == "news"||$evSLinkActions[$j] == "tags"||$evSLinkActions[$j] == "add"||$evSLinkActions[$j] == "new_user"||$evSLinkActions[$j] == "newsletter2")
							{
								$no_ajax = true;
							}
							
							$link_id="link_".$oLinkActions[$i]."_".$evSLinkActions[$j];
							
							if($oLinkActions[$i]=="home"&&$evSLinkActions[$j]=="welcome")
							{
							  $str_link = "index.php";
							
							}
							else
							{
								if($no_ajax)
								{
									$str_link = "index.php?category=".$oLinkActions[$i]."&action=".$evSLinkActions[$j];
								}
								else
								{
									$str_link = "#".$oLinkActions[$i]."-".$evSLinkActions[$j];
								}
							}
							
							$is_current_li=false;
							if
							(
								isset($_REQUEST["category"])
								&&
								$_REQUEST["category"]==$oLinkActions[$i]
								&&
								isset($_REQUEST["action"])
								&&
								$_REQUEST["action"]==$evSLinkActions[$j]
							)
							{
								$is_current_li=true;
							}
							
							$menu_html.="\n<li ".($is_current_li?"class=\"selected-li\"":"")."><a class=\"s-level\"  href=\"".$str_link."\">".$evSLinkTexts[$j]."</a></li>";
						}
					}
					else
					{
						if($this->CheckPermissions($evSLinkActions[$j], ""))
						{
							$menu_html.="\n<li class=\"menu-sub-link\"><a class=\"s-level\" href=\"index.php?category=".$evSLinkActions[$j]."&action=home\">".$evSLinkTexts[$j]."</a></li>";
						}
					}
				}
				
				$menu_html.="\n</ul>";
			}
			$menu_html.="\n</li>";
		}
		
		$this->pageHTML=
		str_replace
		(
			"<admin bottom_menu/>",
			$bottom_menu,
			$this->pageHTML
		);
			
		return $menu_html;
	
	}
	
	function LanguagesMenu()
	{
		global $lang,$AdminPanelLanguages,$_REQUEST,$language;
		
		$language_menu_html = "";
		
		if(isset($_REQUEST["folder"])&&isset($_REQUEST["page"]))
		{
			$strPageLink="category=".$_REQUEST["category"]."&folder=".$_REQUEST["folder"]."&page=".$_REQUEST["page"]."&";
		}
		else
		if(isset($_REQUEST["category"])&&isset($_REQUEST["action"]))
		{
			$strPageLink="category=".$_REQUEST["category"]."&action=".$_REQUEST["action"]."&";
		}
		else
		{
			$strPageLink="";
		}
										
		foreach($AdminPanelLanguages as $arrLang)
		{
			list($languageName,$languageCode)=$arrLang;
			
			if($languageCode == $lang) continue;
			
			$language_menu_html .= "<a class=\"language-link\" href=\"index.php?".$strPageLink."lng=".$languageCode."\">".$languageName."</a> ";
			
		}
		
		global $M_OPEN_MAIN_SITE;
		
		$language_menu_html .= "<a class=\"language-link left-margin-20px\" href=\"../index.php\" target=\"_blank\">".$M_OPEN_MAIN_SITE."</a> ";
			
		return $language_menu_html;
	}
	
	function MobileLink()
	{
	
	}
	
	
	function get_fa_icon($action)
	{
		$icons =array
		(
			'connections'=>'square-o',
			'password'=>'lock',
			'users'=>'user',
			'stores'=>'laptop',
			'welcome'=>'desktop',
			'packages'=>'fax',
			'payments'=>'money',
			'advertisements'=>'external-link',
			'commissions'=>'credit-card',
			'commissions_report'=>'pie-chart',
			'products_manager'=>'shopping-cart',
			'reviews'=>'book',
			'options'=>'gears',
			'orders'=>'money',
			'settings'=>'gears',
			'statistics'=>'bar-chart-o',
			'security'=>'users',
			'templates'=>'square-o',
			'extensions'=>'sun-o',
			'categories'=>'bars',
			'locations'=>'globe',
			'languages'=>'globe',
			'manage'=>'qrcode',
			'posted_data'=>'mail-forward',
			'menu'=>'navicon',
			'new_user'=>'user',
			'admin'=>'users',
			'permissions'=>'unlock',
			'site_management'=>'sitemap',
			'pages_pro'=>'sitemap'
		);
		
		if(isset($icons[$action]))
		{
			return "<i class=\"fa fa-".$icons[$action]." fa-fw\"></i>";
		}
		else
		{
			return "<i class=\"fa fa-table fa-fw\"></i>";
		}
	}
}
?>