<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');


	$data = $_REQUEST;
	if(isset($data['do_reg'])){
		//выполнить регитрацию
		$errors = [];
		if(empty($data['login'])){
			$errors[] = "придумайте логин";
		}
		if(user_reg::isUser(trim($data['login']))){
			$errors[] = "логин уже занят";
		}
		if(empty($data['password1'])){
			$errors[] = "придумайте пароль";
		}
		if(empty($data['password2'])){
			$errors[] = "подтвердите пароль";
		}
		if($data['password1']!=$data['password2']){
			$errors[] = "парои не совподают";
		}
		if(!empty($errors)){
			echo $errors[0];
			require_once($_SERVER['DOCUMENT_ROOT'].'/reg/reg_struct.php');
		}else{
			$user = new user_reg($data['login'],$data['password1']);
			unset($user);
			$_SESSION['connection'] = trim($data['login']);
			header('location:/');
		}
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/reg/reg_struct.php');
	}