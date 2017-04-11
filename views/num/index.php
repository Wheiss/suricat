<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Большая цифра</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/main" method="post" class="main-form">
		<?="<p class='big_num'>".$num."</p>"?></td>
		<input id="left-btn" type="submit" name="plusplus" value="+1" />
		<button form="redirect" onClick='location.href="/log-out"' id="right-btn">Выйти</button>
	</form>
</body>
</html>