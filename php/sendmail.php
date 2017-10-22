<?php
	if (isset($_GET['callback'])) {
		header("Content-Type: application/json");
		if (isset($_POST['fromEmail']) && isset($_POST['toEmail']) && isset($_POST['subject'])) {
			$emailTo = clean_input($_POST['toEmail']);
			$emailFrom = clean_input($_POST['fromEmail']);
			$subject = clean_input($_POST['subject']);
			$body = clean_input($_POST['message']);
			$headers = "From: ".$emailFrom."\r\n".'Reply-to: '.$emailFrom."\r\n".'X-mailer: PHP/'.phpversion();
			
			if (mail($emailTo, $subject, $body, $headers)) {
				$result = array('success' => true);
			} else {
				$result = array('success' => false, 'errmsg' => "Email failed to send, please try again later.");
			}
			
		} else {
			$result = array('success' => false, 'errmsg' => "Must have From, To and Subject to send Email");
		}
		echo $_GET['callback']."(".json_encode($result).")";
	}

	function clean_input($data)
	{
		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
?>
