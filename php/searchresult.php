<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sri Ramakrishna Vijayam</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/style.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<link href="images/favicon.ico" rel="shortcut icon" />
</head>

<body>
<div id="loader"><img src="images/loading.gif" alt="Loader"/></div>
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
			<ul data-page="1" data="true" id="pageLazy">
<?php

$eauthor=$_POST['author'];
$etitle=$_POST['title'];
$efeature=$_POST['feature'];
$eyear1=$_POST['year1'];
$eyear2=$_POST['year2'];
$text=$_POST['text'];

echo "<iframe class=\"num_result\" src=\"get_count.php?author=$eauthor&title=$etitle&feature=$efeature&year1=$eyear1&year2=$eyear2&text=$text\"></iframe>";

include("search-ajax.php");

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
<script type="text/javascript">
	$(document).ready(function(){
		var mul = $('#pageLazy').attr('data-page');
		var pagenum = mul.split(/;/)[0];
		var level = mul.split(/;/)[1];
		var goNow = true;
		$(window).scroll( function() {
			var go = $('#pageLazy');
			
			var postData = <?php echo !empty($_POST)?json_encode($_POST):'null';?>;
			if(go.attr('data') == "true" && goNow == true){
				if(($(this).scrollTop() + $(this).innerHeight()) > ($(document).height() - 3000)) {
					
					$('#loader').fadeIn(500);
					pagenum = parseInt(pagenum)+parseInt(1);

					goNow = false;
					if(level != 1){
					$.ajax({
						type: "POST",
						url: "search-ajax.php?page=" + pagenum,
						dataType: "html",
						data: postData,
						success: function(res){
							if(res.match(/No result/) == null) {
								goNow = true;
								$('#loader').fadeOut(500);
								go.append(res).fadeIn();
							} else {
								goNow = false;
								$('#loader').fadeOut(500);
							}
						},
						error: function(e){
							goNow = false;
							$('#loader').fadeOut(500);
						}
					});}
				}
			}
		});
	});
</script>
</body>

</html>
