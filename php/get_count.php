<?php

require_once("connect.php");

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");
mysql_query("set names utf8");

$eauthor=$_GET['author'];
$etitle=$_GET['title'];
$efeature=$_GET['feature'];
$eyear1=$_GET['year1'];
$eyear2=$_GET['year2'];
$text=$_GET['text'];
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
	$eyear2='2012';
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
	$query="SELECT count(*) FROM
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
	
	$query="SELECT count(*) FROM
				(SELECT * FROM
					(SELECT * FROM
						(SELECT * FROM
							(SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$textFilter' IN BOOLEAN MODE))
						AS tb1 WHERE $authorFilter)
					AS tb2 WHERE $titleFilter)
				AS tb3 WHERE feature REGEXP '$efeature')
			AS tb4 WHERE year between $eyear1 and $eyear2 ORDER BY volume, issue, cur_page";
}

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$num_results = $row['count(*)'];

if ($num_results > 0)
{
	echo "<!DOCTYPE html>
	<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<title>Jivan Vikas</title>
	<link href=\"style/font.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\" />
	</head>

	<body>
	<div class=\"page\">
	<span class=\"authorspan\">" . $num_results . " results(s)</span>
	</page>
	</body>
	</html>";
}

?>
