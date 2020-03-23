<?php
if($_POST)
{
//require('constant.php');
    
    $user_name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $user_email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $user_phone     = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $content   = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
    
    if(empty($user_name)) {
		$empty[] = "<b>Name</b>";		
	}
	if(empty($user_email)) {
		$empty[] = "<b>Email</b>";
	}
	if(empty($user_phone)) {
		$empty[] = "<b>Phone Number</b>";
	}
	if(empty($content)) {
		$empty[] = "<b>Message</b>";
	}	
	
	if(!empty($empty)) {
		$output = json_encode(array('type'=>'error', 'text' => implode(", ",$empty) . ' Required!'));
        die($output);
	}
	
	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
	    $output = json_encode(array('type'=>'error', 'text' => '<b>'.$user_email.'</b> is an invalid Email, please correct it.'));
		die($output);
	}
	
	//reCAPTCHA validation
	/*if (isset($_POST['g-recaptcha-response'])) {
		
		require('component/recaptcha/src/autoload.php');		
		
		$recaptcha = new \ReCaptcha\ReCaptcha(SECRET_KEY, new \ReCaptcha\RequestMethod\SocketPost());

		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		  if (!$resp->isSuccess()) {
				$output = json_encode(array('type'=>'error', 'text' => '<b>Captcha</b> Validation Required!'));
				die($output);				
		  }	
	}*/
	
//	$to = "marketing@greenfieldps.com";
	$to = "ejazz.rubz@gmail.com";
$subject = " JL ASIA ";

$message = "
<html>
<head>
<title> JL ASIA </title>
</head>
<body>
<table border='1' cellpading='0' cellspacing='0'>
<tr>
<th style='padding:5px;'>Name</th>
<th style='padding:5px;'>Email</th>
<th style='padding:5px;'>Phone</th>
<th style='padding:5px;'>Message</th>
</tr>
<tr>
<td style='padding:5px;'>".$user_name."</td>
<td style='padding:5px;'>".$user_email."</td>
<td style='padding:5px;'>".$user_phone."</td>
<td style='padding:5px;'>".$content."</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <test@meemwebhub.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";


	//$toEmail = "member@testdomain.com";
//	$toEmail = "ejazz.rubz@gmail.com";
	//$mailHeaders = "From: " . $user_name . "<" . $user_email . ">\r\n";
	if (mail($to,$subject,$message,$headers)) {
	    $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_name .', Thanks. We will get back to you shortly.'));
	    die($output);
	} else {
	    $output = json_encode(array('type'=>'error', 'text' => 'Unable to send email, please contact'.SENDER_EMAIL));
	    die($output);
	}
}
?>