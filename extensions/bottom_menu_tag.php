<?php
// Jobs Portal All Rights Reserved

// A software product of NetArt Media, All Rights Reserved

// Find out more about our products and services on:

// http://www.netartmedia.net
?><?php

if(!defined('IN_SCRIPT')) die("");

$HTML = "";

$bFFlag = true;

if(isset($this->arrPages))

{

	foreach($this->arrPages as $arrPage)

	{

		if(trim($arrPage[2])=="")

		{

			continue;

		}



		if($arrPage[1]=="0")

		{

			$HTML.="

				<li>

					<a href=\"".$this->GenerateLink($this->params[1111],$this->params[1112],$this->lang,stripslashes($arrPage[2]))."\">".stripslashes($arrPage[2])."</a>

				</li>

			";

		}

	}

}

?>