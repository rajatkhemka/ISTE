<DIV id = "myModal2" class = "modal fade" role = "dialog">
	<DIV class = "modal-dialog">
		<DIV class = "modal-content">
			<DIV class = "modal-header">
				<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
				<H4 class = "modal-title">Log In</H4>
			</DIV>
			<DIV class = "modal-body">
				<?php
					if ((empty($_POST) === false) and ($_POST['form_type'] === 'user_login')) {
						$user_name = $_POST['name_user'] ;
						$password = secure($_POST['password_user']) ;
						$required_fields = array('name_user' , 'password_user') ;
						if(check_input($_POST , $required_fields) === true ) {
							$errors[] = "Fields marked with an * are required!!" ;
						} if (user_exists($database_handler , $user_name) === false) {
							$errors[] = "Sorry no user of such particular details exists!!" ;
						} if (user_active($database_handler , $user_name) === false) {
							$errors[] = "You need to activate your account!!" ;
						} if (login_user($database_handler , $user_name , $password) === false) {
							$errors[] = 'That credentials are incorrect!!' ;
						} else {
							$login = login_user($database_handler , $user_name , $password) ;
							$_SESSION['id'] = $login ;
							$_SESSION['type'] = 'user' ;
							?>
							<SCRIPT>
								window.location.href = "Pages/login.php" ;
							</SCRIPT>
							<?php
							$_POST = array() ;
						}
					}
				?>
				<FORM action = "" method = "POST" >
					<DIV class = "form-group" >
						<INPUT type = "text" name = "name_user" class = "form-control" placeholder = "User Name" /><BR />
						<INPUT type = "password" name = "password_user" class = "form-control" placeholder = "Password" /><BR />
					</DIV>
					<INPUT class = "form-control" type = "hidden" name = "form_type" value = "user_login" />
					<INPUT type = "submit" value = "Submit" data-backdrop = "static" class = "btn btn-block btn-success" />
				</FORM>
			</DIV>
			<DIV class = "modal-footer">
				<DIV class = "col-md-6">
					<A href = "#" style = "text-decoration: none;color: white" title = "Next Section" data-toggle = "modal" data-target = "#myModal11">
						<BUTTON type = "button" class = "btn btn-default btn-block btn-danger" data-dismiss = "modal">Forgot Username</BUTTON>
					</A>
				</DIV>
				<DIV class = "col-md-6">
					<A href = "#" style = "text-decoration: none;color: white" title = "Next Section" data-toggle = "modal" data-target = "#myModal12">
						<BUTTON type = "button" class = "btn btn-default btn-block btn-danger" data-dismiss = "modal">Forgot Password</BUTTON>
					</A>
				</DIV>
			</DIV>
		</DIV>
	</DIV>
</DIV>