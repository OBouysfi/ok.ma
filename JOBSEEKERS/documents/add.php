<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
	<div class="fright">

	<?php
		echo LinkTile
		 (
			"home",
			"welcome",
			$M_DASHBOARD,
			"",
			"blue"
		 );
		 
		 echo LinkTile
		 (
			"documents",
			"list",
			$M_MY_FILES,
			"",
			"green"
		 );
	
	
	?>

</div>
<div class="clear"></div>


<?php
//FILE PARSING FUNCTIONS
function rtf_p_text($s) {
    $arrfailAt = array("*", "fonttbl", "colortbl", "datastore", "themedata");
    for ($i = 0; $i < count($arrfailAt); $i++)
        if (!empty($s[$arrfailAt[$i]])) return false;
    return true;
} 

function rtf2text($filename) {
   
    $text = file_get_contents($filename);
    if (!strlen($text))
        return "";

   
    $document = "";
    $stack = array();
    $j = -1;
   
    for ($i = 0, $len = strlen($text); $i < $len; $i++) {
        $c = $text[$i];

        switch ($c) {
         
            case "\\":
             
                $nc = $text[$i + 1];

                 if ($nc == '\\' && rtf_p_text($stack[$j])) $document .= '\\';
                elseif ($nc == '~' && rtf_p_text($stack[$j])) $document .= ' ';
                elseif ($nc == '_' && rtf_p_text($stack[$j])) $document .= '-';
              
                elseif ($nc == '*') $stack[$j]["*"] = true;
                elseif ($nc == "'") {
                    $hex = substr($text, $i + 2, 2);
                    if (rtf_p_text($stack[$j]))
                        $document .= html_entity_decode("&#".hexdec($hex).";");
                
                    $i += 2;
                } elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
                    $word = "";
                    $param = null;

                     for ($k = $i + 1, $m = 0; $k < strlen($text); $k++, $m++) {
                        $nc = $text[$k];
                          if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
                            if (empty($param))
                                $word .= $nc;
                            else
                                break;
                       
                        } elseif ($nc >= '0' && $nc <= '9')
                            $param .= $nc;
                         elseif ($nc == '-') {
                            if (empty($param))
                                $param .= $nc;
                            else
                                break;
                        } else
                            break;
                    }
                     $i += $m - 1;

                    $toText = "";
                    switch (strtolower($word)) {
                         case "u":
                            $toText .= html_entity_decode("&#x".dechex($param).";");
                            $ucDelta = @$stack[$j]["uc"];
                            if ($ucDelta > 0)
                                $i += $ucDelta;
                        break;
                       
                        case "par": case "page": case "column": case "line": case "lbr":
                            $toText .= "\n";
                        break;
                        case "emspace": case "enspace": case "qmspace":
                            $toText .= " ";
                        break;
                        case "tab": $toText .= "\t"; break;
                        case "chdate": $toText .= date("m.d.Y"); break;
                        case "chdpl": $toText .= date("l, j F Y"); break;
                        case "chdpa": $toText .= date("D, j M Y"); break;
                        case "chtime": $toText .= date("H:i:s"); break;
                        case "emdash": $toText .= html_entity_decode("&mdash;"); break;
                        case "endash": $toText .= html_entity_decode("&ndash;"); break;
                        case "bullet": $toText .= html_entity_decode("&#149;"); break;
                        case "lquote": $toText .= html_entity_decode("&lsquo;"); break;
                        case "rquote": $toText .= html_entity_decode("&rsquo;"); break;
                        case "ldblquote": $toText .= html_entity_decode("&laquo;"); break;
                        case "rdblquote": $toText .= html_entity_decode("&raquo;"); break;
                         default:
                            $stack[$j][strtolower($word)] = empty($param) ? true : $param;
                        break;
                    }
                  
                    if (rtf_p_text($stack[$j]))
                        $document .= $toText;
                }

                $i++;
            break;
            case "{":
                array_push($stack, $stack[$j++]);
            break;
            case "}":
                array_pop($stack);
                $j--;
            break;
          
            case '\0': case '\r': case '\f': case '\n': break;
           
            default:
                if (rtf_p_text($stack[$j]))
                    $document .= $c;
            break;
        }
    }
   
    return $document;
}

class PDF2Text {
	// Some settings
	var $multibyte = 2; // Use setUnicode(TRUE|FALSE)
	var $convertquotes = ENT_QUOTES; // ENT_COMPAT (double-quotes), ENT_QUOTES (Both), ENT_NOQUOTES (None)
	
	// Variables
	var $filename = '';
	var $decodedtext = '';
	
	function setFilename($filename) { 
		// Reset
		$this->decodedtext = '';
		$this->filename = $filename;
	}
	
	function output($echo = false) { 
		if($echo) echo $this->decodedtext;
		else return $this->decodedtext;
	}
	
	function setUnicode($input) { 
		// 4 for unicode. But 2 should work in most cases just fine
		if($input == true) $this->multibyte = 4;
		else $this->multibyte = 2;
	}
	
	function decodePDF() { 
		// Read the data from pdf file
		$infile = @file_get_contents($this->filename, FILE_BINARY); 
		if (empty($infile)) 
			return ""; 
		
		// Get all text data.
		$transformations = array(); 
		$texts = array(); 
		
		// Get the list of all objects.
		preg_match_all("#obj[\n|\r](.*)endobj[\n|\r]#ismU", $infile, $objects); 
		$objects = @$objects[1]; 
		
		// Select objects with streams.
		for ($i = 0; $i < count($objects); $i++) { 
			$currentObject = $objects[$i]; 
			
			// Check if an object includes data stream.
			if (preg_match("#stream[\n|\r](.*)endstream[\n|\r]#ismU", $currentObject, $stream)) { 
				$stream = ltrim($stream[1]); 
				
				// Check object parameters and look for text data. 
				$options = $this->getObjectOptions($currentObject); 
				
				if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"]))) 
					continue; 
				
				// Hack, length doesnt always seem to be correct
				unset($options["Length"]);
				
				// So, we have text data. Decode it.
				$data = $this->getDecodedStream($stream, $options);  
				
				if (strlen($data)) { 
					if (preg_match_all("#BT[\n|\r](.*)ET[\n|\r]#ismU", $data, $textContainers)) {
						$textContainers = @$textContainers[1]; 
						$this->getDirtyTexts($texts, $textContainers); 
					} else 
						$this->getCharTransformations($transformations, $data); 
				} 
			} 
		} 
		
		// Analyze text blocks taking into account character transformations and return results. 
		$this->decodedtext = $this->getTextUsingTransformations($texts, $transformations); 
	}
	
	
	function decodeAsciiHex($input) {
		$output = "";
		
		$isOdd = true;
		$isComment = false;
		
		for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
			$c = $input[$i];
			
			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}
			
			switch($c) {
				case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
				case '%': 
					$isComment = true;
					break;
				
				default:
					$code = hexdec($c);
					if($code === 0 && $c != '0')
						return "";
					
					if($isOdd)
						$codeHigh = $code;
					else
						$output .= chr($codeHigh * 16 + $code);
					
					$isOdd = !$isOdd;
					break;
			}
		}
		
		if($input[$i] != '>')
			return "";
		
		if($isOdd)
			$output .= chr($codeHigh * 16);
		
		return $output;
	}
	
	function decodeAscii85($input) {
		$output = "";
		
		$isComment = false;
		$ords = array();
		
		for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
			$c = $input[$i];
			
			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}
			
			if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
				continue;
			if ($c == '%') {
				$isComment = true;
				continue;
			}
			if ($c == 'z' && $state === 0) {
				$output .= str_repeat(chr(0), 4);
				continue;
			}
			if ($c < '!' || $c > 'u')
				return "";
			
			$code = ord($input[$i]) & 0xff;
			$ords[$state++] = $code - ord('!');
			
			if ($state == 5) {
				$state = 0;
				for ($sum = 0, $j = 0; $j < 5; $j++)
					$sum = $sum * 85 + $ords[$j];
				for ($j = 3; $j >= 0; $j--)
					$output .= chr($sum >> ($j * 8));
			}
		}
		if ($state === 1)
			return "";
		elseif ($state > 1) {
			for ($i = 0, $sum = 0; $i < $state; $i++)
				$sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
			for ($i = 0; $i < $state - 1; $i++)
				$ouput .= chr($sum >> ((3 - $i) * 8));
		}
		
		return $output;
	}
	
	function decodeFlate($input) {
		return gzuncompress($input);
	}
	
	function getObjectOptions($object) {
		$options = array();
		
		if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
			$options = explode("/", $options[1]);
			@array_shift($options);
			
			$o = array();
			for ($j = 0; $j < @count($options); $j++) {
				$options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
				if (strpos($options[$j], " ") !== false) {
					$parts = explode(" ", $options[$j]);
					$o[$parts[0]] = $parts[1];
				} else
					$o[$options[$j]] = true;
			}
			$options = $o;
			unset($o);
		}
		
		return $options;
	}
	
	function getDecodedStream($stream, $options) {
		$data = "";
		if (empty($options["Filter"]))
			$data = $stream;
		else {
			$length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
			$_stream = substr($stream, 0, $length);
			
			foreach ($options as $key => $value) {
				if ($key == "ASCIIHexDecode")
					$_stream = $this->decodeAsciiHex($_stream);
				if ($key == "ASCII85Decode")
					$_stream = $this->decodeAscii85($_stream);
				if ($key == "FlateDecode")
					$_stream = $this->decodeFlate($_stream);
				if ($key == "Crypt") { // TO DO
				}
			}
			$data = $_stream;
		}
		return $data;
	}
	function getDirtyTexts(&$texts, $textContainers) {
		
		for ($j = 0; $j < count($textContainers); $j++) {
			if (preg_match_all("#\[(.*)\]\s*TJ[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, @$parts[1]);
			elseif(preg_match_all("#T[d|w|m|f]\s*(\(.*\))\s*Tj[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, @$parts[1]);
			elseif(preg_match_all("#T[d|w|m|f]\s*(\[.*\])\s*Tj[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, @$parts[1]);
		}
	}
	function getCharTransformations(&$transformations, $stream) {
		preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
		preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);
		
		for ($j = 0; $j < count($chars); $j++) {
			$count = $chars[$j][1];
			$current = explode("\n", trim($chars[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
					$transformations[str_pad($map[1], 4, "0")] = $map[2];
			}
		}
		for ($j = 0; $j < count($ranges); $j++) {
			$count = $ranges[$j][1];
			$current = explode("\n", trim($ranges[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$_from = hexdec($map[3]);
					
					for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
				} elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$parts = preg_split("#\s+#", trim($map[3]));
					
					for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
				}
			}
		}
	}
	function getTextUsingTransformations($texts, $transformations) {
		$document = "";
		for ($i = 0; $i < count($texts); $i++) {
			$isHex = false;
			$isPlain = false;
			
			$hex = "";
			$plain = "";
			for ($j = 0; $j < strlen($texts[$i]); $j++) {
				$c = $texts[$i][$j];
				switch($c) {
					case "<":
						$hex = "";
						$isHex = true;
						break;
					case ">":
						$hexs = str_split($hex, $this->multibyte); // 2 or 4 (UTF8 or ISO)
						for ($k = 0; $k < count($hexs); $k++) {
							$chex = str_pad($hexs[$k], 4, "0"); // Add tailing zero
							if (isset($transformations[$chex]))
								$chex = $transformations[$chex];
							$document .= html_entity_decode("&#x".$chex.";");
						}
						$isHex = false;
						break;
					case "(":
						$plain = "";
						$isPlain = true;
						break;
					case ")":
						$document .= $plain;
						$isPlain = false;
						break;
					case "\\":
						$c2 = $texts[$i][$j + 1];
						if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
						elseif ($c2 == "n") $plain .= '\n';
						elseif ($c2 == "r") $plain .= '\r';
						elseif ($c2 == "t") $plain .= '\t';
						elseif ($c2 == "b") $plain .= '\b';
						elseif ($c2 == "f") $plain .= '\f';
						elseif ($c2 >= '0' && $c2 <= '9') {
							$oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
							$j += strlen($oct) - 1;
							$plain .= html_entity_decode("&#".octdec($oct).";", $this->convertquotes);
						}
						$j++;
						break;
					
					default:
						if ($isHex)
							$hex .= $c;
						if ($isPlain)
							$plain .= $c;
						break;
				}
			}
			$document .= "\n";
		}
		
		return $document;
	}
}
//END FILE PARSING FUNCTIONS

?>
<h3>
	<?php echo $ADD_NEW_DOCUMENT;?>
</h3>

<?php
if($database->SQLCount("files","WHERE user='$AuthUserName'","file_id") >= aParameter(816))
{
?>
<br><br><br>
	<span class="red_font">
		
		<?php echo $MAX_NUMBER_FILES;?>
		
	</span>
<br><br><br><br><br>
<?php
}
else
{
?>


<?php

function get_file_extension($filename)
{
    $path_info = pathinfo($filename);
    return strtolower($path_info['extension']);
}


function GetFileType($file_type)
{ 
	global $website;  
	foreach($website->GetParam("ACCEPTED_FILE_TYPES") as $c_file_type) 
	{  
		if($c_file_type[0] == $file_type) 
		return $c_file_type[1];   
	} 
	return "";
}
 


if(isset($_POST["ProceedAddFile"]))
{
	$iResult =mt_rand(100000,9999999);// SQLInsertUserFile("file_user");
	$strInputFile="file_user";
	$file_name = $_FILES[$strInputFile]["name"];  
	$file_size = $_FILES[$strInputFile]["size"];  
	$file_type = $_FILES[$strInputFile]["type"];  
	$file_extension = GetFileType($file_type); 

	if($file_extension == "") 
	{ 
		echo "<b><span class=\"red-font\">".$M_FILE_FORMAT_NOT_SUPPORTED."</span></b>";  
	}  
	else  
	{   
		$uploadedFile = "../user_files/" . $iResult.".".$file_extension;    
		
		if($file_size > $website->GetParam("MAX_FILE_SIZE"))  
		{   
			echo "<b><font color=red>".$FILE_MAX_SIZE_EXCEEDED."</font></b>";  
		}  
		else  
		{
 
 
				move_uploaded_file($_FILES[$strInputFile]['tmp_name'], $uploadedFile);
				
			
				$database->SQLInsert
				(
					"files",
					array("user","file_name","file_date","file_type","file_size","file_id","description","is_resume"),
					array($AuthUserName,$file_name,time(),$file_type,$file_size,$iResult,get_param("file_description"),get_param("is_resume"))
				);	

			
			if(isset($_FILES["file_user"]))
			{
				$uploaded_file_extension = get_file_extension($_FILES["file_user"]["name"]);
				$uploaded_file_text = "";
				$uploaded_file = "../user_files/".$iResult.".".$uploaded_file_extension;
				
				if($uploaded_file_extension == "pdf")
				{
					$a = new PDF2Text();
					
					$a->setFilename($uploaded_file);
					$a->decodePDF();
					$uploaded_file_text = $a->output(); 
				
				}
				elseif($uploaded_file_extension == "rtf")
				{
					$uploaded_file_text = rtf2text($uploaded_file);
				}
				elseif($uploaded_file_extension == "docx"||$uploaded_file_extension == "odt")
				{
					if($uploaded_file_extension == 'docx')
						$dataFile = "word/document.xml";
					else
						$dataFile = "content.xml"; 
					
					if(class_exists("ZipArchive"))
					{
						$zip = new ZipArchive;		
						if (true === $zip->open($uploaded_file)) 
						{
				   
							if(($index = $zip->locateName($dataFile)) !== false) 
							{
							
								$text = $zip->getFromIndex($index);
							
								$xml = DOMDocument::loadXML($text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
								
								$uploaded_file_text = strip_tags($xml->saveXML());
							}
						
							$zip->close();
						}
					}
				}
				
				if(trim($uploaded_file_text)!="")
				{
					$database->SQLUpdate_SingleValue
					(
						"files",
						"file_id",
						$iResult,
						"file_text",
						$uploaded_file_text
					);
				}
			
			}
			
			if($iResult > 0)		
			{
				echo '		
				<br/>
				<h3>
					'.$FILE_ADDED.'
				
					<br/><br/>
					<a class="underline-link" href="index.php?category=documents&action=list">'.$M_VIEW_FILES_LIST.'</a>
				</h3>
				<br/>
				';
			}
		}
	}
}
?>

<br>



<script>

function SubmitForm1(x)
{
	if(x.file_user.value == "")
	{
		alert("Please select a file!");
		return false;
	}
	
	return true;

}

</script>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<form action="index.php" onsubmit="return SubmitForm1(this)" method=post ENCTYPE="multipart/form-data">
		<input type="hidden" name="ProceedAddFile"/>
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
				<table summary="" border="0">
				  	<tr>
				  		<td><?php echo $FILE;?>: </td>
				  		<td><input type="file" size="30" name="file_user" style="width:400px" id="file_user"></td>
				  	</tr>
				  	<tr>
				  		<td><?php echo $DESCRIPTION;?>: </td>
				  		<td><textarea cols="60" rows="5" name="file_description" style="width:400px" id="file_description"></textarea></td>
				  	</tr>
						<tr>
				  		<td><?php echo $M_IS_IT_RESUME;?> </td>
				  		<td>
							<select name="is_resume" style="width:400px">
								<option value="0"><?php echo $M_NO;?></option>
								<option value="1" <?php if(isset($resume)) echo "selected";?>><?php echo $M_YES;?></option>
							</select>
						</td>
				  	</tr>
				  </table>
		
		<br>
		<input type=submit value=" <?php echo $AJOUTER;?> " class="btn btn-primary">
		
		</form>
		</td>
	</tr>
</table>

<?php
}
?>



