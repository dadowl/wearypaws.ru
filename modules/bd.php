<?php
	setlocale(LC_ALL, 'ru_RU.utf8');
	Header("Content-Type: text/html;charset=UTF-8");
	
	$db = mysql_connect ("localhost","root","");
	mysql_select_db ("accounts",$db);

	$db_pex = mysql_connect ("localhost","root","");
	mysql_select_db ("accounts",$db_pex);
?>