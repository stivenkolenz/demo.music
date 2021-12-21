<?php

$slug[1] = (isset($slug[1]) ? $slug[1] : 'main');

switch ($slug[1]) {
	case 'main':
		// Проверяем есть ли уже в системе активное обращение
		// $res = $DB->qf_assoc("SELECT `id` FROm `requests` WHERE `user_id` = '{$user['id']}' AND `aviable` = 1 ORDER BY `date` DESC;", 1);
		$res = $DB->qf_assoc("SELECT `id` FROm `requests` WHERE `user_id` = '{$user['id']}' ORDER BY `date` DESC;", 1);
		// $F->prec( $res );
		if (isset($res['id'])) {
			// Если есть, то отправляем продолжать прохождение этапов
			$F->loc("/r/{$res['id']}/");
		} else {
			// Если нет, то посылаем на содзание нового
			$F->loc("/r/new/");
		}
		break;

	case 'new':
		// Проверка на наличие заявки с открытым первым этапом
		$SQL = "SELECT `requests`.*, `steps`.`status` AS `step_1` FROM `requests` LEFT JOIN `steps` ON `steps`.`step_id` = '1' AND `steps`.`request_id` = `requests`.`id` WHERE `requests`.`user_id` = '{$user['id']}';";
		$DB->qf_array($SQL);
		if ( !empty($DB->rD()) ) {
			foreach ($DB->rD() as $key => $req) {
				if ( $req['step_1'] == 'open' ) {
					$F->loc("/r/{$req['id']}");
				}
			}
		}
		// Проверка на наличие заявки с открытым первым этапом

		// Создание нового обращения
		$SQL = "INSERT INTO `requests` VALUES ( null, {$user['id']}, NOW(), 1 );";
		$request_id = $DB->q($SQL);

		// Создаем статусы для шагов по этому запросу
		if ( TEST === true ) {
			$SQL = "INSERT INTO `steps` ( `id`, `request_id`, `step_id`, `status` ) VALUES ( null, {$request_id}, 1, 'open' ), ( null, {$request_id}, 2, 'open' ), ( null, {$request_id}, 3, 'open' );";
		} else {
			$SQL = "INSERT INTO `steps` ( `id`, `request_id`, `step_id`, `status` ) VALUES ( null, {$request_id}, 1, 'open' ), ( null, {$request_id}, 2, 'close' ), ( null, {$request_id}, 3, 'close' );";
		}
		$DB->q($SQL);
		$F->loc("/r/{$request_id}/");
		break;

	default:
		// Проверяем доступы к обращению. А-ля защита от дурака.. И запрет доступа к чужим образениям
		$request_id = (int) $slug[1];
		// $res = $DB->qf_assoc("SELECT * FROM `requests` WHERE `id` = '{$request_id}' AND `aviable` = 1;", 1);
		$res = $DB->qf_assoc("SELECT * FROM `requests` WHERE `id` = '{$request_id}';", 1);
		if (!isset($res['user_id']) || $res['user_id'] != $user['id']) {
			// Посылаем нафиг, нет такого запроса вообще или нет доступа к нему. 
			// Ну ты же не админ, что бы получать доступ к чужому запросу..
			$F->loc("/r/", $lang['noacces_r']);
		} else {
			// Ну всё окей, это точно запрос этого пользователя и он есть :)
			// Вытаскиваем статусы текущего запроса
			$SQL = "SELECT * FROM `step_status`;";
			$DB->qf_array($SQL);
			$ss = []; // Все возможные статусы
			foreach ($DB->rD() as $key => $value)
				$ss[$value['status']] = $value['info'];

			$SQL = "SELECT * FROM `steps` WHERE `request_id` = '{$request_id}';";
			$res = $DB->qf_array($SQL, 1);
			$steps = []; // Информация о статусах этапов
			foreach ($res as $key => $value) {
				$steps[$value['step_id']] = [
					'id' => $value['step_id'],
					's' => $value['status'],
					's_info' => $ss[$value['status']],
					'info' => $value['info'],
				];
			}

			$TPL->name('steps_status');
			$TPL->set('STATUS_1', $ss[$steps[1]['s']]);
			$TPL->set('STATUS_2', $ss[$steps[2]['s']]);
			$TPL->set('STATUS_3', $ss[$steps[3]['s']]);
			$TPL->set('STATUS_CSS_1', $steps[1]['s'] . ($slug[3] == '1' && $slug[2] != 'song' ? ' active' : ''));
			$TPL->set('STATUS_CSS_2', $steps[2]['s'] . ($slug[3] == '2' || $slug[2] == 'song' ? ' active' : ''));
			$TPL->set('STATUS_CSS_3', $steps[3]['s'] . ($slug[3] == '3' && $slug[2] != 'song' ? ' active' : ''));
			$TPL->set('INFO_1', $steps[1]['s_info']);
			$TPL->set('INFO_2', $steps[2]['s_info']);
			$TPL->set('INFO_3', $steps[3]['s_info']);
			$TPL->set('REQ_ID', $request_id);
			$C->create('steps_status', $TPL->compile('steps_status'));
			$C->add($C->get('steps_status'), 'main');
			// Вытаскиваем статусы текущего запроса

			switch ($slug[2]) {
				case 'step':
					require_once req('step.php', '/app/modules/');
					break;

				case 'song':
					// 1:25 - начало
					require_once req('edit_song.php', '/app/modules/');
					break;

				case 'message':
					require_once req('message.php', '/app/modules/');
					break;

				case 'download':
					require_once req('contract.php', '/app/modules/');
					break;

				default:
					$C->add('Надо выбрать шаг', 'main');
					// $F->pre( $steps );
					foreach ($steps as $key => $step)
						if ($step['s'] == 'open')
							$F->loc("/r/{$request_id}/step/" . $step['id']);
						elseif ($step['s'] == 'send')
							$F->loc("/r/{$request_id}/message/check/");
						elseif ($step['s'] == 'fail')
							$F->loc("/r/{$request_id}/message/fail/");
						elseif ($step['s'] == 'info')
							$F->loc("/r/{$request_id}/message/info/");
							
						if ( $steps[3]['s'] == 'ok'  )
							$F->loc("/r/{$request_id}/step/3/");
					break;
			}
		}
		break;

		/*     default:
		$F->pre('YOU SHALL NOT PASS');
		http_response_code(404);
		die();
		break; */
}
