function ContextMenu()
{	
	this.Data = Array();
	this.Width = 200;
	this.Height =50;
	this.Padding = 2;
	this.Font = "Verdana";
	this.FontSize = "11px";
	this.FontColor = "#636d73";
	this.FlatStyle = true;
	this.BorderColor = "#cecfce";
	this.BorderStyle = "solid";
	this.BGColor= "#ffffff";
	this.SelectedBGColor = "#ffd7c6";
	this.SelectedFontColor = "#636d73";
	this.ShowVersion = ShowVersion;
	this.Show = Show;
	this.Hide = Hide;
	this.Render = Render;
	this.GetHTML = GetHTML;
	this.Version = "1.1";	

	document.onmousedown = MouseDown;
	document.oncontextmenu = OnContextMenu;

	function OnContextMenu()
	{
		return false;
	}
	
	function ShowAt(X, Y)
	{
			document.getElementById("ContextMenu").style.visibility = "visible";
			document.getElementById("ContextMenu").style.left = X;
			document.getElementById("ContextMenu").style.top = Y;
	}
	
	function MouseDown(e)
	{

		if(!document.all)
		{
			//if(e.which != 1)
			if(true)
			{
					document.getElementById("ContextMenu").style.visibility = "visible";
					document.getElementById("ContextMenu").style.left = e.pageX + 1;
					document.getElementById("ContextMenu").style.top = e.pageY + 1;
			}
			else
			{
					//document.getElementById("ContextMenu").style.visibility = "hidden";
			}
			
			return true;
		}

		else
		
		if(event.button && event.button == 2)
		{
		
			document.getElementById("ContextMenu").style.visibility = "visible";
			document.getElementById("ContextMenu").style.left = event.x + 1;
			document.getElementById("ContextMenu").style.top = event.y + 1;
			
			return false;
		}
		
		
		
		
	}

	function GetHTML()
	{
		var strResult = "";
		
		strResult += "<table id=\"ContextMenu\" bgcolor=\""+this.BGColor+"\" width="+this.Width+" height="+this.Height+" cellpadding="+this.Padding+" cellspacing=0 style=\"width:"+this.Width+";height:"+this.Height+";position:absolute;top:0;left:0;visibility:hidden;border-style:"+this.BorderStyle+";border-color:"+this.BorderColor+";border-width:"+(this.FlatStyle?"1px 1px 1px 1px":"1px 2px 2px 1px")+"\">";
		
		for(i = 0; i < this.Data.length; i++)
		{
			strResult += "<tr ><td onclick=\""+(this.Data[i][1].substring(0,11)=="javascript:"?this.Data[i][1].replace("javascript:",""):"document.location.href='"+this.Data[i][1]+"'")+"\" onmouseover=\"this.bgColor='"+this.SelectedBGColor+"';this.style.color='"+this.SelectedFontColor+"'\" onmouseout=\"this.bgColor='"+this.BGColor+"';this.style.color='"+this.FontColor+"'\" style=\"font-family:"+this.Font+";color:"+this.FontColor+";font-size:"+this.FontSize+";border-style:"+this.BorderStyle+";border-color:"+this.BorderColor+";border-width:"+(this.FlatStyle?"0px 0px 0px 0px":"0px 0px 0px 0px")+"\">";
			
			strResult += "" + this.Data[i][0];
			
			strResult += "</td></tr>";
		}		
		
		strResult += "</table>";
		
		return strResult;
	}

	function Show(objectName)
	{
		document.getElementById(objectName).innerHTML = this.GetHTML();
	}
	
	function Hide(objectName)
	{
		document.getElementById(objectName).innerHTML = "";
	}
	
	function Render()
	{
		document.write(this.GetHTML());
	}
	
	function ShowVersion(){
		document.write(this.Version);
	}
}



azMenu.Registry = []
azMenu.aniLen = 350
azMenu.hideDelay = 1000
azMenu.minCPUResolution = 5

// constructor
function azMenu(id, dir, left, top, width, height)
{
	this.ie  = document.all ? 1 : 0
	this.ns4 = document.layers ? 1 : 0
	this.dom = document.getElementById ? 1 : 0

	if (this.ie || this.ns4 || this.dom) {
		this.id			 = id
		this.dir		 = dir
		this.orientation = dir == "left" || dir == "right" ? "h" : "v"
		this.dirType	 = dir == "right" || dir == "down" ? "-" : "+"
		this.dim		 = this.orientation == "h" ? width : height
		this.hideTimer	 = false
		this.aniTimer	 = false
		this.open		 = false
		this.over		 = false
		this.startTime	 = 0

		// global reference to this object
		this.gRef = "azMenu_"+id
		eval(this.gRef+"=this")

		// add this menu object to an internal list of all menus
		azMenu.Registry[id] = this

		var d = document
		d.write('<style type="text/css">')
		d.write('#' + this.id + 'Container { visibility:hidden; ')
		d.write('left:' + left + 'px; ')
		d.write('top:' + top + 'px; ')
		d.write('overflow:hidden; }')
		d.write('#' + this.id + 'Container, #' + this.id + 'Content { position:absolute; ')
		d.write('width:' + width + 'px; ')
		d.write('height:' + height + 'px; ')
		d.write('clip:rect(0 ' + width + ' ' + height + ' 0); ')
		d.write('}')
		d.write('</style>')

		this.load()
	}
}

azMenu.prototype.load = function() {
	var d = document
	var lyrId1 = this.id + "Container"
	var lyrId2 = this.id + "Content"
	var obj1 = this.dom ? d.getElementById(lyrId1) : this.ie ? d.all[lyrId1] : d.layers[lyrId1]
	if (obj1) var obj2 = this.ns4 ? obj1.layers[lyrId2] : this.ie ? d.all[lyrId2] : d.getElementById(lyrId2)
	var temp

	if (!obj1 || !obj2) window.setTimeout(this.gRef + ".load()", 100)
	else {
		this.container	= obj1
		this.menu		= obj2
		this.style		= this.ns4 ? this.menu : this.menu.style
		this.homePos	= eval("0" + this.dirType + this.dim)
		this.outPos		= 0
		this.accelConst	= (this.outPos - this.homePos) / azMenu.aniLen / azMenu.aniLen 

		// set event handlers.
		if (this.ns4) this.menu.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
		this.menu.onmouseover = new Function("azMenu.showMenu('" + this.id + "')")
		this.menu.onmouseout = new Function("azMenu.hideMenu('" + this.id + "')")

		//set initial state
		this.endSlide()
	}
}
	
azMenu.showMenu = function(id)
{
	var reg = azMenu.Registry
	var obj = azMenu.Registry[id]
	
	
	if (obj.container) {
		obj.over = true

		// close other menus.
		for (menu in reg) if (id != menu) azMenu.hide(menu)

		// if this menu is scheduled to close, cancel it.
		if (obj.hideTimer) { reg[id].hideTimer = window.clearTimeout(reg[id].hideTimer) }

		// if this menu is closed, open it.
		if (!obj.open && !obj.aniTimer) reg[id].startSlide(true)
	}
	
}

azMenu.hideMenu = function(id)
{
	// schedules the menu to close after <hideDelay> ms, which
	// gives the user time to cancel the action if they accidentally moused out
	var obj = azMenu.Registry[id]
	if (obj.container) {
		if (obj.hideTimer) window.clearTimeout(obj.hideTimer)
		obj.hideTimer = window.setTimeout("azMenu.hide('" + id + "')", azMenu.hideDelay);
	}
}

azMenu.hide = function(id)
{
	var obj = azMenu.Registry[id]
	obj.over = false

	if (obj.hideTimer) window.clearTimeout(obj.hideTimer)
	
	// flag that this scheduled event has occured.
	obj.hideTimer = 0

	// if this menu is open, close it.
	if (obj.open && !obj.aniTimer) obj.startSlide(false)
}

azMenu.prototype.startSlide = function(open) {
	this[open ? "onactivate" : "ondeactivate"]()
	this.open = open
	if (open) this.setVisibility(true)
	this.startTime = (new Date()).getTime()	
	this.aniTimer = window.setInterval(this.gRef + ".slide()", azMenu.minCPUResolution)
}

azMenu.prototype.slide = function() {
	var elapsed = (new Date()).getTime() - this.startTime
	if (elapsed > azMenu.aniLen) this.endSlide()
	else {
		var d = Math.round(Math.pow(azMenu.aniLen-elapsed, 2) * this.accelConst)
		if (this.open && this.dirType == "-")		d = -d
		else if (this.open && this.dirType == "+")	d = -d
		else if (!this.open && this.dirType == "-")	d = -this.dim + d
		else										d = this.dim + d

		this.moveTo(d)
	}
}

azMenu.prototype.endSlide = function() {
	this.aniTimer = window.clearTimeout(this.aniTimer)
	this.moveTo(this.open ? this.outPos : this.homePos)
	if (!this.open) this.setVisibility(false)
	if ((this.open && !this.over) || (!this.open && this.over)) {
		this.startSlide(this.over)
	}
}

azMenu.prototype.setVisibility = function(bShow) { 
	var s = this.ns4 ? this.container : this.container.style
	s.visibility = bShow ? "visible" : "hidden"
}
azMenu.prototype.moveTo = function(p) { 
	this.style[this.orientation == "h" ? "left" : "top"] = this.ns4 ? p : p + "px"
}
azMenu.prototype.getPos = function(c) {
	return parseInt(this.style[c])
}

// events
azMenu.prototype.onactivate		= function() { }
azMenu.prototype.ondeactivate	= function() { }









/* author: Anton Zamov zamov@online.fr */
/* Creation date: 10/15/2003 */

onerror=ErrorManager;

function ErrorManager(){
	//return true;
}

function nvoid(){

}

function HideDiv(divName){
	var divObject=eval("document.all."+divName);
	divObject.style.display="none";
}


function ShowDiv(divName){
	var divObject=eval("document.all."+divName);
	divObject.style.display="block";
}

function ProceedShowHide(divName){
	var divObject=eval("document.all."+divName);
	
	if(divObject.style.display=="none"){
		divObject.style.display="block";
	}
	else{
		divObject.style.display="none";
	}
}

var iOpened=0;
function ProceedShow(){

	if(iOpened==0){
		iOpened=1;
		document.all.AddDiv.style.display="block";
		document.all.LinkText.innerHTML="HIDE";
	}
	else{
		iOpened=0;
		document.all.AddDiv.style.display="none";
		document.all.LinkText.innerHTML="SHOW";
	}
	
	
}




var isAll=false;
function SelectAllCheckBoxes(){

	
	if(isAll){
		re = /CHECKED/gi;  
		MainForm.innerHTML=MainForm.innerHTML.replace(re,"");
		SelectAllButton.value=" Select All ";
	}
	else{
		re = /type=checkbox/gi;  
		MainForm.innerHTML=MainForm.innerHTML.replace(re,"type=checkbox CHECKED");
		SelectAllButton.value=" Deselect All ";
	}
	
	isAll=!isAll;
	
}





/*************** Color settings ******************/
var tdMouseBasic="#f7f3f7";
var tdMouseOver="#e7dfe7";
var tdMouseSelected="#c6594a";
/***********************************************/


function tdOver(x,y){
	if(document.all&&y!="selected"){
		
		if(x.style.background!=tdMouseSelected){
			x.style.background=""+tdMouseOver;
		}
	}
}


function tdOut(x,y){
	if(document.all&&y!="selected"){
		x.style.background=""+tdMouseBasic;	
	}
}
