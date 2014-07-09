#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();
@ids=();

open(IN,"<:utf8","rv.xml") or die "can't open rv_new.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

#vnum, number, month, year, title, feature, authid, page, 

$sth11=$dbh->prepare("CREATE TABLE article(title varchar(500), 
title_new varchar(500), 
authid varchar(200), 
authorname varchar(1000), 
feature varchar(200), 
page varchar(5), 
page_end varchar(5), 
volume varchar(3),
issue varchar(5),
year int(4), 
month varchar(2),
titleid int(6) auto_increment, primary key(titleid)) ENGINE=MyISAM character set utf8 collate utf8_general_ci");
$sth11->execute();
$sth11->finish(); 

$line = <IN>;

$authids = "";
$author_name = "";

while($line)
{
	if($line =~ /<volume vnum="(.*)">/)
	{
		$volume = $1;
		print $volume . "\n";
	}
	elsif($line =~ /<issue inum="(.*)" month="(.*)" year="(.*)">/)
	{
		$issue = $1;
		$month = $2;
		$year = $3;
	}	
	elsif($line =~ /<title>(.*)<\/title>/)
	{
		$title = $1;
	}
	elsif($line =~ /<feature>(.*)<\/feature>/)
	{
		$feature = $1;
	}	
	elsif($line =~ /<page>(.*)<\/page>/)
	{
		$pages = $1;
		($page, $page_end) = split(/-/, $pages);
	}	
	elsif($line =~ /<author>(.*)<\/author>/)
	{
		$authorname = $1;
		$authids = $authids . ";" . get_authid($authorname);
		$author_name = $author_name . ";" .$authorname;
	}
	elsif($line =~ /<allauthors\/>/)
	{
		$authids = "0";
		$author_name = "";
	}
	elsif($line =~ /<\/entry>/)
	{
		insert_article($title,$authids,$author_name,$feature,$page,$page_end,$volume,$issue,$year,$month);
		$authids = "";
		$author_name = "";
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();

sub insert_article()
{
	my($title,$authids,$author_name,$feature,$page,$page_end,$volume,$issue,$year,$month) = @_;
	my($sth1);

	$title =~ s/'/\\'/g;
	$feature =~ s/'/\\'/g;
	$authids =~ s/^;//;
	$author_name =~ s/^;//;
	$author_name =~ s/'/\\'/g;
	
	$sth1=$dbh->prepare("insert into article values('$title','$title','$authids','$author_name','$feature','$page','$page_end','$volume','$issue','$year','$month','')");
	
	$sth1->execute();
	$sth1->finish();
}

sub get_authid()
{
	
	my($authorname) = @_;
	my($sth,$ref,$authid);

	$authorname =~ s/'/\\'/g;
	
	$sth=$dbh->prepare("select authid from author where authorname='$authorname'");
	$sth->execute();
			
	my $ref = $sth->fetchrow_hashref();
	$authid = $ref->{'authid'};
	$sth->finish();
	return($authid);
}	
