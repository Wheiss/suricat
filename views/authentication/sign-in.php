<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Аутентификация</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/auth" method="post" class="auth-form">
		<p>Ваш логин:
		<input class="input-text" type="text" name="login" value="<?=htmlspecialchars(@$_POST['login'])?>" />
		</p>
		<p>Пароль:
		<input class="input-text" type="password" name="password" value="<?=htmlspecialchars(@$_POST['password'])?>" />
		</p>
		<p><input type="checkbox" name="remember">Запомнить меня</p>
		<?php 
		if(!empty($authentication_errors)) {
			foreach ($authentication_errors as $name => $text) {
				echo "<p class='error'>$text</p>";
			}
		}?>
		<p>
		<input type="submit" value="Войти" /><button form="redirect" onClick='location.href="/sign-up"' id="right-btn">Зарегистрироваться</button>
		</p>
		
	</form>
</body>
</html>