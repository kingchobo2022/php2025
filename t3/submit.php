<?php
session_start();

if(!isset($_POST['csrf_token'], $_SESSION['csrf_token'])
	|| $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {

	die('CSRF 공격이 감지되었습니다.');
}
unset($_SESSION['csrf_token']);

 
