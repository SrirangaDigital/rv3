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
		<div class="maintitle">Search Result</div>
		<div class="rule">&nbsp;</div>
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder_back">
		<div class="archive_holder">
			<img class="tag" src="images/tag.png" alt="Tag" />
			<ul>
<?php

include("connect.php");

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$eauthor=$_POST['author'];
$etitle=$_POST['title'];
$efeature=$_POST['feature'];
$eyear1=$_POST['year1'];
$eyear2=$_POST['year2'];
$text=$_POST['text'];
$text2 = $text;

$eauthor = preg_replace("/[\t]+/", " ", $eauthor);
$eauthor = preg_replace("/[ ]+/", " ", $eauthor);
$eauthor = preg_replace("/^ /", "", $eauthor);
$eauthor = preg_replace("/[ ]+$/", "", $eauthor);

$etitle = preg_replace("/[\t]+/", " ", $etitle);
$etitle = preg_replace("/[ ]+/", " ", $etitle);
$etitle = preg_replace("/^ /", "", $etitle);
$etitle = preg_replace("/[ ]+$/", "", $etitle);

if($etitle=='')
{
	$etitle='.*';
}
if($eauthor=='')
{
	$eauthor='.*';
}
if($efeature=='')
{
	$efeature='.*';
}
if($eyear1=='')
{
	$eyear1='1921';
}
if($eyear2=='')
{
	$eyear2='2012';
}

if($eyear1 > $eyear2)
{
	$temp = $eyear1;
	$eyear1 = $eyear2;
	$eyear2 = $temp;
}

if($text=='')
{
	$query="SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM
						(SELECT * FROM article WHERE authorname REGEXP '$eauthor') AS tb1
					WHERE title REGEXP '$etitle') AS tb2
				WHERE feature REGEXP '$efeature') AS tb3
			WHERE year between $eyear1 and $eyear2 ORDER BY volume, issue, page";
	$result = mysql_query($query,$db);
	$num_results = mysql_num_rows($result);
}
elseif($text!='')
{
	$text = rtrim($text);

	$query="SELECT * FROM searchtable WHERE text REGEXP '$text' and authorname REGEXP '$eauthor' and title REGEXP '$etitle' and feature REGEXP '$efeature' and year between $eyear1 and $eyear2 ORDER BY volume, issue, page";

	$result = mysql_unbuffered_query($query,$db);
	$num_results = 0;
}

$titleid[0]=0;
$count = 1;
$id = 0;
if(($num_results > 0) || ($text != ''))
{
	while($row = mysql_fetch_assoc($result))
	{
		$titleid=$row['titleid'];
		$title=$row['title'];
		$feature=$row['feature'];
		$page=$row['page'];
		$authid=$row['authid'];
		$authorname=$row['authorname'];
		$volume=$row['volume'];
		$issue=$row['issue'];
		$year=$row['year'];
		$month=$row['month'];
		
		if($text != '')
		{
			$cur_page = $row['cur_page'];
		}
		
		$title_display = $title;
		if($etitle != '.*')
		{
			$title_display = preg_replace("/$etitle/", "<span class=\"hlight\">$etitle</span>", $title);
		}
		
		if ($id != $titleid)
		{
			echo "<li><span class=\"titlespan\"><a href=\"../Volumes/$volume/$issue/index.djvu?djvuopts&page=$page.djvu&zoom=page&find=$text2\" target=\"_blank\">$title_display</a></span>";
			if($authid != 0)
			{

				echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
				$aut = preg_split('/;/',$authid);
				$anms = preg_split('/;/',$authorname);

				$fl = 0;
				for ($k=0;$k<sizeof($aut);$k++)
				{
					$authorname_display = $anms[$k];
					if($eauthor != '.*')
					{
						$authorname_display = preg_replace("/$eauthor/", "<span class=\"hlight\">$eauthor</span>", $anms[$k]);
					}
					
					if($fl == 0)
					{
						echo "<span class=\"authorspan\"><a href=\"auth.php?authid=".$aut[$k]."&author=".$anms[$k]."\">$authorname_display</a></span>";
						$fl = 1;
					}
					else
					{
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"auth.php?authid=".$anms[$k]."&author=".$anms[$k]."\">$authorname_display</a></span>";
					}
				}
			}
			echo "<br />";
			if($feature != "")
			{
				echo "<span class=\"featurespan\"><a href=\"feat.php?feature=$feature\">$feature</a></span>&nbsp;&nbsp;";
			}
			echo "<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&issue=$issue\">(".$month_name{intval($month)}."&nbsp;".$year.")</a></span><br />";
			if($text != '')
			{
				echo "<span class=\"authorspan\"><span class=\"hlight\">$text</span>&nbsp;found at page no(s). </span>";
				echo "<span class=\"titlespan small\"><a href=\"../Volumes/$volume/$issue/index.djvu?djvuopts&page=$cur_page.djvu&zoom=page&find=$text2\" target=\"_blank\"\">&nbsp;".intval($cur_page)."&nbsp;</a></span>";
				$id = $titleid;
			}
		}
		else
		{
			echo "<span class=\"titlespan small\"><a href=\"../Volumes/$volume/$issue/index.djvu?djvuopts&page=$cur_page.djvu&zoom=page&find=$text2\" target=\"_blank\"\">&nbsp;".intval($cur_page)."&nbsp;</a></span>";
			$id = $titleid;
		}
/*
		echo "</li>\n";
*/
	}
	$num_results = mysql_num_rows($result);
}
else
{
	echo"<ul><li><span class=\"titlespan\">No result</span><br />";
	echo"<span class=\"authorspan\"><a href=\"search.php\">Please go back and search again</a></span></li></ul>";
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
<?php
if($num_results > 0)
{
	echo "<div class=\"nresult\"><span class=\"authorspan\">$num_results result(s)</span></div>";
}
?>
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
