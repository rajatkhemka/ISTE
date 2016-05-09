<?php
	include '../Core/init.php' ;
	if (empty($_POST) === false) {
		$current_password = secure($_POST['password']) ;
		$new_password = secure($_POST['new_password']) ;
		$new_password_again = secure($_POST['new_password_again']) ;
		$required_fields = array('password' , 'new_password' , 'new_password_again') ;
		if(check_input($_POST , $required_fields) === true ) {
			$errors[] = "Fields marked with an * are required!!" ;
		}
		if ($current_password != $user_data['user_password']) {
			$errors[] = "Your password is incorrect!!" ;
		}
		if ($new_password != $new_password_again) {
			$errors[] = "Your passwords must match!!" ;
		}
		if (check_length($new_password) === false) {
			$errors[] = "Password must be 6 to 32 characters long!!" ;
		}
	}
?>
<!DOCTYPE html>
<HTML lang = "en">
	<HEAD>
		<META http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
		<META charset = "utf-8" />
		<META name = "viewport" content = "width=device-width, initial-scale = 1" />
		<META name = "author" content = "capt_MAKO | Sneha Bharti" />
		<TITLE>ISTE|KNIT, Sultanpur</TITLE> 
		<LINK rel = 'stylesheet' type = 'text/css' href = 'http://fonts.googleapis.com/css?family=Wellfleet' />
		<LINK rel = 'stylesheet' type = 'text/css' href = 'http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic' />	
		<LINK rel = 'stylesheet' type = 'text/css' href = 'http://fonts.googleapis.com/css?family=Oswald' />
		<LINK rel = 'stylesheet' type = 'text/css' href = 'http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911' />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap-theme.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/notifIt.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/style.css" />
		<SCRIPT type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/bootstrap.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/Jquery.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/notifIt.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/waypoints.min.js"></SCRIPT>
	</HEAD>
	<BODY>  
		<HEADER id = "header">
			<DIV class = "content">
				<DIV id = "logo">
					<A href = "login.php">ISTE</A>
				</DIV>
			</DIV>
		</HEADER>
		<DIV id = "slide1">
			<DIV class = "col-md-3"></DIV>
			<DIV class = "col-md-6">
				<DIV class = "box">
					<?php
						if ((isset($_GET['success']) === true) && (empty($_GET['success']) === true)) {
							echo 'Your password has been successfully changed!!' ;
						} else {
							if ((isset($_GET['force']) === true) && (empty($_GET['force']) === true)) {
								echo '<P>Please change your password now</P>' ;
							}
							if ((empty($errors) === true) && (empty($_POST) === false)) {
								change_password($database_handler , $_SESSION['id'] , $new_password) ;
								?>
								<SCRIPT type = "text/javascript">
									window.location.href = "change_password.php?success" ;
								</SCRIPT>
								<?php
							} elseif (empty($errors) === false) {
								echo output_errors($errors) ;
							}
							?>
							<FORM action = "" method = "POST" >
								<DIV class = "form-group" ><BR />
									<INPUT type = "password" name = "password" class = "form-control" placeholder = "Current Password" /><BR />
									<INPUT type = "password" name = "new_password" class = "form-control" placeholder = "New Password" /><BR />
									<INPUT type = "password" name = "new_password_again" class = "form-control" placeholder = "New Password Again" /><BR />
								</DIV>
								<CENTER>
									<INPUT type = "submit" value = "Submit" data-backdrop = "static" class = "btn btn-default btn-block btn-success" />
								</CENTER>
							</FORM>
							<?php
						}
					?>
				</DIV>
			</DIV>
			<DIV class = "col-md-3"></DIV>
		</DIV>
	</BODY>
</HTML>
