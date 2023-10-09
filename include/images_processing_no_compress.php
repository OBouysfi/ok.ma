<?php

if(!defined('IN_SCRIPT')) die("");

if(isset($_POST["list_images"])&&$_POST["list_images"]!="")
{
	$list_files=explode(",",$_POST["list_images"]);
	for($i=0;$i<sizeof($list_files);++$i)
	{
		$file_name=(isset($path)?$path:"")."uploads/".$list_files[$i];
		if(!file_exists($file_name)) continue;
		
		$size	= getimagesize($file_name);
		$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
		
		
		$mime_type="image/jpg";
		if($file_ext=="gif") $mime_type="image/gif";
		else
		if($file_ext=="png") $mime_type="image/png";
		
		
		$files[]=array
		(
			'name'    =>$file_name,
			'type'  => "",
			'tmp_name'=>$file_name,
			'mime' => $mime_type, 
			'size'  => getimagesize($file_name) 
		);
	}
}
else
if(!isset($_FILES[isset($input_field)?$input_field:'images']))
{

}
else
if(isset($_FILES))
{

	$files=array();
	$fdata=$_FILES[isset($input_field)?$input_field:'images'];
	
	
	if(is_array($fdata['name']))
	{
		for($i=0;$i<count($fdata['name']);++$i)
		{

			if(trim($fdata['name'][$i])==""||trim($fdata['tmp_name'][$i])=="") continue;
		
			$size	= getimagesize($fdata['tmp_name'][$i]);
			$mime	= $size['mime'];
			
			if (substr($mime, 0, 6) != 'image/') continue;


			$files[]=array
			(
				'name'    =>$fdata['name'][$i],
				'type'  => $fdata['type'][$i],
				'tmp_name'=>$fdata['tmp_name'][$i],
				'mime' => $mime, 
				'size'  => $fdata['size'][$i]  
			);
		}
	}else $files[]=$fdata;
}


if(isset($files))
{
	
	$is_first_image = true;
	
	foreach ($files as $file) 
	{ 
	
		if(trim($file['tmp_name'])=="") continue;
		
		$i_random=rand(200,100000000);

		$save_file_name = (isset($path)?$path:"")."backgrounds/" .$i_random.".jpg";
	
		$uploaded_file = $file['tmp_name'];
		
		if($uploaded_file == "") continue;
	

		move_uploaded_file($uploaded_file,$save_file_name);
	
		
		if($str_images_list!="")
		{
			$str_images_list.=",";
		}
		
		$str_images_list.=$i_random;
		
		$is_first_image = false;
	}
}


?>