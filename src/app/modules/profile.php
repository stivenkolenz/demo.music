<?php
	if(!$logged) $F->loc('/', 'У тебя нет доступа к этой странице');

	if (isset($_POST['email'])) {
		$hash = md5(microtime(1).'-'.$user['id'].'-'.$user['email']);
		$new_email = $DB->es($_POST['email']);
		$email = $DB->es($user['email']);
		$SQL = "INSERT INTO `checkemail` VALUES (null, '{$user['id']}', NOW(), 1, '{$email}', '{$new_email}', null, '{$hash}');";
		$DB->q($SQL);
		if ( empty($user['email']) ) {
			$F->send_check_email($hash, $new_email, 'check', ['new'=> $new_email]);
			$F->loc('/p/', 'На вашу почту было отправлено уведомление со ссылкой для подтверждения почты.');
		} else {
			$F->send_check_email($hash, $user['email'], 'change', ['new'=> $email]);
			$F->loc('/p/', 'На вашу почту было отправлено уведомление со ссылкой для подтверждения смены почты.');
		}
	}

	$SQL = "SELECT * FROM `requests` WHERE `user_id` = '{$user['id']}';";
	$DB->qf_array($SQL);
	$reqs = [];
	$C->create('reqs');
	if( !empty($DB->rD()) ) {
		$have_open = false;
		$WHERE = [];
		foreach ($DB->rD() as $key => $r) {
			$reqs[$r['id']] = $r;
			$WHERE[] = "`request_id` = '{$r['id']}'";
		}
		$WHERE = implode(' OR ', $WHERE);
		// $C->add($F->preb($WHERE), 'main');

		$SQL = "SELECT * FROM `steps` WHERE {$WHERE};";
		$DB->qf_array($SQL);
		$WHERE = [];
		foreach ($DB->rD() as $key => $s) {
			$reqs[$s['request_id']]['steps'][$s['step_id']] = $s['status'];
			if ( $s['step_id'] == 1 && !in_array($s['status'], ['close', 'open'])) {
				$WHERE[] = "`request_id` = '{$s['request_id']}' AND `field` = 'nickname'";
			}
			if ( $s['step_id'] == '1' && $s['status'] == 'open' ) {
				$have_open = true;
			}
		}
		if ( !empty($WHERE) ) {
			$WHERE = implode(' OR ', $WHERE);
			$SQL = "SELECT `value`, `request_id` FROM `values` WHERE {$WHERE};";
			$DB->qf_array($SQL);
			// $F->prec($DB->rD());
			foreach ($DB->rD() as $key => $n) {
				$reqs[$n['request_id']]['nick'] = $n['value'];
			}
		}
		
		foreach ($reqs as $key => $r) {
			$date = new DateTime($r['date']);

			$TPL->name('profile_req');
			$TPL->set('ID', $r['id']);
			$TPL->set('DATE', $date->format('d.m.Y'));
			$TPL->set('NICK', $r['nick']);
			$TPL->set('STEP_1', $r['steps'][1]);
			$TPL->set('STEP_2', $r['steps'][2]);
			$TPL->set('STEP_3', $r['steps'][3]);
			$C->add($TPL->compile('profile_req'), 'reqs');
		}
	} else {
		// $C->add('<tr><td colspan="5" class="tac info">У вас нет заявок</td></tr>', 'reqs');
	}


	### Заявки нового типа ###
	$SQL = "SELECT * FROM `demo_reqs` WHERE `user_id` = '{$user['id']}';";
	$DB->qf_array($SQL);
	$new_reqs = [];
	$C->create('new_reqs');
	if( !empty($DB->rD()) ) {
		$have_open = false;
		
		foreach ($DB->rD() as $key => $r) {
			$date = new DateTime($r['date']);

			if ( in_array($r['stage_1'], ['open']) || in_array($r['stage_2'], ['open']) || in_array($r['stage_3'], ['open']) ) {
				$have_open = true;
			}
			$TPL->name('profile_new_req');
			$TPL->set('ID', $r['id']);
			$TPL->set('DATE', $date->format('d.m.Y'));
			$TPL->set('NICK', $r['nickname']);
			$TPL->set('STEP_1', $r['stage_1']);
			$TPL->set('STEP_2', $r['stage_2']);
			$TPL->set('STEP_3', $r['stage_3']);
			$C->add($TPL->compile('profile_new_req'), 'new_reqs');
		}
	} else {
		$C->add('<tr><td colspan="5" class="tac info">У вас нет заявок нового типа</td></tr>', 'reqs');
	}
	### Заявки нового типа ###



	// $C->add($F->preb($reqs), 'main');
	// $C->add($F->preb($user), 'main');
	// $F->prec($slug);
	// $F->prec($user);

	$date = new DateTime($user['reg_date']);

	$TPL->name('profile');
	$TPL->set('VK', $user['vk_id']);
	$TPL->set('NAME', $user['vk_data']['first_name'] . ' ' . $user['vk_data']['last_name'] );
	$TPL->set('AVATAR', $user['vk_data']['photo_max'] );
	$TPL->set('REG', $date->format('d.m.Y') );
	$TPL->set_block('HAVE_OPEN', !$have_open );
	$TPL->set('EMAIL', $user['email'] );
	$TPL->set('REQS', $C->get('reqs').$C->get('new_reqs') );
	// $TPL->set('REQS', $F->preb($reqs) );
	$TPL->set_block('CHECKEMAIL', $user['checkemail'] );
	
	if ( $slug[1] == 'email') {
		$TPL->set_block('SET_EMAIL', 0 );
		$TPL->set_block('NOTSET_EMAIL', 1 );
	} else {
		$TPL->set_block('SET_EMAIL', !empty($user['email']) );
		$TPL->set_block('NOTSET_EMAIL', empty($user['email']) );
	}


	$C->add($TPL->compile('profile'),'main');

?>