var selected_location="";
var is_over=false;
var over_location="";
var over_id="";
var first_link_id="";
var first_link_name="";

function ChooseLocation(location,id)
{
	selected_location=id;
	var new_html="";
	new_html+='<!--'+id+'--><a title="click to clear the selection" href=\'javascript:ResetLocation("'+location+'","'+id+'")\'>'+location+'<!--<img src="images/close.gif" width="6" height="6" border="0" style="position:relative;top:-6px;border:0px solid #000000">--></a> : ';
	document.getElementById("selected_dropdown").innerHTML+=new_html;
	document.getElementById("location_dropdown").style.display="none";
	over_location="";
	over_id="";
	document.getElementById("location_dropdown").innerHTML="";
	document.getElementById("text_dropdown").value="";
	reload_hint();
}

document.onclick=function(){
document.getElementById("location_dropdown").style.display="none";
};



function OverLocation(location, id)
{
	over_location=location;
	over_id=id;
	if(id!=first_link_id)
	{
		if(document.getElementById("first_link"))
		document.getElementById("first_link").style.backgroundColor="#ffffff";
	}
}

function ResetLocation(location,id)
{
	
	var current_html = document.getElementById("selected_dropdown").innerHTML;
	var current_html_array=current_html.split('<!--'+id+'-->');
	var location_array=id.split(".");
	
	
	var new_location="";
	is_first=true;
	for(i=0;i<(location_array.length-1);i++)
	{
		if(!is_first) new_location+=".";
		new_location+=location_array[i];
		is_first=false;
	}
	
	
	selected_location=new_location;
	
	if(location_array.length == 1)
	{
		document.getElementById("text_dropdown").value=m_all;
	}
	document.getElementById("selected_dropdown").innerHTML=current_html_array[0];
	document.getElementById("location_dropdown").style.display="none";
	over_location="";
	over_id="";
	document.getElementById("location_dropdown").innerHTML="";
	reload_hint();
	
}

function fill_dropdown(text)
{
	
	var new_html="";
	var splitArray = text.split("~");

	var j = 0;
	for(j = 0; j < splitArray.length; j++)
	{
	 var location = splitArray[j].split("#");
	 
	 if(location[0]=="no suggestion")
	 {
		first_link_id="";
		first_link_name="";
		new_html+=''+location[0];
		
	 }
	 else
	 {
		if(j==0&&document.getElementById("text_dropdown").value != "" )
		{
			first_link_name=location[0];
			
			first_link_id=location[1];
			new_html+='<a id="first_link" href=\'javascript:ChooseLocation("'+location[0]+'","'+location[1]+'")\' onmouseover=\'javascript:OverLocation("'+location[0]+'","'+location[1]+'")\'>'+location[0]+'</a>';
		}
		else
		{
		   new_html+='<a href=\'javascript:ChooseLocation("'+location[0]+'","'+location[1]+'")\' onmouseover=\'javascript:OverLocation("'+location[0]+'","'+location[1]+'")\'>'+location[0]+'</a>';
		 }
	  }
	}
	
	if(splitArray.length > 1)
	{
		document.getElementById("location_dropdown").innerHTML=new_html;
		document.getElementById("location_dropdown").style.display="block";
	}
	else
	{
		s_html = document.getElementById("selected_dropdown").innerHTML;
		
		document.getElementById("selected_dropdown").innerHTML =
		s_html.substring(0, s_html.length - 2);
	}
}

function reload_hint()
{
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			fill_dropdown(xmlhttp.responseText);
		}
	}
	
	xmlhttp.open("GET",suggest_location_url+"?location="+selected_location+"&q=",true);
	xmlhttp.send(null);

}

function show_hint(str)
{
	
	if (str.length==0)
	{
		first_link_id="";
		first_link_name="";
		return;
	}
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
			fill_dropdown(xmlhttp.responseText);
		}
	}
	
	xmlhttp.open("GET",suggest_location_url+"?location="+selected_location+"&q="+str,true);
	xmlhttp.send(null);

}

var combodropimage='images/phone_icon.png';
var combodropoffsetY=0;
var combozindex=100

if (combodropimage!="")
	combodropimage='<img class="downimage" src="'+combodropimage+'" title="Select an option" />'

	
function update_select()
{

}	

function text_mousedown(x)
{
	if(x.value==m_all)
	{
		x.value="";
	}
}

var glob_lock = true;
document.body.onmousedown = function(evt) 
{ 
	glob_lock = false;
 	if(!is_over)
	{
		if(document.getElementById("location_dropdown").style.display!="none")
		
		document.getElementById("location_dropdown").style.display="none";
	}
		
	return true;
}

document.onkeydown=enterkey_press;
function enterkey_press(e)
{
     var key;     
     if(window.event)
          key = window.event.keyCode; 
     else
          key = e.which;   
	if(key == 13&&is_over)
	{
		
		if(over_id!="")
		{
			ChooseLocation(over_location, over_id);
		
		
			return false;
		}
	}
	else
	{
		return true;
	}
}
	
function field_lost_focus()
{
	document.getElementById("text_dropdown").value=first_link_name;
}	

function get_browser() 
{
	var agt=navigator.userAgent.toLowerCase();
	if (agt.indexOf("opera") != -1) return 'Opera';
	if (agt.indexOf("staroffice") != -1) return 'Star Office';
	if (agt.indexOf("webtv") != -1) return 'WebTV';
	if (agt.indexOf("beonex") != -1) return 'Beonex';
	if (agt.indexOf("chimera") != -1) return 'Chimera';
	if (agt.indexOf("netpositive") != -1) return 'NetPositive';
	if (agt.indexOf("phoenix") != -1) return 'Phoenix';
	if (agt.indexOf("firefox") != -1) return 'Firefox';
	if (agt.indexOf("safari") != -1) return 'Safari';
	if (agt.indexOf("skipstone") != -1) return 'SkipStone';
	if (agt.indexOf("msie") != -1) return 'Internet Explorer';
	if (agt.indexOf("netscape") != -1) return 'Netscape';
	if (agt.indexOf("mozilla/5.0") != -1) return 'Mozilla';
	if (agt.indexOf('\/') != -1) {
	if (agt.substr(0,agt.indexOf('\/')) != 'mozilla') {
	return navigator.userAgent.substr(0,agt.indexOf('\/'));}
	else return 'Netscape';} else if (agt.indexOf(' ') != -1)
	return navigator.userAgent.substr(0,agt.indexOf(' '));
	else return navigator.userAgent;
}
	
function transform_select(selectid, selectwidth, optionwidth)
{
	var selectbox=document.getElementById(selectid);
 
	document.write('<div id="dhtml_'+selectid+'" class="mselect" style="position:relative;top:'+(get_browser()=="Safari"?'-1':'0')+'px;">');
	
	document.write('<span id="selected_dropdown" style="position:absolute;top:6px">');
	document.write('</span>');
	document.write('<input type="text" id="text_dropdown" name="text_dropdown" onblur = "field_lost_focus()" onkeyup="show_hint(this.value)" value="'+m_all+'" onmousedown="text_mousedown(this)" style="width:'+selectwidth+';" />');
	
	document.write('<div id="location_dropdown" class="dropdown">');
	
	
	for (var i=0; i<selectbox.options.length; i++)
	{
		document.write('<a href=\'javascript:ChooseLocation("'+selectbox.options[i].text+'","'+selectbox.options[i].value+'")\' onmouseover=\'javascript:OverLocation("'+selectbox.options[i].text+'","'+selectbox.options[i].value+'")\'>');
		document.write(selectbox.options[i].text);
		document.write('</a>');
	}
		
		
	document.write('</div></div>');
	
	
	selectbox.style.display="none";
	
	
	var mselectbox=document.getElementById("dhtml_"+selectid);
	
	mselectbox.style.zIndex=combozindex;
	combozindex--;
	
	if (typeof selectwidth!="undefined")
	{
		mselectbox.style.width=selectwidth;
	}
	
	if (typeof optionwidth!="undefined")
	{
		mselectbox.getElementsByTagName("div")[0].style.width=optionwidth;
	}
	
	
	mselectbox.getElementsByTagName("div")[0].style.top=mselectbox.offsetHeight+combodropoffsetY+"px";
	
	
	mselectbox.onmouseover=function()
	{
		is_over=true;
		if(this.getElementsByTagName("div")[0].innerHTML!="")
		this.getElementsByTagName("div")[0].style.display="block";
	}
	
	mselectbox.onmouseout=function()
	{
		is_over=false;
		over_location="";
		over_id="";
	}
	
	
}


function ChangeImages(x)
{
	document.getElementById("images_number").innerHTML=x;
	allowed_images=x;
	if(allowed_images==0)
	{
		document.getElementById("images_fieldset").style.display="none";
	}
	else
	{
		document.getElementById("images_fieldset").style.display="block";
	}
}