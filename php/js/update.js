function checkradio(status)
{
	if(status=="Yes")
	{
		document.getElementById("pub_yes").style.display = "block";
		document.getElementById("pub_no").style.display = "none";
	}
	else
	{
		document.getElementById("pub_yes").style.display = "none";
		document.getElementById("pub_no").style.display = "block";
	}
}

function select_all(status)
{
	var data = document.getElementById('java').value;
	
	data = data.split("|");
	
	if(status == 'Y')
	{
		for(i=1;i<data.length;i++)
		{
			document.getElementById(data[i]).checked = 1;
		}
	}
	else
	{
		for(i=1;i<data.length;i++)
		{
			document.getElementById(data[i]).checked = 0;
		}
	}
}

