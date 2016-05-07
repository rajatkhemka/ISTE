<?php
	//checks for the existence of admin
	function admin_exists($database_handler , $admin_name) {
		$sql_query = "SELECT * FROM `admin` WHERE `admin_name` = '$admin_name'" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if($result == 1) {
			return true ;
		} else {
			return false ;
		}
	}
	//checks if the particular admin is active
	function admin_active($database_handler , $admin_name) {
		$sql_query = "SELECT * FROM `admin` WHERE `admin_name` = '$admin_name' AND `admin_active_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if($result == 1) {
			return true ;
		} else {
			return false ;
		}
	}
	//logs in the admin if the credentials match
	function login_admin($database_handler , $admin_name , $admin_email , $admin_number , $admin_password) {
		$sql_query = "SELECT * FROM `admin` WHERE `admin_name` = '$admin_name' AND `admin_email` = '$admin_email' AND `admin_mobile` = $admin_number AND `admin_password` = '$admin_password' AND `admin_active_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) -> num_rows ;
		if ($result == 1) {
			$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
			return $result['admin_id'] ;
		} else {
			return false ;
		}
	}
	//gives the entire data of the admin
	function admin_data($database_handler , $id) {
		$sql_query = "SELECT * FROM `admin` WHERE `admin_id` = $id" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		return $result ;
	}
	//sends mail to every user on the database
	function mail_users($database_handler , $subject , $body) {
		$body .= "\n\n-admin@iste.org" ;
		$sql_query = "SELECT * FROM `user` WHERE `user_mail_letter_status` = 1" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while(($row = mysqli_fetch_array($result))) {
			$to = $row['user_email'] ;
			send_email($to , $subject , $body) ;
		}
	}
	//adds a quiz in the database
	function add_quiz($database_handler , $quiz_details) {
		$field = '`' . implode('` , `' , array_keys($quiz_details)) . '`' ;
		$data = '\'' . implode('\' , \'' , $quiz_details) . '\'' ;
		$sql_query = "INSERT INTO `quiz` ($field) VALUES ($data)" ;
		$result = mysqli_query($database_handler , $sql_query) ;
	}
	//removes the quiz from the database
	function remove_quiz($database_handler , $title) {
		$event_id = substr(md5($title) , 0 , 10) ;
		$sql_query = "SELECT * FROM `questions` WHERE `event_id` = '$event_id'" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_assoc($result)) {
			$question_id = $row['question_id'] ;
			$sql_query = "DELETE FROM `answers` WHERE `question_id` = '$question_id'" ;
			mysqli_query($database_handler , $sql_query) ;
			$sql_query = "DELETE FROM `options` WHERE `question_id` = '$question_id'" ;
			mysqli_query($database_handler , $sql_query) ;
		}
		$sql_query = "DELETE FROM `questions` WHERE `event_id` = '$event_id'" ;
		mysqli_query($database_handler , $sql_query) ;
		$sql_query = "DELETE FROM `quiz` WHERE `title` = '$title'" ;
		mysqli_query($database_handler , $sql_query) ;
	}
	//gets password of the admin logged in
	function get_admin_password($database_handler , $email) {
		$sql_query = "SELECT * FROM `admin` WHERE `admin_email` = '$email'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$password = $result['admin_password'] ;
		return $password ;
	}
	//removes the user by admin
	function deactivate_user($database_handler , $user_name) {
		$sql_query = "UPDATE `user` SET `user_active_status` = 0 WHERE `user_name` = '$user_name'" ;
		mysqli_query($database_handler , $sql_query) ;
	}
	//gets the quiz details for the user
	function get_quiz_details($database_handler) {
		$count = 1 ;
		$sql_query = "SELECT * FROM `quiz`" ;
		$result = mysqli_query($database_handler , $sql_query) ;
		while ($row = mysqli_fetch_array($result)) {
			$title = $row['title'] ;
			$string =
			'<TR>
				<TD>' . $count . '</TD>
				<TD>' . $title . '</TD>
				<TD>' . $row['total'] . '</TD>
				<TD>' . $row['total'] * $row['correct'] . '</TD>
				<TD>' . $row['time'] . '</TD>
				<TD>
					<A href = "start_quiz.php?title=' . $title . '">Start</A>
				</TD>
			</TR>' ;
			echo $string ;
			$count ++ ;
		}
	}
	//gets the number of questins for a quiz
	function get_no_of_questions($database_handler , $title) {
		$sql_query = "SELECT * FROM `quiz` WHERE `title` = '$title'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		$count = $result['total'] ;
		return $count ;
	}
	//gets the event id for the quiz
	function get_event_id_from_title($database_handler , $title) {
		$sql_query = "SELECT * FROM `quiz` WHERE `title` = '$title'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		return $result['event_id'] ;
	}
	//gets questions from the POST array
	function get_questions($data , $array_length) {
		array_walk($data , 'secure_array') ;
		$count = 1 ;
		$output = array() ;
		while ($count <= $array_length / 6) {
			$output[] = $data['question' . $count] ;
			$count ++ ;
		}
		return $output ;
	}
	//unsets the questions from the POST array
	function unset_questions($new_data , $array_length) {
		$count1 = 1 ;
		$count2 = 1 ;
		while ($count1 <= $array_length) {
			unset($new_data['question' . $count2]) ;
			if ($count1 % 6 == 1) {
				$count2 ++ ;
			}
			$count1 += 6 ;
		}
		return $new_data ;
	}
	//unsets correct answer from the POST array
	function unset_correct_answers($new_data) {
		$count1 = 0 ;
		$count2 = 1 ;
		foreach ($new_data as $key => $value) {
			if ($count1 % 5 == 0) {
				unset($new_data['correct_answer_for_' . $count2]) ;
				$count2 ++ ;
			}
			$count1 ++ ;
		}
		return $new_data ;
	}
	//gets options from the POST array
	function get_options($data , $array_length) {
		array_walk($data , 'secure_array') ;
		$new_data = $data ;
		$new_data = unset_questions($new_data , $array_length) ;
		$new_data = unset_correct_answers($new_data) ;
		return $new_data ;
	}
	//gets answer from the POST array
	function get_answers($data , $array_length) {
		array_walk($data , 'secure_array') ;
		$new_data = $data ;
		$output = array() ;
		$count = 0 ;
		foreach ($new_data as $key => $value) {
			if (($count + 1) % 6 == 0) {
				$output[] = $value ;
			}
			$count ++ ;
		}
		return $output ;
	}
	//adds questions to the quiz
	function add_questions($database_handler , $questions , $id ,$number_of_questions) {
		array_walk($questions , 'secure_array') ;
		$count = 0 ;
		while ($count < $number_of_questions) {
			$question_id = substr(md5($questions[$count]) , 0 , 10) ;
			$fields = array('event_id' , 'question_id' , 'question') ;
			$field = '`' . implode('` , `' , $fields) . '`' ;
			$question = $questions[$count] ;
			$values = array($id , $question_id , $question) ;
			$value = '\'' . implode('\' , \'' , $values) . '\'' ;
			$sql_query = "INSERT INTO `questions` ($field) VALUES ($value)" ;
			mysqli_query($database_handler , $sql_query) ;
			$count ++ ;
		}
	}
	//adds options of the question to the database
	function add_options($database_handler , $limit , $options , $questions) {
		$i = 0 ;
		$j = 0 ;
		while ($i < sizeof($options)) {
			$question_id = substr(md5($questions[$j]) , 0 , 10) ;
			if ($i % 4 === 3) {
				$j ++ ;
			}
			$opt = $options[$i] ;
			$option_id = substr(md5($opt) , 0 , 10) ;
			$sql_query = "INSERT INTO `options` VALUES ('$question_id' , '$opt' , '$option_id')" ;
			mysqli_query($database_handler , $sql_query) ;
			$i ++ ;
		}
	}
	//adds answers of the questions to the database
	function add_answer($database_handler , $answers , $questions , $limit) {
		for($count = 0 ; $count < $limit ; $count ++) {
			$question_id = substr(md5($questions[$count]) , 0 , 10) ;
			$answer = $answers[$count] ;
			$sql_query = "SELECT * FROM `options` WHERE `option` = '$answer'" ;
			$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
			$answer_id = $result['option_id'] ;
			$sql_query = "INSERT INTO `answers` VALUES ('$question_id' , '$answer_id')" ;
			mysqli_query($database_handler , $sql_query) ;
		}
	}
	//gets the number of questions in a quiz
	function get_number_of_questions($database_handler , $quiz_id) {
		$sql_query = "SELECT * FROM `quiz` WHERE `event_id` = '$quiz_id'" ;
		$result = mysqli_query($database_handler , $sql_query) -> fetch_assoc() ;
		return $result['total'] ;
	}
?>