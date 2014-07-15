<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sri Ramakrishna Vijayam</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/style.css" media="screen" rel="stylesheet" type="text/css" />

<link href="images/favicon.ico" rel="shortcut icon" />
</head>

<body>
<div class="page">
	<div class="header">
		<a href="../index.php" title="Home"><img class="logo" src="images/logo.png" alt="Sri Ramakrishna Math Logo" /></a>
		<a href="../index.php" title="Home"><img class="title" src="images/title.png" alt="Sri Ramakrishna Vijayam" /></a>
		<ul class="nav">
			<li><a href="../index.php">HOME</a></li>
			<li><a href="about.php">ABOUT</a></li>
			<li><a href="editors.php">EDITORS</a></li>
			<li><a href="gallery.php">GALLERY</a></li>
			<li><a href="help.php">HELP</a></li>
		</ul>
	</div>
	<div class="mainbody">
		<div class="maintitle">List of Authors</div>
		<div class="rule">&nbsp;</div>
		<div class="alphabet">
			<ul>
				<li><a href="authors.php?letter=அ">அ</a></li>
				<li><a href="authors.php?letter=ஆ">ஆ</a></li>
				<li><a href="authors.php?letter=இ">இ</a></li>
				<li><a href="authors.php?letter=ஈ">ஈ</a></li>
				<li><a href="authors.php?letter=உ">உ</a></li>
				<li><a href="authors.php?letter=ஊ">ஊ</a></li>
				<li><a href="authors.php?letter=எ">எ</a></li>
				<li><a href="authors.php?letter=ஏ">ஏ</a></li>
				<li><a href="authors.php?letter=ஐ">ஐ</a></li>
				<li><a href="authors.php?letter=ஒ">ஒ</a></li>
				<li><a href="authors.php?letter=க">க</a></li>
				<li><a href="authors.php?letter=ச">ச</a></li>
				<li><a href="authors.php?letter=ஜ">ஜ</a></li>
				<li><a href="authors.php?letter=ஞ">ஞ</a></li>
				<li><a href="authors.php?letter=ட">ட</a></li>
				<li><a href="authors.php?letter=த">த</a></li>
				<li><a href="authors.php?letter=ந">ந</a></li>
				<li><a href="authors.php?letter=ப">ப</a></li>
				<li><a href="authors.php?letter=ம">ம</a></li>
				<li><a href="authors.php?letter=ய">ய</a></li>
				<li><a href="authors.php?letter=ர">ர</a></li>
				<li><a href="authors.php?letter=ல">ல</a></li>
				<li><a href="authors.php?letter=வ">வ</a></li>
				<li><a href="authors.php?letter=ஸ">ஸ</a></li>
				<li><a href="authors.php?letter=ஸ்ரீ">ஸ்ரீ</a></li>
			</ul>
		</div>
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder">
			<img class="tag" src="images/tag.png" alt="Tag" />
			<ul>
<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");
mysql_query("set names utf8");

$letter = $_GET['letter'];

if($letter == '')
{
	$letter = 'அ';
}

if($letter == 'ஸ')
{
	$query = "select * from author where ((authorname like 'ஸ%') and (authorname not like 'ஸ்ரீ%')) order by authorname";
}
else
{
	$query = "select * from author where authorname regexp '^$letter' order by authorname";
}

$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$authid=$row['authid'];
		$authorname=$row['authorname'];

		if($authorname != '')
		{
			echo "<li>";
			echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$authid&author=$authorname\">$authorname</a></span>";
			echo "</li>";
		}
	}
}

?>
				</ul>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="archive_nav">
			<img src="images/pin.png" alt="Pin" /><br />
			<ul>
				<li><a href="volumes.php">Volumes</a></li>
				<li><a href="articles.php?letter=அ">Articles</a></li>
				<li><a href="authors.php?letter=அ" class="active">Authors</a></li>
				<li><a href="features.php">Categories</a></li>
				<li><a href="search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="footer">
		<img src="images/footer.png" alt="Footer Flow" />
	</div>
</div>
</body>

</html>
