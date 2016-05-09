<?php
	include '../Core/init.php' ;
?>
<!DOCTYPE html>
<HTML>
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
		<HEADER id = "header">
			<DIV class = "content">
				<DIV id = "logo">
					<A href = "../index.php">ISTE</A>
				</DIV>
			</DIV>
		</HEADER>
		<DIV id = "slide1">
			<DIV class = "content">
				<H1>ISTE</H1></BR></BR>
				<H1>KNIT, Sultanpur</H1>
				<?php
					if ((isset($_GET['success']) === true) && (empty($_GET['success']) === true)) {
						?>
						<H3>We have activated your account ,  and you are free to log in!!</H3>
						<?php
					} elseif (isset($_GET['email'] , $_GET['email_code']) === true) {
						$email = trim($_GET['email']) ;
						$email_code = trim($_GET['email_code']) ;
						if (email_exists($database_handler , $email) === false) {
							$errors[] = 'Oops, something went wrong and we couldn\'t find that email address!!' ;
						} elseif (activate($database_handler , $email , $email_code) === false) {
							$errors[] = 'We had problems activating your account please try again later!!' ;
						}
						if (empty($errors) === false) {
							echo '<H2>Oops,</H2>' ;
							echo output_errors($errors) ;
						} else {
							?>
							<SCRIPT type = "text/javascript">
								window.location.href = "activate.php?success" ;
							</SCRIPT>
							<?php
						}
					} else {
						?>
						<SCRIPT type = "text/javascript">
							window.location.href = "../index.php" ;
						</SCRIPT>
						<?php
					}
				?>
			</DIV>
		</DIV>
	</BODY>
</HTML>