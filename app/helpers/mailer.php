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

	static public function sendActivation($username, $address, $token)
	{
		$config = \Theogony\ConfigCore::getInstance();
		return self::send([$address => $address],
			"[{$config->site->title}] Confirm your {$config->site->title} account", 
<<<__HTML__
<html>
	<body>
		<div style='font-family: "LucidaGrande" , "Lucida Sans Unicode", "Lucida Sans", Verdana, Tahoma, sans-serif; margin: 0; padding: 30px 20px; font-size: 13px; line-height: 1; color: #000; background-color: #eee;'>
			<p style='font-weight: bold;'>Hi there!</p>
			<p>We have received a request to active your account <strong>{$username}</strong>. Confirm that you wish to active this account by clicking the link below (or paste it into your browser if that doesn't work). This step is to ensure that your identity is not stolen by others.</p>
			<p><a href='{$config->site->baseurl}account/active/{$token}'>{$config->site->baseurl}account/active/{$token}</a></p>
			<p>If you did not make this request yourself, just ignore this message.</p>
			<p>Have a nice day,<br />{$config->site->title}.</p>
			<p>This e-mail was sent by a user triggered event and thus can't really be unsubscribed from.<br />If you keep getting these message and don't want to, please contact <a href='mailto:kuroba@davy.tw'>customer support</a>.</p>
		</div>
	</body>
</html>
__HTML__
		);
	}
}

?>
