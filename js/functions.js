var AnimationStep = 25; 
var AnimationInterval = 10; 
var LoginHeight = 240;
var c_step=0;

function ShowLogin() 
{
	var oDiv = document.getElementById("main-login-form");
		
	if (c_step < (LoginHeight / AnimationInterval))
	{
		oDiv.style.display = "block";
	 
		Animate(oDiv);
	}
	else
	{
		HideAnimate(oDiv);
	}
}

function HideLogin() 
{
	
	var oDiv = document.getElementById("main-login-form");
	HideAnimate(oDiv);
}

function HideAnimate(element) 
{
   
    if (c_step <= 0)
	{
		element.style.display = "none";
		return true;
	}
        
	
	c_step--;	
	
	element.style.clip="rect(0px 500px "+(c_step*AnimationStep)+"px 0px)";
	
    window.setTimeout(function() {
        HideAnimate(element);
    }, AnimationInterval);
    return false;
}


function Animate(element) 
{
   
    if (c_step >= (LoginHeight / AnimationInterval))
        return true;
	
	c_step++;	
	
	element.style.clip="rect(0px 500px "+(c_step*AnimationStep)+"px 0px)";
	
    window.setTimeout(function() {
        Animate(element);
    }, AnimationInterval);
    return false;
}



function ShowHide(div_name)
{

	if(document.getElementById(div_name).style.display=="block")
	{
		document.getElementById(div_name).style.display="none";
	}
	else
	{
		
		document.getElementById(div_name).style.display="block";
	}

}



function DeleteSavedListing(id)
{
	var saved_listings = r_cookie("saved_listings");
	
	if(saved_listings.indexOf(id+",") != -1)
	{
		saved_listings=saved_listings.replace(id+",","");
		
		document.cookie="saved_listings="+saved_listings;
		
		$("#save_"+id).removeAttr("href");
		$("#save_"+id+" img:last-child").remove();
		$("#save_"+id).append('<img height="16" src="images/star-d.png" alt="Favoris" />'); 
	}
}

function SaveListing(id)
{
	var saved_listings = r_cookie("saved_listings");
	
	if(saved_listings.indexOf(id+",") != -1)
	{
		
	}
	else
	{
		
		saved_listings+=id+",";
		document.cookie="saved_listings="+saved_listings;
		
		$("#save_"+id).removeAttr("href");
		$("#save_"+id+" img:last-child").remove();
		$("#save_"+id).append('<img height="16" src="images/star-a.png" alt="Favoris" />'); 
	}
}

function r_cookie(cname)
{
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) 
	  {
	  var c = ca[i].trim();
	  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	  }
	return "";
}

function cancelDropDown(type)
{
	document.getElementById("label_"+type).innerHTML="";
	reload_items("",type,(type=="category"?"Category":"Location"));

}

function dropDownChange(x,type)
{
	var selected_option= x.options[x.selectedIndex].value;
	document.getElementById("field_"+type).value=selected_option;
	
	var selected_options = selected_option.split("@");
	
	reload_items(selected_options[0],type,selected_options[1]);
}

function reload_items(selected_location,type,selected_value)
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
			fill_dropdown(xmlhttp.responseText,type,selected_value,selected_location);
		}
	}
	
	xmlhttp.open("GET","include/suggest_"+type+".php?location="+selected_location+"&q=",true);
	xmlhttp.send(null);

}



function fill_dropdown(text,type,selected_value,selected_location)
{
	drop_down=document.getElementById(type);
	var new_html="";
	var splitArray = text.split("~");

	var j = 0;
	
	if(splitArray.length>1)
	{
		drop_down.options.length = 1;
		if(selected_location=="")
		{
			if(type=="category"&&typeof cancel_category !== 'undefined')
			{
				document.getElementById("label_"+type).innerHTML=cancel_category;	
			}
			else
			if(type=="location"&&typeof cancel_location !== 'undefined')
			{
				document.getElementById("label_"+type).innerHTML=cancel_location;	
			}
			else
			{
				document.getElementById("label_"+type).innerHTML="<br/>";
			}
		}
		else
		{
			document.getElementById("label_"+type).innerHTML="<a href=\"javascript:cancelDropDown('"+type+"')\"><img src=\"images/small-x-black.png\" alt=\"\"/> "+selected_value+"</a> > ";
		}
	}	

	
	for(j = 0; j < splitArray.length; j++)
	{
		var location = splitArray[j].split("#");
	
		if(location[0]=="no suggestion"||location[1]=="no suggestion"||location[0]=="")
		continue;
		
		drop_down.options[j+1] = new Option(location[0],location[1]+"@"+location[0]);
	
	}
	
}

function GoBack()
{
	history.back();
}

