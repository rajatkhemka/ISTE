<?php
	include '../Core/init.php' ;
	$project = $_GET['project'] ;
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
		<HEADER id = "header">
			<DIV class = "content">
				<DIV id = "logo">
					<A href = "../index.php">ISTE</A>
				</DIV>
			</DIV>
		</HEADER>
		<DIV id = "slide1">
			<DIV class = "container">
				<DIV class = "box">
					<DIV class = "box-icon">
						<SPAN class = "fa fa-4x fa-css3"></SPAN>
					</DIV>
					<DIV class = "info">
						<CENTER>
							<DIV class = "a">
								<B>
									<?php
										echo $project ;
									?>
								</B>
							</DIV>
						</CENTER>
						<P>
							<?php
								$project_info = get_project_details($database_handler , $project) ;
								echo $project_info['project_details'] . '<BR /><BR />Developer-' . $project_info['project_developer'] ;
							?>
						</P>
						<?php
							if ($project_info['download_link'] != '0') {
								?>
								<A href = "<?php echo $project_info['download_link'] ;?>" style = "decoration: none;color: white">
									<IMG src = "../Images/windows.png" />
								</A>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php
							} if ($project_info['github_link'] != '0') {
								?>
								<A href = "<?php echo $project_info['github_link'] ;?>" style = "decoration: none;color: white">
									<IMG src = "../Images/git.png" />
								</A>
								<?php
							}
						?>
					</DIV>
				</DIV>
			</DIV>
		<DIV>
	</BODY>
</HTML>