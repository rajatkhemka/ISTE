<?php
	include '../Core/init.php' ;
	$user_name = $user_data['user_name'] ;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<META charset="UTF-8" />
		<TITLE>ISTE | Login</TITLE>
		<LINK rel = "stylesheet" href = "../CSS/bootstrap.css" />
		<LINK rel = "stylesheet" href = "../CSS/Login/reset.css" />
		<LINK rel = "stylesheet" href = "../CSS/Login/style.css" />
		<SCRIPT TYPE="text/javascript">
			function show_div() {
				document.getElementById("quiz_list").style.display = "" ;
				document.getElementById("profile").style.display = "none" ;
			}
		</SCRIPT>
	</HEAD>
    <BODY>
		<NAV>
			<UL>
				<LI>
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<H4>SETTINGS</H4>
				</LI>
				<LI>
					<span class="glyphicon glyphicon-compressed" aria-hidden="true"></span>
					<H4>
						<A href = "change_password.php" style = "text-decoration: none;color: white">CHANGE PASSWORD</A>
					</H4>
				</LI>
				<LI>
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
					<H4>
						<A href = "logout.php" style = "text-decoration: none;color: white">LOG OUT</A>
					</H4>
				</LI>
		    </UL>
		</NAV>
		<DIV class = "container">
			<DIV class = "topcorner">
				<?php
					echo "Welcome " . $user_name ;
				?>
			</DIV>
			<DIV class = "menu-icon">
				<SPAN></SPAN>
			</DIV>
			<DIV class = "floating-box1">
				<?php
					if (empty($_GET['start_quiz']) === true) {
						$button_text = 'Take Quiz' ;
						?>
						<DIV id = "quiz_list" style = "display: none;">
							<?php
								display_quizes($database_handler) ;
							?>
						</DIV>
						<?php
					} else {
						start_quiz($database_handler , $_GET['start_quiz']) ;
						$button_text = "" ;
					}
				?>
			</DIV>
			<DIV class = "floating-box2">
				<DIV class = "headng">Stats</DIV>
				<DIV class = "linebreak"></DIV>
			</DIV>
			<INPUT type = "button" class = "btn" name = "answer" onClick = "show_div()" value = "<?php echo $button_text?>"/>
		</DIV>
		<SCRIPT src = "http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></SCRIPT>
		<SCRIPT src = "../JS/Login/index.js"></SCRIPT>
    </BODY>
</HTML>