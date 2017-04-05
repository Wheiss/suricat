<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/sign-up" method="post" class="auth-form" id="reg-form">
	<table>
		<tr>
		<td><p>Желаемый логин:</p></td>
		<td><input type="text" name="login" value="<?=htmlspecialchars(@$_POST['login'])?>" /></td>
		</tr>
		<tr> </tr>
		<tr>
		<td><p>Ваш пароль:</p></td>
		<td><input type="password" name="password" value="<?=htmlspecialchars(@$_POST['password'])?>" /></td>
		</tr>
		<td><p>Подтвердите пароль:</p></td>
		<td><input type="password" name="password_confirm" value="<?=htmlspecialchars(@$_POST['password_confirm'])?>" /></td>
		<tr><td><p>Укажите дату рождения:</p></td>
		<td><table>
		<tr align="center">
		<td><p>День:</p></td>
		<td><p>Месяц:</p></td>
		<td><p>Год:</p></td>
		</tr>
		<tr>
		<td>
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
		</td>
		<td>
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
		</td>
		<td>
		<select name="birth_year" form="reg-form">
			<?php for($i = 0; $i<=300; $i++){
					if(@$_POST['birth_year']!=(date('Y')-$i)) {
					echo"<option>".(date('Y')-$i)."</option>";
					}
					else {
						echo"<option selected=selected>".(date('Y')-$i)."</option>";
					}
				} ?>
		</select></td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
			<td colspan="2"><?php 
			if(!empty($registration_errors)) {
				foreach ($registration_errors as $name => $text) {
					echo "<p class='error'>$text</p>";
				}
			}?>
			</td>
		</tr>
		<tr valign="bottom">
		<td height="40px" ><a href="/auth">Перейти на страницу входа</a></td>
		<td><input type="submit" value="Зарегистрироваться" id="right-btn"/></td>
		</tr>
	</table>

	</form>
</body>
</html>