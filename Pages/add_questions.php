<?php
	include '../Core/init.php' ;
	$quiz_id = $_GET['e_id'] ;
	$_GET = array() ;
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
		<DIV class = "jumbotron">
			<H1>Hello, world!</H1>
			<FORM action = "" method = "POST">
			<?php
				$limit = get_number_of_questions($database_handler , $quiz_id) ;
				$count = 1 ;
				while ($count <= $limit) {
					?>
					<BR /><TEXTAREA type = "text" name = "question_<?php echo $count ;?>" class = "form-control" placeholder = "Enter your Questions here"></TEXTAREA><BR />
					<INPUT type = "text" class = "form-control" name = "option_a_question_<?php echo $count ;?>" placeholder = "Option A" /><BR />
					<INPUT type = "text" class = "form-control" name = "option_b_question_<?php echo $count ;?>" placeholder = "Option B" /><BR />
					<INPUT type = "text" class = "form-control" name = "option_c_question_<?php echo $count ;?>" placeholder = "Option C" /><BR />
					<INPUT type = "text" class = "form-control" name = "option_d_question_<?php echo $count ;?>" placeholder = "Option D" /><BR />
					<INPUT type = "text" class = "form-control" name = "answer_question_<?php echo $count ;?>" placeholder = "Enter the correct option"/><BR />
					<?php
					$count ++ ;
				}
			?>
				<BR /><INPUT type = "submit" class = "form-control btn btn-block btn-success" />
			</FORM>
			<?php
				if (empty($_POST) === false) {
					$count = 1 ;
					$questions = array() ;
					$options = array() ;
					$correct_answer = array() ;
					while ($count <= $limit) {
						$index = 'question_' . $count ;
						array_push($questions , $_POST[$index]) ;
						$index = 'option_a_question_' . $count ;
						array_push($options , $_POST[$index]) ;
						$index = 'option_b_question_' . $count ;
						array_push($options , $_POST[$index]) ;
						$index = 'option_c_question_' . $count ;
						array_push($options , $_POST[$index]) ;
						$index = 'option_d_question_' . $count ;
						array_push($options , $_POST[$index]) ;
						$index = 'answer_question_' . $count ;
						array_push($correct_answer , $_POST[$index]) ;
						$count ++ ;
					}
					add_questions($database_handler , $questions , $quiz_id ,$limit) ;
					add_options($database_handler , $limit , $options , $questions) ;
					add_answer($database_handler , $correct_answer , $questions , $limit) ;
				}
			?>
		</DIV>
	</BODY>
</HTML>