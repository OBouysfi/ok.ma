$(function() {

    $('#side-menu').metisMenu();
	

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
})


var default_content="";
var lock_check = false;
var interval_id = 0;

$(document).ready(function(){
	
		checkURL();
		$('ul li a').click(function (e){

				checkURL(this.hash);

		});
		
		
		default_content = $('#main-content').html();
		
		
		interval_id = setInterval("checkURL()",250);
	
});

var lasturl="";

var check_url_count=0;

function checkURL(hash)
{
	if(lock_check)
	{
	
	}
	else
	{
		if(!hash) hash=window.location.hash;
		
		check_url_count++;
		
		if(hash != lasturl)
		{
			lasturl=hash;
			
			if(hash=="")
			$('#main-content').html(default_content);
			
			else
			loadPage(hash);
		}
		
		if(check_url_count==10)
		{
			
		}
	}
}


function loadPage(url)
{
	
	if(lock_check)
	{
	
	}
	else
	{
	url=url.replace('#','');
	
	var array_url = url.split('-');
	
	var url_data = "category="+array_url[0]+"&action="+array_url[1];
	
	if(array_url[2])
	{
		url_data = url_data + "&"+array_url[2];
	}

	$('#loading').css('visibility','visible');
	
	$.ajax({
		type: "POST",
		url: "admin_page.php",
		data: url_data,
		dataType: "html",
		success: function(msg){
			
			if(parseInt(msg)!=0)
			{
			
				$('#main-content').html(msg);
				$('#loading').css('visibility','hidden');
				
				if($(window).width()<768)
				{
					if($('.navbar-toggle').css('display') !='none')
					{
						$(".navbar-toggle").trigger( "click" );
					}
				}
				
			}
			
		},
		error: function(msg)
		{
			
			
			$('#main-content').html("There was an error while processing the page.<br/><br/>Click <a href=\"admin_page.php?"+url_data+"\">here</a> to see details.<br/><br/><br/><br/>");
			$('#loading').css('visibility','hidden');
			
		}
		
	});
	}
}

function isFunction(possibleFunction) 
{
  return (typeof(possibleFunction) == typeof(Function));
}

function ShowLoading()
{
	do_process=true;
	if(isFunction(ValidateForm))
	{
		if(!ValidateForm(document.getElementById("add-form")))
		{
			do_process=false;
		}
	}
	
	if(do_process)
	{
		lock_check = true;
		$('#loading').css('visibility','hidden');
		$('#add-form').submit();
	}
}

function LoadingIcon()
{
	$('#loading').css('visibility','visible');
}

function HideLoadingIcon()
{
	$('#loading').css('visibility','hidden');
}

function StartOver()
{
	
}







function sub_loc_select(x,field_name,all_text,suggest_action)
{
	if(x=="") return;
	
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
			show_sub_locs(xmlhttp.responseText,x,field_name);
		}
	}
	
	xmlhttp.open("GET",suggest_action+".php?location="+x+"&q=",true);
	
	xmlhttp.send(null);
	
}
var up_html = new Array();
var i_last_level = -1;
function show_sub_locs(text,x,field_name)
{
	var i_level = (x.split(".").length - 1);

	for(i=i_level;i<=4;i++)
	{
		document.getElementById("s_"+field_name+"_"+i).innerHTML="";	
	}
	
	var new_html="";
	var splitArray = text.split("~");

	var j = 0;
	for(j = 0; j < splitArray.length; j++)
	{
		var location = splitArray[j].split("#");
		 
		if(location[0]=="no suggestion")
		{
			
			
		}
		else
		{
			new_html += "<option value=\""+location[1]+"\">"+location[0]+"</option>";
		}
	}
	
	if(new_html!="")
	{
		new_html ='<select '+(field_name=="category_1"?'required':'')+' onChange="sub_loc_select(this.value,\''+field_name+'\'")" type="text" class="sub-loc-select" id="'+field_name+'_'+(i_level+1)+'" name="'+field_name+'_'+(i_level+1)+'">'
		+'<option value="">'+m_all+'</option>'+new_html+'</select>';
		document.getElementById("s_"+field_name+"_"+i_level).innerHTML=new_html;
	}

	i_last_level = i_level
}	


function get_cat_value(x)
{
	for(i=4;i>=0;i--)
	{
		if(document.getElementById(x+"_"+i))
		
		{
			var e = document.getElementById(x+"_"+i);
			return  e.options[e.selectedIndex].value;
		
		}
	
	}
	return "";
}

function PageLoaded()
{	
	document.getElementById("main_navigation").style.visibility="visible";
	
	if(current_cat!=""&&document.getElementById("link_"+current_cat))
	{
		$("#link_"+current_cat).click();
	}
	
}
