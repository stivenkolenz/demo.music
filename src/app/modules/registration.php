<?php

	if ($logged) {
		$F->loc('/', 'У вас нет доступа к этой странице');
	}

	if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
		$email = $DB->es($_POST['email']);
		$pass = $DB->es($_POST['pass']);

		$SQL = "SELECT * FROM `users` WHERE `email` = '{$email}';";
		$DB->qf_assoc($SQL);
		if ( !empty($DB->rD()) ) {
			$F->loc('/reg/', "Почтовый ящик {$email} уже используется. Используйте другой почтовый ящик.");
		} else {
			$ip = $F->getIP();
			$SQL = "INSERT INTO `users` VALUES ( null, null, NOW(), '{$ip}', null, null, '{$ip}', '{$email}', '{$pass}' );";
			$id = $DB->q($SQL);
			$auth_pass = md5($pass);

			$str = microtime(1).'-'.$id.'-'.$email;
			$hash = md5($str);
			$SQL = "INSERT INTO `checkemail` VALUES (null, '{$id}', NOW(), 1, null, '{$email}', null, '{$hash}');";
			$DB->q($SQL);

			$F->send_check_email($hash, $email, 'check');

			$F->set_cookie("auth_pass", $auth_pass, 31);
			$F->set_cookie("auth_id", $id, 31);
			$F->loc("/", 'Вы успешно зарегистрировались на сайте.');
		}
	}

	$TPL->name('registration');
	$C->add($TPL->compile('registration'), 'main');

	// echo "123";

?>