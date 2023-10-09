<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");

$language_version = $LoginInfo["bo_lang"];


	
if(isset($_REQUEST["ProceedChangeLanguage"]))
{
	$language_version=strtolower($_REQUEST["ProceedChangeLanguage"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}
else
{
	$language_version = strtolower($LoginInfo["bo_lang"]);
	
}


if($language_version == "")
{
	$default_language = $database->DataArray("languages","default_language=1");
	$language_version = strtolower($default_language["code"]);
	
	$database->SQLUpdate_SingleValue
	(
		"admin_users",
		"username",
		"'".$AuthUserName."'",
		"bo_lang",
		$language_version
	);
}	
?>
<script>
function SavePage()
{
	document.getElementById("post_html_<?php echo $language_version;?>").value=
	$('#html_<?php echo $language_version;?>').val();
	document.getElementById("EditForm").submit();
}
</script>

<div class="fright">

	<?php

	
	echo LinkTile
		 (
			"",
			"",
			$M_SAVE,
			"",
			
			"blue",
			"small",
			"true",
			"SavePage"
		 );
				 
			echo LinkTile
				 (
					"site_management",
					"pages_pro",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>
<br>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);


$SubmitButtonText=$M_SAVE;	
AddEditForm
(
	array(""),
	array("html_".$language_version),
	array(),
	array("textarea_120_25"),
	"pages",
	"id",
	$id,
	$M_NEW_VALUES_SAVED,
	"",
	120,
	true
);
	
?>
<br>



<!--[if lt IE 8]><link rel="stylesheet" href="wysiwyg/ie.css" type="text/css" media="screen, projection" /><![endif]-->
<link rel="stylesheet" href="wysiwyg/jquery.wysiwyg.css" type="text/css"/>
<script type="text/javascript" src="wysiwyg/jquery.js"></script>
<script type="text/javascript" src="wysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="wysiwyg/wysiwyg.table.js"></script>
<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		$('#html_<?php echo $language_version;?>').wysiwyg({
		  controls: {
			bold          : { visible : true },
			italic        : { visible : true },
			underline     : { visible : true },
			strikeThrough : { visible : true },
			
			justifyLeft   : { visible : true },
			justifyCenter : { visible : true },
			justifyRight  : { visible : true },
			justifyFull   : { visible : true },

			indent  : { visible : true },
			outdent : { visible : true },

			undo : { visible : true },
			redo : { visible : true },
			
			insertOrderedList    : { visible : true },
			insertUnorderedList  : { visible : true },
			insertHorizontalRule : { visible : true },

			h4: {
				visible: true,
				className: 'h4',
				command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
				arguments: ($.browser.msie || $.browser.safari) ? '<h4>' : 'h4',
				tags: ['h4'],
				tooltip: 'Header 4'
			},
			h5: {
				visible: true,
				className: 'h5',
				command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
				arguments: ($.browser.msie || $.browser.safari) ? '<h5>' : 'h5',
				tags: ['h5'],
				tooltip: 'Header 5'
			},
			h6: {
				visible: true,
				className: 'h6',
				command: ($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
				arguments: ($.browser.msie || $.browser.safari) ? '<h6>' : 'h6',
				tags: ['h6'],
				tooltip: 'Header 6'
			},
			
			cut   : { visible : true },
			copy  : { visible : true },
			paste : { visible : true },
			html  : { visible: true },
			increaseFontSize : { visible : true },
			decreaseFontSize : { visible : true },
			exam_html: {
				exec: function() {
					this.insertHtml('<abbr title="exam">Jam</abbr>');
					return true;
				},
				visible: true
			}
		  },
		  events: {
			click: function(event) {
				if ($("#click-inform:checked").length > 0) {
					event.preventDefault();
					alert("You have clicked jWysiwyg content!");
				}
			}
		  }
		});
$('#html_<?php echo $language_version;?>').wysiwyg("insertHtml", "");
	});
})(jQuery);


function fileSelected()
{

	document.getElementById("file_loading").style.display="block";
	document.getElementById("file_upload_form").submit();
	
}

function UploadSuccess(x)
{
	if(x!="")
	{
		document.getElementById("file_loading").style.display="none";
		
		var img_url="../uploaded_images/"+x+".jpg";
		$("#id_src").val(img_url);
		$("#id_src").trigger("change");
	}
	
}
</script>

