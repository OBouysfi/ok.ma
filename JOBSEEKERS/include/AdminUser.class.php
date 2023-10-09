<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
class AdminUser
{
	public $arrPermissions=array("PermissionsArray");
	public $AuthUserName;
	public $AuthGroup;
	
	public $language = "en";
	
	function AdminUser($AuthUserName, $AuthGroup)
	{
		global $is_mobile,$_REQUEST,$_SERVER,$database,$website,$DBprefix,$AdminUser,$LoginInfo;
		
		$this->AuthUserName = $AuthUserName;
		$this->AuthGroup = $AuthGroup;
		
		if(isset($_REQUEST["category"])&&$_REQUEST["category"]=="exit")
		{
			$database->Query
			("
				INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
				VALUES('".$AuthUserName."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
			");
			setcookie("AuthJ","",time()-1,"/");
			die("<script>document.location.href='../index.php';</script>");
		}
		
		if(isset($_REQUEST["lng"]))
		{
			$website->ms_w($_REQUEST["lng"]);
			
			$this->language = $_REQUEST["lng"];
			$website->lang= $_REQUEST["lng"];			
			$database->Query
			("
			  UPDATE ".$DBprefix."jobseekers
			  SET language='".$_REQUEST["lng"]."'
			  WHERE username='".$AuthUserName."'
			");
		}
		else
		{
			$this->language = $LoginInfo["language"];
			$website->lang= $LoginInfo["language"];
		}
		
		if(strlen($this->language)!=2)
		{
			$this->language = "en";
		}
		
		
		
	}
	
	function LoadPermissions()
	{
		global $database;
	
	}
	
	function GetLanguage()
	{
		return $this->language;
	}
	
	function HasPermission($category, $action)
	{
		
		if(true||$this->AuthGroup == "Administrators")
		{
			return true;
		}
		else
		if(array_search("@".$this->AuthGroup."@".$category."@".$action, $this->arrPermissions,false))
		{
			return true;
		}
		else
		if($category != "" && $action=="")
		{
			$vr2 = ($category."_oLinkActions");	
			global $$vr2;
			$evLinkActions = $$vr2;

			foreach($evLinkActions as $evAction)
			{
				if(array_search("@".$this->AuthGroup."@".$category."@".$evAction, $this->arrPermissions,false))
				{
					return true;
				}
			}
			
			return false;
		}
		else
		{
			return false;
		}
		
	}

}

?>