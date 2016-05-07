<?php
	//checks for the existence of user
	function user_exists($database_handler , $user_name) {
		$sql_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name'" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if($result == 1) {
			return true ;
		} else {
			return false ;
		}
	}
	//checks if the particular user is active
	function user_active($database_handler , $user_name) {
		$sql_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' AND `user_active_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if($result == 1) {
			return true ;
		} else {
			return false ;
		}
	}
	//logs in the user if the credentials match
	function login_user($database_handler , $user_name , $user_password) {
		$sql_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name' AND `user_password` = '$user_password' AND `user_active_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if ($result == 1) {
			$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
			return $result['user_id'] ;
		} else {
			return false ;
		}
	}
	//store the feedback in the database
	function store_feedback($database_handler , $user_name , $user_email , $feedback_subject , $feedback_body , $feedback_time) {
		$sql_query = "INSERT INTO `feedback` SET `user_name` = '$user_name' , `user_email` = '$user_email' , `feedback_subject` = '$feedback_subject' , `feedback_body` = '$feedback_body' , `feedback_time` = NOW()" ;
		mysqli_query($database_handler , $sql_query) ;
	}
	//checks if a particular email exists or not
	function email_exists($database_handler , $user_email) {
		$sql_query = "SELECT * FROM `user` WHERE `user_email` = '$user_email'" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if($result == 1) {
			return true ;
		} else {
			return false ;
		}
	}
	//sends the feedback email to the given address
	function send_feedback_email($to , $subject , $body , $name , $user_email) {
		$header = 'From :' . $name . ' <' . $user_email . '>' ;
		mail($to , $subject , $body , $header) ;
	}
	//checks if the particular user is admin
	function check_if_user_is_admin($database_handler , $user_id) {
		$sql_query = "SELECT * FROM `user` WHERE `user_id` = $user_id AND `user_admin_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if ($result == 1)
		{
			return true ;
		} else {
			return false ;
		}
	}
	//registers the user
	function register_user($database_handler , $register_data) {
		array_walk($register_data , 'secure_array') ;
		$field = '`' . implode('` , `' , array_keys($register_data)) . '`' ;
		$data = '\'' . implode('\' , \'' , $register_data) . '\'' ;
		$sql_query = "INSERT INTO `user` ($field) VALUES ($data)" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$subject = 'Activate your account' ;
		$body = "Hello " . $register_data['user_first_name'] . " " . $register_data['user_last_name'] . ",\n\nYou need to activate your account by clicking the link below:\n\nhttp://localhost/ISTE/Pages/activate.php?email=" . $register_data['user_email'] . "&email_code=" . $register_data['user_email_code'] . "\n\n- ISTE" ;
		send_email($register_data['user_email'] , $subject , $body) ;
	}
	//send activation email
	function send_email($to , $subject , $body) {
		$header = 'From: admin@iste.org' ;
		mail($to , $subject , $body , $header) ;
	}
	//activates the user
	function activate($database_handler , $email , $email_code) {
		$email = mysqli_real_escape_string($database_handler , $email) ;
		$email_code = mysqli_real_escape_string($database_handler , $email_code) ;
		$sql_query = "SELECT * FROM `user` WHERE `user_email` = '$email' AND `user_email_code` = '$email_code' AND `user_active_status` = 0" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		if ($result -> num_rows == 1) {
			$sql_query = "UPDATE `user` SET `user_active_status` = 1 WHERE `user_email` = '$email'" ;
			mysqli_query($database_handler , $sql_query) ;
			return true ;
		} else {
			return false ;
		}
	}
	//gives the number of registered users on the web site
	function number_of_users($database_handler) {
		$sql_query = "SELECT * FROM `user`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$count = $result -> num_rows ;
		return $count ;
	}
	//changes the password of the user logged in
	function change_password($database_handler , $user_id , $password) {
		$sql_query = "UPDATE `user` SET `user_password` = '$password' , `user_password_recovery_status` = 0 WHERE `user_id` = $user_id" ;
		mysqli_query($database_handler , $sql_query) ;
	}
	//updates the details of the users
	function update_user($database_handler , $user_id , $update_data) {
		$update = array() ;
		foreach ($update_data as $field => $data) {
			$update[] = '`' . $field . '` =\'' . $data .'\'' ;
		}
		$sql_query = "UPDATE `user` SET " . implode(' , ' , $update) . " WHERE `user_id` = " . $user_id ;
		mysqli_query($database_handler , $sql_query) ;
	}
	//gives the user id of the user with the given username
	function user_id_from_username($database_handler , $user_name) {
		$sql_query = "SELECT * FROM `user` WHERE `user_name` = '$user_name'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$id = $result['user_id'] ;
		return $id ;
	}
	//gives the entire data of the user
	function user_data($database_handler , $user_id) {
		$sql_query = "SELECT * FROM `user` WHERE `user_id` = $user_id" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		return $result ;
	}
	//gets the gender from the short hand form
	function get_expanded_gender($gender) {
		if ($gender === 'M') {
			return 'Male' ;
		} else {
			return 'Female' ;
		}
	}
	//gets the branch from the short hand form
	function get_expanded_branch($branch) {
		switch ($branch) {
			case 'CE' : {
				$result = 'Civil Engineering' ;
				break ;
			} case 'CSE' : {
				$result = 'Computer Science and Engineering' ;
				break ;
			} case 'EE' : {
				$result = 'Electrical Engineering' ;
				break ;
			} case 'EL' : {
				$result = 'Electronics Engineering' ;
				break ;
			} case 'ME' : {
				$result = 'Mechanical Engineering' ;
				break ;
			} case 'IT' : {
				$result = 'Informatin Technology' ;
				break ;
			} case 'MCA' : {
				$result = 'Master of Computer Application' ;
				break ;
			}
		}
		return $result ;
	}
	//gets the user id of the user with given email
	function user_id_from_email($database_handler , $email) {
		$sql_query = "SELECT * FROM `user` WHERE `user_email` = '$email'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$id = $result['user_id'] ;
		return $id ;
	}
	//recovers the details of the user logged in
	function recover($database_handler , $mode , $email) {
		$user_id = user_id_from_email($database_handler , $email) ;
		$user_data = user_data($database_handler , $user_id) ;
		if ($mode == 'username') {
			$subject = 'Your User Name Recovery' ;
			$body = "Hello " . $user_data['user_first_name'] . " " . $user_data['user_last_name'] . ",\n\nYour User Name is:\n\n" . $user_data['user_name'] . "\n\n- ISTE" ;
			send_email($email , $subject , $body) ;
		} elseif ($mode == 'password') {
			$generated_password = substr(md5(rand(999 , 999999)) , 0 , 8) ;
			change_password($database_handler , $user_id , $generated_password) ;
			$subject = 'Your Password Recovery' ;
			$body = "Hello " . $user_data['user_first_name'] . " " . $user_data['user_last_name'] . ",\n\nYour new Password is:\n\n" . $generated_password . "\n\n- ISTE" ;
			$fields = array('user_password_recovery_status' => '1') ;
			update_user($database_handler , $user_id , $fields) ;
			send_email($email , $subject , $body) ;
		}
	}
	//gets the quiz for the user
	function get_quiz($database_handler , $title) {
		$sql_query = "SELECT * FROM `quiz` WHERE `title` = '$title'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$event_id = $result['event_id'] ;
		$sql_query = "SELECT * FROM `questions` WHERE `event_id` = '$event_id' ORDER BY `question_number`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$string = '<FORM action = "" method = "POST">' ;
		while ($row = mysqli_fetch_assoc($result)) {
			$question_id = $row['question_id'] ;
			$string .=
			'<LEFT>Q no. ' . $row['question_number'] . '</LEFT><BR /><BR />' . $row['question'] . '<BR /><BR />' ;
			$sql_query = "SELECT * FROM `options` WHERE `question_id` = '$question_id'" ;
			$new_result = mysqli_query($database_handler , $sql_query) ;
			$count = 'a' ;
			$name = 'choice_for_question_' . $row['question_number'] ;
			while ($new_row = mysqli_fetch_assoc($new_result)) {
				$string .= '<INPUT type = "radio" name = "' . $name . '" value ="' . $count .'" />' . $new_row['option'] . '<BR /><BR />' ;
				$count ++ ;
			}
		}
		$string .= '<INPUT type = "submit" value = "Submit!!" /><BR /><BR /></FORM>' ;
		echo $string ;
	}
	//checks the answes submitted by the user
	function check_answers($database_handler , $data , $title , $number_of_questions) {
		$sql_query = "SELECT * FROM `quiz` WHERE `title` = '$title'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$event_id = $result['event_id'] ;
		$question_id = array() ;
		$sql_query = "SELECT * FROM `questions` WHERE `event_id` = '$event_id'" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_assoc($result)) {
			$question_id[] = $row['question_id'] ;
		}
		$answer = array() ;
		$count = 1 ;
		while ($count <= $number_of_questions) {
			$id = $question_id[$count - 1] ;
			$sql_query = "SELECT * FROM `answers` WHERE `question_id` = '$id'" ;
			$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
			$answer['choice_for_question_' . $count] = $result['answer_id'] ;
			$count ++ ;
		}
		$sql_query = "SELECT * FROM `quiz` WHERE `title` = '$title'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$correct = $result['correct'] ;
		$wrong = $result['wrong'] ;
		$score = 0 ;
		foreach ($data as $key => $value) {
			if ($value == $answer[$key]) {
				$score += $correct ;
			} elseif ($value != $answer[$key]) {
				$score -= $wrong ;
			} else {
				$score += 0 ;
			}
		}
		return $score ;
	}
	//stores the score of the user in the database
	function store_score($database_handler , $score_data) {
		$field = '`' . implode('` , `' , array_keys($score_data)) . '`' ;
		$data = '\'' . implode('\' , \'' , $score_data) . '\'' ;
		$name = $score_data['user_name'] ;
		$sql_query = "SELECT * FROM `rank` WHERE `user_name` = '$name'" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if ($result == 0) {
			$sql_query = "INSERT INTO `rank` ($field) VALUES ($data)" ;
		} else {
			$score = $score_data['score'] ;
			$date = $score_data['date'] ;
			$sql_query = "UPDATE `rank` SET `score` = $score AND `date` = '$date' WHERE `user_name` = '$name'" ;
		}
		mysqli_query($database_handler , $sql_query) ;
	}
	//gets the score of the current user
	function get_score($database_handler , $user_name) {
		$sql_query = "SELECT * FROM `rank` WHERE `user_name` = '$user_name'" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$number = $result -> num_rows ;
		if ($number == 1) {
			$result = $result -> fetch_assoc() ;
			return $result['score'] ;
		} else {
			return 0 ;
		}
	}
	//displays the quizes
	function display_quizes($database_handler) {
		$count = 1 ;
		$string = '<TABLE class = "table table-striped">
						<TR>
							<TH>S No.</TH>
							<TH>Title</TH>
							<TH>Time Limit</TH>
							<TH>No. of Questions</TH>
							<TH>Status</TH>
						</TR>' ;
		$sql_query = "SELECT * FROM `quiz`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_assoc($result)) {
			$string .= '<TR>
							<TD>' . $count . '</TD>
							<TD>' . $row['title'] . '</TD>
							<TD>' . $row['time'] . ' minutes</TD>
							<TD>' . $row['total'] . '</TD>
							<TD>
								<A href = "login.php?start_quiz=' . $row['event_id'] . '" style = "decoration:none"><IMG src = "../Images/start.png" />
								</A>
							</TD>
						</TR>' ;
			$count ++ ;
		}
		$string .= '</TABLE>' ;
		echo $string ;
	}
	//function to start a particular quiz
	/*function start_quiz($database_handler , $id) {
		$count = 1;
		$sql_query = "SELECT * FROM `questions` WHERE `event_id` = '$id'" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_assoc($result)) {
			$string = '' ;
			$q_id = $row['question_id'] ;
			$sql_query = "SELECT * FROM `options` WHERE `question_id` = '$q_id'" ;
			$options = array() ;
			$data = mysqli_query($database_handler , $sql_query) ;
			while ($set = mysqli_fetch_assoc($data)) {
				
				
			}
			$string .= '<FORM action = "" method = "POST">
							' . $row['question'] . '<BR />
							a). &nbsp;&nbsp;
						</FORM>' ;
			echo $string ;
			$count ++ ;
		}
	}*/
	function start_quiz($database_handler , $id)
	{
		
		$sql_query = "SELECT * FROM `questions` WHERE `event_id` = '$id'" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		$string = '<FORM action = "" method = "POST">' ;
		while ($row = mysqli_fetch_assoc($result))
		{
			$question_id = $row['question_id'] ;
			$string .=
			'</LEFT><BR /><BR />' . $row['question'] . '<BR /><BR />' ;
			$sql_query = "SELECT * FROM `options` WHERE `question_id` = '$question_id'" ;
			$new_result = mysqli_query($database_handler , $sql_query) ;
			$count = 'a' ;
			$name = 'choice_for_question_' . $row['question_id'] ;
			while ($new_row = mysqli_fetch_assoc($new_result))
			{
				$string .= '<INPUT type = "radio" name = "' . $name . '" value ="' . $count .'" />' . $new_row['option'] . '<BR /><BR />' ;
				$count ++ ;
			}
		}
		$string .= '<INPUT type = "submit" value = "Submit!!" /><BR /><BR /></FORM>' ;
		echo $string ;
	}
?>