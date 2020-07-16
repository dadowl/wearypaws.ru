<?php
function MineToWeb($minetext){
preg_match_all("/[^§&]*[^§&]|[§&][0-9a-z][^§&]*/", $minetext, $brokenupstrings);
$returnstring = "";
foreach ($brokenupstrings as $results){
$ending = '';
foreach ($results as $individual){
$code = preg_split("/[&§][0-9a-z]/", $individual);
preg_match("/[&§][0-9a-z]/", $individual, $prefix);
if (isset($prefix[0])){
$actualcode = substr($prefix[0], 1);
switch ($actualcode){
case "1":
$returnstring = $returnstring.'<FONT COLOR="0000AA">';
$ending = $ending ."</FONT>";
break;
case "2":
$returnstring = $returnstring.'<FONT COLOR="00AA00">';
$ending =$ending ."</FONT>";
break;
case "3":
$returnstring = $returnstring.'<FONT COLOR="00AAAA">';
$ending = $ending ."</FONT>";
break;
case "4":
$returnstring = $returnstring.'<FONT COLOR="AA0000">';
$ending =$ending ."</FONT>";
break;
case "5":
$returnstring = $returnstring.'<FONT COLOR="AA00AA">';
$ending =$ending . "</FONT>";
break;
case "6":
$returnstring = $returnstring.'<FONT COLOR="FFAA00">';
$ending =$ending ."</FONT>";
break;
case "7":
$returnstring = $returnstring.'<FONT COLOR="AAAAAA">';
$ending = $ending ."</FONT>";
break;
case "8":
$returnstring = $returnstring.'<FONT COLOR="555555">';
$ending =$ending ."</FONT>";
break;
case "9":
$returnstring = $returnstring.'<FONT COLOR="5555FF">';
$ending =$ending . "</FONT>";
break;
case "a":
$returnstring = $returnstring.'<FONT COLOR="55FF55">';
$ending =$ending ."</FONT>";
break;
case "b":
$returnstring = $returnstring.'<FONT COLOR="55FFFF">';
$ending = $ending ."</FONT>";
break;
case "c":
$returnstring = $returnstring.'<FONT COLOR="FF5555">';
$ending =$ending ."</FONT>";
break;
case "d":
$returnstring = $returnstring.'<FONT COLOR="FF55FF">';
$ending =$ending ."</FONT>";
break;
case "e":
$returnstring = $returnstring.'<FONT COLOR="FFFF55">';
$ending = $ending ."</FONT>";
break;
case "f":
$returnstring = $returnstring.'<FONT COLOR="FFFFFF">';
$ending =$ending ."</FONT>";
break;
case "l":
if (strlen($individual)>2){
$returnstring = $returnstring.'<span style="font-weight:bold;">';
$ending = "</span>".$ending;
break;
}
case "m":
if (strlen($individual)>2){
$returnstring = $returnstring.'<strike>';
$ending = "</strike>".$ending;
break;
}
case "n":
if (strlen($individual)>2){
$returnstring = $returnstring.'<span style="text-decoration: underline;">';
$ending = "</span>".$ending;
break;
}
case "o":
if (strlen($individual)>2){
$returnstring = $returnstring.'<i>';
$ending ="</i>".$ending;
break;
}
case "r":
$returnstring = $returnstring.$ending;
$ending = '';
break;
}
if (isset($code[1])){
$returnstring = $returnstring.$code[1];
if (isset($ending)&&strlen($individual)>2){
$returnstring = $returnstring.$ending;
$ending = '';
}
}
}
else{
$returnstring = $returnstring.$individual;
}

}
}

return $returnstring;
}
//Test Data //
//$text1 = '§r§0k §kMinecraft§rl §lMinecraft§rm §mMinecraft§rn §nMinecraf§ro §oMinecraft§rr §rMinecraft§r§00 §11 §22 §33 §44 §55 &l&66 §77 §88 §99 §aa §bb §cc §dd §ee §ff§bA §5&lminecraft &l§5minecraft &r§9MOTD§6[MegaKraft]§4[Factions]§8[PvP]§2[Economy]';
//echo MineToWeb($text1);
?>