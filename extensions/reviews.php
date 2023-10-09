<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
if(isset($_REQUEST["id"]))
{
	$id=$_REQUEST["id"];
}
else
{	
	die("The id was not set.");
}

$website->ms_i($id);

$company = $database->DataArray("employers","id=".$id." ");

$strLink = $website->company_link($company["id"],$company["company"]);

$website->Title(stripslashes($company["company"])." - ".$M_USER_OPINIONS);
$website->MetaDescription($website->text_words($M_USER_OPINIONS." - ".stripslashes(strip_tags($company["company_description"])),30));
$website->MetaKeywords($website->format_keywords($website->text_words($M_USER_OPINIONS." ".stripslashes(strip_tags($company["company_description"])),20)));

echo "<br/>".$M_GO_BACK_TO." <b><a class=\"underline-link\" href=\"".$strLink."\">".strip_tags(stripslashes($company["company"]))."</a></b>";


$strErrorSecCode="";
$showCommentsForm = true;


if(isset($_REQUEST["add_comment"]))
{
	$pos_http = strpos(strtolower($_POST["comment"]), "http");
	$pos_url = strpos(strtolower($_POST["comment"]), "url=");
	$pos_a = strpos(strtolower($_POST["comment"]), "<a ");
	$actual_length = strlen($_POST["comment"]);
	$stripped_length = strlen(strip_tags($_POST["comment"])); 


	if($actual_length != $stripped_length || $pos_http !== false || $pos_url !== false || $pos_a !== false)
	{
		$strErrorSecCode = " ";
	}
	
	else
	if($website->GetParam("USE_CAPTCHA_IMAGES") && ( ( md5(strtoupper($_POST['captcha_code'])) != $_SESSION['code'])|| trim($_POST['captcha_code']) == "" ) )
	{
		$strErrorSecCode = $M_WRONG_CODE;
	 }
	 else
	 if($database->SQLCount("company_reviews","WHERE ip='".$_SERVER["REMOTE_ADDR"]."' AND id=".$id)>0)
	 {
		$strErrorSecCode = $M_ALREADY_POSTED;
	 }
	 else
	 {
		$database->SQLInsert
		(
			"company_reviews",
			array("vote","ip","title","author","email","html","company_id","date","status"),
			array($_POST["rate_product"],$_SERVER["REMOTE_ADDR"],strip_tags($_POST["title"]),strip_tags($_POST["author"]),strip_tags($_POST["email"]),strip_tags($_POST["comment"]),$id,time(),"1")
		);
		
		$website->UpdateVendorRating($id);
						
		$showCommentsForm = false;
		echo "<br/><h3>".$M_YOUR_REVIEW_POSTED."</h3><br/>";
	 }
}
?>

<script>
var post_review = false;
function ShowPostForm()
{
	if(!post_review)
	{
		document.getElementById("post-review").style.display="block";
		post_review = true;
	}
	else
	{
		document.getElementById("post-review").style.display="none";
		post_review = false;
	}
}
</script>

<?php
if($showCommentsForm)
{
?>

<?php
if(!isset($_REQUEST["write"]))
{
?>
<a class="btn btn-green no-decoration pull-right" href="javascript:ShowPostForm()"><?php echo $M_POST_REVIEW;?></a>
<div class="clear"></div>

<?php
}
?>

<script>
function ValidateForm(x)
{

	if(x.author.value==""){
		alert("<?php echo $M_PLEASE_ENTER_NAME;?>");
		x.author.focus();
		return false;
	}
	
	
	if(x.email.value=="")
	{
		alert("<?php echo $M_PLEASE_ENTER_EMAIL;?>");
		x.email.focus();
		return false;
	}
	
	if(x.answer2.value=="")
	{
		alert("<?php echo $M_PLEASE_ENTER_ANSWER;?>");
		x.answer2.focus();
		return false;
	}
	
	if(x.title.value=="")
	{
		alert("<?php echo $M_PLEASE_ENTER_THE_TITLE;?>");
		x.title.focus();
		return false;
	}
	
	if(x.comment.value=="")
	{
		alert("<?php echo $M_PLEASE_ENTER_COMMENTS;?>");
		x.comment.focus();
		return false;
	}
	
	
	return true;
}
</script>

<div id="post-review" <?php if(!isset($_REQUEST["write"])&&$strErrorSecCode=="") echo 'style="display:none"';?>>
	
<?php
	$rate_product="";
	if(isset($_POST["rate_product"]))
	{
		$rate_product=$_POST["rate_product"];
	}
	
	echo '
	<br/>
	<h3>'.($strErrorSecCode!=""?$strErrorSecCode:$M_WRITE_A_REVIEW." ".$M_FOR." \"".strip_tags(stripslashes($company["company"]))."\"").'</h3>
	<br/>		
		<form  id="main" method="post" action="'.$website->get_file_prefix().'index.php"  onsubmit="return ValidateForm(this)">
		<input type=hidden name="id" value="'.$id.'">
		<input type="hidden" name="add_comment" value="1">
		<input type="hidden" name="mod" value="reviews">
			
						
			<fieldset>
				<legend>'.$M_REVIEW_DETAILS.'</legend>
				<ol>
				<li>
					<label for="rate_product">
					 '.$M_RATE_WEBSITE.'
					</label>
					<input type="radio" style="position:relative;top:7px" class="pull-left" value="5" '.($rate_product==""||$rate_product=="5"?"checked":"").' name="rate_product">
					<span class="pull-left" style="margin-right:15px">5</span>
					
					<input type="radio" style="position:relative;top:7px" class="pull-left" value="4" '.($rate_product=="4"?"checked":"").' name="rate_product">
					<span class="pull-left" style="margin-right:15px">4</span>
					
					<input type="radio" style="position:relative;top:7px" class="pull-left" value="3" '.($rate_product=="3"?"checked":"").' name="rate_product">
					<span class="pull-left" style="margin-right:15px">3</span>
					
					<input type="radio" style="position:relative;top:7px" class="pull-left" value="2" '.($rate_product=="2"?"checked":"").' name="rate_product">
					<span class="pull-left" style="margin-right:15px">2</span>
					
					<input type="radio" style="position:relative;top:7px" class="pull-left" value="1" '.($rate_product=="1"?"checked":"").' name="rate_product">
					<span class="pull-left" style="margin-right:15px">1</span>
					<div class="clear"></div>
				</li>
				<li>
					<label for="title">
					'.$M_REVIEW_TITLE.'
					</label>
					<input   id="title" name="title" value="'.(isset($_POST["title"])?$_POST["title"]:"").'" size="40" required/>
			
				</li>
				<li>
					<label for="comment">
					'.$M_COMMENTS.'
					</label>
					<textarea  id="comment" name="comment" rows="10" required cols="40">'.(isset($_POST["comment"])?$_POST["comment"]:"").'</textarea>
		
				</li>
				</ol>
			</fieldset>
			
			<fieldset>
				<legend>'.$M_Y_DETAILS.'</legend>
				<ol>
				<li>
					<label for="author">
					'.$M_NAME.'
					</label>
					<input   id="author" name="author" value="'.(isset($_POST["author"])?$_POST["author"]:"").'" size="40" required/>
				</li>
				
				<li>
					<label for="email">
					'.$M_EMAIL.'
					</label>
					<input  id="email" name="email" value="'.(isset($_POST["email"])?$_POST["email"]:"").'" size="40"/>
				</li>
				
			
			';
								
		
			if($website->GetParam("USE_CAPTCHA_IMAGES")==1)
			{
			?>
			<li>
				<label for="captcha_code">
				<img src="include/sec_image.php" width="100" height="30"/>
				</label>
				<input id="captcha_code" name="captcha_code" placeholder="<?php echo $M_PLEASE_ENTER_CODE;?>" type="text" required/>
			</li>
			<?php
			}
			?>
						
			</ol>
		</fieldset>
	<fieldset>
		<button type="submit"><?php echo $M_SEND;?></button>
	</fieldset>		

	<?php
	if($MULTI_LANGUAGE_SITE)
	{
	?>
	<input type="hidden" name="lang" value="<?php echo $website->lang;?>"/>
	<?php
	}
	?>
	
	</form>
	<br/>
</div>					
<div class="clear"></div>

<?php
}


//user opinions and reviews
echo "<br/><h3>".$M_USER_OPINIONS." ".$M_FOR." ".strip_tags(stripslashes($company["company"]))."</h3>
<br/>";

$tableComments = $database->DataTable("company_reviews","WHERE company_id=".$id." ORDER BY id DESC");

if($database->num_rows($tableComments) == 0)											
{
	echo "<br/><i>".$M_STILL_NO_REVIEWS."</i><br/><br/><br/><br/><br/><br/><br/>";
}

while($arrComment = $database->fetch_array($tableComments))
{
	echo show_stars($arrComment["vote"]);
	echo '<b style="position:relative;left:10px;top:-5px">'.strip_tags(stripslashes($arrComment["title"])).'</b>';
	echo "<br/>".$M_BY." <b>".$arrComment["author"]."</b>";
	echo ', '.date($website->GetParam("DATE_FORMAT"), $arrComment["date"]);
	echo '<hr style="margin:5px"/>';
	echo '
	
	'.strip_tags(stripslashes($arrComment["html"])).'
	';	
	
	
			
		
	echo '<br><br><br>';
}



?>

<?php

//end user opinions and reviews
$website->Title($M_REVIEWS);
$website->MetaDescription("");
$website->MetaKeywords("");
?>
