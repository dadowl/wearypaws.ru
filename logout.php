<?php
          session_start();
          if    (empty($_SESSION['login']) or empty($_SESSION['password'])) 
          {
          //если не существует сессии с логином и паролем, значит на    этот файл попал невошедший пользователь. Ему тут не место. Выдаем сообщение    об ошибке, останавливаем скрипт
          exit ("<html><head><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>");
          }
          
unset($_SESSION['password']);
            unset($_SESSION['login']); 
            unset($_SESSION['id']);//    уничтожаем переменные в сессиях
        exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>");
            // отправляем пользователя на главную страницу.
            ?>