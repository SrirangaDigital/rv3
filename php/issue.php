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
<?php

include("connect.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");

$volume=$_GET['vol'];
$year=$_GET['year'];

echo "<div class=\"maintitle\">".$year."&nbsp;(Volume&nbsp;".intval($volume).")</div>";
echo"<div class=\"rule\">&nbsp;</div>
		<div class=\"archive_holder_back\">
		<div class=\"archive_holder_back\">
		<div class=\"archive_holder_back\">
		<div class=\"archive_holder_back\">
		<div class=\"archive_holder_vol\">
			<img class=\"tag_vol\" src=\"images/tag.png\" alt=\"Tag\" />";

$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct issue, month from article where volume='$volume' order by issue";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

$count = 0;
$row_count = 5;
echo "<li><table class=\"vol_table\"><tr class=\"no_border\">";
					
for($i=1;$i<=$num_rows;$i++)
{
	$row=mysql_fetch_assoc($result);
	$issue=$row['issue'];
	$month=$row['month'];

	$count++;
	
	$issue_int = preg_split("/\-/", $issue);
	
	if(sizeof($issue_int) == 2)
	{
		$issue_int = intval($issue_int[0]) . "-" . intval($issue_int[1]);
	}
	else
	{
		$issue_int = intval($issue_int[0]);
	}
	
	if($count > $row_count)
	{
		echo "</tr></table></li><li><table class=\"vol_table\"><tr>";
		$count = 1;
	}
	echo "<td><span class=\"volspan\"><a href=\"toc.php?vol=$volume&issue=$issue\">".$month_name{intval($month)}."<br /><span class=\"yearspan\">(Issue $issue_int)</span></a></span></td>";
}

echo "</tr></table></li>";

?>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="archive_nav">
			<img src="images/pin.png" alt="Pin" /><br />
			<ul>
				<li><a href="volumes.php" class="active">Volumes</a></li>
				<li><a href="articles.php?letter=அ">Articles</a></li>
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
