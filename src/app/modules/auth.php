<?php

// use classes\Auth;

if ($logged) {
	$SMSG->add( $lang['noacces'] );
	$F->loc('/');
} else {
	if ($slug[1] == 'email') {
		$F->prec($_POST); 

		$email = $DB->es($_POST['email']);
		$pass = $DB->es($_POST['pass']);

		$SQL = "SELECT * FROM `users` WHERE `email` = '{$email}' AND `password` = '{$pass}' AND `password` IS NOT NULL;";
		$DB->qf_assoc($SQL);
		$F->prec($DB->rD());
		if(empty($DB->rD())) {
			// Пара логин-пароль не найдена
			$F->loc('/', 'Пара логин/пароль не найдена');
		} else {
			$res = $DB->rD();
			$F->set_cookie("auth_pass", md5($pass), 31);
			$F->set_cookie("auth_id", $res['id'], 31);
			$F->loc("/");
		}
	} else {
		require_once req('auth');

		$Auth = new Auth($config->vk['client_id'], $config->vk['client_secret']);
		if (!isset($_GET['code']) && !isset($_GET['state'])) {
			$Auth->go();
		} else {
			$login = $Auth->get_data($_GET['code']);

			$res = $DB->qf_assoc("SELECT * FROM `users` WHERE `vk_id` = '{$login['id']}';", 1);
			$vk_code = $DB->es($_GET['code']);
			$auth_ip = $DB->es($_GET['state']);
			if (isset($res['id'])) {
				$DB->q("UPDATE `users` SET `vk_code` = '{$vk_code}', `auth_ip` = '{$auth_ip}' WHERE `id` = '{$res['id']}';");
			} else {
				$ip = $F->getIP();
				$vk_data = $DB->es( json_encode($login) );
				$res['id'] = $DB->q("INSERT INTO `users` VALUES ( null, '{$login['id']}', NOW(), '{$ip}', '{$vk_data}', '{$vk_code}', '{$auth_ip}', null, null );");
			}
			$auth_key = md5($vk_code . $auth_ip);

			$F->set_cookie("auth_key", $auth_key, 31);
			$F->set_cookie("auth_id", $res['id'], 31);
			$F->loc("/");
		}
	}
}
