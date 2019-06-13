<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');

	$data = $_REQUEST;
	if(isset($data['do_auto'])){
		//выполнить авторизацию
		$user = new user_auto($data['login'],$data['password']);
		$errors = [];
		if(empty($data['login'])){
			$errors[] = "введите логин";
		}
		if(!$user->isLogin()){
			$errors[] = "такого лонина не существует";
		}
		if(empty($data['password'])){
			$errors[] = 'введите пароль';
		}
		if(!$user->isTruePassword($data['password'])){
			$errors[] = 'не верно указан пароль';
		}
		if(!empty($errors)){
			echo $errors[0];
			require_once($_SERVER['DOCUMENT_ROOT'].'/auto/auto_struct.php');
		}else{
			$_SESSION['connection'] = trim($data['login']);
			header("location:/");
		}
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/auto/auto_struct.php');
	}