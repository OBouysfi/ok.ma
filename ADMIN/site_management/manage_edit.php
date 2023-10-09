<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php

if(isset($ProceedSave))
{
	//die($FormCode);
	SQLUpdate
	(
		"forms",
		array("code"),
		array($FormCode),
		"id=".$id
	);
	 
}

$arrForm = DataArray("forms","id=$id");
?>
<script>
var strHiddenFields="";
var strValidation="";
</script>

<?php
				$arrFormItems = explode("~~~~~", $arrForm["code"]);
				
				$strCodeToDisplay = "";
				
				if(sizeof($arrFormItems) == 2)
				{
					$strCodeToDisplay =  stripslashes($arrFormItems[1]);
					
					echo "
					<div style='display:none'>
					<textarea id=\"PreviousValidation\" >".stripslashes(trim($arrFormItems[0]))."</textarea>
					</div>		
					";
					
					/*
					<script>\n
						var strValidation = \"\";
					\n</script>
					*/
					
				}
				else
				{
					$strCodeToDisplay =  stripslashes($arrForm["code"]);
				}
				
				$arrFormItems2 = explode("<input type=hidden",$strCodeToDisplay,2);
				
				$arrFormItems2[1] =  "<input type=hidden" . $arrFormItems2[1];
				
				
				echo "
					
					<script>\n
						strHiddenFields= \"".addslashes(trim($arrFormItems2[1]))."\";
					\n</script>
				
					";
					
				?>
				
<table summary="" border="0" width=750>
	<tr>
		<td width=32>
		
		<img src="images/icons<?php echo $DN;?>/tools.gif" width="45" height="43" alt="" border="0">
		
		</td>
		<td class=basictext><b><?php echo $MODIFY_ELEMENTS;?></b></td>
	</tr>
</table>
<br>
<style>
.previewTD{font-family:verdana;font-size:11;color:#ff6500}
.td{font-family:verdana;font-size:11;}
</style>

<?php

/*
if(!isset($lStep)&&!isset($actionStep)){
	$lStep=1;
	$actionStep=-1;
}

if($actionStep==2){


	 SQLInsert("forms",array("name","description","code","submit","message","email"),array($FormName,$FormDescription,$FormCode,$FormSubmit,$FormMessage,$ReceiveEmail));
	 
	$lStep=3;
}
else
if($actionStep==1){
	
	$lStep=2;
}
*/
?>


<script>

var formCode = "";
var iCurrentXDimension=4;
var iCurrentYDimension=4;
var iX=1;
var iY=1;

function InsTT(){

	
	if(T324dFHFD5.style.visibility=="hidden"){
		T324dFHFD5.style.visibility="visible";
	}
	else{
		T324dFHFD5.style.visibility="hidden";
		
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
    
	
function SubmitSave()
{

	//alert(strValidation);
	//return false;
	
	//alert(""+document.all.FormPreview.innerHTML+strHiddenFields);
	if(document.all)
	{
		toggleOffBorders();
	}
	
	
	strValidation = document.getElementById("PreviousValidation").value + strValidation;
	
	if(strValidation == "")
	{
		document.all.FormCode.value=document.all.FormPreview.innerHTML+strHiddenFields;
	}
	else
	{
		document.all.FormCode.value=strValidation + "~~~~~" + document.all.FormPreview.innerHTML+strHiddenFields;
	}

	//alert(document.all.FormCode.value);
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
	ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddCheckboxGroup()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddCombobox(){
	ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddCombobox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddRadiobuttonGroup(){
	ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD>Items:</td><td class=previewTD>(<?php echo $ONE_PER_LINE;?>)</td></tr><tr><td class=previewTD></td><td class=previewTD> <textarea cols=15 rows=10 name=fielditems></textarea> </td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddRadioButtonGroup()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddTextarea(){
	ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD>Cols:</td><td class=previewTD> <input type=text size=5 name=fieldcols></td></tr><tr><td class=previewTD>Rows:</td><td class=previewTD> <input type=text size=5 name=fieldrows></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextarea()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
}

function AddTextBox(){
//alert(""+strHiddenFields);
	if(document.all)
	{
		ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TAILLE;?>:</td><td class=previewTD> <select name=fieldSize><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option></select></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr id=obl_tr style='display:none'><td colspan=2 class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextBox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>";
	}
	else
	{
		ElementPreview.innerHTML="<table width=180><tr><td class=previewTD><?php echo $NOM;?>:</td><td class=previewTD> <input name=fieldName type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TEXT_MESSAGE;?>:</td><td class=previewTD> <input name=fieldText type=textbox size=15></td></tr><tr><td class=previewTD><?php echo $TAILLE;?>:</td><td class=previewTD> <select name=fieldSize><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option></select></td></tr><tr><td class=previewTD>Obligatory:</td><td><input type=checkbox name=obl id=obl onmousedown='javascript:OblChecked(this)'></td></tr><tr><td class=previewTD>&nbsp;</td><td class=previewTD align=right><br><input onclick=\"javascript:RealAddTextBox()\" type=button class=adminButton value=\" <?php echo $AJOUTER;?> >>\"></td></tr></table>   <table ><tr id=obl_tr style='display:none'><td  class=previewTD>Message:<br><textarea cols=20 rows=3 id=obl_message></textarea></td></tr></table>";
	}
}

function OblChecked(x)
{
	
	if(x.checked)
	{
		document.getElementById("obl_tr").style.display = "none";
	}
	else
	{
		document.getElementById("obl_tr").style.display = "block";
	}
}




function RealAddCheckboxGroup(){

if(document.all.fieldName.value==""){
	//alert("<?php echo $FORM_NAME_EMPTY;?>");
	<?php
	echo 'HT("2","'.$FORM_NAME_EMPTY.'<br>",700,230,0.5,20);';
	?>
	return;
}

var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.all.fielditems.value.split("\n");
	

	var comboHTML="";
	
	for(i=0;i<arrCombo.length;i++){
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<input type=checkbox name=field_"+iRandom+" value=\""+arrCombo[i]+"\"> "+arrCombo[i];
		
		
	}
	
	comboHTML+="";
	
	FormPreview.innerHTML=FormPreview.innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.all.fieldText.value+" </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.all.fieldName.value+"\">";
	
	if(document.all)
	{
		toggleBorders();
	}
	
	ElementPreview.innerHTML="";
}





function RealAddRadioButtonGroup(){

if(document.all.fieldName.value==""){

	<?php
	echo 'HT("2","'.$NAME_EMPTY.'<br>",700,130,0.5,20);';
	?>
	return;
}

var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.all.fielditems.value.split("\n");
	
	var comboHTML="";
	
	for(i=0;i<arrCombo.length;i++){
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<input type=radio name=field_"+iRandom+" value=\""+arrCombo[i]+"\"> "+arrCombo[i];
		
		
	}
	
	comboHTML+="";
	
	FormPreview.innerHTML=FormPreview.innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.all.fieldText.value+" </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.all.fieldName.value+"\">";
	
	if(document.all)
	{
		toggleBorders();
	}
	
	ElementPreview.innerHTML="";
}

function RealAddCombobox(){

if(document.all.fieldName.value==""){
	//alert("The name can not be empty!");
	<?php
	echo 'HT("2","'.$NAME_EMPTY.'<br>",700,130,0.5,20);';
	?>
	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	var arrCombo=document.all.fielditems.value.split("\n");
	
	var comboHTML="<select name=field_"+iRandom+">";
	
	for(i=0;i<arrCombo.length;i++){
	
		if(arrCombo[i]==""){
			continue;
		}
		
		comboHTML+="<option>"+arrCombo[i]+"</option>";
		
	}
	
	comboHTML+="</select>";
	
	FormPreview.innerHTML=FormPreview.innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.all.fieldText.value+" </td><td>"+comboHTML+"</td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.all.fieldName.value+"\">";
	
	if(document.all)
	{
	toggleBorders();
	}
	
	ElementPreview.innerHTML="";
}

function RealAddTextarea(){

if(document.all.fieldName.value==""){
	//alert("The name can not be empty!");
	<?php
	echo 'HT("2","'.$NAME_EMPTY.'<br>",700,130,0.5,20);';
	?>
	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	FormPreview.innerHTML=FormPreview.innerHTML.replace("<!--###-->",""
	+
	"<tr><td>"
	+
	document.all.fieldText.value+" </td><td>"+"<textarea name=field_"+iRandom+" cols="+document.all.fieldcols.value+" rows="+document.all.fieldrows.value+"></textarea>"+"</td></tr>"
	+"<!--###-->");;
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.all.fieldName.value+"\">";
	
	
	
	if(document.all)
	{
		toggleBorders();
	}
	
	ElementPreview.innerHTML="";
}


var toggle="off";
	function toggleBorders(){

	//alert("ent")

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

	//alert("ent")

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

if(document.all.fieldName.value==""){
	//alert("The name can not be empty!");
	<?php
	echo 'HT("2","'.$NAME_EMPTY.'<br>",700,130,0.5,20);';
	?>
	return;
}

	var iRandom=Math.floor(Math.random()*10000);


	FormPreview.innerHTML=FormPreview.innerHTML.replace("<!--###-->",""
	
	
	+
	"<tr ><td>"
	+
	document.all.fieldText.value+" </td><td>"+"<input type=text  name=field_"+iRandom+" size="+document.all.fieldSize.options[document.all.fieldSize.selectedIndex].text+"></td></tr>"
	+"<!--###-->");
	
	strHiddenFields+="<input type=hidden name=namefield_"+iRandom+" value=\""+document.all.fieldName.value+"\">";
	
	if(document.getElementById("obl").checked)
	{
		strValidation += "\nif(x.field_"+iRandom+" && x.field_"+iRandom+".value=='')\n {\nalert(\""+document.getElementById("obl_message").value+"\");\nx.field_"+iRandom+".focus();\nreturn false;}\n";
	}
	
	
	if(document.all)
	{
		toggleBorders();
	}
	
	ElementPreview.innerHTML="";
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
    if(document.all.colorMenu.style.display=="none"){
		document.all.colorMenu.style.display="block";
		strLand="ForeColor";
	}
	else{
		document.all.colorMenu.style.display="none";
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
			strResult+="<td id=td"+i+""+j+"  onclick=tdOver("+i+","+j+") width=20 height=20 class=mainTD123 "+((i<=cx&&j<=cy)?"bgcolor=red":"bgcolor=white")+">&nbsp;</td>";
		}	
		
		strResult+="</tr>";
		
	}
	
	
	strResult+="</table>";
	
	return strResult;
}

function tdOver(x,y){

	document.all.labelTD.innerHTML="<a href=javascript:InsT() class=labelTD123>"+(x+1)+" by "+(y+1)+" Table</a>";
	iX=x+1;
	iY=y+1;
	
	DynamicTable.innerHTML=getTableContent(iCurrentXDimension,iCurrentYDimension,x,y);
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
	
	//alert(strResult);
	
		var sText = document.selection.createRange();
	
	if(sText.parentElement().tagName=="BODY"){
		return;
	}
	
if (!sText==""){
    		
	if(sText.text!=""){
	
		//if(confirm("Are you sure that you wish to replace the selected text: "+sText.text+" with a HTML Table?")){
			sText.text="@@@@@@@";
		//}
		
	}
	else{
			sText.text="@@@@@@@";
	}
  }
  else{
  	  alert("Please select some text!");
  }   

   document.all.FormPreview.innerHTML=document.all.FormPreview.innerHTML.replace("@@@@@@@",strResult);
	
	
	if(document.all)
	{
		toggleBorders();
	}
	document.all.T324dFHFD5.style.visibility="hidden";
}

var toggle="off";

function toggleBorders(){

var allTables = document.all.FormPreview.getElementsByTagName("TABLE");

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
	<div id=DynamicTable  style="width:90"><script>document.write(getTableContent(4,4,0,0));</script></div>
	<table  cellpading=0 cellspacing=0  height=20 ><tr><td class=labelTD123 id=labelTD align=center><a href=javascript:InsT() class=labelTD>1 x 1 Table</a></td></tr></table>
</div>

	<DIV id=colorMenu style="DISPLAY: none;position:absolute;top:30;left:497">
      <TABLE
      style="BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; FONT-SIZE: 7px; BORDER-LEFT: buttonhighlight 1px solid; CURSOR: hand; BORDER-BOTTOM: buttonshadow 1px solid; FONT-FAMILY: Verdana"
      borderColor=#666666 cellSpacing=5 cellPadding=1 bgColor=buttonface
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
<!--rstart-->
<table summary="" border="0" width=750>
  	<tr>
  		<td class=basictext>


<table border="0" width="747" cellpadding="0" cellspacing="0">
	<tr>
		<td align=right>
		
		<script>
		if(!document.all)
		//if(false)
		{
			document.write("<div style='display:none;'>");
		}
		</script>
			<table summary="" border="0" cellpadding="2" cellspacing="0" height=22 width=350 bgcolor=#efebde style="border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px">
		  		<tr>
		  			<td>
  
						<img  WIDTH=23 HEIGHT=22 alt="Bold" class="butClass" src="wizardImages/bold.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doBold()">
						
						<img WIDTH=23 HEIGHT=22  alt="Italic" class="butClass" src="wizardImages/italic.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doItalic()">
						
						<img  WIDTH=23 HEIGHT=22 alt="Underline" class="butClass" src="wizardImages/underline.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doUnderline()">
						<img WIDTH=21 HEIGHT=20  alt="Remove Text Formatting" class="butClass" src="wizardImages/button_remove_format.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doRemoveFormat()">
						
						<img  WIDTH=23 HEIGHT=22 alt="Text Color" class="butClass" src="wizardImages/forecol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doForeCol()">
			
						<!--
						<img  alt="Insert Table" class="butClass"  src="wizardImages/table.gif" border="0" width="20" height="16" alt=""  onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="InsTT()">
						-->
						
						
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
		  
		  <script>
		if(!document.all)
		{
			document.write("</div>");
		}
		</script>

		</td>
	</tr>
</table>



<table summary="" border="0" width=750>
	<tr>
		<td width=200 valign=top>

   
<table summary="" border="0">
	<tr height=30>
	
		<td class=basictext style='color:black;'>
		
<img align=left src="images/form_checkbox2.gif" border="0" width="22" height="20" alt="">
<a href="javascript:AddCheckboxGroup()" >
<?php echo $ADD_CHECKBOX;?>
</a>
		</td>
		</tr><tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_combobox2.gif" border="0" width="21" height="20" alt="">
<a href="javascript:AddCombobox()" >
<?php echo $ADD_COMBOBOX;?>
</a>
		</td>
			</tr><tr height=30>
		<td class=basictext style='color:black;'>
		
<img align=left src="images/form_radiobutton2.gif" border="0" width="20" height="20" alt="">
<a href="javascript:AddRadiobuttonGroup()" >
<?php echo $ADD_RADIOBUTTON;?>
</a>
		</td>
			</tr><tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_textarea2.gif" border="0" width="21" height="20" alt="">
<a href="javascript:AddTextarea()" >
<?php echo $ADD_TEXTAREA;?>
</a>
		</td>
			</tr><tr height=30>
		<td class=basictext style='color:black;'>
		<img align=left src="images/form_textbox2.gif" border="0" width="22" height="20" alt="">
<a href="javascript:AddTextBox()" >
<?php echo $ADD_TEXTBOX;?>
</a>
		</td>
	</tr>
</table>

</td>
<td width=200 >
				
				
				<div id="ElementPreview" style="color:#ff6500;padding-left:5px;padding-top:5px;font-family:Verdana;font-size:11;background:#efefef;width:200;height:300;border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px">

			</div>


		</td>
		<td width=350 >
				
				
				<div id="FormPreview" style="padding-left:5px;padding-top:5px;font-family:Verdana;font-size:11;background:#efefef;width:350;height:300;border-style:solid;border-color:#cecfce;border-width:1px 1px 1px 1px" contenteditable="true">
				<?php echo $arrFormItems2[0];?>
			

				</div>

				<script>
					
									if(document.all)
									{
										toggleBorders();
									}
				</script>

		</td>
	</tr>
</table>

<br>
<form action="index.php" method=post onsubmit="return SubmitSave()">
<input type=hidden name=ProceedSave>

<input type=hidden name=id value="<?php echo $id;?>">

<input type=hidden name=category value="<?php echo $category;?>">

<input type=hidden name=folder value="<?php echo $folder;?>">
<input type=hidden name=page value="<?php echo $page;?>">

<input type=hidden name="FormCode">

<table summary="" border="0" width=750>
	<tr>
		<td align=right>
			<input type=submit class=adminButton value=" <?php echo $SAUVEGARDER;?> " >
		</td>
	</tr></form>
</table>





		</td>
  	</tr>
  </table>
  
<script>
/*
var HTType="1";
var HTMessage="<?php echo $HT_DESIGN_FORM;?>";
document.onmousedown = HTMouseDown;
*/
</script>

<?php
generateBackLink("manage");
?>


