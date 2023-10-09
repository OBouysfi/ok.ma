<?php
$iCounter=0;
echo '<?php';
echo "\n";
echo "\$loc=array();";
echo "\n";
foreach($arrLines as $strLoc)
{
	if(isset($limit)&&$iCounter==$limit) break;
	
	$iCounter++;
	if(trim($strLoc) == "")
	{
		continue;
	}
	
	$arrLoc =  preg_split("/[\d\.]+/", $strLoc, 2, PREG_SPLIT_DELIM_CAPTURE );
	
	$pattern = '/[0-9\.]+/';
	preg_match($pattern, $strLoc, $matches);
	$loc_id = substr($matches[0],0,strlen($matches[0])-1);
	$loc_name = trim(str_replace($loc_id,"",$strLoc));
	
	if(trim($loc_id)==""||trim($loc_name)=="") continue;
	
	$arr_digits= explode(".",$loc_id);
	
	
	if(sizeof($arr_digits)==1)
	{
		echo "\$loc";
		echo "[".$loc_id."]";
	}
	else
	{
		echo "\$loc".(sizeof($arr_digits)-1);	
		for($i=0;$i<sizeof($arr_digits);$i++)
		{
			echo "[".trim($arr_digits[$i])."]";
		}
	}
	
	echo "=\"".trim($arrLoc[1])."\";";
	$i=0;
	echo "\n";
	
}
echo '?>';
?>