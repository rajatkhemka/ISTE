<?php
	include 'Core/init.php' ;
?>
<!DOCTYPE html>
<HTML lang = "en">
	<HEAD>
		<META http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
		<META charset = "utf-8" />
		<META name = "viewport" content = "width=device-width, initial-scale = 1" />
		<META name = "author" content = "capt_MAKO | Sneha Bharti" />
		<TITLE>ISTE|KNIT, Sultanpur</TITLE>
		<?php
			include 'Include/files.php' ;
		?>
		<SCRIPT type = "text/javascript" > 
		$(document).ready(function() {
			$('a[href*=#]').each(function() {
				if ((location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')) && (location.hostname == this.hostname) && (this.hash.replace(/#/,''))) {
					var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']') ;
					var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false ;
					if ($target) {
						var targetOffset = $target.offset().top ;
						$(this).click(function() {
							$("#nav li a").removeClass("active") ;
							$(this).addClass('active') ;
							$('html, body').animate({scrollTop: targetOffset}, 1000) ;
							return false ;
						}) ;
					}
				}
			}) ;
		}) ;
		</SCRIPT>
		<SCRIPT type = "text/javascript" >
			$(document).ready(function() {
				$("#collage-container img").mouseover(function() {
					$("#collage-container img").css("z-index",1) ;
					$(this).css("z-index",999) ;
					$(this).fadeOut(100,function() {
						$(this).fadeIn(1000) ;  
					}) ;
				}) ;
			}) ;
		</SCRIPT>		
		<SCRIPT type = "text/javascript" >
			$(document).ready(ajustamodal) ;
			$(window).resize(ajustamodal) ;
			function ajustamodal() {
				var altura = $(window).height() - 160 ;
				$(".ativa-scroll").css({"height":altura,"overflow-y":"auto"}) ;
			}
		</SCRIPT>
		<SCRIPT type = "text/javascript" >
				$(window).load(function() {
					$(".se-pre-con").fadeOut("slow");;
				});
		</SCRIPT>
	</HEAD>
	<BODY>
	<DIV class = "se-pre-con"></DIV>
		<?php
			include 'Include/forgot_password.php' ;
			include 'Include/forgot_username.php' ;
			include 'Include/feedback.php' ;
			include 'Include/login.php' ;
			include 'Include/signup.php' ;
			include 'Include/admin_login.php' ;
			include 'Include/user_panel.php' ;
			include 'Include/Members/final.php' ;
			include 'Include/Members/third.php' ;
			include 'Include/Members/second.php' ;
			include 'Include/Members/first.php' ;
			include 'Include/Members/alumni.php' ;
			include 'Include/header.php' ;
		?>
		<DIV id = "slide1">
			<DIV class = "content">
				<H1>ISTE</H1></BR></BR>
				<H1>KNIT, Sultanpur</H1>
			</DIV>
		</DIV> 
		<DIV id = "slide2">
			<DIV class = "content" >
				<SECTION class = "cd-horizontal-timeline">
					<DIV class = "timeline">
						<DIV class = "events-wrapper">
							<DIV class = "events">
								<OL>
									<?php
										get_dates($database_handler) ;
									?>
								</OL>
								<SPAN class = "filling-line" aria-hidden = "true"></SPAN>
							</DIV>
						</DIV>
						<UL class = "cd-timeline-navigation">
							<LI><A href= "#0" class = "prev inactive">Prev</A></LI>
							<LI><A href= "#0" class = "next">Next</A></LI>
						</UL>
					</DIV>
					<DIV class = "events-content">
						<OL>
							<?php
								get_events($database_handler) ;
							?>
						</OL>
					</DIV>
				</SECTION>
			</DIV>
		</DIV> 
		<DIV id = "slide3">
			<DIV class = "content"></DIV> 
			<DIV class = "container">
				<DIV class = "row">
					<?php
						show_projects($database_handler) ;
					?>
				</DIV>
			</DIV>
		</DIV> 
		<DIV id = "slide4">
			<DIV class = "content">
				<BUTTON type = "button" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal5" id = "button">Final Year</BUTTON>
				<BUTTON type = "button" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal6" id = "button">Third Year</BUTTON>
				<BUTTON type = "button" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal7" id = "button">Second Year</BUTTON>
				<BUTTON type = "button" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal8" id = "button1">First Year</BUTTON>
				<BUTTON type = "button" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal9" id = "button2">Aluminis</BUTTON>
			</DIV> 
		</DIV>
		<?php
			include 'Include/footer.php' ;
		?>
	</BODY>
</HTML>