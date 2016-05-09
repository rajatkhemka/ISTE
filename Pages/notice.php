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
					if ((isset($_GET['forgot_password'])) and (empty($_GET['forgot_password']))) {
						?>
						<H3>Your password has been mailed to you !! :)</H3>
						<?php
					} elseif ((isset($_GET['forgot_username'])) and (empty($_GET['forgot_username']))) {
						?>
						<H3>Your username has been mailed to you !! :)</H3>
						<?php
					} elseif ((isset($_GET['feedback'])) and (empty($_GET['feedback']))) {
						?>
						<H3>Thanks for your valuable feedback !! :)</H3>
						<?php
					} elseif ((isset($_GET['register'])) and (empty($_GET['register']))) {
						?>
						<H3>You have successfully registered, kindly check your mail for activation of your account !! :)</H3>
						<?php
					}
				?>
			</DIV> 
		</DIV>
	</BODY>
</HTML>