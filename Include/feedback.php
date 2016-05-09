<DIV id = "myModal10" class = "modal fade" role = "dialog">
	<DIV class = "modal-dialog">
		<DIV class = "modal-content">
			<DIV class = "modal-header">
				<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
				<H4 class = "modal-title">Feedback</H4>
			</DIV>
			<?php
				if ((empty($_POST) === false) and ($_POST['form_type'] === 'feedback')) {
					$user_name = secure($_POST['name_feedback']) ;
					$user_email = secure($_POST['email_feedback']) ;
					$feedback_subject = secure($_POST['subject_feedback']) ;
					$feedback_body = secure($_POST['feedback']) ;
					$feedback_time = date("d-m-Y h:i:s") ;
					$required_fields = array('name_feedback' , 'subject_feedback' , 'email_feedback' , 'feedback') ;
					if(check_input($_POST , $required_fields) === true ) {
						$errors[] = "Fields marked with an * are required!!" ;
					} else {
						send_feedback_email('admin@iste.org' , $feedback_subject , $feedback_body , $user_name , $user_email) ;
						?>
						<SCRIPT type = "text/javascript">
							window.location.href = "Pages/notice.php?feedback" ;
						</SCRIPT>
						<?php
						$_POST = array() ;
					}
				}
			?>
			<FORM action = "" method = "POST">
				<DIV class = "modal-body">
					<INPUT class = "form-control" type = "text" name = "name_feedback" placeholder = "Name *" autocomplete = "on"/><BR />
					<INPUT class = "form-control" type = "text" name = "subject_feedback" placeholder = "Subject *" autocomplete = "on"/><BR />
					<INPUT class = "form-control" type = "email" name = "email_feedback" placeholder = "Email ID *" autocomplete = "on"/><BR />
					<TEXTAREA class = "form-control" rows = "5" cols = "8" name = "feedback" placeholder = "Write feedback here... *"></TEXTAREA><BR />
					<INPUT class = "form-control" type = "hidden" name = "form_type" value = "feedback" />
					<INPUT class = "btn btn-default" type = "submit" value = "Send Feedback!!" />
				</DIV>
			</FORM>
		</DIV>
	</DIV>
</DIV>