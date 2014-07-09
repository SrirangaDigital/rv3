function show_edit(titleid)
{
	titleid = "tid_" + titleid;
	document.getElementById(titleid).style.display = "block";
}

function show_edit_author(authid, titleid)
{
	authid = "aid_" + authid + "_" + titleid;
	document.getElementById(authid).style.display = "block";
}
