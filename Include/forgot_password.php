<DIV id = "myModal12" class = "modal fade" role = "dialog">
	<DIV class = "modal-dialog">
		<DIV class = "modal-content">
			<DIV class = "modal-header">
				<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
				<H4 class = "modal-title">Forgot Password</H4>
			</DIV>
			<?php
				if (empty($_POST) === true) {
					$errors[] = 'Fields marked with an * are required!!' ;
				} elseif ($_POST['form_type'] === 'forgot_password') {
					$email = secure($_POST['email_forgot']) ;
					if (email_exists($database_handler , $email) === true) {
						$mode = "password" ;
						recover($database_handler , $mode , $email) ;
						?>
						<SCRIPT type = "text/javascript">
							window.location.href = "Pages/notice.php?forgot_password" ;
						</SCRIPT>
						<?php
						$_POST = array() ;
					} else {
						$errors[] ="Oops, we couldn't find that email address" ;
					}
				}
			?>
			<FORM action = "" method = "POST">
				<DIV class = "modal-body">
					<INPUT class = "form-control" type = "email" name = "email_forgot" placeholder = "Email ID *" autocomplete = "on"/><BR />
					<INPUT class = "form-control" type = "hidden" name = "form_type" value = "forgot_password" />
					<INPUT class = "btn btn-default btn-block btn-info" type = "submit" value = "Get Password!!" />
				</DIV>
			</FORM>
		</DIV>
	</DIV>
</DIV>