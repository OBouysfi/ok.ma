<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
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
			setcookie("Auth","",time()-1);
			die("<script>document.location.href='login.php';</script>");
		}
		
		if(isset($_REQUEST["lng"]))
		{
			$website->ms_w($_REQUEST["lng"]);
			
			$this->language = $_REQUEST["lng"];
					
			$database->Query
			("
			  UPDATE ".$DBprefix."admin_users
			  SET language='".$_REQUEST["lng"]."'
			  WHERE username='".$AuthUserName."'
			");
		}
		else
		{
			$this->language = $LoginInfo["language"];
		}
		
		if(strlen($this->language)!=2)
		{
			$this->language = "en";
		}
		
		
		if(isset($_REQUEST["switch_mobile"]))
		{
			$website->ms_i($_REQUEST["switch_mobile"]);
			
			$is_mobile = $_REQUEST["switch_mobile"];
					
			$database->Query
			("
			  UPDATE ".$DBprefix."admin_users
			  SET is_mobile='".$_REQUEST["switch_mobile"]."'
			  WHERE username='".$AuthUserName."'
			");
		}
		else
		{
			//$is_mobile = $LoginInfo["is_mobile"];
		}
		$is_mobile = false;
	}
	
	function LoadPermissions()
	{
		global $database;
		
		$Permissions = $database->DataTable("admin_users_permissions","");

		while($oPermission=$database->fetch_array($Permissions))
		{
			array_push($this->arrPermissions, $oPermission["permission"]);
		}

	
	}
	
	function GetLanguage()
	{
		return $this->language;
	}
	
	function HasPermission($category, $action)
	{
		
		if($this->AuthGroup == "Administrators")
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