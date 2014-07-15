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
		<div class="maintitle">List of Articles</div>
		<div class="rule">&nbsp;</div>
		<div class="alphabet">
			<ul>
				<li><a href="articles.php?letter=அ">அ</a></li>
				<li><a href="articles.php?letter=ஆ">ஆ</a></li>
				<li><a href="articles.php?letter=இ">இ</a></li>
				<li><a href="articles.php?letter=ஈ">ஈ</a></li>
				<li><a href="articles.php?letter=உ">உ</a></li>
				<li><a href="articles.php?letter=ஊ">ஊ</a></li>
				<li><a href="articles.php?letter=எ">எ</a></li>
				<li><a href="articles.php?letter=ஏ">ஏ</a></li>
				<li><a href="articles.php?letter=ஐ">ஐ</a></li>
				<li><a href="articles.php?letter=ஒ">ஒ</a></li>
				<li><a href="articles.php?letter=ஓ">ஓ</a></li>
				<li><a href="articles.php?letter=க">க</a></li>
				<li><a href="articles.php?letter=ச">ச</a></li>
				<li><a href="articles.php?letter=ஜ">ஜ</a></li>
				<li><a href="articles.php?letter=ஞ">ஞ</a></li>
				<li><a href="articles.php?letter=ட">ட</a></li>
				<li><a href="articles.php?letter=த">த</a></li>
				<li><a href="articles.php?letter=ந">ந</a></li>
				<li><a href="articles.php?letter=ப">ப</a></li>
				<li><a href="articles.php?letter=ம">ம</a></li>
				<li><a href="articles.php?letter=ய">ய</a></li>
				<li><a href="articles.php?letter=ர">ர</a></li>
				<li><a href="articles.php?letter=ல">ல</a></li>
				<li><a href="articles.php?letter=வ">வ</a></li>
				<li><a href="articles.php?letter=ஸ">ஸ</a></li>
				<li><a href="articles.php?letter=ஷ">ஷ</a></li>
				<li><a href="articles.php?letter=ஸ்ரீ">ஸ்ரீ</a></li>
				<li><a href="articles.php?letter=ஹ">ஹ</a></li>
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
	$query = "select * from article where ((title like 'ஸ%') and (title not like 'ஸ்ரீ%')) order by title, volume, issue, page";
}
else
{
	$query = "select * from article where title regexp '^$letter' order by title, volume, issue, page";
}

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$titleid=$row['titleid'];
		$title=$row['title'];
		$feature=$row['feature'];
		$page=$row['page'];
		$authid=$row['authid'];
		$volume=$row['volume'];
		$issue=$row['issue'];
		$year=$row['year'];
		$month=$row['month'];

		echo "<li><span class=\"titlespan\"><a href=\"../Volumes/$volume/$issue/index.djvu?djvuopts&page=$page.djvu&zoom=page\" target=\"_blank\">$title</a></span>";
		if($authid != 0)
		{

			echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
			$aut = preg_split('/;/',$authid);

			$fl = 0;
			foreach ($aut as $aid)
			{
				$query2 = "select * from author where authid=$aid";
				$result2 = mysql_query($query2);

				$num_rows2 = mysql_num_rows($result2);

				if($num_rows2)
				{
					$row2=mysql_fetch_assoc($result2);

					$authorname=$row2['authorname'];
					$authorname_new=$row2['authorname_new'];
					
					if($fl == 0)
					{
						echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$aid&author=$authorname\">$authorname</a></span>";
						$fl = 1;
					}
					else
					{
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"auth.php?authid=$aid&author=$authorname\">$authorname</a></span>";
					}
				}

			}
		}
		echo "<br />";
		if($feature != "")
		{
			echo "<span class=\"featurespan\"><a href=\"feat.php?feature=$feature\">$feature</a></span>&nbsp;&nbsp;";
		}
		echo "<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&issue=$issue\">(".$month_name{intval($month)}."&nbsp;".$year.")</a></span>";
		echo "</li>\n";
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
				<li><a href="articles.php?letter=அ" class="active">Articles</a></li>
				<li><a href="authors.php?letter=அ">Authors</a></li>
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
