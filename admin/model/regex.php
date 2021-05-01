<?php 

class Regex
{
	public function toBBCode($string)
	{
		//HTML
		$string = preg_replace('#\<h1\>(.+)\</h1\>#isU', '[h1]$1[/h1]', $string); //h1
		$string = preg_replace('#\<h2\>(.+)\</h2\>#isU', '[h2]$1[/h2]', $string); //h2
		$string = preg_replace('#\<h3\>(.+)\</h3\>#isU', '[h3]$1[/h3]', $string); //h3
		$string = preg_replace('#\<strong\>(.+)\</strong\>#isU', '[b]$1[/b]', $string); //bold
		$string = preg_replace('#\<i\>(.+)\</i\>#isU', '[i]$1[/i]', $string); //italic
		$string = preg_replace('#\<u\>(.+)\</u\>#isU', '[u]$1[/u]', $string); //underline
		$string = preg_replace('#\<s\>(.+)\</s\>#isU', '[s]$1[/s]', $string); //crossout
		$string = preg_replace('#\<p\>(.+)\</p\>#isU', '[p]$1[/p]', $string); //paragraph
		$string = preg_replace('#\<img src\=\'(.+)\' /\>#isU', '[img]$1[/img]' , $string); //image
		$string = preg_replace('#\<img width\=\'([0-9]{1,2})\%\' height=\'([0-9]{1,2})\%\' src\=\'(.+)\' /\>#isU', '[img=$1]$3[/img]' , $string); //image with size 
		$string = preg_replace('#\<br /\>#isU', '' , $string); //br
		$string = preg_replace('#\<span style\=\'color\:\#([a-f0-9]{6})\'\>(.+)\</span\>#isU', '[color=#$1]$2[/color]', $string); //color
		$string = preg_replace('#\<div style\=\'text\-align\:(left|right|center|justify)\'\>(.+)\</div\>#isU', '[align=$1]$2[/align]', $string); //align
		$string = preg_replace('#\<div style\=\'float\:(right|left)\'\>(.+)\</div\>#isU', '[float=$1]$2[/float]' , $string); //float
		$string = preg_replace('#\<fieldset\>\<legend\>(.+)\</legend\>(.+)\</fieldset\>#isU', '[field=$1]$2[field]' , $string); //fieldset with name
		$string = preg_replace('#\<fieldset\>(.+)\</fieldset\>#isU', '[field]$1[/field]' , $string); //fieldset without name
		$string = preg_replace('#\<a href\=\'(.+)\'\>(.+)\</a\>#isU', '[url=$1]$2[/url]' , $string); //link

		$string = preg_replace('#\<(ol|ul)\>(.+)\</(ol|ul)\>#isU', '[$1]$2[/$3]', $string); //ol ul
		$string = preg_replace('#\<li\>(.+)\</li\>#isU', '[li]$1[/li]', $string); //li


		//SMILEYS
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/smile.png\' /\>#isU', ':)' , $string); // :)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/wink.png\' /\>#isU', ';)' , $string); // ;)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/flat.png\' /\>#isU', ':|' , $string); // :|
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/cry.png\' /\>#isU', ':\'(' , $string); // :'(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/sad.png\' /\>#isU', ':(' , $string); // :(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/quiet.png\' /\>#isU', ':X' , $string); // :X
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/doubts.png\' /\>#isU', ':/' , $string); // :/
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy.png\' /\>#isU', ':D' , $string); // :D
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy2.png\' /\>#isU', 'xD' , $string); // xD
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/confused.png\' /\>#isU', ':S' , $string); // :S
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/tongue.png\' /\>#isU', ':P' , $string); // :P
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/surprised.png\' /\>#isU', ':O' , $string); // :O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/mad.png\' /\>#isU', 'x(' , $string); // x(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/bored.png\' /\>#isU', '-.-' , $string); // -.-
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/ninja.png\' /\>#isU', '^:' , $string); // ^:
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/angry.png\' /\>#isU', 'xO' , $string); // xO
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/suspicious.png\' /\>#isU', 'o_O' , $string); // o_O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/nerd.png\' /\>#isU', '._.' , $string); // ._.

		return $string;
	}

	public function fromBBCode($field)
	{
		//HTML
		$string = htmlspecialchars($field);
		$string = preg_replace('#\[h1\](.+)\[/h1\]#isU', '<h1>$1</h1>', $string); //h1
		$string = preg_replace('#\[h2\](.+)\[/h2\]#isU', '<h2>$1</h2>', $string); //h2
		$string = preg_replace('#\[h3\](.+)\[/h3\]#isU', '<h3>$1</h3>', $string); //h3
		$string = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $string); //bold
		$string = preg_replace('#\[i\](.+)\[/i\]#isU', '<i>$1</i>', $string); //italic
		$string = preg_replace('#\[u\](.+)\[/u\]#isU', '<u>$1</u>', $string); //underline
		$string = preg_replace('#\[s\](.+)\[/s\]#isU', '<s>$1</s>', $string); //crossout
		$string = preg_replace('#\[p\](.+)\[/p\]#isU', '<p>$1</p>' , $string); //paragraph
		$string = preg_replace('#\[img\](.+)\[/img\]#isU', '<img src=\'$1\' />' , $string); //image
		$string = preg_replace('#\[img\=([0-9]{1,2})\](.+)\[/img\]#isU', '<img width=\'$1%\' height=\'$1%\' src=\'$2\' />' , $string); //image with size
		$string = preg_replace('#\\n#isU', '<br />' , $string); //br
		$string = preg_replace('#\[color\=\#([a-f0-9]{6})\](.+)\[/color\]#isU', '<span style=\'color:#$1\'>$2</span>', $string); //color
		$string = preg_replace('#\[align\=(left|right|center|justify)\](.+)\[/align\]#isU', '<div style=\'text-align:$1\'>$2</div>', $string); //align
		$string = preg_replace('#\[float\=(right|left)](.+)\[/float\]#isU', '<div style=\'float:$1\'>$2</div>' , $string); //float
		$string = preg_replace('#\[field\](.+)\[/field\]#isU', '<fieldset>$1</fieldset>' , $string); //fieldset without name
		$string = preg_replace('#\[field\=(.+)\](.+)\[/field\]#isU', '<fieldset><legend>$1</legend>$2</fieldset>' , $string); //fieldset with name
		$string = preg_replace('#\[url\](.+)\[/url\]#isU', '<a href=\'$1\'>$1</a>' , $string); //link
		$string = preg_replace('#\[url\=(.+)\](.+)\[/url\]#isU', '<a href=\'$1\'>$2</a>' , $string); //link=

		$string = preg_replace('#\[(ol|ul)\](.+)\[/(ol|ul)\]#isU', '<$1>$2</$3>', $string); //ol ul
		$string = preg_replace('#\[li\](.+)\[/li\]#isU', '<li>$1</li>', $string); //li

		//SMILEYS
		$string = preg_replace('# \:\)#isU', ' <img class=\'smiley\' src=\'public/css/smileys/smile.png\' />' , $string); // :)
		$string = preg_replace('# \;\)#isU', ' <img class=\'smiley\' src=\'public/css/smileys/wink.png\' />' , $string); // ;)
		$string = preg_replace('# \:\|#isU', ' <img class=\'smiley\' src=\'public/css/smileys/flat.png\' />' , $string); // :|
		$string = preg_replace('# \:\'\(#isU', ' <img class=\'smiley\' src=\'public/css/smileys/cry.png\' />' , $string); // :'(
		$string = preg_replace('# \:\(#isU', ' <img class=\'smiley\' src=\'public/css/smileys/sad.png\' />' , $string); // :(
		$string = preg_replace('# \:X#isU', ' <img class=\'smiley\' src=\'public/css/smileys/quiet.png\' />' , $string); // :X
		$string = preg_replace('# \:\/#isU', ' <img class=\'smiley\' src=\'public/css/smileys/doubts.png\' />' , $string); // :/
		$string = preg_replace('# \:D#isU', ' <img class=\'smiley\' src=\'public/css/smileys/happy.png\' />' , $string); // :D
		$string = preg_replace('# xD#isU', ' <img class=\'smiley\' src=\'public/css/smileys/happy2.png\' />' , $string); // xD
		$string = preg_replace('# \:S#isU', ' <img class=\'smiley\' src=\'public/css/smileys/confused.png\' />' , $string); // :S
		$string = preg_replace('# \:P#isU', ' <img class=\'smiley\' src=\'public/css/smileys/tongue.png\' />' , $string); // :P
		$string = preg_replace('# \:O#isU', ' <img class=\'smiley\' src=\'public/css/smileys/surprised.png\' />' , $string); // :O
		$string = preg_replace('# x\(#isU', ' <img class=\'smiley\' src=\'public/css/smileys/mad.png\' />' , $string); // x(
		$string = preg_replace('# \-\.\-#isU', ' <img class=\'smiley\' src=\'public/css/smileys/bored.png\' />' , $string); // -.-
		$string = preg_replace('# \^\:#isU', ' <img class=\'smiley\' src=\'public/css/smileys/ninja.png\' />' , $string); // ^:
		$string = preg_replace('# xO#isU', ' <img class=\'smiley\' src=\'public/css/smileys/angry.png\' />' , $string); // xO
		$string = preg_replace('# o\_O#isU', ' <img class=\'smiley\' src=\'public/css/smileys/suspicious.png\' />' , $string); // o_O
		$string = preg_replace('# \.\_\.#isU', ' <img class=\'smiley\' src=\'public/css/smileys/nerd.png\' />' , $string); // ._.
		return $string;
	}
	
	public function previewPost($string)
	{
		//HTML
		$string = preg_replace('#\<h1\>(.+)\</h1\>#isU', '$1', $string); //h1
		$string = preg_replace('#\<h2\>(.+)\</h2\>#isU', '$1', $string); //h2
		$string = preg_replace('#\<h3\>(.+)\</h3\>#isU', '$1', $string); //h3
		$string = preg_replace('#\<strong\>(.+)\</strong\>#isU', '$1', $string); //bold
		$string = preg_replace('#\<i\>(.+)\</i\>#isU', '$1', $string); //italic
		$string = preg_replace('#\<u\>(.+)\</u\>#isU', '$1', $string); //underline
		$string = preg_replace('#\<s\>(.+)\</s\>#isU', '$1', $string); //crossout
		$string = preg_replace('#\<p\>(.+)\</p\>#isU', '$1', $string); //paragraph
		$string = preg_replace('#\<img src\=\'([^(public/css/smileys/)].+)\' /\>#isU', '' , $string); //image 
		$string = preg_replace('#\<img width\=\'([0-9]{1,2})\%\' height=\'([0-9]{1,2})\%\' src\=\'(.+)\' /\>#isU', '' , $string); //image with size 
		$string = preg_replace('#\<br /\>#isU', '' , $string); //br
		$string = preg_replace('#\<span style\=\'color\:\#([a-f0-9]{6})\'\>(.+)\</span\>#isU', '$2', $string); //color
		$string = preg_replace('#\<div style\=\'text\-align\:(left|right|center|justify)\'\>(.+)\</div\>#isU', '$2', $string); //align
		$string = preg_replace('#\<div style\=\'float\:(right|left)\'\>(.+)\</div\>#isU', '$2' , $string); //float
		$string = preg_replace('#\<fieldset\>\<legend\>(.+)\</legend\>(.+)\</fieldset\>#isU', '$2' , $string); //fieldset with name
		$string = preg_replace('#\<fieldset\>(.+)\</fieldset\>#isU', '$1' , $string); //fieldset without name
		$string = preg_replace('#\<a href\=\'(.+)\'\>(.+)\</a\>#isU', '$2' , $string); //link

		$string = preg_replace('#\<(ol|/ol|ul|/ul)\>#isU', '', $string); //ol ul
		$string = preg_replace('#\<li\>(.+)\</li\>#isU', '<br />- $1<br />', $string); //li


		//SMILEYS
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/smile.png\' /\>#isU', ':)' , $string); // :)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/wink.png\' /\>#isU', ';)' , $string); // ;)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/flat.png\' /\>#isU', ':|' , $string); // :|
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/cry.png\' /\>#isU', ':\'(' , $string); // :'(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/sad.png\' /\>#isU', ':(' , $string); // :(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/quiet.png\' /\>#isU', ':X' , $string); // :X
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/doubts.png\' /\>#isU', ':/' , $string); // :/
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy.png\' /\>#isU', ':D' , $string); // :D
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy2.png\' /\>#isU', '' , $string); // xD
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/confused.png\' /\>#isU', ':S' , $string); // :S
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/tongue.png\' /\>#isU', ':P' , $string); // :P
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/surprised.png\' /\>#isU', ':O' , $string); // :O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/mad.png\' /\>#isU', 'x(' , $string); // x(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/bored.png\' /\>#isU', '' , $string); // -.-
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/ninja.png\' /\>#isU', '^:' , $string); // ^:
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/angry.png\' /\>#isU', '' , $string); // xO
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/suspicious.png\' /\>#isU', '' , $string); // o_O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/nerd.png\' /\>#isU', '' , $string); // ._.
		return $string;
	}

	public function date($string)
	{
		$string = preg_replace('#([0-3][0-9]{3})-([0-1][0-9])-([0-3][0-9])#isU', '$3/$2/$1' , $string);
		return $string;
	}

	public function time($string)
	{
		$string = preg_replace('#([0-2][0-9]):([0-5][0-9]):00#isU', '$1h$2min' , $string);
		return $string;
	}
}