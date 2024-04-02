function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
}

function formReset(val)
{
	document.getElementById(val).reset();
	return false;
}

function addTextToCombo(combo, index, newText, newValue)
{
    var newOpt1 = new Option(newText, newValue);
    combo.options[index] = newOpt1;
    combo.selectedIndex = 0;
}

// for open window in center position //
function PopupCenter(pageURL, title,w,h) 
{
	//alert('hi');
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, titlebar=no, width='+w+', height='+h+', top='+top+', left='+left);
}





// JavaScript Document
function showimg()
{
document.getElementById('imgload').style.display="block";
return true;
}


// for masters //
function checkinputmaster(id)
{
	//alert(id)
	var n=id.split(",");
	var msg=0;
	for(var i=0;i<n.length;i++)
	{
		//alert(n[i])
		var idname=n[i].split(" ");
		var name = document.getElementById(idname[0]).value.trim();
		var datatype = idname[1];
		//alert(name)
		if(name=="")
		{
			alert("Fill Mandatory Field");
			document.getElementById(idname[0]).value="";
			document.getElementById(idname[0]).focus();
			msg=1;
			break;
		}
		
		if(datatype=="al")
		{
			if(!onlyalphabets(name))
			{
				alert("Please Enter only Alphabet");
				document.getElementById(idname[0]).value="";
				document.getElementById(idname[0]).focus();
				msg=1;
				break;
			}
		}
		else if(datatype=="an")
		{
			if(!alphanumeric(name))
			{
				alert("Please Enter only Alpha Numeric Value");
				document.getElementById(idname[0]).value="";
				document.getElementById(idname[0]).focus();
				msg=1;
				break;
			}
		}
		else if(datatype=="nu")
		{
			if(!numeric(name))
			{
				alert("Please Enter only Numbers");
				document.getElementById(idname[0]).value="";
				document.getElementById(idname[0]).focus();
				msg=1;
				break;
			}
		}
	}
	//alert(msg)
	if(msg==1)
	{
		//alert("false")
		return false;
	}
	else
	{
		//alert("ok")
		//showimg();
		return true;
	}
}


function onlyalphabets(name)
{
	var reg=/^[a-zA-Z -]*$/;
	return reg.test(name);
}

function alphanumeric(name)
{
	var reg=/^[a-zA-Z 0-9 -.]*$/;
	return reg.test(name);
}

function numeric(name)
{
	var reg=/^[0-9 -.]*$/;
	return reg.test(name);
}


function showdiv()
{
	//document.getElementById('divmsg').style.display="block";
	$('#divmsg').animate( {backgroundColor:'#FFF2DF'}, 300).fadeIn(1000,function() {
    $('#divmsg').show();
	});
	setTimeout("hidediv()",3000);
	
}
function hidediv()
{
	//document.getElementById('divmsg').style.display="none";
	$('#divmsg').animate( {backgroundColor:'#FEBAA7'}, 300).fadeOut(1000,function() {
    $('#divmsg').hide();
	});
}

function removeexistmsg()
{
	document.getElementById('existsid').style.display="none";
}

function removeexistmsg1()
{
	document.getElementById('existsid1').style.display="none";
}