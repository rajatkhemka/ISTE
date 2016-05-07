<?php
	session_start() ;
	include 'connection.php' ;
	include 'Functions/admin.php' ;
	include 'Functions/general.php' ;
	include 'Functions/user.php' ;
	$ip_address = get_users_ip() ;
	$current_file = explode('/' , $_SERVER['SCRIPT_NAME']) ;
	$current_file = end($current_file) ;
	if ((logged_in() === true) and ($_SESSION['type'] === 'user')) {
		$id = $_SESSION['id'] ;
		$user_data = user_data($database_handler , $id) ;
		if (($current_file !=='change_password.php') and ($current_file !=='logout.php') and ($user_data['user_password_recovery_status'] == 1)) {
			header('Location: change_password.php?force') ;
			exit() ;
		}
	} elseif ((logged_in() === true) and ($_SESSION['type'] === 'admin')) {
		$id = $_SESSION['id'] ;
		$user_data = admin_data($database_handler , $id) ;
	}
	$errors = array() ;
?>