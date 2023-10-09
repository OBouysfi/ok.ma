<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
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
					"faq_manager",
					"home",
					$M_GO_BACK,
					"",
					
					"red"
				 );
		?>
</div>
<div class="clear"></div>
<script>

function SubmitNewsForm(x)
{
	document.getElementById("post_html").value=
	$('#html').val();
	
	return true;
}
</script>
<br>
<?php
$id=$_REQUEST["id"];
$website->ms_i($id);
$SubmitButtonText = $M_SAVE;

AddEditForm
(
	array($M_QUESTION.":",$M_ANSWER.":"),
	array("title","html"),
	array(),
	array("textbox_60","textarea_112_15"),
	"faq",
	"id",
	$id,
	$M_NEW_VALUES_SAVED,
	"SubmitNewsForm"
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
