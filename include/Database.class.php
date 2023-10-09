<?php
// Jobs Portal

// http://www.netartmedia.net/jobsportal

// Copyright (c) All Rights Reserved NetArt Media

// Find out more about our products and services on:

// http://www.netartmedia.net
?><?php

class Database

{

	public $allowed_html_fields=array("html","code","payment_code","cv","message","welcome_text");



    public function Connect($mysql_server, $mysql_user, $mysql_password)

    {

         $this->connection = mysqli_connect($mysql_server, $mysql_user, $mysql_password);

    }



	public function SelectDB($database_name)

    {

        mysqli_select_db($this->connection,$database_name);

    }

	

    public function __destruct()

    {

		

        mysqli_close($this->connection);

    }



    public function Query($query)

    {

        return mysqli_query($this->connection,$query);

    }

	

	 public function InsertQuery($query)

    {

         mysqli_query($query, $this->connection);

		 

		 return mysqli_insert_id($this->connection);

    }

	

	public function SQLQuery($query)

    {

        return mysqli_query($this->connection, $query);

    }

	

	public function num_rows($result_set)

    {

        return mysqli_num_rows($result_set);

    }

	

	public function fetch_array($result_set)

    {

        return mysqli_fetch_array($result_set);

    }

	

	public function escape_string($value)

	{

		return mysqli_escape_string($this->connection, $value);

	}

	

	public function SetParameter($param_id, $param_value)

    {

		global $DBprefix;

		if(!is_int($param_id)) die("");

		mysqli_query($this->connection, "UPDATE ".$DBprefix."settings SET value='".mysqli_real_escape_string($this->connection, $param_value)."' WHERE id=".$param_id);

    }

	

	public function GetParameter($param_id)

	{

		

		global $DBprefix;

		

		$sql_query = "SELECT * FROM ".$DBprefix."settings WHERE id=".$param_id;



		$data_table = $this->Query($sql_query);

		

		if(!$data_table || mysqli_num_rows($data_table) == 0)

		{

			return null;

		}

		else

		{

			$result_array = mysqli_fetch_array($data_table);

			return stripslashes($result_array["value"]);

		}



	}

	

	public function DataArray($strTable,$sqlClause)

	{

		

		global $DBprefix;

		

		$sql_query = "SELECT * FROM ".$DBprefix.$strTable." WHERE ".$sqlClause;



		$data_table = $this->Query($sql_query);

		

		if(!$data_table || mysqli_num_rows($data_table) == 0)

		{

			return null;

		}

		else

		{

			return mysqli_fetch_array($data_table);

		}



	}

	

	public function DataArray_Query($sql_query)

	{

		

		global $DBprefix;

		

		

		$data_table = $this->Query($sql_query);

		

		if(!$data_table || mysqli_num_rows($data_table) == 0)

		{

			return null;

		}

		else

		{

			return mysqli_fetch_array($data_table);

		}



	}

	

	public function DataTable($strTable,$sqlClause)

	{

		global $DBprefix;

		

		$sql_query = "SELECT * FROM ".$DBprefix.$strTable." ".$sqlClause;



		

		$data_table = $this->Query($sql_query);

		

		return $data_table;

	}

	

	

	public function SQLCount_Query($strQuery)

	{

	

		

		$iResult=0;



		$result_set = mysqli_query($this->connection, $strQuery);

		

		$iResult=mysqli_num_rows($result_set);

		

		return $iResult;

	}

	

	function GetFieldsInTable($strTable)

	{

		global $DBprefix;

		$mysql_fields = array();

		$pieces = explode(",", $strTable);

		$oResult=mysqli_query($this->connection, "SHOW COLUMNS FROM ".$DBprefix.$pieces[0]); 

		

		while ($row = mysqli_fetch_assoc($oResult)) 

		{

		   array_push($mysql_fields,$row["Field"]);

		}

				

		return $mysql_fields;

	}

	

	function SQLInsert($strTable,$arrNames,$arrValues)

	{

		global $DBprefix;

		$strNames="";

		$strList="";



		$num = count($arrNames);



		for ($i = 0; $i < $num; $i++) 

		{

			$strNames.=$arrNames[$i].",";

		}



		$num = count ($arrValues);



		for ($i = 0; $i < $num; $i++) 

		{

		

			if(strpos($arrNames[$i], "html_")!== false)

			{

			

			}

			else

			if(!in_array($arrNames[$i], $this->allowed_html_fields))

			{

				if(is_array($arrValues[$i]))

				{

					$arrValues[$i]=implode(",",$arrValues[$i]);

				}

				$arrValues[$i]=strip_tags($arrValues[$i]);

				

			}

			

			

			$strList.="'".mysqli_real_escape_string($this->connection, $arrValues[$i])."',";

			

		}



		$strList=substr($strList,0,(strlen($strList)-1));

		$strNames=substr($strNames,0,(strlen($strNames)-1));



		$strQuery="INSERT INTO ".$DBprefix.$strTable." 

		(".$strNames.") 

		VALUES 

		(".$strList.")";

		



		$this->Query($strQuery);

		

		

		

		$iResult=mysqli_insert_id($this->connection);

		

		return $iResult;

	}



	public function SQLCount($table,$where_query="", $count_column = "id")

	{

		global $DBprefix;

		

		

		$result = $this->Query

		(

			"SELECT COUNT(".$count_column.")

			FROM ".$DBprefix.$table."

			".($where_query!=""?$where_query:"")

		);

		

	

		return $this->mysqli_result($result, 0);

	}

	

	function mysqli_result($result, $row, $field = 0) 

	{

		$result->data_seek($row);

	  

		$data = $result->fetch_array();

	 

		return $data[$field];

	}

	public function SQLMin($strTable, $strField)

	{

		global $DBprefix;

		$result = $this->Query

		(

			"SELECT MIN(".$strField.")

			FROM ".$DBprefix.$strTable

		);

		

	

		return $this->mysqli_result($result, 0);

	}

	

	public function SQLMax($strTable, $strField)

	{

		global $DBprefix;

		$result = $this->Query

		(

			"SELECT MAX(".$strField.")

			FROM ".$DBprefix.$strTable

		);

		

	

		return $this->mysqli_result($result, 0);

	}

 

	

	function SQLDelete($strTable,$Key,$arrIDs)

	{



		global $DBprefix;



		$strList="";





		$num = count ($arrIDs);



		for ($i = 0; $i < $num; $i++) 

		{

			$strList.=$arrIDs[$i].",";

		}



		$strList=substr($strList,0,(strlen($strList)-1));





		$strQuery="DELETE FROM ".$DBprefix.$strTable." WHERE ".$Key." IN ($strList)";



		$this->Query($strQuery);



	}

	

	

	function SQLDeletePlus($auth_column,$auth_value,$strTable,$Key,$arrIDs)

	{



		global $DBprefix;



		$strList="";





		$num = count ($arrIDs);



		for ($i = 0; $i < $num; $i++) 

		{

			$strList.=$arrIDs[$i].",";

		}



		$strList=substr($strList,0,(strlen($strList)-1));





		$strQuery="DELETE FROM ".$DBprefix.$strTable." WHERE ".$Key." IN ($strList) AND ".$auth_column."='".$auth_value."'";



		$this->Query($strQuery);



	}

	

	function SQLUpdate($strTable,$arrNames,$arrValues,$whereClause)

	{

		global $DBprefix;



		$strUpdateList="";



		$num = count($arrNames);



		for ($i = 0; $i < $num; $i++) 

		{

			if(strpos($arrNames[$i], "html_")!== false)

			{

				

			}

			else

			if(!in_array($arrNames[$i], $this->allowed_html_fields))

			{

				if(is_array($arrValues[$i])) $arrValues[$i]=implode(",",$arrValues[$i]);

				$arrValues[$i]=strip_tags($arrValues[$i]);

			}

				$arr_decim=array("experience_level");

				

				if(in_array($arrNames[$i],$arr_decim))



				{

					$strUpdateList.=$arrNames[$i]."=NULL,";

				}				

				else	

				{

					$strUpdateList.=$arrNames[$i]."='".mysqli_real_escape_string($this->connection, $arrValues[$i])."',";

				}

		}



		$strUpdateList=substr($strUpdateList,0,(strlen($strUpdateList)-1));



		$strQuery="UPDATE ".$DBprefix.$strTable."

		SET ".$strUpdateList."

		WHERE ".$whereClause;

		$strQuery=str_replace("'NULL'","NULL",$strQuery);



		

		$iResult=$this->Query($strQuery);



		return $iResult;

	}

	

	function SQLUpdate_SingleValue

	(

		$strTable,

		$PrimaryKey,

		$PrimaryKeyValue,

		$FieldName,

		$FieldValue

	){





		global $DBprefix;



		if(!in_array($FieldName, $this->allowed_html_fields))

		{

			$FieldValue=strip_tags($FieldValue);

		}

		

		$strQuery="UPDATE ".$DBprefix.$strTable."

		SET ".$FieldName."='".mysqli_real_escape_string($this->connection, $FieldValue)."'

		WHERE ".$PrimaryKey."=".$PrimaryKeyValue;



		$iResult=$this->Query($strQuery);



		return $iResult;

	}

	

	

	function SQLSum_Query

	(

		$strTable,

		$strField,

		$whereQuery

	)

	{

		global $DBprefix;

		$strResult="";

		

		$strQuery="SELECT sum(".$strField.") abc FROM ".$DBprefix.$strTable." WHERE ".$whereQuery;

		

		$oResult=$this->Query($strQuery);



		$arrResult=mysqli_fetch_array($oResult);

		

		$strResult=$arrResult["abc"];

		

		return round($strResult,2);

	}

	

	

	function SQLAvg_Query

	(

		$strTable,

		$strField,

		$whereQuery

	)

	{



		$strResult="";

		

		global $DBprefix;



		$strQuery="SELECT avg(".$strField.") abc FROM ".$DBprefix.$strTable." WHERE ".$whereQuery;

		

		$oResult=$this->Query($strQuery);



		$arrResult=mysqli_fetch_array($oResult);

		

		$strResult=$arrResult["abc"];

		return round($strResult,2);

	}



	function SQLUpdateField_MultipleArray($strTable,$strName,$strValue,$strIdName,$arrIds)

	{



		if(sizeof($arrIds)==0)

		{

			return;

		}

		

		$strIds="";



		for($i=0;$i<sizeof($arrIds);$i++)

		{



			if($i==(sizeof($arrIds)-1))

			{

				$strIds.="".$arrIds[$i];

			}

			else{

				$strIds.="".$arrIds[$i].",";

			}



		}



		global $DBprefix;



		$strQuery="UPDATE ".$DBprefix.$strTable."

		SET ".$strName."='".mysqli_real_escape_string($this->connection, $strValue)."'

		WHERE ".$strIdName." IN (".$strIds.")";

		

		$this->Query($strQuery);

	}



	function getSingleValue

			(

				$strTable,

				$PrimaryKey,

				$PrimaryKeyValue,

				$FieldName

			)

	{



		$strResult="";

		global $DBprefix;



		

		$strQuery="SELECT $FieldName FROM $DBprefix".$strTable."

						  WHERE $PrimaryKey=$PrimaryKeyValue";



		$oResult=$this->Query($strQuery);



		$aResult=mysqli_fetch_array($oResult);

		

		$strResult=$aResult[$FieldName];

		

		return $strResult;

	}

	

}

?>