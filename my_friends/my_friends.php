<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');


	if(isset($data['do_search_freinds'])){
		if(!empty($data['search_friends'])){

			$str = htmlspecialchars(trim($data['search_friends']));

			$arrStr = explode(' ', $str);

			



		}else{
			require_once($_SERVER['DOCUMENT_ROOT'].'my_friends/my_friends_html.php');			
		}
	}else{

		require_once($_SERVER['DOCUMENT_ROOT'].'my_friends/my_friends_html.php');
	}
		