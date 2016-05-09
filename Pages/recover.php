 <?php
	include '../Core/init.php' ;
	protect_page() ;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>Recover</TITLE>
	</HEAD>
	<BODY>
		<A href = "../index.php">&larr; Back</A><BR /><BR />
		<?php
			if ((isset($_GET['success']) === true) && (empty($_GET['success']) === true))
			{
				echo '<P>Your details have been sent to the email address you provided!!</P>' ;
			}
			else
			{
				$mode_allowed = array('username' , 'password') ;
				if ((isset($_GET['mode']) === true) && (in_array($_GET['mode'] , $mode_allowed) === true))
				{
					$mode = secure($_GET['mode']) ;
					if ((isset($_POST['email']) === true) && (empty($_POST['email']) === false))
					{
						$email = secure($_POST['email']) ;
						if (email_exists($database_handler , $email) === true)
						{
							recover($database_handler , $mode , $email) ;
							header('Location: recover.php?success') ;
						}
						else
						{
							echo '<P>Oops, we couldn\'t find that email address</P>' ;
						}
					}
					?>
					<FORM action = "" method = "POST">
						Please enter your email address *:<BR /><BR />
						<INPUT type = "text" name = "email" placeholder = "Email" autocomplete = "on" /><BR /><BR />
						<INPUT type = "submit" value = "Recover" />
					</FORM>
					<?php
				}
				else
				{
					header('Location: ../index.php') ;
					exit() ;
				}
			}
		?>
	</BODY>
</HTML>
