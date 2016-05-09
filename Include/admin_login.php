<DIV id = "myModal4" class = "modal fade" role = "dialog">
	<DIV class = "modal-dialog">
		<DIV class = "modal-content">
			<DIV class = "modal-header">
				<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
				<H4 class = "modal-title">Admin Login</H4>
			</DIV>
			<?php
				if ((empty($_POST) === false) and ($_POST['form_type'] === 'admin_login')) {
					$admin_name = secure($_POST['username_admin']) ;
					$admin_email = secure($_POST['email_admin']) ;
					$admin_password = secure($_POST['password_admin']) ;
					$admin_number = secure($_POST['phone_admin']) ;
					$required_fields = array('username_admin' , 'email_admin' , 'password_admin' , 'phone_admin') ;
					if(check_input($_POST , $required_fields) === true ) {
						$errors[] = "Fields marked with an * are required!!" ;
					} if (admin_exists($database_handler , $admin_name) === false) {
						$errors[] = "Sorry no admin of such particular details exists!!" ;
					} if (admin_active($database_handler , $admin_name) === false) {
						$errors[] = "You need to activate your account!!" ;
					} if (login_admin($database_handler , $admin_name , $admin_email , $admin_number , $admin_password) === false) {
						$errors[] = 'That credentials are incorrect!!' ;
					} else {
						$login = login_admin($database_handler , $admin_name , $admin_email , $admin_number , $admin_password) ;
						$_SESSION['id'] = $login ;
						$_SESSION['type'] = 'admin' ;
						?>
							<SCRIPT>
								window.location.href = "Pages/admin.php" ;
							</SCRIPT>
						<?php
						$_POST = array() ;
					}
				}
			?>
			<DIV class = "modal-body" >
				<FORM action = "" method = "POST" >
					<DIV class = "form-group">
						<INPUT type = "text" name = "username_admin" class = "form-control" placeholder = "Admin Name *" /><BR />
						<INPUT type = "email" name = "email_admin" class = "form-control" placeholder = "Admin Email *" /><BR />
						<INPUT type = "password" name = "password_admin" class = "form-control" placeholder = "Admin Password *" /><BR />
						<INPUT type = "text" name = "phone_admin" class = "form-control" placeholder = "Admin Phone *" /><BR />
					</DIV>
					<DIV class = "modal-footer">
						<INPUT class = "form-control" type = "hidden" name = "form_type" value = "admin_login" />
						<INPUT type = "submit" value = "Submit" class = "btn btn-default">
					</DIV>
				</FORM>
			</DIV>
		</DIV>
	</DIV>
</DIV>