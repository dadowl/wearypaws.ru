<?php 
	$login = $_SESSION['login'];
	$result = mysql_query("SELECT id,money,uuid FROM gamers WHERE login='$login'",$db);
    $myrow = mysql_fetch_array($result);
    $fotodir  = "/mine/users/foto/".$login.".jpg";
    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$fotodir)){
    	$fotodir = "/mine/users/foto/def/def_".rand(1, 16).".png";
    }
    $uuid = $myrow['uuid'];
    $pexsend = mysql_query("SELECT parent FROM permissions_inheritance WHERE child = '$uuid'",$db_pex);
	$pexres = mysql_fetch_assoc($pexsend);
	if (empty($pexres['parent'])){
		$pexsh = 'default';
	} else {
		$pexsh = $pexres['parent'];
	}
	$pexsend2 = mysql_query("SELECT value FROM permissions WHERE name = '$pexsh' AND permission = 'prefix'",$db_pex);
	$pextolk = mysql_fetch_assoc($pexsend2);

	$pextolk = MineToWeb($pextolk['value']);
?>
<div id="lkshort">
	<img src="<?php echo $fotodir; ?>" />
	<div id="logind">
		Привет, <?php echo $login; ?>
		<a href="../logout.php"><img src="../images/door.png" id="door" /></a>
	</div>
	<div id="info">
		<br />
		<span>Группа: </span><b><?php echo $pextolk; ?></b><br />
		<span>Баланс: </span><b><?php echo $myrow['money']; ?> руб.</b>
		<div id="lkshfooter">
			<a href="../lk.php?id=<?php echo $myrow['id']; ?>">Перейти в полную версию ЛК</a>
		</div>
	</div>
</div>