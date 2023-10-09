var category_selected_location="";
var category_is_over=false;
var category_over_location="";
var category_over_id="";
var category_first_link_id="";
var category_first_link_name="";
var category_combozindex=100;
var category_combodropoffsetY=0;

function category_ChooseLocation(location,id)
{
	category_selected_location=id;
	ShowFields(id);
	var new_html="";
	new_html+='<!--'+id+'--><a title="click to clear the selection" href=\'javascript:category_ResetLocation("'+location+'","'+id+'")\'>'+location+'</a> : ';
	document.getElementById("category_selected_dropdown").innerHTML+=new_html;
	document.getElementById("category_location_dropdown").style.display="none";
	category_over_location="";
	category_over_id="";
	document.getElementById("category_location_dropdown").innerHTML="";
	document.getElementById("category_text_dropdown").value="";
	category_reload_hint();
}




function category_OverLocation(location, id)
{
	category_over_location=location;
	category_over_id=id;
	if(id!=category_first_link_id)
	{
		if(document.getElementById("category_first_link"))
		document.getElementById("category_first_link").style.backgroundColor="#ffffff";
	}
}

function category_ResetLocation(location,id)
{
	
	UpdatePackages(id);
	
	var current_html = document.getElementById("category_selected_dropdown").innerHTML;
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
	
	
	category_selected_location=new_location;
	
	if(location_array.length == 1)
	{
		document.getElementById("category_text_dropdown").value=m_all;
	}
	document.getElementById("category_selected_dropdown").innerHTML=current_html_array[0];
	document.getElementById("category_location_dropdown").style.display="none";
	category_over_location="";
	category_over_id="";
	document.getElementById("category_location_dropdown").innerHTML="";
	category_reload_hint();
	
}

function category_fill_dropdown(text)
{
	
	var new_html="";
	var splitArray = text.split("~");

	var j = 0;
	for(j = 0; j < splitArray.length; j++)
	{
	 var location = splitArray[j].split("#");
	 
	 if(location[0]=="no suggestion")
	 {
		category_first_link_id="";
		category_first_link_name="";
		new_html+=''+location[0];
		
	 }
	 else
	 {
		if(j==0&&document.getElementById("category_text_dropdown").value != "" )
		{
			category_first_link_name=location[0];
			
			category_first_link_id=location[1];
			new_html+='<a id="category_first_link" href=\'javascript:category_ChooseLocation("'+location[0]+'","'+location[1]+'")\' onmouseover=\'javascript:category_OverLocation("'+location[0]+'","'+location[1]+'")\'>'+location[0]+'</a>';
		}
		else
		{
		   new_html+='<a href=\'javascript:category_ChooseLocation("'+location[0]+'","'+location[1]+'")\' onmouseover=\'javascript:category_OverLocation("'+location[0]+'","'+location[1]+'")\'>'+location[0]+'</a>';
		 }
	  }
	}
	
	if(splitArray.length > 1)
	{
		document.getElementById("category_location_dropdown").innerHTML=new_html;
		document.getElementById("category_location_dropdown").style.display="block";
	}
	else
	{
		s_html = document.getElementById("category_selected_dropdown").innerHTML;
		
		document.getElementById("category_selected_dropdown").innerHTML =
		s_html.substring(0, s_html.length - 2);
	}
}

function category_reload_hint()
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
			category_fill_dropdown(xmlhttp.responseText);
		}
	}
	
	xmlhttp.open("GET",category_suggest_location_url+"&location="+category_selected_location+"&q=",true);
	xmlhttp.send(null);

}

function category_show_hint(str)
{
	
	if (str.length==0)
	{
		category_first_link_id="";
		category_first_link_name="";
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
			
			category_fill_dropdown(xmlhttp.responseText);
		}
	}
	
	xmlhttp.open("GET",category_suggest_location_url+"&location="+category_selected_location+"&q="+str,true);
	xmlhttp.send(null);

}


function category_text_mousedown(x)
{
	if(x.value==m_all)
	{
		x.value="";
	}
}

var category_glob_lock = true;
document.body.onmousedown = function(evt) 
{ 
	category_glob_lock = false;
 	if(!category_is_over)
	{
		if(document.getElementById("category_location_dropdown").style.display!="none")
		
		document.getElementById("category_location_dropdown").style.display="none";
	}
		
	return true;
}

document.onkeydown=category_enterkey_press;
function category_enterkey_press(e)
{
     var key;     
     if(window.event)
          key = window.event.keyCode; 
     else
          key = e.which;   
	if(key == 13&&category_is_over)
	{
		
		if(category_over_id!="")
		{
			category_ChooseLocation(category_over_location, category_over_id);
		
		
			return false;
		}
	}
	else
	{
		return true;
	}
}
	
function category_field_lost_focus()
{
	document.getElementById("category_text_dropdown").value=category_first_link_name;
}	

function category_get_browser() 
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
	
function category_transform_select(selectid, selectwidth, optionwidth)
{
	var selectbox=document.getElementById(selectid);
 
	document.write('<div id="dhtml_'+selectid+'" class="mselect" style="position:relative;top:'+(category_get_browser()=="Safari"?'-1':'0')+'px;">');
	
	document.write('<span id="category_selected_dropdown" style="position:absolute;top:6px">');
	document.write('</span>');
	document.write('<input type="text" id="category_text_dropdown" name="category_text_dropdown" onblur = "category_field_lost_focus()" onkeyup="category_show_hint(this.value)" value="'+m_all+'" onmousedown="category_text_mousedown(this)" style="width:'+selectwidth+';" />');
	
	document.write('<div id="category_location_dropdown" class="dropdown">');
	
	
	for (var i=0; i<selectbox.options.length; i++)
	{
		document.write('<a href=\'javascript:category_ChooseLocation("'+selectbox.options[i].text+'","'+selectbox.options[i].value+'")\' onmouseover=\'javascript:category_OverLocation("'+selectbox.options[i].text+'","'+selectbox.options[i].value+'")\'>');
		document.write(selectbox.options[i].text);
		document.write('</a>');
	}
		
		
	document.write('</div></div>');
	
	
	selectbox.style.display="none";
	
	
	var mselectbox=document.getElementById("dhtml_"+selectid);
	
	mselectbox.style.zIndex=category_combozindex;
	category_combozindex--;
	
	if (typeof selectwidth!="undefined")
	{
		mselectbox.style.width=selectwidth;
	}
	
	if (typeof optionwidth!="undefined")
	{
		mselectbox.getElementsByTagName("div")[0].style.width=optionwidth;
	}
	
	
	mselectbox.getElementsByTagName("div")[0].style.top=mselectbox.offsetHeight+category_combodropoffsetY+"px";
	
	
	mselectbox.onmouseover=function()
	{
		category_is_over=true;
		if(this.getElementsByTagName("div")[0].innerHTML!="")
		this.getElementsByTagName("div")[0].style.display="block";
	}
	
	mselectbox.onmouseout=function()
	{
		category_is_over=false;
		category_over_location="";
		category_over_id="";
	}
	
	
}

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] == obj) {
            return true;
        }
    }
    return false;
}

var previous_cat="0";
var current_cat="0";

function UpdatePackages(id)
{
	if(document.getElementById("packages-0"))
	{
	
		current_cat = id;
	
		if(document.getElementById("packages-"+previous_cat))
		{
			document.getElementById("packages-"+previous_cat).style.display="none";
		}
		found_s_packs = false;
		found_exact_match = false;
		
		if(document.getElementById("packages-"+current_cat))
		{
			document.getElementById("packages-"+current_cat).style.display="block";
			document.getElementById("packages-0").style.display="none";
			found_exact_match = true;
		}
			
		if(!found_exact_match)
		{
			var arrayOfIds = current_cat.split('.');
			sub_id = current_cat;
			
			for(var i=(arrayOfIds.length-1); i >= 0 ; i--)
			{
				sub_id = current_cat.substring(0, sub_id.length - arrayOfIds[i].length);
				
				if(document.getElementById("packages-"+sub_id))
				{
					document.getElementById("packages-"+sub_id).style.display="block";
					document.getElementById("packages-0").style.display="none";
					found_s_packs = true;
					break;
				}
				
			}
		
		
			if(!found_s_packs)
			{
				document.getElementById("packages-0").style.display="block";
			}
		}
		previous_cat = current_cat;
	}
}

function in_array(array, id) 
{
    for(var i=0;i<array.length;i++) 
	{
        if(array[i] == id)
		{
            return true;
        }
    }
    return false;
}

function ShowFields(id)
{
	
	var s_div = "fields-"+id;

	var pieces = id.split('.');
	var sub_ids = new Array();
	c_id = "";
	for(var i = 0; i < pieces.length; i++) 
	{
		if(c_id == "")
		{
			c_id=pieces[i];
		}
		else
		{
			c_id=c_id+"." + pieces[i];
		}
		sub_ids.push("fields-"+c_id);
	}
	
	
	
	if(document.getElementById("additional-fields"))
	{
		var elms = document.getElementById("additional-fields").getElementsByTagName("div");
		 
		for (var i = 0; i < elms.length; i++) 
		{
			if(elms[i].id.indexOf("fields") == 0)
			{
			
				if (in_array(sub_ids, elms[i].id)) 
				{
					if(document.getElementById(s_div))
					{
						document.getElementById(s_div).style.display="block";
					}
				}
				else
				{
					if(document.getElementById(elms[i].id))
					{
						document.getElementById(elms[i].id).style.display="none";	
					}
				}
			}
		}
		
		
		
		UpdatePackages(id);
		
	}
	
	
}
