<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
	unset($_SESSION['connection']);
	header('location:/');
?>