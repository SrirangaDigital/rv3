#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$sth_enc=$dbh->prepare("set names utf8");
$sth_enc->execute();
$sth_enc->finish();

$sth11=$dbh->prepare("CREATE TABLE testocr(volume varchar(3),
issue varchar(6),
cur_page varchar(10),
text varchar(10000)) ENGINE=MyISAM character set utf8 collate utf8_general_ci");

$sth11->execute();
$sth11->finish(); 

@volumes = `ls Text`;

for($i1=0;$i1<@volumes;$i1++)
{
	print $volumes[$i1];
	chop($volumes[$i1]);
	
	@issues = `ls Text/$volumes[$i1]/`;

	for($i2=0;$i2<@issues;$i2++)
	{
		chop($issues[$i2]);

		@files = `ls Text/$volumes[$i1]/$issues[$i2]/`;
		
		for($i3=0;$i3<@files;$i3++)
		{
			chop($files[$i3]);
			if($files[$i3] =~ /\_db\.txt/)
			{
				$vol = $volumes[$i1];
				$iss = $issues[$i2];
				$cur_page = $files[$i3];
				
				open(DATA,"<:utf8","Text/$vol/$iss/$cur_page")or die ("cannot open Text/$vol/$iss/$cur_page");
				
				$cur_page =~ s/\_db\.txt//g;
						
				$line=<DATA>;
				
				$sth1=$dbh->prepare("insert into testocr values ('$vol','$iss','$cur_page','$line')");
				$sth1->execute();
				$sth1->finish();
				
				close(DATA);
			}
		}
	}
}
