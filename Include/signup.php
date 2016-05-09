<DIV id = "myModal3" class = "modal fade" role = "dialog">
	<DIV class = "modal-dialog">
		<DIV class = "modal-content">
			<DIV class = "modal-header">
				<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
				<H4 class = "modal-title">Register</H4>
			</DIV>
			<?php
				if ((empty($_POST) === false) and ($_POST['form_type'] === 'user_register')) {
					$user_name = secure($_POST['username_register']) ;
					$user_password = secure($_POST['password_register']) ;
					$user_password_again = secure($_POST['password_again_register']) ;
					$user_first_name = secure($_POST['first_name_register']) ;
					$user_last_name = secure($_POST['last_name_register']) ;
					$user_email = secure($_POST['email_register']) ;
					$user_gender = secure($_POST['gender_register']) ;
					$user_branch = secure($_POST['branch_register']) ;
					$user_roll_number = secure($_POST['roll_number_register']) ;
					$user_mobile_number = secure($_POST['mobile_number_register']) ;
					$required_fields = array('username_register' , 'password_register' , 'password_again_register' , 'first_name_register' , 'last_name_register' , 'email_register' , 'gender_register' , 'branch_register') ;
					if(check_input($_POST , $required_fields) === true ) {
						$errors[] = "Fields marked with an * are required!!" ;
					} if (user_exists($database_handler , $user_name) === true) {
						$errors[] = 'Sorry , the username \'' . htmlentities($user_name) . '\' is alreday taken!!' ;
					} if (preg_match("/\\s/", $user_name) == true) {
						$errors[] = 'Username cannot contain any spaces!!' ;
					} if (check_length($user_password) === false) {
						$errors[] = "Password must be 6 to 32 characters long!!" ;
					} if ($user_password != $user_password_again) {
						$errors[] = "Your password must match!!" ;
					} if (email_exists($database_handler , $user_email) === true) {
						$errors[] = 'Sorry , the email \'' . htmlentities($user_email) . '\' is alreday taken!!' ;
					} elseif (empty($errors) === true) {
						$register_data = array(
							'user_name' => $user_name ,
							'user_password' => $user_password ,
							'user_first_name' => $user_first_name ,
							'user_last_name' => $user_last_name ,
							'user_gender' => $user_gender ,
							'user_email' => $user_email ,
							'user_branch' => $user_branch ,
							'user_email_code' => md5(microtime() + $_POST['user_name'])
							) ;
						register_user($database_handler , $register_data) ;
						?>
						<SCRIPT>
							window.location.href = "Pages/notice.php?register" ;
						</SCRIPT>
						<?php
						$_POST = array() ;
					}
				}
			?>
			<FORM action = "" method = "POST">
				<DIV class = "modal-body ativa-scroll">
					<DIV class = "form-group">			
						<INPUT type = "text" name = "username_register" class = "form-control" placeholder = "User Name" /><BR />
						<INPUT type = "password" name = "password_register" class = "form-control" placeholder = "Password" /><BR />
						<INPUT type = "password" name = "password_again_register" class = "form-control" placeholder = "Re-enter Password" /><BR />
						<INPUT type = "text" name = "first_name_register" class = "form-control" placeholder = "First Name" /><BR />
						<INPUT type = "text" name = "last_name_register" class = "form-control" placeholder = "Last Name" /><BR />
						<INPUT type = "email" name = "email_register" class = "form-control" placeholder = "E-mail ID" /><BR />
						<SELECT name = "gender_register" class = "form-control">
							<OPTION>Select a Gender</OPTION>
							<OPTION value = "M">Male</OPTION>
							<OPTION value = "F">Female</OPTION>
						</SELECT><BR />
						<SELECT name = "branch_register" class = "form-control">
							<OPTION>Select a Branch</OPTION>
							<OPTION value = "CE">Civil Engineering</OPTION>
							<OPTION value = "CSE">Computer Science and Engineering</OPTION>
							<OPTION value = "EE">Electrical Engineering</OPTION>
							<OPTION value = "EL">Electronics Engineering</OPTION>
							<OPTION value = "ME">Mechanical Engineering</OPTION>
							<OPTION value = "IT">Information Technology</OPTION>
							<OPTION value = "MCA">Master of Computer Application</OPTION>
						</SELECT><BR />
					</DIV>
				</DIV>
				<DIV class = "modal-footer">
					<INPUT class = "form-control" type = "hidden" name = "form_type" value = "user_register" />
					<INPUT type = "Submit" value = "Submit" class = "btn btn-default btn-block btn-success" />
				</DIV>
			</FORM>
		</DIV>
	</DIV>
</DIV>