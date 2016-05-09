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
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Wellfleet" />
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic" />	
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Oswald" />
		<LINK rel = "stylesheet" type = "text/css" href = "http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap-theme.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/bootstrap.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/notifIt.css" />
		<LINK rel = "stylesheet" type = "text/css" href = "../CSS/style.css" />
		<SCRIPT type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/bootstrap.js"></SCRIPT>
		<SCRIPT type = "text/javascript" src = "../JS/Jquery.js"></SCRIPT>
	</HEAD>
	<BODY>
		<DIV id = "mail_user" class = "modal fade" role = "dialog">
			<DIV class = "modal-dialog">
				<DIV class = "modal-content">
					<DIV class = "modal-header">
						<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
						<H4 class = "modal-title">Mail User</H4>
					</DIV>
					<FORM action = "" method="POST">
						<DIV class = "modal-body">
							<DIV class = "form-group">			
								<INPUT type = "text" name = "subject" class = "form-control" placeholder = "Subject"></BR>
								<TEXTAREA type = "text" name = "body" class = "form-control" placeholder = "Body"></TEXTAREA></BR>
								<INPUT type = "hidden" name = "form_type" value = "mail_user"/>
							</DIV>
						</DIV>
						<DIV class = "modal-footer">
							<A href = "#" title = "Next Section">
								<INPUT type = "submit" class = "btn btn-default">
							</A>
							<BUTTON type = "button" class = "btn btn-default" data-dismiss = "modal">Cancel</BUTTON>
						</DIV>
					</FORM>
					<?php
						if ((empty($_POST) === false) and ($_POST['form_type'] === 'mail_user')) {
							if (empty($_POST['subject'])) {
								$errors[] = 'Subject is required!!' ;
							}
							if (empty($_POST['body'])) {
								$errors[] = 'Body is required!!' ;
							}
							if (empty($errors) === false) {
								echo output_errors($errors) ;
							} else {
								$subject = secure($_POST['subject']) ;
								$body = secure($_POST['body']) ;
								mail_users($database_handler , $subject , $body) ;
								$_POST = array() ;
							}
						} elseif (empty($errors) === false) {
							echo output_errors($errors) ;
						}
					?>
				</DIV>
			</DIV>
		</DIV>
		<DIV id = "add_quiz" class = "modal fade" role = "dialog">
			<DIV class = "modal-dialog">
				<DIV class = "modal-content">
					<DIV class = "modal-header">
						<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
						<H4 class = "modal-title">Add Quiz</H4>
					</DIV>
					<FORM action = "" method = "POST">
						<DIV class = "modal-body">
							<DIV class = "form-group">			
								<INPUT type = "text" name = "title" class = "form-control" placeholder = "Title"></BR>
								<INPUT type = "text" name = "number_of_questions" class = "form-control" placeholder = "Number of Questions"></BR>
								<INPUT type = "text" name = "positive_marks" class = "form-control" placeholder = "Marks on Right Answer"></BR>
								<INPUT type = "text" name = "negative_marks" class = "form-control" placeholder = "Negative marks on Wrong Answer"></BR>
								<INPUT type = "text" name = "time_limit" class = "form-control" placeholder = "Time limit of test in minutes"></BR>
								<INPUT type = "text" name = "question_tag" class = "form-control" placeholder = "Question Tag"></BR>
								<INPUT type = "text" name = "description" class = "form-control" placeholder = "Description"></BR>
								<INPUT type = "hidden" name = "form_type" value = "add_quiz" />
							</DIV>
						</DIV>
						<DIV class = "modal-footer">
							<INPUT type = "submit" class = "btn btn-default">
							<BUTTON type = "button" class = "btn btn-default" data-dismiss = "modal">Cancel</BUTTON>
						</DIV>
					</FORM>
					<?php
						if ((empty($_POST) === false) and ($_POST['form_type'] === 'add_quiz')) {
							$title = $_POST['title'] ;
							$number_of_questions = $_POST['number_of_questions'] ;
							$positive_marks = $_POST['positive_marks'] ;
							$negative_marks = $_POST['negative_marks'] ;
							$time_limit = $_POST['time_limit'] ;
							$question_tag = $_POST['question_tag'] ;
							$description = $_POST['description'] ;
							$quiz_details = array(
								'event_id' => md5(microtime()),
								'title' => $title,
								'correct' => $positive_marks,
								'wrong' => $negative_marks,
								'total' => $number_of_questions,
								'time' => $time_limit,
								'tag' => $question_tag,
								'description' => $description
								) ;
							add_quiz($database_handler , $quiz_details) ;
							$_POST = array() ;
							?>
							<SCRIPT type = "text/javascript">
								window.location.href = "add_questions.php?e_id=<?php echo $quiz_details['event_id']?>" ;
							</SCRIPT>
							<?php
						}
					?>
				</DIV>
			</DIV>
		</DIV>
		<DIV id = "remove_quiz" class = "modal fade" role = "dialog">
			<DIV class = "modal-dialog">
				<DIV class = "modal-content">
					<DIV class = "modal-header">
						<BUTTON type = "button" class = "close" data-dismiss = "modal">&times;</BUTTON>
						<H4 class = "modal-title">Remove Quiz</H4>
					</DIV>
					<FORM action = "" method = "POST">
						<DIV class = "modal-body">
							<DIV class = "form-group">			
								<INPUT type = "text" name = "title" class = "form-control" placeholder = "Title"/>
								<INPUT type = "hidden" name = "form_type" value = "remove_quiz" />
							</DIV>
						</DIV>
						<DIV class = "modal-footer">
							<INPUT type = "submit" class = "btn btn-default">
							<BUTTON type = "button" class = "btn btn-default" data-dismiss = "modal">Cancel</BUTTON>
						</DIV>
					</FORM>
					<?php
						if ((empty($_POST) === false) and ($_POST['form_type'] === "remove_quiz")) {
							$title = $_POST['title'] ;
							remove_quiz($database_handler , $title) ;
							$_POST = array() ;
						}
					?>
				</DIV>
			</DIV>
		</DIV>
		<HEADER id = "header">
			<DIV class = "content">
				<DIV id = "logo">
					<A href = "#slide1">Admin@ISTE</A>
				</DIV>
				<NAV id = "nav">
					<UL>
						<LI>
							<A href = "#" data-toggle = "modal" data-target = "#mail_user">Mail User</A>
						</LI>
						<LI>
							<A href = "#" data-toggle = "modal" data-target = "#add_quiz">Add Quiz</A>
						</LI>
						<LI>
							<A href = "#" data-toggle = "modal" data-target = "#remove_quiz">Remove Quiz</A>
						</LI>
						<LI>
							<A href = "logout.php" >Log Out</A>
						</LI>
					</UL>
				</NAV>
			</DIV>
		</HEADER>
		<DIV id = "slide1">
			<H1> Hello admin , 
				<?php
					echo $user_data['admin_name'] ;
				?>
				 !!
			</H1>
		<DIV>
	</BODY>
</HTML>