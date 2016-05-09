<?php
	include '../Core/init.php' ;
?>
<!DOCTYPE html>
<HTML lang = "en">
	<HEAD>
		<META http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
		<META charset = "utf-8" />
		<META name = "viewport" content = "width=device-width, initial-scale = 1" />
		<META name = "author" content = "capt_MAKO | Sneha Bharti" />
		<TITLE>ISTE|KNIT, Sultanpur</TITLE>
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap-theme.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/notifIt.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/style.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Wellfleet" />
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic" />	
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Oswald" />
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911" />
		<SCRIPT type = "text/javascript" src = "../JS/bootstrap.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/Jquery.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></SCRIPT>
	</HEAD>
	<BODY>
		<HEADER id = "header">
			<DIV class = "content">
				<DIV id = "logo">
					<A href = "login.php">ISTE</A>
				</DIV>
				<NAV id = "nav">
					<UL>
						<LI>
							<A href = "change_password.php">Change Password</A>
						</LI>
						<LI>
							<A  href = "#">Profile</A>
						</LI>
						<LI>
							<A  href = "#">View Quiz</A>
						</LI>
						<LI>
							<A href = "logout.php">Log Out</A>
						</LI>
					</UL>
				</NAV>
			</DIV>
		</HEADER>
		<DIV id = "slide1">
			<DIV class = "content">
				
				<?php
					if (empty($_POST) === false) {
						$user_name = $_POST['user_name'] ;
						$user_first_name = secure($_POST['first_name']) ;
						$user_last_name = secure($_POST['last_name']) ;
						$user_email = secure($_POST['user_email']) ;
						$user_roll_number = secure($_POST['user_roll_number']) ;
						$user_phone_number = secure($_POST['user_phone_number']) ;
						if (isset($_POST['user_mail_letter_status']) === true) {
							$user_mail_letter_status = 'on' ;
						} else {
							$user_mail_letter_status = 'off' ;
						}
						$required_fields = array('user_name' , 'first_name' , 'user_email' , 'user_gender' , 'user_branch' , 'user_roll_number') ;
						if(check_input($_POST , $required_fields) === true ) {
							$errors[] = "Fields marked with an * are required!!" ;
						} if ((user_exists($database_handler , $user_name) === true) and ($user_data['user_name'] !== $user_name)) {
							$errors[] = 'Sorry , the username \'' . $user_name . '\' is alreday taken!!' ;
						} if ((email_exists($database_handler , $user_email) === true) and ($user_data['user_email'] !== $user_email)) {
							$errors[] = 'Sorry , the email \'' . $user_email . '\' is alreday taken!!' ;
						} else {
							if (empty($errors) === true) {
								if ($user_mail_letter_status == 'on') {
									$allow_email = 1 ;
								} else {
									$allow_email = 0 ;
								}
								$update_data = array(
									'user_name' => $user_name ,
									'user_first_name' => $user_first_name ,
									'user_last_name' => $user_last_name ,
									'user_email' => $user_email ,
									'user_mail_letter_status' => $allow_email ,
									'user_roll_number' => $user_roll_number ,
									'user_phone_number' => $user_phone_number
									) ;
								update_user($database_handler , $user_data['user_id'] , $update_data) ;
								?><BR />
								<DIV class = "alert alert-success alert-dismissible" role = "alert">
									<BUTTON type = "button" class = "close" data-dismiss = "alert" aria-label = "Close">
										<SPAN aria-hidden = "true">&times;</SPAN>
									</BUTTON>
									<STRONG>Attention!</STRONG> Profile updated successfully.
								</DIV>
								<?php
								$page = $_SERVER['PHP_SELF'] ;
 								$sec = "2" ;
 								header("Refresh: $sec; url=$page") ;
							} elseif (empty($errors) === false) {
								echo output_errors($errors) ;
							}
						}
					}
				?>
				<FORM action = "" method = "POST" enctype = "multipart/form-data">
					<DIV class = "col-md-2"></DIV>
					<DIV class = "col-md-8">
						<DIV class = "input-group">
							<SPAN class = "input-group-addon" id = "basic-addon_user_name">User name</SPAN>
							<INPUT class = "form-control" aria-describedby = "basic-addon_user_name" type = "text" autocomplete = "on" name = "user_name" value = <?php echo $user_data['user_name'] ;?> />
						</DIV><BR />
						<DIV class = "input-group">
							<SPAN class = "input-group-addon" id = "basic-addon_user_first_name">First name</SPAN>
							<INPUT class = "form-control" aria-describedby = "basic-addon_user_first_name" type = "text" autocomplete = "on" name = "first_name" value = <?php echo $user_data['user_first_name'] ;?> />
						</DIV><BR />
						<DIV class = "input-group">
							<SPAN class = "input-group-addon" id = "basic-addon_user_last_name">Last name</SPAN>
							<INPUT class = "form-control" aria-describedby = "basic-addon_user_last_name" type = "text" autocomplete = "on" name = "last_name" value = <?php echo $user_data['user_last_name'] ;?> />
						</DIV><BR />
						<DIV class = "input-group">
							<SPAN class = "input-group-addon" id = "basic-addon_user_email">Email ID</SPAN>
							<INPUT class = "form-control" aria-describedby = "basic-addon_user_email" type = "email" autocomplete = "on" name = "user_email" value = <?php echo $user_data['user_email'] ;?> />
						</DIV><BR />
						<DIV class = "input-group">
							<SPAN class = "input-group-addon" id = "basic-addon_user_display_picture">Profile Image</SPAN>
							<INPUT class = "form-control" aria-describedby = "basic-addon_user_display_picture" type = "file" name = "user_display_picture" />
						</DIV><BR />
						<DIV class = "input-group">
							<H3>Would you like to recieve newsletter from us?</H3>
							<INPUT class = "form-control" type = "checkbox" name ="user_mail_letter_status" <?php if($user_data['user_mail_letter_status'] == 1) { echo 'checked="checked"' ; }?> />
						</DIV><BR />
						<INPUT class = "btn btn-default" type = "submit" value = "Update!!" />
					</DIV>
					<DIV class = "col-md-2"></DIV>
				</FORM>
			</DIV>
		</DIV>
	</BODY>
</HTML>