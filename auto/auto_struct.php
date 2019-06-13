<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>vseti</title>
</head>
<body>
	<form action="/auto/auto.php" method="POST">
		<input type="text" name="login" placeholder="login" value="<?php echo $_REQUEST['login']?>"><br />
		<input type="password" name="password" placeholder="password" value="<?php echo $_REQUEST['password']?>"><br />
		<input type="submit" name="do_auto"><br />
	</form>
	<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/reg/reg.php">регистрация</a>
</body>
</html>