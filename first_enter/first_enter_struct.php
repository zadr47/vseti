<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php $_SERVER['DOCUMENT_ROOT'] ?>/vseti/vseti.php" method="POST">
		<input type="text" name="name" placeholder="выше имя" value="<?php echo $_REQUEST['name'] ?>"><br />
		<input type="text" name="surname" placeholder="выша фамилия" value="<?php echo $_REQUEST['surname'] ?>"><br />
		<input type="text" name="gender" placeholder="выш пол" value="<?php echo $_REQUEST['gender'] ?>"><br />
		<input type="text" name="life_city" placeholder="ваш город" value="<?php echo $_REQUEST['life_city'] ?>"><br />
		<input type="text" name="birthday" placeholder="ваш день рожденья" value="<?php echo $_REQUEST['birthday'] ?>"><br />
		<input type="submit" name="do_first_enter" value="готово">
	</form>
</body>
</html>

