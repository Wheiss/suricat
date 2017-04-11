<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/sign-up" method="post" class="auth-form" id="reg-form">
	<p>Желаемый логин:
	<input class="input-text" type="text" name="login" value="<?=htmlspecialchars(@$_POST['login'])?>" />
	</p>
	<p>Ваш пароль:
	<input class="input-text" type="password" name="password" value="<?=htmlspecialchars(@$_POST['password'])?>" />
	</p>
	<p>Укажите дату рождения:</p>

	<p>
	<select name="birth_day" form="reg-form">
		<?php for($i = 1; $i<=31; $i++){
				if(@$_POST['birth_day']!=$i) {
				echo"<option>$i</option>";
				}
				else {
					echo"<option selected=selected>$i</option>";
				}
			} ?>
	</select>
	
	<select name="birth_month" form="reg-form">
		<?php foreach (@Registration::months() as $num => $month) {
			if(@$_POST['birth_month'] != $num+1) {
			echo '<option value="'.($num+1).'">'.$month.'</option>';
			}
			else {
				echo '<option value="'.($num+1).'" selected=selected>'.$month.'</option>';
			}
		} ?>
		
	</select>
	
	<select name="birth_year" form="reg-form">
		<?php for($i = 0; $i<=300; $i++){
				if(@$_POST['birth_year']!=(date('Y')-$i)) {
				echo"<option>".(date('Y')-$i)."</option>";
				}
				else {
					echo"<option selected=selected>".(date('Y')-$i)."</option>";
				}
			} ?>
	</select>
	</p>
	<?php 
		if(!empty($registration_errors)) {
			foreach ($registration_errors as $name => $text) {
				echo "<p class='error'>$text</p>";
			}
		}?>
		<a href="/auth">Перейти на страницу входа</a><input type="submit" value="Зарегистрироваться" id="right-btn"/>
	</form>
</body>
</html>