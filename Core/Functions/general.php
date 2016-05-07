<?php
	//secure the input for any attack on the server
	function secure($data) {
		$data = htmlentities($data) ;
		return $data ;
	}
	//secures the array for any attack on the server
	function secure_array(&$data) {
		$data = htmlentities($data) ;
	}
	//checks if any input field is empty
	function check_input($data = array() , $required_fields = array()) {
		foreach ($data as $key => $value) {
			if ((in_array($key , $required_fields) === true) and (empty($value) === true)) {
				return true ;
			}
		}
		return false ;
	}
	//checks the length of tha password
	function check_length($password) {
		if ((strlen($password) < 6) or (strlen($password) > 64)) {
			return false ;
		} else {
			return true ;
		}
	}
	//redirect the user to the given page
	function redirect_to($current_file , $location) {
		$pages_directory = array('admin.php' , 'login.php' , 'feedback.php' , 'register.php') ;
		if ((in_array($current_file , $pages_directory)) and ($location = 'index.php')) {
			header('Location: ../' . $location) ;
			exit() ;
		}
	}
	//checks if the user is logged in
	function logged_in() {
		if (isset($_SESSION['id']) === true) {
			return true ;
		} else {
			return false ;
		}
	}
	//outputs the error
	function output_errors($errors) {
		$output = array() ;
		foreach ($errors as $error) {
			$output[] = $error ;
		}
		$result = '<UL><LI>' . implode('</LI><LI>' , $output) . '</LI></UL>' ;
		return $result ;
	}
	//protects the page from logged in user
	function protect_page() {
		if (logged_in() === true) {
			header('Location: ../index.php') ;
			exit() ;
		}
	}
	//gets the ip of the user
	function get_users_ip() {
		$ip = '' ;
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP') ;
		} elseif (getenv('HTTP_X_FORWRDED_FOR')) {
			$ip = getenv('HTTP_X_FORWRDED_FOR') ;
		} elseif (getenv('HTTP_X_FORWRDED')) {
			$ip = getenv('HTTP_X_FORWRDED') ;
		} elseif(getenv('HTTP_FORWRDED_FOR')) {
			$ip = getenv('HTTP_FORWRDED_FOR') ;
		} elseif (getenv('HTTP_FORWRDED')) {
			$ip = getenv('HTTP_FORWRDED') ;
		} elseif (getenv('REMOTE_ADDR')) {
			$ip = getenv('REMOTE_ADDR') ;
		} else {
			$ip = 'UNKNOWN' ;
		}
		return $ip ;
	}
	//gets the length of the array
	function get_length_of_array($data) {
		$count = 0 ;
		foreach ($data as $key => $value) {
			$count ++ ;
		}
		return $count ;
	}
	//returns the images of final year
	function get_images($database_handler, $current_file, $year) {
		if ($current_file == 'index.php') {
			$sql_query = "SELECT * FROM `images` WHERE `image_year` = $year" ;
			$result = mysqli_query($database_handler , $sql_query) ;
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<IMG src = "' . $row['image_source'] . '" id = "' . $row['image_tag_id'] . '" title = "' . $row['image_title'] . '" />' ;
			}
		}
	}
	//shows the projects list
	function show_projects($database_handler) {
		$sql_query = "SELECT * FROM `project`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$string = '' ;
		while ($row = mysqli_fetch_assoc($result)) {
			$link_address = 'Pages/download.php?project=' . $row['project_name'] . '' ;
			$string .= '<DIV class = "container">
							<DIV class = "box">
								<DIV class = "box-icon">
									<SPAN class = "fa fa-4x fa-css3"></SPAN>
								</DIV>
								<DIV class = "info">
									<CENTER>
										<DIV class = "a">
											<B>' . $row['project_name'] . '</B>
										</DIV>
									</CENTER>
									<P>' . $row['project_details'] . '<BR /><BR />Developer-' . $row['project_developer'] . '</P><BR />
									<A href = ' . $link_address . ' class = "btn btn-default btn-block btn-info">Show</A>
								</DIV>
							</DIV>
						</DIV>' ;
		}
		echo $string ;
	}
	//function to get the dates of the events
	function get_dates($database_handler) {
		$sql_query = "SELECT * FROM `events`" ;
		$count = 0 ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_assoc($result)) {
			if ($count == 0) {
				$string = 'class = selected' ;
			} else {
				$string = '' ;
			}
			echo'<LI>
					<A href= "#0" data-date = "' . $row['event_data_date']  . '" ' . $string . '>' . $row['event_date'] . '</A>
				</LI>' ;
			$count ++ ;
		}
	}
	//function to get event details
	function get_events($database_handler) {
		$sql_query = "SELECT * FROM `events`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$count = 0 ;
		while ($row = mysqli_fetch_assoc($result)) {
			if ($count == 0) {
				$string = 'class = selected' ;
			} else {
				$string = '' ;
			}
			echo'<LI data-date = "' . $row['event_data_date']  . '" ' . $string . '>
					<H2>' . $row['event_title']  . '</H2>
					<EM>' . $row['event_full_date'] . '</EM>
					<P> ' . $row['event_description'] .  ' </P>
				</LI>' ;
			$count ++ ;
		}
	}
	//function to display developers
	function get_developers($database_handler) {
		$sql_query = "SELECT * FROM `developers`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$string = '' ;
		while ($row = mysqli_fetch_assoc($result)) {
			$string .= '<DIV class = "col-sm-3">
							<DIV class = "card">
								<CANVAS class = "header-bg" width = "250" height = "70" id = "header-blur"></CANVAS>
								<DIV class = "avatar">
									<IMG src = "' . $row['developer_image_path'] . '" alt = "" />
								</DIV>
								<DIV class = "content">
									<P>
										<BR />' . $row['developer_name'] . '<BR />
										' . $row['developer_branch'] . '<BR />
										' . $row['developer_year'] . '<BR />
										Email-id: ' . $row['developer_email_id'] . '
									</P>
								</DIV>
							</DIV>
						</DIV>' ;
		}
		echo $string ;
	}
	//function to get the details of required project
	function get_project_details($database_handler , $project) {
		$sql_query = "SELECT * FROM `project` WHERE `project_name` = '$project'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		return $result ;
	}
?>