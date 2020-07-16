 <!-- Смена пароля -->
 <div id="myModal1" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(1);">×</span>
    <h2>Сменить пароль</h2>
  </div>
  <div class="modal-body">
    <?php 
      if($myrow['onoffansw'] == 1) {
        echo "
          Для продолжения введите ответ на свой контрольный вопрос и почту:
          <br /><b>".$myrow['question']."?</b>
          <form action='newPass.php' method='post'>
            Ответ на вопрос: <input name='answ' type='text' required maxlength='100'>
            <br />
            Почта: <input name='email' type='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' required><br />
            <div class='modal-footer'>
              <input type='submit' name='submit' value='Отправить'>
            </div>
          </form>
          ";
      } else {
        echo "
          Для продолжение процедуры введите вашу почту.
          <form action='newPass.php'    method='post'>
            Почта: <input name='email2' type='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' required><br />
            <div class='modal-footer'>
              <input type='submit' name='submit' value='Отправить'>
            </div>
            <input name='login2' type='hidden' pattern='(?:^(?:[a-zA-Z0-9_]{3,16})$)' maxlength='16' minlength='3'  value='".$login."'>
          </form>
        ";
      }
    ?>
  </div>
</div>
</div>
 <!-- Смена почты -->
 <div id="myModal2" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(2);">×</span>
    <h2>Сменить адрес почты</h2>
  </div>
  <div class="modal-body">
    <?php 
      if($myrow['onoffansw'] == 1) {
        echo "
          Для продолжения введите ответ на свой контрольный вопрос, почту и пароль:
          <br /><b>".$myrow['question']."?</b>
          <form action='newEmail.php' method='post'>
            Ответ на вопрос: <input name='answ' type='text' required maxlength='100'><br />
            Почта: <input name='email' type='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' required><br />
            Пароль: <input name='pass' type='password' required pattern='(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}' minlength='8'><br />
            <div class='modal-footer'>
              <input type='submit' name='submit' value='Отправить'>
            </div>
          </form>
          ";
      } else {
        echo "
          Для продолжение процедуры введите вашу почту и пароль.
          <form action='newEmail.php'    method='post'>
            Почта: <input name='email2' type='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' required><br />
            Пароль: <input name='pass2' type='password' required pattern='(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}' minlength='8' ><br />
            <div class='modal-footer'>
              <input type='submit' name='submit' value='Отправить'>
            </div>
            <input name='login2' type='hidden' pattern='(?:^(?:[a-zA-Z0-9_]{3,16})$)' maxlength='16' minlength='3' value='".$login."'>
          </form>
        ";
      }
    ?>
  </div>
</div>
</div>
 <!-- Аватарка -->
 <div id="myModal3" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(3);">×</span>
    <h2>Установить аватарку</h2>
  </div>
  <div class="modal-body">
    <form action='modules/update.php'    method='post' enctype='multipart/form-data'>
      <input type="FILE" name="uploadAva" required>
      <span style="color:gray;">Изображение должно быть формата jpg, gif или png.</span>
      <div class='modal-footer'>
        <input type='submit' name='submit' value='Изменить'>
      </div>
    </form>
  </div>
</div>
</div>
 <!-- Скин -->
 <div id="myModal4" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(4);">×</span>
    <h2>Установить скин</h2>
  </div>
  <div class="modal-body">
    <form action='modules/update.php'    method='post' enctype='multipart/form-data'>
      <input type="FILE" name="uploadSkin" required>
      <span style="color:gray;">Изображение должно быть формата png. 
        <br />Файл должен быть размером <b>64х64</b>! 
        <br />Для HD скинов <b>256х128</b>, <b>1024х512</b> или <b>512х256</b></span>
      <div class='modal-footer'>
        <input type='submit' name='submit' value='Изменить'>
      </div>
    </form>
  </div>
</div>
</div>
 <!-- Плащ -->
 <div id="myModal5" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(5);">×</span>
    <h2>Установить плащ</h2>
  </div>
  <div class="modal-body">
    <form action='modules/update.php'    method='post' enctype='multipart/form-data'>
      <input type="FILE" name="uploadCloak">
      <span style="color:gray;">Изображение должно быть формата png. 
        <br />Файл должен быть размером <b>64х32</b> или <b>22x17</b>! 
        <br />Для HD плащей <b>512x256</b>.</span>
      <div class='modal-footer'>
        <input type='submit' name='uplCloak' value='Изменить'>
    </form>
        <form action='modules/update.php'    method='post' enctype='multipart/form-data'>
          <input type='submit' name='delcloak' value='Удалить плащ'>
        </form>
      </div>
  </div>
</div>
</div>
 <!-- Вопрос Ответ -->
 <div id="myModal6" class="modal">
 <div class="modal-content">
  <div class="modal-header">
    <span class="close" onClick="closeModal(6);">×</span>
    <h2>Настройка "Вопрос Ответ"</h2>
  </div>
  <div class="modal-body">
    <?php 
      if($myrow['onoffansw'] == 1) {
        echo "
          Изменить данные для системы 'Вопрос Ответ' нельзя.<br>
          Обращайтесь в тех. поддержку.
            <div class='modal-footer'>
            </div>
          ";
      } else {
        echo "
          Для продолжения укажите свою почту и пароль.
          <form action='newQA.php' method='post'>
            Почта: <input name='email' type='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' required><br />
            Пароль: <input name='pass' type='password' required pattern='(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}' minlength='8'><br />
            <div class='modal-footer'>
              <input type='submit' name='submit' value='Отправить'>
            </div>
            <input name='login' type='hidden' pattern='(?:^(?:[a-zA-Z0-9_]{3,16})$)' maxlength='16' minlength='3' value='".$login."'>
          </form>
        ";
      }
    ?>  
  </div>
</div>
</div>
<script type='text/javascript' src='js/modals.js'></script>