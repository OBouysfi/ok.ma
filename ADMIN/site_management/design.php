<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<div class="fright">
	<?php
	echo LinkTile
	 (
		"site_management",
		"manage",
		$M_GO_BACK,
		"",
		"red"
	 );
?>
</div>

<br>
<span class="medium-font" id="page-header">
<?php echo $MANAGEMENT_FORMS;?>
</span>
	
<br><br>


<?php

if(isset($_REQUEST["actionStep"]))
{
	$actionStep=$_REQUEST["actionStep"];
}

if(!isset($_REQUEST["lStep"])&&!isset($_REQUEST["actionStep"]))
{
	$lStep=1;
	$actionStep=-1;
}

if($actionStep==2)
{
	 $database->SQLInsert
	 ("forms",
	 array("name","description","code","submit","message","email"),
	 array($_REQUEST["FormName"],$_REQUEST["FormDescription"],$_REQUEST["FormCode"],$_REQUEST["FormSubmit"],$_REQUEST["FormMessage"],$_REQUEST["ReceiveEmail"])
	 );
	 
	$lStep=3;
}
else
if($actionStep==1){
	
	$lStep=2;
}
?>


<script>

var formCode = "";
var iCurrentXDimension=4;
var iCurrentYDimension=4;
var iX=1;
var iY=1;

function InsTT(){

	
	if(document.getElementById("T324dFHFD5").style.visibility=="hidden")
	{
		document.getElementById("T324dFHFD5").style.visibility="visible";
	}
	else
	{
		document.getElementById("T324dFHFD5").style.visibility="hidden";
		
	}
}

  function doFont(fName)
  {
    if(fName != '')
      document.execCommand('fontname', false, fName);
  }
  
  function doSize(fSize)
  {
    if(fSize != '')
      document.execCommand('fontsize', false, fSize);
  }
  
  
  function doBold()
  {
	document.execCommand('bold', false, null);
  }

  function doItalic()
  {
	document.execCommand('italic', false, null);
  }
  
  
  function doUnderline()
  {
	document.execCommand('underline', false, null);
  }
  
  
  function doRemoveFormat()
  {
	document.execCommand('RemoveFormat', false, null);
  }

  function selOn(ctrl)
  {
	ctrl.style.borderColor = '#000000';
	ctrl.style.backgroundColor = '#B5BED6';
	ctrl.style.cursor = 'hand';	
  }
  
  function selOff(ctrl)
  {
	ctrl.style.borderColor = '#efebde';  
	ctrl.style.backgroundColor = '#efebde';
  }
  
  function selDown(ctrl)
  {
	ctrl.style.backgroundColor = '#8492B5';
  }
  
  function selUp(ctrl)
  {
    ctrl.style.backgroundColor = '#B5BED6';
  }
    
	
function SubmitSave(){

	
	if(document.all)
	{
		toggleOffBorders();
	}

	if(strValidation == "")
	{
		document.getElementById("FormCode").value=document.getElementById("FormPreview").innerHTML+strHiddenFields;
	}
	else
	{
		document.getElementById("FormCode").value=strValidation + "~~~~~" + document.getElementById("FormPreview").innerHTML+strHiddenFields;
	}

	return true;
}

document.onkeydown=kdown;

function kdown(){
	//alert(event.keyCode);
	if(event.keyCode==46){
		//return false;
	}
}
function AddCheckboxGroup(){
	document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 id=fielditems name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddCheckboxGroup()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddCombobox(){
	document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 id=fielditems name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddCombobox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddRadiobuttonGroup(){
	document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 id=fielditems name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddRadioButtonGroup()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddTextarea()
{
  
  	if(document.all)
	{
		document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD>Cols:</td><td class=previewTD> <input type=text size=5 id=fieldcols name=fieldcols></td></tr><tr><td class=previewTD>Rows:</td><td class=previewTD> <input type=text size=5 id=fieldrows name=fieldrows></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl id=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextarea()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table><table style='position:absolute'><tr id=obl_tr style='visibility:hidden'><td  class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr></table>";
	}
	else
	{
		document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD>Cols:</td><td class=previewTD> <input type=text size=5 id=fieldcols name=fieldcols></td></tr><tr><td class=previewTD>Rows:</td><td class=previewTD> <input type=text size=5 id=fieldrows name=fieldrows></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl id=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextarea()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table><table style='position:absolute'><tr id=obl_tr style='visibility:hidden'><td  class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr></table>";
	}
}

function AddTextBox(){

	
	if(false)
	{
		document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TAILLE;?>:</td><td class=previewTD> <select id=fieldSize name=fieldSize><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option></select></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr id=obl_tr style='visibility:hidden'><td colspan=2 class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextBox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
	}
	else
	{
		document.getElementById("ElementPreview").innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input id=fieldName name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TAILLE;?>:</td><td class=previewTD> <select id=fieldSize name=fieldSize><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option></select></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl id=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextBox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>   <table style='position:absolute'><tr id=obl_tr style='visibility:hidden'><td  class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr></table>";
	}
}

function OblChecked(x)
{

	if(x.checked)
	{
		document.getElementById("obl_tr").style.visibility = "hidden";
	}
	else
	{
		document.getElementById("obl_tr").style.visibility = "visible";
	}
}

var strHiddenFields="";
var strValidation="";


function RealAddCheckboxGroup(){

if(document.getElementById("fieldName").value=="")
{
	document.getElementById("page-header").innerHTML = "<?php echo $FORM_NAME_EMPTY;?>";

	return;
}

var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.getElementById("fielditems").value.split("\n");
	

	var comboHTML="";
	
	for(i=0;i<arrCombo.length;i++){
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<input type=checkbox name=field_"+iRandom+" value=\""+arrCombo[i]+"\"> "+arrCombo[i];
		
		
	}
	
	comboHTML+="";
	
	document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.getElementById("fieldName").value+": </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.getElementById("fieldName").value+"\">";
	
	toggleBorders();
	
	document.getElementById("ElementPreview").innerHTML="";
}





function RealAddRadioButtonGroup(){

if(document.getElementById("fieldName").value==""){

document.getElementById("page-header").innerHTML = "<?php echo $NAME_EMPTY;?>";


	return;
}

var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.getElementById("fielditems").value.split("\n");
	
	var comboHTML="";
	
	for(i=0;i<arrCombo.length;i++)
	{
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<input "+(i==0?"checked":"")+" type=radio name=field_"+iRandom+" value=\""+arrCombo[i]+"\"> "+arrCombo[i];
		
		
	}
	
	comboHTML+="";
	
	document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.getElementById("fieldName").value+": </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.getElementById("fieldName").value+"\">";
	
	toggleBorders();
	
	document.getElementById("ElementPreview").innerHTML="";
}

function RealAddCombobox(){

if(document.getElementById("fieldName").value=="")
{
	document.getElementById("page-header").innerHTML = "<?php echo $NAME_EMPTY;?>";


	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.getElementById("fielditems").value.split("\n");
	
	var comboHTML="<select name=field_"+iRandom+">";
	
	for(i=0;i<arrCombo.length;i++){
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<option>"+arrCombo[i]+"</option>";
		
	}
	
	comboHTML+="</select>";
	
	document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.getElementById("fieldName").value+": </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.getElementById("fieldName").value+"\">";
	
	toggleBorders();
	
	document.getElementById("ElementPreview").innerHTML="";
}

function RealAddTextarea(){

if(document.getElementById("fieldName").value==""){
	
document.getElementById("page-header").innerHTML = "<?php echo $NAME_EMPTY;?>";
	
	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.getElementById("fieldName").value+": </td><td>"+"<textarea name=field_"+iRandom+" cols="+document.getElementById("fieldcols").value+" rows="+document.getElementById("fieldrows").value+"></textarea>"+"</td></tr>"
	+"<!--###-->");;
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.getElementById("fieldName").value+"\">";
	
	
	if(document.getElementById("obl").checked)
	{
		strValidation += "if(x.field_"+iRandom+" && x.field_"+iRandom+".value=='')\n {\nalert(\""+document.getElementById("obl_message").value+"\");\nx.field_"+iRandom+".focus();\nreturn false;}\n";
	}
	
	if(document.all)
	{
		toggleBorders();
	}
	
	document.getElementById("ElementPreview").innerHTML="";
}


var toggle="off";
	function toggleBorders(){

	
		if(document.all)
		{
						var allForms = document.getElementById("FormPreview").getElementsByTagName("FORM");
						var allInputs =document.getElementById("FormPreview").getElementsByTagName("INPUT");
						var allTables = document.getElementById("FormPreview").getElementsByTagName("TABLE");
						var allLinks = document.getElementById("FormPreview").getElementsByTagName("A");
			}
		else
		{
						var allForms = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("FORM");
						var allInputs =document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("INPUT");
						var allTables = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("TABLE");
						var allLinks = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("A");
						
		}


		for (a=0; a < allForms.length; a++) {
			if (toggle == "off") {
				allForms[a].style.border = "1px dotted #FF0000"
			} else {
				allForms[a].style.cssText = ""
			}
		}

				// Do tables
		for (i=0; i < allTables.length; i++) {

		allTables[i].contentEditable = "true"
				if (toggle == "off") {
					allTables[i].style.border = "1px dotted #BFBFBF"

				} else {
					allTables[i].style.cssText = ""
				}

				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {

								allCellsInRow[x].style.border = "1px dotted #BFBFBF"

							} else {
								allCellsInRow[x].style.cssText = ""
							}
						}
				}
		}

		// Do anchors
		for (a=0; a < allLinks.length; a++) {
			if (toggle == "off") {
				if (allLinks[a].href.toUpperCase() == "") {
					allLinks[a].style.width = "20px"
					allLinks[a].style.height = "20px"
					allLinks[a].style.textIndent  = "20px"
					allLinks[a].style.backgroundRepeat  = "no-repeat"
					allLinks[a].style.backgroundImage = "url(" + HTTPStr + "://" + URL + pathToImages + "/anchor.gif)"
				}
			} else {
				allLinks[a].style.cssText = ""
			}
		}



	}

		function toggleOffBorders(){

		if(document.all)
		{
						var allForms = document.getElementById("FormPreview").getElementsByTagName("FORM");
						var allInputs =document.getElementById("FormPreview").getElementsByTagName("INPUT");
						var allTables = document.getElementById("FormPreview").getElementsByTagName("TABLE");
						var allLinks = document.getElementById("FormPreview").getElementsByTagName("A");
			}
		else
		{
						var allForms = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("FORM");
						var allInputs =document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("INPUT");
						var allTables = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("TABLE");
						var allLinks = document.getElementById('FormPreview').contentWindow.document.body.getElementsByTagName("A");
						
		}


		// Do forms
		for (a=0; a < allForms.length; a++) {
			if (toggle == "off") {
				allForms[a].style.border = ""
			} else {
				allForms[a].style.cssText = ""
			}
		}

				// Do tables
		for (i=0; i < allTables.length; i++) {

		allTables[i].contentEditable = "true"
				if (toggle == "off") {
					allTables[i].style.border = ""

				} else {
					allTables[i].style.cssText = ""
				}

				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {

								allCellsInRow[x].style.border = ""

							} else {
								allCellsInRow[x].style.cssText = ""
							}
						}
				}
		}

		// Do anchors
		for (a=0; a < allLinks.length; a++) {
			if (toggle == "off") {
				if (allLinks[a].href.toUpperCase() == "") {
					allLinks[a].style.width = "20px"
					allLinks[a].style.height = "20px"
					allLinks[a].style.textIndent  = "20px"
					allLinks[a].style.backgroundRepeat  = "no-repeat"
					allLinks[a].style.backgroundImage = "url(" + HTTPStr + "://" + URL + pathToImages + "/anchor.gif)"
				}
			} else {
				allLinks[a].style.cssText = ""
			}
		}



	}

	
function RealAddTextBox(){

if(document.getElementById("fieldName").value==""){
	
document.getElementById("page-header").innerHTML = "<?php echo $NAME_EMPTY;?>";
	
	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("<!--###-->",""
	
	
	+
	"<tr ><td>"
	+
	document.getElementById("fieldName").value+": </td><td>"+"<input type=text  name=field_"+iRandom+" size="+document.getElementById("fieldSize").options[document.getElementById("fieldSize").selectedIndex].text+"></td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.getElementById("fieldName").value+"\">";
	
	if(document.getElementById("obl").checked)
	{
		strValidation += "if(x.field_"+iRandom+" && x.field_"+iRandom+".value=='')\n {\nalert(\""+document.getElementById("obl_message").value+"\");\nx.field_"+iRandom+".focus();\nreturn false;}\n";
	}
	
	if(document.all)
	{
		toggleBorders();
	}
	
	document.getElementById("ElementPreview").innerHTML="";
}

	function showColor(oBox,oColor) {
	
		oBox.innerHTML = oColor.style.backgroundColor.toUpperCase();
		oBox.style.backgroundColor = oColor.style.backgroundColor
}

	function doColor(oColor) {
			document.execCommand('ForeColor',false,oColor.innerHTML);
	}
	
	function doForeCol()
  {
    if(document.getElementById("colorMenu").style.display=="none"){
		document.getElementById("colorMenu").style.display="block";
		strLand="ForeColor";
	}
	else{
		document.getElementById("colorMenu").style.display="none";
	}
  }

  function getTableContent(x,y,cx,cy){

	
	if(x==(cx+1)){
		x=x+1;
		iCurrentXDimension=x;
	}
	
	if(y==(cy+1)){
		y=y+1;
		iCurrentYDimension=y;
	}
	
	
	var strResult="";
	
	strResult+="<table cellpading=0 cellspacing=0 >";
	
	for(i=0;i<x;i++){
		
		strResult+="<tr>";
		
		for(j=0;j<y;j++){
			strResult+="<td id=td"+i+""+j+"  onclick=tdOver("+i+","+j+") width=20 height=20 class=mainTD123 "+((i<=cx&&j<=cy)?"bgclass=hl_text":"bgcolor=white")+">&nbsp;</td>";
		}	
		
		strResult+="</tr>";
		
	}
	
	
	strResult+="</table>";
	
	return strResult;
}

function tdOver(x,y){

	document.getElementById("labelTD").innerHTML="<a href=javascript:InsT() class=labelTD123>"+(x+1)+" by "+(y+1)+" Table</a>";
	iX=x+1;
	iY=y+1;
	
	getElementById("DynamicTable").innerHTML=getTableContent(iCurrentXDimension,iCurrentYDimension,x,y);
}


function InsT(){

	
	
	var strResult="<table>";
	
	for(i=0;i<iX;i++){
		
		strResult+="<tr>";
		
		for(j=0;j<iY;j++){
			strResult+="<td>&nbsp;&nbsp;</td>";	
		}
		
		strResult+="</tr>";
		
	}
	 
	strResult+="</table>";
	
	
		var sText = document.selection.createRange();
	
	if(sText.parentElement().tagName=="BODY"){
		return;
	}
	
if (!sText==""){
    		
	if(sText.text!=""){
	
		sText.text="@@@@@@@";
		
	}
	else{
			sText.text="@@@@@@@";
	}
  }
  else{
  	  alert("Please select some text!");
  }   

   document.getElementById("FormPreview").innerHTML=document.getElementById("FormPreview").innerHTML.replace("@@@@@@@",strResult);
	
	toggleBorders();
	document.getElementById("T324dFHFD5").style.visibility="hidden";
}

var toggle="off";

function toggleBorders(){

var allTables = document.getElementById("FormPreview").getElementsByTagName("TABLE");

for (i=0; i < allTables.length; i++) {

		allTables[i].contentEditable = "true"
				if (toggle == "off") {
					allTables[i].runtimeStyle.border = "1px dotted #BFBFBF"

				} else {
					allTables[i].runtimeStyle.cssText = ""
				}

				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {

								allCellsInRow[x].runtimeStyle.border = "1px dotted #BFBFBF"

							} else {
								allCellsInRow[x].runtimeStyle.cssText = ""
							}
						}
				}
		}

}
</script>

<style>
.mainTD123{border-style:solid;border-color:#777777;border-width:0px 1px 1px 0px;}
.labelTD123{font-family:Verdana;color:#777777;font-size:11;text-decoration:none}
.leftBorder{border-style:solid;border-color:#777777;border-width:1px 1px 1px 1px}
</style>

<div id=T324dFHFD5 class="leftBorder"   style="text-align:center;position:absolute;visibility:hidden;top:65;left:685;height:100;background:#eeeeee" >
	<div id=DynamicTable  style="width:90px"><script>document.write(getTableContent(4,4,0,0));</script></div>
	<table  cellpading=0 cellspacing=0  height=20 ><tr><td class=labelTD123 id=labelTD align=center><a href=javascript:InsT() class=labelTD>1 x 1 Table</a></td></tr></table>
</div>

	<DIV id=colorMenu style="DISPLAY: none;position:absolute;top:70px;left:497px">
      <TABLE
      style="BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; FONT-SIZE: 7px; BORDER-LEFT: buttonhighlight 1px solid; CURSOR: hand; BORDER-BOTTOM: buttonshadow 1px solid; FONT-FAMILY: Verdana"
      borderColor=#666666 cellSpacing=5 cellPadding=1 bgColor="gray"
      border=1 width=435>
        <TBODY>
        <TR>
          <TD id=color
          style="FONT-SIZE: 12px; FONT-FAMILY: verdana; HEIGHT: 20px"
            colSpan=20>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ff0000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ffff00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #00ff00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #00ffff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #0000ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ff00ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ffffff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #f5f5f5"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #dcdcdc"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #fffafa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #d3d3d3"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #c0c0c0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #a9a9a9"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #808080"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #696969"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #000000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #2f4f4f"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #708090"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #778899"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #4682b4"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #4169e1"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #6495ed"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #b0c4de"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #7b68ee"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #6a5acd"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #483d8b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #191970"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #000080"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00008b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #0000cd"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #1e90ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00bfff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #87cefa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #87ceeb"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #add8e6"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #b0e0e6"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f0ffff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #e0ffff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #afeeee"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00ced1"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #5f9ea0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #48d1cc"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00ffff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #40e0d0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #20b2aa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #008b8b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #008080"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #7fffd4"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #66cdaa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #8fbc8f"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #3cb371"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #2e8b57"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #006400"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #008000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #228b22"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #32cd32"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00ff00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #7fff00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #7cfc00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #adff2f"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #98fb98"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #90ee90"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00ff7f"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #00fa9a"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #556b2f"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #6b8e23"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #808000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #bdb76b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #b8860b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #daa520"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffd700"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f0e68c"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #eee8aa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffebcd"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffe4b5"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f5deb3"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffdead"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #deb887"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #d2b48c"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #bc8f8f"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #a0522d"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #8b4513"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #d2691e"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #cd853f"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f4a460"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #8b0000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #800000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #a52a2a"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #b22222"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #cd5c5c"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f08080"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fa8072"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #e9967a"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffa07a"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff7f50"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff6347"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff8c00"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffa500"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff4500"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #dc143c"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff0000"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff1493"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff00ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ff69b4"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffb6c1"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffc0cb"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #db7093"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #c71585"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #800080"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #8b008b"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #9370db"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #8a2be2"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #4b0082"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #9400d3"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #9932cc"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ba55d3"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #da70d6"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ee82ee"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #dda0dd"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #d8bfd8"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #e6e6fa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f8f8ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f0f8ff"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f5fffa"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #f0fff0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fafad2"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fffacd"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fff8dc"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffffe0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fffff0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fffaf0"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #faf0e6"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fdf5e6"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #faebd7"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffe4c4"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffdab9"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffefd5"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fff5ee"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #fff0f5"
          onmousedown=doColor(color)>&nbsp;</TD>
          <TD onmouseover=showColor(color,this)
          style="BACKGROUND-COLOR: #ffe4e1"
          onmousedown=doColor(color)>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(color,this)
          style="FONT-SIZE: 10px; FONT-FAMILY: verdana; HEIGHT: 15px"
          onmousedown=doColor(color) colSpan=20>&nbsp;None</TD></TR></TBODY>
	  </TABLE>
	  </DIV>

<table summary="" border="0" width=750>
  	<tr>
  		<td class=basictext>

<?php
if($lStep==1){
?>
<i><font class=hl_text>
<?php echo $PLEASE_CHOOSE_A_NAME;?>
</font></i>
<br><br>
<?php

?>
<form action="index.php" method=post onsubmit="return ValidateStep1(this)">
<input type="hidden" name="actionStep" value="1">
<input type="hidden" name="category" value="<?php echo $category;?>">
<input type="hidden" name="action" value="<?php echo $action;?>">
<?php echo $NOM;?>: <input type=text name="FormName" size="40"/>
<br><br>
<?php echo $DESCRIPTION;?>:
<br>
<textarea name=FormDescription rows="5" cols="50"></textarea>
<br><br>

<input type=submit class=adminButton value=" <?php echo $NEXT_MESSAGE;?> >> ">
	


</form>


<?php
}
if($lStep==2){

$FormName=$_REQUEST["FormName"];
$FormDescription=$_REQUEST["FormDescription"];
?>
<b><?php echo $SELECTED_NAME;?></b>: <font class=hl_text><?php echo $FormName;?></font>
<br><br><br>
<i><font class=hl_text><?php echo $PLEASE_ADD_THE_FORM_ELEMENTS;?></font></i>
<br><br>

<table border="0" width="947" cellpadding="0" cellspacing="0">
	<tr>
		<td align=right>
		
		
			<table summary="" border="0" cellpadding="2" cellspacing="0" height=22 width=400 bgcolor=#efebde style="position:relative;left:-25px;border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px">
		  		<tr>
		  			<td>
  &nbsp;
						<img  WIDTH=23 HEIGHT=22 alt="Bold" class="butClass" src="images/bold.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBold()">
						<img WIDTH=23 HEIGHT=22  alt="Italic" class="butClass" src="images/italic.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doItalic()">
						<img  WIDTH=23 HEIGHT=22 alt="Underline" class="butClass" src="images/underline.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doUnderline()">
						<img WIDTH=21 HEIGHT=20  alt="Remove Text Formatting" class="butClass" src="images/button_remove_format.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRemoveFormat()">
						<img  WIDTH=23 HEIGHT=22 alt="Text Color" class="butClass" src="images/forecol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doForeCol()">
			
						
					&nbsp;
					  <select name="selFont" onChange="doFont(this.options[this.selectedIndex].value)">
		    <option value="">Font</option>
		    <option value="Arial">Arial</option>
			<option value="Comic Sans MS">Comic Sans</option>
		    <option value="Courier">Courier</option>
		    <option value="Sans Serif">Sans Serif</option>
		    <option value="Tahoma">Tahoma</option>
		    <option value="Verdana">Verdana</option>
		    <option value="Wingdings">Wingdings</option>
		  </select>
		  <select name="selSize" onChange="doSize(this.options[this.selectedIndex].value)">
		    <option value="">Size</option>
		    <option value="1">1</option>
		    <option value="2">2</option>
		    <option value="3">3</option>
		    <option value="4">4</option>
		    <option value="5">5</option>
		    <option value="6">6</option>
			<option value="7">7</option>
		  </select>
	
						
						
						
						</td>
						
						
		  		</tr>
		  </table>
		  
		

		</td>
	</tr>
</table>



<table summary="" border="0">
	<tr>
		<td width=200 valign=top>

   
<table summary="" border="0">


<tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_textbox2.gif" border="0" width="22" height="20" alt="">
<a href="javascript:AddTextBox()" >
<?php echo $ADD_TEXTBOX;?>
</a>
		</td>
	</tr>
	
	
	<tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_textarea2.gif" border="0" width="21" height="20" alt="">
<a href="javascript:AddTextarea()" >
<?php echo $ADD_TEXTAREA;?>
</a>
		</td>
			</tr>
	
	
	<tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_combobox2.gif" border="0" width="21" height="20" alt="">
<a href="javascript:AddCombobox()" >
<?php echo $ADD_COMBOBOX;?>
</a>
		</td>
			</tr>
	
	<tr height=30>
		<td class=basictext style='color:black;'>
		
<img align=left src="images/form_radiobutton2.gif" border="0" width="20" height="20" alt="">
<a href="javascript:AddRadiobuttonGroup()" >
<?php echo $ADD_RADIOBUTTON;?>
</a>
		</td>
			</tr>
	

	<tr height=30>
	
		<td class=basictext style='color:black;'>
		
<img align=left src="images/form_checkbox2.gif" border="0" width="22" height="20" alt="">
<a href="javascript:AddCheckboxGroup()" >
<?php echo $ADD_CHECKBOX;?>
</a>
		</td>
		</tr>
	
</table>

</td>
<td width=300 >
				
				
			<div id="ElementPreview" style="color:#ff6500;padding-left:5px;padding-top:5px;font-family:Verdana;background:#efefef;width:300px;height:300px;border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px">

			</div>


		</td>
		<td width=400 >
				
				
				<div id="FormPreview" style="padding-left:5px;padding-top:5px;font-family:Verdana;font-size:11;background:#efefef;width:400px;height:300px;border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px" contenteditable="true">
				<table ><!--###--></table>

				</div>


		</td>
	</tr>
</table>

<br>
<form action="index.php" method=post onsubmit="return SubmitSave()">
<input type=hidden name=actionStep value="2">
<input type=hidden name=FormName value="<?php echo $FormName;?>">
<input type=hidden name=FormDescription value="<?php echo $FormDescription;?>">


<table summary="" border="0">
	<tr>
		<td><b><?php echo $SUBMIT_BTN;?>:</b></td>
		<td> <input type=text name="FormSubmit" size=32 value="<?php echo $ENVOYER;?>"></td>
	</tr>
	<tr>
		<td><b><?php echo $EMAIL_RECEIVE;?>(*):</b></td>
		<td><input type=text name="ReceiveEmail" size=32 >
		
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<br>
				<b><?php echo $MSG_DISPLAYED;?>:</b>
				<br>
				 <textarea cols=47 rows=6 name="FormMessage"><?php echo $X10;?><?php echo $THE_DATA_YOU_JUST;?></textarea>
		
		
		</td>
		
	</tr>
	
</table>
<br>
		(*)<?php echo $EMAIL_RECEIVE_EMPTY;?>
<br>


<br>
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=action value="<?php echo $action;?>">
<input type=hidden name="FormCode" id="FormCode">

<input type=submit class=adminButton value=" <?php echo $NEXT_MESSAGE;?> >> " >
</form>





<?php
}
if($lStep==3){
?>

<span class="medium-font">
<?php echo $CNGR_THE_NEW_FORM;?>
<br><br> 
<a href="index.php?category=site_management&action=manage">
<?php echo $PUBLISH_THE_FORM;?>
</a>
</span>
<br>


<br><br><br>
<i><?php echo $FORM_NAME;?>:</i> <font class=hl_text><?php echo $_REQUEST["FormName"];?></font>
<br><br>
<i><?php echo $FORM_DESCRIPTION;?>:</i> <font class=hl_text><?php echo $_REQUEST["FormDescription"];?></font>
<br><br>

<i><?php echo $EMAIL;?>:</i> <font class=hl_text><?php if($_REQUEST["ReceiveEmail"]=="") echo "[no email defined]";else echo $_REQUEST["ReceivedEmail"];?></font>
<br><br>



<?php
}
?>

		</td>
  	</tr>
  </table>
  




