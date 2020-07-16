				<h3><span>Присоединяйся</span></h3>
				<br />	
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">Вход</a></li>
						<li><a href="#tabs-2">Регистрация</a></li>
						<li><a href="#tabs-3">Забыли пароль?</a></li>
					</ul><br /><br />
					<div id="tabs-1">
						<div id="formiflogin">
							<div class="ctable" style="height:110px !important; width: 450px;">
								<div class="col1">
									<p>Логин</p>
									<p>Пароль</p>
								</div>
									<form action="modules/login.php" method="post">
								<div class="col2">
										<input name="login" type="text" placeholder="" pattern="(?:^(?:[a-zA-Z0-9_]{3,16})$)" maxlength="16" minlength="3" required><br />
										<input name="password" type="password" required placeholder="" pattern="(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}" minlength="8" maxlength="20"><br />
								</div>
									<br /><br /><br />
									<input type="submit" name="submit" value="Войти" style="margin-top:10px;"><br />
								</form>
							</div>
						</div>
					</div>
					<div id="tabs-2">
						<div id="formifreg">
							<div class="ctable" style="height:320px !important; width: 450px;">
								<div class="col1">
									<p>Логин(ник)</p> 
									<p>E-mail</p>
									<p>Пароль</p>
									<p>Ник пригласившего вас игрока</p>
									<p>Пол</p>
								</div>
								<form action="modules/registration.php" method="post">
								<div class="col2" style="" >
										<input name="login" type="text" placeholder="" pattern="(?:^(?:[a-zA-Z0-9_]{3,16})$)" maxlength="16" minlength="3" title="Допускаются логины  от 3х знаков, содержащие только латинские буквы, цифры и «_»." required value="<?php echo $login; ?>"/><br />
										<input name="email" type="text" required placeholder="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $email; ?>"/><br />
										<input name="password" type="password" required placeholder="" pattern="(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}" minlength="8" title="Минимум 8 знаков. Хотя бы одна заглавная, одна строчная и одна цифра." maxlength="20"><br />
										<input name="referall" type="text" title="Например, momlynx" pattern="(?:^(?:[a-zA-Z0-9_]{3,16})$)" maxlength="16" minlength="3" <?php echo $reftoform; ?>><br /><br />
										<input name="gender" type="radio" value="man" <? echo $gender0; ?> class="radbut">Мужской
    									<input name="gender" type="radio" value="girl" <? echo $gender1; ?> class="radbut">Женский<br /><br />
								</div>
									<br />
									<div class="g-recaptcha" data-sitekey="6Lfwg7cUAAAAAK7xn3Sxw_KrJIqGW0PXzIhUlL8K"></div>
									<div class="text-danger" id="recaptchaError"></div>			
									<input type="submit" name="submit" value="Зарегистрироваться" style="margin-top:95px; width:150px;"><br />
								</form>
							</div>
						</div>
					</div>
					<div id="tabs-3">
						<div id="formiflogin">
							<div class="ctable" style="height:110px !important; width: 450px;">
								<div class="col1">
									<p>Логин(ник)</p> 
									<p>E-mail</p>
								</div>
								<form action="lostpass.php" method="post">
								<div class="col2">
										<input name="login" type="text" placeholder="" pattern="(?:^(?:[a-zA-Z0-9_]{3,16})$)" maxlength="16" minlength="3" title="" required /><br />
										<input name="email" type="text" required placeholder="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" /><br />
								</div>
									<br /><br /><br />
									<input type="submit" name="submit" value="Восстановить доступ" style="margin-top:10px; width:150px;"><br />
								</form>
							</div>
						</div>
					</div>
				</div>