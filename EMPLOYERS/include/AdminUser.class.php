<?php
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
			setcookie("AuthE","",time()-1,"/");
			die("<script>document.location.href='../index.php';</script>");
		}
		
		if(isset($_REQUEST["lng"]))
		{
			$website->ms_w($_REQUEST["lng"]);
			
			$this->language = $_REQUEST["lng"];
			$website->lang= $_REQUEST["lng"];		
			$database->Query
			("
			  UPDATE ".$DBprefix."employers
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
		global $database,$LoginInfo;
		
		if(isset($LoginInfo["subAccount"]))
		{
			$subAccount=$LoginInfo["subAccount"];
			$Permissions=$database->DataTable("sub_accounts_permissions","WHERE permission LIKE '~~".$subAccount."~~%' ");

			while($oPermission=$database->fetch_array($Permissions))
			{
			
				array_push($this->arrPermissions, strtolower($oPermission["permission"]));
				
					if(strstr($oPermission["permission"],("application_management~~list")))
					{
						array_push($this->arrPermissions, str_replace("application_management~~list","application_management~~my",strtolower($oPermission["permission"])));
				
					}
			}
			array_push($this->arrPermissions, "~~".strtolower($subAccount)."~~exit~~exit");
			array_push($this->arrPermissions, "~~".strtolower($subAccount)."~~home~~welcome");

		}
		
		
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