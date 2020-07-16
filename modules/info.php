<?php
function ShowServer($host, $port,  $holder_width, $srvname,$num = 0) {

$socket = @fsockopen($host, $port , $errno , $errstr, 2);

if ($socket == false) {
?>
<div class="server-info-holder" style="width:<?php echo $holder_width; ?>px">
	<div class="server-info-name" style="width:<?php echo $holder_width-10; ?>px">
		<?php echo $srvname; ?>
	</div>
	<div class="server-info-state" style="width:<?php echo $holder_width-20; ?>px">	
		<div class="progressbar_overlay">Оффлайн</div>
		<div class="redbar" style="width:<?php echo $holder_width-20; ?>px">
			<div class="progressbar_meter" style="width:100%"></div>	
		</div>
	</div>
</div>
<?php 
return;
}

@fwrite($socket, "\xFE");
$data = "";
$data = @fread($socket, 1024);
@fclose($socket);

if ($data == false or substr($data, 0, 1) != "\xFF") return;

$info = explode("\xA7", mb_convert_encoding(substr($data,1), "iso-8859-1", "utf-16be"));
$playersOnline = $info[11]+$num;
$playersMax = $info[12];
 ?>
<div class="server-info-holder" style="width:<?php echo $holder_width; ?>px">
	<div class="server-info-name" style="width:<?php echo ($holder_width-10); ?>px">
		<?php echo $srvname; ?>
	</div>
	<div class="server-info-state" style="width:<?php echo ($holder_width-20); ?>px">
		<div class="greenbar" style="width:<?php echo ($holder_width-20); ?>px">
			<div class="progressbar_meter" style="width:<?php echo round(($playersOnline/$playersMax)*100); ?>%">
			<?php echo "$playersOnline / $playersMax"; ?></div>	
		</div>	
	</div>
</div>
<?php } ?>