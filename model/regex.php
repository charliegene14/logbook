<?php

class Regex
{
	public function previewPost($string)
	{
		$string = preg_replace('#\<h1\>(.+)\</h1\>#isU', '$1', $string); //h1
		$string = preg_replace('#\<h2\>(.+)\</h2\>#isU', '$1', $string); //h2
		$string = preg_replace('#\<h3\>(.+)\</h3\>#isU', '$1', $string); //h3
		$string = preg_replace('#\<strong\>(.+)\</strong\>#isU', '$1', $string); //bold
		$string = preg_replace('#\<i\>(.+)\</i\>#isU', '$1', $string); //italic
		$string = preg_replace('#\<u\>(.+)\</u\>#isU', '$1', $string); //underline
		$string = preg_replace('#\<s\>(.+)\</s\>#isU', '$1', $string); //crossout
		$string = preg_replace('#\<p\>(.+)\</p\>#isU', '$1', $string); //paragraph
		$string = preg_replace('#\<img src\=\'([^(public/css/smileys/)].+)\' /\>#isU', '', $string); //image 
		$string = preg_replace('#\<img width\=\'([0-9]{1,2})\%\' height=\'([0-9]{1,2})\%\' src\=\'(.+)\' /\>#isU', '', $string); //image with size 
		$string = preg_replace('#\<br /\>#isU', '', $string); //br
		$string = preg_replace('#\<span style\=\'color\:\#([a-f0-9]{6})\'\>(.+)\</span\>#isU', '$2', $string); //color
		$string = preg_replace('#\<div style\=\'text\-align\:(left|right|center|justify)\'\>(.+)\</div\>#isU', '$2', $string); //align
		$string = preg_replace('#\<div style\=\'float\:(right|left)\'\>(.+)\</div\>#isU', '$2', $string); //float
		$string = preg_replace('#\<fieldset\>\<legend\>(.+)\</legend\>(.+)\</fieldset\>#isU', '$2', $string); //fieldset with name
		$string = preg_replace('#\<fieldset\>(.+)\</fieldset\>#isU', '$1', $string); //fieldset without name
		$string = preg_replace('#\<a href\=\'(.+)\'\>(.+)\</a\>#isU', '$2', $string); //link

		$string = preg_replace('#\<(ol|/ol|ul|/ul)\>#isU', '', $string); //ol ul
		$string = preg_replace('#\<li\>(.+)\</li\>#isU', '<br />- $1<br />', $string); //li

		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/smile.png\' /\>#isU', ':)', $string); // :)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/wink.png\' /\>#isU', ';)', $string); // ;)
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/flat.png\' /\>#isU', ':|', $string); // :|
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/cry.png\' /\>#isU', ':\'(', $string); // :'(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/sad.png\' /\>#isU', ':(', $string); // :(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/quiet.png\' /\>#isU', ':X', $string); // :X
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/doubts.png\' /\>#isU', ':/', $string); // :/
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy.png\' /\>#isU', ':D', $string); // :D
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/happy2.png\' /\>#isU', '', $string); // xD
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/confused.png\' /\>#isU', ':S', $string); // :S
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/tongue.png\' /\>#isU', ':P', $string); // :P
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/surprised.png\' /\>#isU', ':O', $string); // :O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/mad.png\' /\>#isU', 'x(', $string); // x(
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/bored.png\' /\>#isU', '', $string); // -.-
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/ninja.png\' /\>#isU', '^:', $string); // ^:
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/angry.png\' /\>#isU', '', $string); // xO
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/suspicious.png\' /\>#isU', '', $string); // o_O
		$string = preg_replace('#\<img class\=\'smiley\' src\=\'public/css/smileys/nerd.png\' /\>#isU', '', $string); // ._.
		return $string;
	}

	public function date($string)
	{
		$string = preg_replace('#([0-3][0-9]{3})-([0-1][0-9])-([0-3][0-9])#isU', '$3/$2/$1', $string);
		return $string;
	}

	public function time($string)
	{
		$string = preg_replace('#([0-9]*):([0-5][0-9]):[0-9\.]{2,}#is', '$1h$2min', $string);
		return $string;
	}
}
