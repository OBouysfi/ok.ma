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
		"modules",
		$M_MODULES,
		$M_LINKS_NEWS_OTHERS,
		"red"
	 );
?>
</div>
<script>

function SubmitNewsForm()
{
	document.getElementById("post_html").value=
	$('#html').val();
	
	return true;
}
</script>
<div class="clear"></div>
<span class="medium-font" id="page-header"><?php echo $ADD_NEW_FAQ;?></span>
<br/><br/>

<?php

$_REQUEST["arrNames2"]=array("date");
$_REQUEST["arrValues2"]=array(time());

AddNewForm
(
		array($M_QUESTION.":",$M_ANSWER.":"),
		
		array("title","html"),

		array("textbox_60","textarea_120_10","combobox_YES_NO"),

		$AJOUTER,
		"faq",
		"The question has been added successfully!",
		false,
		array(),
		"SubmitNewsForm"
		
	);
?>









<?php

if(isset($_REQUEST["Delete"])&&isset($_REQUEST["CheckList"]))
{
	$database->SQLDelete("faq","id",$_REQUEST["CheckList"]);
}

?>

<br><br><br>
<span class="medium-font"><?php echo $LIST_FAQ;?></span>
		
<br>		
<br>
<?php

$arrTDSizes=array("100","50","150","*");


RenderTable
(
	"faq",
	array("date","EditNote","title","html"),
	array("Date",$MODIFY,$M_QUESTION,$M_ANSWER),
	650,
	"ORDER BY id DESC",
	$EFFACER,
	"id",
	"index.php"
);
?>


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
		$('#html').wysiwyg({
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

		$('#html').wysiwyg("insertHtml", "");
	});
})(jQuery);
</script>

