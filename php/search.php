<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sri Ramakrishna Vijayam</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/style.css" media="screen" rel="stylesheet" type="text/css" />

<link href="images/favicon.ico" rel="shortcut icon" />
<script type="text/javascript" src="js/tamil_kbd.js" charset="UTF-8"></script>
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
		<div class="maintitle">Search</div>
		<div class="rule">&nbsp;</div>
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder">
			<img class="tag" src="images/tag.png" alt="Tag" />
			<ul>
				<li>
					<span class="titlespan">&nbsp;</span>
				</li>
			</ul>
<?php include("keyboard.php"); ?>
			<form action="searchresult.php" method="POST">
				<table class="searchtable">
					<tr>
						<td class="sleft" >Title</td>
						<td class="sright"><input name="title" id="title" onfocus="SetId('title')"/></td>
					</tr>
					<tr>
						<td class="sleft">Author</td>
						<td class="sright"><input name="author" id="author" onfocus="SetId('author')"/></td>
					</tr>
					
<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

echo "<tr>
	<td class=\"sleft\">Category</td>
	<td class=\"sright\"><select name=\"feature\" id=\"feature\" style=\"width: 17em;\">";

$query1 = "select distinct feature from article order by feature";
$result1 = mysql_query($query1);

$num_rows1 = mysql_num_rows($result1);

if($num_rows1)
{
	for($i=0;$i<$num_rows1;$i++)
	{
		$row1=mysql_fetch_assoc($result1);
		$feature=$row1['feature'];

		echo "<option value=\"$feature\">$feature</option>";
	}
}

echo "</select></td>
</tr>
<tr>
	<td class=\"sleft\">Year</td>
	<td class=\"sright\">From&nbsp;&nbsp;&nbsp;<select name=\"year1\" id=\"year1\"><option></option>";

$query = "select distinct year from article order by year";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=0;$i<$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);
		$year=$row['year'];

		echo "<option value=\"$year\">$year</option>";
	}
}
echo "</select>&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;<select name=\"year2\" id=\"year2\"><option></option>";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=0;$i<$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);
		$year=$row['year'];

		echo "<option value=\"$year\">$year</option>";
	}
}
echo "</select></td>
</tr>";
?>
					<tr>
						<td class="sleft">Text</td>
						<td class="sright"><input name="text" id="text" onfocus="SetId('text')"/></td>
					</tr>
					<tr class="sub_res">
						<td class="sleft" colspan="2">
							<input type="submit" value="Submit"/>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="reset" value="Reset"/>
						</td>
					</tr>
				</table>
			</form>
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
				<li><a href="authors.php?letter=அ">Authors</a></li>
				<li><a href="features.php">Categories</a></li>
				<li><a class="active" href="search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="footer">
		<img src="images/footer.png" alt="Footer Flow" />
	</div>
</div>
</body>

</html>
