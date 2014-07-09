#!/usr/bin/perl

use utf8;
use Switch;

@volumes = `ls Text`;

for($i1=0;$i1<@volumes;$i1++)
{
	chop($volumes[$i1]);
	
	@issues = `ls Text/$volumes[$i1]/`;

	for($i2=0;$i2<@issues;$i2++)
	{
		chop($issues[$i2]);

		@files = `ls Text/$volumes[$i1]/$issues[$i2]/`;
		
		for($i3=0;$i3<@files;$i3++)
		{
			chop($files[$i3]);
			if($files[$i3] =~ /\.txt/)
			{
				$ntxt = "/var/www/rv3/Text/$volumes[$i1]/$issues[$i2]/" . $files[$i3];
				print $ntxt . "\n";
				conv_t2u($ntxt);
			}
		}
	}
}

sub conv_t2u($c)
{
my($ntxt) = @_;

my($str, $c1, $c2, $c3, $c4, $wrd, $i, $uni, $tstr, $ntxt_uni, $ntxt_db);

$ntxt_uni = $ntxt;
$ntxt_db = $ntxt;
$ntxt_uni =~s/\.txt/\_uni.txt/g;
$ntxt_db =~s/\.txt/\_db.txt/g;

open(IN, $ntxt) or die "can't open $ntxt\n";
open(OUTUNI,">:utf8", $ntxt_uni) or die "Can not open $ntxt_uni\n";
open(OUTDB,">:utf8", $ntxt_db) or die "Can not open $ntxt_db\n";


$str = <IN>;

$tstr = '';
@wrds = ();

while($str)
{
	if($str =~ /\(word ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+) \"(.*)\"\)/)
	{
		$c1 = $1;
		$c2 = $2;
		$c3 = $3;
		$c4 = $4;
		
		$wrd = $5;
		
		$wrd =~ s/158\|([0-9][0-9][0-9])/$1|158/;
		$wrd =~ s/159\|([0-9][0-9][0-9])/$1|159/;
		$wrd =~ s/160\|([0-9][0-9][0-9])/$1|160/;
		
		$wrd =~ s/158\|157/177/;
		$wrd =~ s/159\|157/178/;
		
		$wrd =~ s/^|//;
		
		@wrds = split(/\|/, $wrd);

		$uni = '';
		for($i=0;$i<@wrds;$i++)
		{
			$uni = $uni . convert_unicode($wrds[$i]);			
		}
		
		print OUTUNI "\t(word " . $c1 . " " . $c2 . " " . $c3 . " " . $c4 . " \"" . $uni . "\")\n";
		
		$uni =~s/\.//g;
		$uni =~s/\,//g;
		$uni =~s/\'//g;
		$uni =~s/\?//g;
		$uni =~s/\!//g;
				
		if(!($tstr =~ /\b$uni\b/))
		{
			$tstr = $tstr . " " . $uni;
		}
		@wrds = ();
	}
	else
	{
		print OUTUNI $str;
	}
	$str = <IN>;
}

print OUTDB $tstr;
 
close(IN);
close(OUTUNI);
close(OUTDB);

}


sub convert_unicode($c)
{
	use Switch;

	my($c) = @_;
	my($d);
	
	$c = int($c);
	
	switch ($c)
	{
		case 1 { $d = 'அ'}
		case 2 { $d = 'ஆ'}
		case 3 { $d = 'இ'}
		case 4 { $d = 'ஈ'}
		case 5 { $d = 'உ'}
		case 6 { $d = 'ஊ'}
		case 7 { $d = 'எ'}
		case 8 { $d = 'ஏ'}
		case 9 { $d = 'ஐ'}
		case 10 { $d = 'ஒ'}
		case 11 { $d = 'ஓ'}
		case 12 { $d = 'ஔ'}
		case 13 { $d = 'க்'}
		case 14 { $d = 'க'}
		case 15 { $d = 'கி'}
		case 16 { $d = 'கீ'}
		case 17 { $d = 'கு'}
		case 18 { $d = 'கூ'}
		case 19 { $d = 'ங்'}
		case 20 { $d = 'ங'}
		case 21 { $d = 'ஙி'}
		case 22 { $d = 'ஙீ'}
		case 23 { $d = 'ஙு'}
		case 24 { $d = 'ஙூ'}
		case 25 { $d = 'ச்'}
		case 26 { $d = 'ச'}
		case 27 { $d = 'சி'}
		case 28 { $d = 'சீ'}
		case 29 { $d = 'சு'}
		case 30 { $d = 'சூ'}
		case 31 { $d = 'ஞ்'}
		case 32 { $d = 'ஞ'}
		case 33 { $d = 'ஞி'}
		case 34 { $d = 'ஞீ'}
		case 35 { $d = 'ஞு'}
		case 36 { $d = 'ஞூ'}
		case 37 { $d = 'ட்'}
		case 38 { $d = 'ட'}
		case 39 { $d = 'டி'}
		case 40 { $d = 'டீ'}
		case 41 { $d = 'டு'}
		case 42 { $d = 'டூ'}
		case 43 { $d = 'ண்'}
		case 44 { $d = 'ண'}
		case 45 { $d = 'ணி'}
		case 46 { $d = 'ணீ'}
		case 47 { $d = 'ணு'}
		case 48 { $d = 'ணூ'}
		case 49 { $d = 'த்'}
		case 50 { $d = 'த'}
		case 51 { $d = 'தி'}
		case 52 { $d = 'தீ'}
		case 53 { $d = 'து'}
		case 54 { $d = 'தூ'}
		case 55 { $d = 'ந்'}
		case 56 { $d = 'ந'}
		case 57 { $d = 'நி'}
		case 58 { $d = 'நீ'}
		case 59 { $d = 'நு'}
		case 60 { $d = 'நூ'}
		case 61 { $d = 'ப்'}
		case 62 { $d = 'ப'}
		case 63 { $d = 'பி'}
		case 64 { $d = 'பீ'}
		case 65 { $d = 'பு'}
		case 66 { $d = 'பூ'}
		case 67 { $d = 'ம்'}
		case 68 { $d = 'ம'}
		case 69 { $d = 'மி'}
		case 70 { $d = 'மீ'}
		case 71 { $d = 'மு'}
		case 72 { $d = 'மூ'}
		case 73 { $d = 'ய்'}
		case 74 { $d = 'ய'}
		case 75 { $d = 'யி'}
		case 76 { $d = 'யீ'}
		case 77 { $d = 'யு'}
		case 78 { $d = 'யூ'}
		case 79 { $d = 'ர்'}
		case 80 { $d = 'ர'}
		case 81 { $d = 'ரி'}
		case 82 { $d = 'ரீ'}
		case 83 { $d = 'ரு'}
		case 84 { $d = 'ரூ'}
		case 85 { $d = 'ல்'}
		case 86 { $d = 'ல'}
		case 87 { $d = 'லி'}
		case 88 { $d = 'லீ'}
		case 89 { $d = 'லு'}
		case 90 { $d = 'லூ'}
		case 91 { $d = 'வ்'}
		case 92 { $d = 'வ'}
		case 93 { $d = 'வி'}
		case 94 { $d = 'வீ'}
		case 95 { $d = 'வு'}
		case 96 { $d = 'வூ'}
		case 97 { $d = 'ழ்'}
		case 98 { $d = 'ழ'}
		case 99 { $d = 'ழி'}
		case 100 { $d = 'ழீ'}
		case 101 { $d = 'ழு'}
		case 102 { $d = 'ழூ'}
		case 103 { $d = 'ள்'}
		case 104 { $d = 'ள'}
		case 105 { $d = 'ளி'}
		case 106 { $d = 'ளீ'}
		case 107 { $d = 'ளு'}
		case 108 { $d = 'ளூ'}
		case 109 { $d = 'ற்'}
		case 110 { $d = 'ற'}
		case 111 { $d = 'றி'}
		case 112 { $d = 'றீ'}
		case 113 { $d = 'று'}
		case 114 { $d = 'றூ'}
		case 115 { $d = 'ன்'}
		case 116 { $d = 'ன'}
		case 117 { $d = 'னி'}
		case 118 { $d = 'னீ'}
		case 119 { $d = 'னு'}
		case 120 { $d = 'னூ'}
		case 121 { $d = 'ஶ்'}
		case 122 { $d = 'ஶ'}
		case 123 { $d = 'ஶி'}
		case 124 { $d = 'ஶீ'}
		case 125 { $d = 'ஶு'}
		case 126 { $d = 'ஶூ'}
		case 127 { $d = 'ஜ்'}
		case 128 { $d = 'ஜ'}
		case 129 { $d = 'ஜி'}
		case 130 { $d = 'ஜீ'}
		case 131 { $d = 'ஜு'}
		case 132 { $d = 'ஜூ'}
		case 133 { $d = 'ஷ்'}
		case 134 { $d = 'ஷ'}
		case 135 { $d = 'ஷி'}
		case 136 { $d = 'ஷீ'}
		case 137 { $d = 'ஷு'}
		case 138 { $d = 'ஷூ'}
		case 139 { $d = 'ஸ்'}
		case 140 { $d = 'ஸ'}
		case 141 { $d = 'ஸி'}
		case 142 { $d = 'ஸீ'}
		case 143 { $d = 'ஸு'}
		case 144 { $d = 'ஸூ'}
		case 145 { $d = 'ஹ்'}
		case 146 { $d = 'ஹ'}
		case 147 { $d = 'ஹி'}
		case 148 { $d = 'ஹீ'}
		case 149 { $d = 'ஹு'}
		case 150 { $d = 'ஹூ'}
		case 151 { $d = 'க்ஷ்'}
		case 152 { $d = 'க்ஷ'}
		case 153 { $d = 'க்ஷி'}
		case 154 { $d = 'க்ஷீ'}
		case 155 { $d = 'க்ஷு'}
		case 156 { $d = 'க்ஷூ'}
		case 157 { $d = 'ா'}
		case 158 { $d = 'ெ'}
		case 159 { $d = 'ே'}
		case 160 { $d = 'ை'}
		case 161 { $d = 'ஸ்ரீ'}
		case 162 { $d = '1'}
		case 163 { $d = '2'}
		case 164 { $d = '3'}
		case 165 { $d = '4'}
		case 166 { $d = '5'}
		case 167 { $d = '6'}
		case 168 { $d = '7'}
		case 169 { $d = '8'}
		case 170 { $d = '9'}
		case 171 { $d = '0'}
		case 172 { $d = '.'}
		case 173 { $d = ','}
		case 174 { $d = "'"}
		case 175 { $d = '?'}
		case 176 { $d = '!'}
		case 177 { $d = 'ொ'}
		case 178 { $d = 'ோ'}
	}
	return($d);
}

