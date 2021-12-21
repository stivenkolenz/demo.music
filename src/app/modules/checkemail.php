<?php

	if (!$logged) $F->loc('/', 'У вас нет доступа к этой странице. Авторизируйтесь и попробуйте снова.');

	if ( isset($slug[1]) ) {
		$SQL = "SELECT * FROM `checkemail` WHERE `user_id` = '{$user['id']}' AND `active` = 1";
		$DB->qf_array($SQL);
		if ( empty($DB->rD()) ) {
			$F->loc('/', 'У вас нет доступа к этой странице.');
		} else {
			$rec = false;
			foreach ($DB->rD() as $key => $r) {
				if ( $r['hash'] == $slug[1] ) {
					$rec = $r;
				}
			}
			if (!$rec) {
				$F->loc('/', 'У вас нет доступа к этой странице.');
			} else {
				$email2 = $DB->es($rec['new']);
				$SQL = "SELECT * FROM `users` WHERE `email` = '{$email2}' AND `id` != '{$user['id']}';";
				$DB->qf_array($SQL);
				if (!empty($DB->rD())) {
					$SQL = "UPDATE `checkemail` SET `active` = 0, `ip` = '{$ip}' WHERE `id` = '{$rec['id']}';";
					$DB->q($SQL);
					$F->loc('/', 'Вы не можете сменить текущий почтовый ящик на этот.');
				} else {
					$ip = $F->getIP();
					$SQL = "UPDATE `checkemail` SET `active` = 0, `ip` = '{$ip}' WHERE `id` = '{$rec['id']}';";
					$DB->q($SQL);

					$SQL = "UPDATE `users` SET `email` = '{$rec['new']}' WHERE `id` = '{$rec['user_id']}';";
					$DB->q($SQL);

					if (empty($rec['old']))
						$F->loc('/', "Почтовый ящик {$rec['new']} подтвержден");
					else
						$F->loc('/', "Почтовый ящик аккаунта был изменен с {$rec['old']} на {$rec['new']}");
				}
			}
		}
		// $F->prec($slug[1]);
	} else {
		$F->loc('/', 'У вас нет доступа к этой странице.');
	}
?>