<?php
	### Поиск активной заявки ###
	if ( !isset($slug[1]) || $slug[1] == 'new') {
		$SQL = "SELECT `id` FROM `demo_reqs` WHERE `user_id` = '{$user['id']}' AND `status` = 'active';";
		$DB->qf_assoc($SQL);
		if ( !empty($DB->rD()) ) {
			$F->loc('/req/'.$DB->rD()['id']);
		} else {
			if ( in_array('new', $slug) ) {
				$SQL = "INSERT INTO `demo_reqs` (`id`, `user_id`, `answers` ) VALUES (null, '{$user['id']}', '');";
				$id = $DB->q($SQL);
				$F->loc('/req/'.$id, 'Новая заявка создана');
				die();
			}
			$F->loc('/', 'У вас нет доступа к этой странице');
		}
	}
	### Поиск активной заявки ###

	### Проверка доступа к заявке ###
	$req_id = (int) $slug[1];
	if ( $req_id != $slug[1] ) $F->loc('/req/'.$req_id, 'У вас нет доступа к этой странице');
	if ( $req_id == false ) $F->loc('/', 'У вас нет доступа к этой странице');

	$SQL = "SELECT * FROM `demo_reqs` WHERE `user_id` = '{$user['id']}' AND `id` = '{$req_id}' AND `status` = 'active' OR `user_id` = '{$user['id']}' AND `id` = '{$req_id}' AND `status` = 'finish';";
	$req = $DB->qf_assoc($SQL, 1);
	if ( empty($req) ) $F->loc('/', 'У вас нет доступа к этой странице');
	### Проверка доступа к заявке ###

	### Поиск этапа и проверка доступа ###
	$req['stage'] = 0; // Номер этапа
	if ( !isset($slug[2]) ) { // Переброс на активный этап
		if ( in_array( $req['stage_1'], ['open']) ) $F->loc('/req/'.$req_id.'/stage/1/');
		if ( in_array( $req['stage_2'], ['open', 'send', 'info', 'befok']) ) $F->loc('/req/'.$req_id.'/stage/2/');
		if ( in_array( $req['stage_3'], ['open', 'send', 'info', 'befok', 'ok']) ) $F->loc('/req/'.$req_id.'/stage/3/');
	}

	if ( $slug[2] == 'stage' ) {
		$req['stage'] = (int) $slug[3];
		$req['stage_status'] = $req['stage_'.$req['stage']];
		
		if ( !in_array($req['stage_status'], ['open', 'send', 'info', 'befok']) && $req['stage'] != 3) $F->loc('/req/'.$req_id, 'У вас нет доступа к этому этапу');
		if ( $req['stage'] != $slug[3] ) $F->loc('/req/'.$req_id, 'У вас нет доступа к этой странице');
		if ( $req['stage'] < 1 || $req['stage'] > 3 ) $F->loc('/req/'.$req_id, 'У вас нет доступа к этой странице');
		$req['stage'] = $req['stage'];
	}
	### Поиск этапа и проверка доступа ###

	### Ответы ###
	$req['answers'] = ( empty($req['answers']) ? [] : json_decode($req['answers'], true) );
	### Ответы ###

	### Треки ###
	$req['songs'] = [];
	$SQL = "SELECT * FROM `demo_reqs_songs` WHERE `req_id` = '{$req['id']}';";
	$DB->qf_array($SQL);
	if ( !empty($DB->rD()) ) {
		foreach ($DB->rD() as $key => $song) {
			$song['answers'] = (empty($song['answers']) ? [] : json_decode($song['answers'], true) );
			$req['songs'][$song['id']] = $song;
		}
	}
	### Треки ###

	### База вопросов ###
	$req['questions'] = json_decode(file_get_contents(ROOT.'/app/modules/req/questions.json'), 1);
	### База вопросов ###

	require_once req('func.php', '/app/modules/req/');
	
	$req['song'] = ( $req['stage'] == 2 && isset($slug[4]) && $slug[4] == 'song' && isset($slug[5]) && ((int) $slug[5] == $slug[5]) ? $slug[5] : false);
	if ( $req['song'] && !isset($req['songs'][$req['song']]) ) {
		$F->loc('/req/'.$req_id.'/', 'У тебя нет доступа к этой странице');
	}
	
	$answers = ($req['song'] ? $req['songs'][$req['song']]['answers'] : $req['answers']);
	$req['current_question_id'] = question_id($answers, $req['stage'], $req['song']);
	
	### Разрешаем пользователям заново проходить по всем вопросам трека, после заполнения ###
	if ( is_null($req['current_question_id']) && $req['song'])
		$req['current_question_id'] = 1;
	### Разрешаем пользователям заново проходить по всем вопросам трека, после заполнения ###


	$req['end'] = ( array_reverse($slug)[0] == 'end' ? true : false );

	### Перекидываем пользователя на страницу завершения этапа ###
	if ( !$req['end'] ) {
		if ( is_null($req['current_question_id']) ) {
			$F->loc('/req/'.$req_id.'/stage/'.$req['stage'].'/end/');
		}
	}
	### Перекидываем пользователя на страницу завершения этапа ###
	
	// $save = ( isset($slug[4]) && $slug[4] == 'save' ? true : false );
	$req['save'] = ( array_reverse($slug)[0] == 'save' ? true : false );
	$req['prevq'] = ( array_reverse($slug)[0] == 'prev' ? true : false );
	
	if ( $req['save'] || $req['prevq'] ) {
		require_once req('save.php', '/app/modules/req/');
	}

	### Копирование ответов с трека ###
	if ( $req['song'] && array_reverse($slug)[0] == 'copy' ) {
		if ( $req['songs'][$req['song']]['status'] == 'end' ) {
			$answers[1] = '';
			$answers = $DB->es(json_encode($answers));

			// $SQL = [];
			foreach ($req['songs'] as $key => $song) {
				if ( $song['status'] == 'open' ) {
					$SQL = "UPDATE `demo_reqs_songs` SET `answers` = '{$answers}' WHERE `id` = '{$song['id']}' AND `req_id` = '{$req['id']}';";
					$DB->q($SQL);
				}
			}
			// $SQL = implode(' ', $SQL);
			$DB->q($SQL);
			$F->loc('/req/'.$req_id.'/', 'Ответы были скопированы. Осталось только заполнить поле с текстом песни.');
		} else {
			$F->loc('/req/'.$req_id.'/', 'Что бы скопировать ответы необходимо полностью заполнить трек.');
		}
	}
	### Копирование ответов с трека ###
	
	$question = question( $answers, $req['current_question_id'], $req['answers'][1], $req['song']);

	if ($req['end']) {
		if ( !is_null($req['current_question_id']) ) {
			$F->loc('/req/'.$req_id.'/');
		}

		### Сохранение этапа и переход к следующему ###
		require_once req('next_stage.php', '/app/modules/req/');
		### Сохранение этапа и переход к следующему ###
	}

	$TPL->name('rn');
	$TPL->set('REQ', json_encode($req));
	$TPL->set('REQ_ID', $req['id']);
	$TPL->set('STAGE', $req['stage']);
	$TPL->set_block('NOT-END', !$req['end']);
	$TPL->set('QUESTION', $question['code']);
	$TPL->set_block('END', $req['end']);
	$TPL->set_block_e('STAGE', $req['stage']);
	$TPL->set_block_e('STAGE_STATUS', $req['stage_status']);
	
	$TPL->set_block('IS_SONG', $req['song']);
	$TPL->set('SONG_NAME', $req['songs'][$req['song']]['name']);
	
	$TPL->set('REQ_INFO', $req['info']);
	$TPL->set_block('NOT_EMAIL', empty($user['email']));
	$TPL->set('DOC_LINK', $req['doc_link']);
	
	$TPL->set('QUESTION_ID', $req['current_question_id']);
	$C->add($TPL->compile('rn'), 'main');
