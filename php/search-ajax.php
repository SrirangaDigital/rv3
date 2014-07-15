<?php

require_once("connect.php");

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");
mysql_query("set names utf8");

$eauthor=$_POST['author'];
$etitle=$_POST['title'];
$efeature=$_POST['feature'];
$eyear1=$_POST['year1'];
$eyear2=$_POST['year2'];
$text=$_POST['text'];
$text2 = $text;

$eauthor = preg_replace("/[,\-]+/", " ", $eauthor);
$eauthor = preg_replace("/[\t]+/", " ", $eauthor);
$eauthor = preg_replace("/[ ]+/", " ", $eauthor);
$eauthor = preg_replace("/^ +/", "", $eauthor);
$eauthor = preg_replace("/ +$/", "", $eauthor);
$eauthor = preg_replace("/  /", " ", $eauthor);
$eauthor = preg_replace("/  /", " ", $eauthor);

$etitle = preg_replace("/[,\-]+/", " ", $etitle);
$etitle = preg_replace("/[\t]+/", " ", $etitle);
$etitle = preg_replace("/[ ]+/", " ", $etitle);
$etitle = preg_replace("/^ +/", "", $etitle);
$etitle = preg_replace("/ +$/", "", $etitle);
$etitle = preg_replace("/  /", " ", $etitle);
$etitle = preg_replace("/  /", " ", $etitle);

$text = preg_replace("/[,\-]+/", " ", $text);
$text = preg_replace("/[\t]+/", " ", $text);
$text = preg_replace("/[ ]+/", " ", $text);
$text = preg_replace("/^ +/", "", $text);
$text = preg_replace("/ +$/", "", $text);
$text = preg_replace("/  /", " ", $text);
$text = preg_replace("/  /", " ", $text);
$text2 = $text;

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
	$eyear2='2014';
}
if($eyear1 > $eyear2)
{
	$temp = $eyear1;
	$eyear1 = $eyear2;
	$eyear2 = $temp;
}

$authorFilter = '';
$titleFilter = '';
$textFilter = '';
$textSearchBox = '';

$authors = preg_split("/ /", $eauthor);
$titles = preg_split("/ /", $etitle);
$texts = preg_split("/ /", $text);

for($ic=0;$ic<sizeof($authors);$ic++)
{
	$authorFilter .= "and authorname REGEXP '" . $authors[$ic] . "' ";
}
for($ic=0;$ic<sizeof($titles);$ic++)
{
	$titleFilter .= "and title REGEXP '" . $titles[$ic] . "' ";
}
for($ic=0;$ic<sizeof($texts);$ic++)
{
	$textFilter .= "+" . $texts[$ic] . " ";
	$textSearchBox .= "|" . $texts[$ic];
}

$authorFilter = preg_replace("/^and /", "", $authorFilter);
$titleFilter = preg_replace("/^and /", "", $titleFilter);
$textSearchBox = preg_replace("/^\|/", "", $textSearchBox);

if($text=='')
{
	$query="SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM
						(SELECT * FROM article WHERE $authorFilter) AS tb1
					WHERE $titleFilter) AS tb2
				WHERE feature REGEXP '$efeature') AS tb3
			WHERE year between $eyear1 and $eyear2 ORDER BY volume, issue, page";
}
elseif($text!='')
{
	$text = rtrim($text);
	
	$query="SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM
						(SELECT * FROM
							(SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$textFilter' IN BOOLEAN MODE))
						AS tb1 WHERE $authorFilter)
					AS tb2 WHERE $titleFilter)
				AS tb3 WHERE feature REGEXP '$efeature')
			AS tb4 WHERE year between $eyear1 and $eyear2 ORDER BY volume, issue, cur_page";
}

if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']))
{
	$query .= " LIMIT ".(($_GET['page'] - 1)*20).",20";
}
else
{
	$query .= " LIMIT 20";
}

$result = mysql_query($query);
$num_results = mysql_num_rows($result);

$titleid[0]=0;
$count = 1;
$id = 0;

if($num_results > 0)
{
	for($i=1;$i<=$num_results;$i++)
	{
		$row = mysql_fetch_assoc($result);
		
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
