<!DOCTYPE HTML>
<html>
	<head>
		<title> 404 | Weary Paws </title>
		<link href="/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="css/serverbar.css" type="text/css">
	</head>
	<body>
			<div id="head">
				<a href="https://wearypaws.ru/"><img src="/images/logo.png" /></a> 
			</div>
		<div id="container2">
		<div id="container">
			<center><h1 style="font-size: 200px; margin: 0px; padding: 50px;" >404</h1></center>
			<?php
				$quotes[] = 'Что ты наделал? Все сломалось!';
				$quotes[] = 'Это не я! За меня мой брат программировал!';
				$quotes[] = 'Тебе настолько нечем заняться?';
				$quotes[] = 'Возьми с полки пирожок!';
				$quotes[] = 'ДуДОС Incorporated!';
				$quotes[] = 'Пришло время переустанавливать Шindows!';
				$quotes[] = 'Обернись!';
				$quotes[] = 'Тут должны были быть данные по новому серверу!';
				$quotes[] = 'Могло быть и хуже...';
				$quotes[] = 'Перезагрузи компьютер';
				$quotes[] = 'Ты втираешь мне какую-то дичь!';
				$quotes[] = 'Перестань обновлять страницу!';
				srand ((double) microtime() * 1000000);
				$random_number = rand(0,count($quotes)-1);
			?>
			<br /><?php echo '<span style="font-size:50px;">'.$quotes[$random_number].'</span>';  ?>
		</div>
		</div>
	</body>
</html>