<?php

class MailHelper {
	static public function send($addresses, $subject, $body)
	{
		$mail= new Theogony\Helper\PHPMailer\Core();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->CharSet = "utf-8";
		
		$mail->Username = "kuroba@davy.tw";
		$mail->Password = "kuro-ba-";
		
		$mail->From = "kuroba@davy.tw";
		$mail->FromName = "Kurōbā Admin";
		
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->IsHTML(true);
		foreach ($addresses as $k => $v)
			$mail->AddAddress($k, $v);
		$mail->AddBCC("s50407s@gmail.com");
		
		return $mail->Send();
	}
}

?>
