<?php

if (!$logged) {
	$F->loc("/", 'У вас нет доступа к этой странице');
	// $SMSG->add('У вас нет доступа к этой странице');
	// header('Location: /');
} else {

	$show_start = true;
	$show_request = false;
	$show_step = [
		'1' => false,
		'2' => false,
		'3' => false,
	];
	$step_form = false;
	$step_info = '';

	if (isset($slug[1]) && $slug[1] == 'new') {
		// Регисрируем в системе новое образение на отправку дэмки

		// Проверяем есть ли уже в системе обращения
		$res = $DB->qf_assoc("SELECT `id` FROm `requests` WHERE `user_id` = '{$user['id']}' ORDER BY `date` DESC;", 1);
		if (isset($res['id'])) {
			// Если есть, то отправляем продолжать прохождение этапов
			$F->loc("/demo/{$res['id']}/");
		} else {
			// Если нет, то регистрируем новое обращение и переходим к работе с ним.
			$SQL = "INSERT INTO `requests` VALUES ( null, {$user['id']}, NOW() );";
			$request_id = $DB->q($SQL);

			// Создаем статусы для шагов по этому запросу
			$SQL = "INSERT INTO `steps` ( `id`, `request_id`, `step_id`, `status` ) VALUES ( null, {$request_id}, 1, 'open' ), ( null, {$request_id}, 2, 'close' ), ( null, {$request_id}, 3, 'close' );";
			$DB->q($SQL);

			$F->loc("/demo/{$request_id}/step/1/");
		}
	} elseif (isset($slug[1])) {
		$request_id = (int) $slug[1];
		$res = $DB->qf_assoc("SELECT * FROM `requests` WHERE `id` = '{$request_id}';", 1); // Проверяем доступы к обращению. А-ля защита от дурака..
		if (!isset($res['user_id']) || $res['user_id'] != $user['id']) {
			// Посылаем нафиг, нет такого запроса вообще или нет доступа к нему. 
			// Ну ты же не админ, что бы получать доступ к чужому запросу..
			$F->loc("/demo/", 'У вас нет доступа к этой странице');
		} else {
			// Ну всё окей, это точно запрос этого пользователя и он есть :)
			$SQL = "SELECT * FROM `steps` WHERE `request_id` = '{$request_id}';";
			$res = $DB->qf_array($SQL, 1);
			$steps = []; // Информация о статусах шагов
			foreach ($res as $key => $value) {
				$steps[$value['step_id']] = ['status' => $value['status'], 'info' => $value['info']];
			}

			$step_status = [
				'open' => 'Этот этап сейчас доступен для заполнения, отправьте нам все необходимые данные для продолжения работы.',
				'close' => 'Этот этап пока не доступен для заполнения. Нужно разобраться с предыдущим этапом :) ',
				'send' => 'Данные с этого этапа уже отправлены, мы уже их проверяем и скоро откроем доступ к следующему этапу.',
				'info' => 'Данные отправлены и проверены, но по ним есть вопросы.',
				'ok' => 'Этот этап уже пройден! Поздравляем! :)',
				'fail' => 'Что-то пошло не так, мы отклонили Вашу работу.',
			];

			$TPL->name('steps_status');
			$TPL->set('STATUS_1', $step_status[$steps[1]['status']]);
			$TPL->set('STATUS_2', $step_status[$steps[2]['status']]);
			$TPL->set('STATUS_3', $step_status[$steps[3]['status']]);
			$TPL->set('STATUS_CSS_1', $steps[1]['status']);
			$TPL->set('STATUS_CSS_2', $steps[2]['status']);
			$TPL->set('STATUS_CSS_3', $steps[3]['status']);
			$TPL->set('INFO_1', $steps[1]['info']);
			$TPL->set('INFO_2', $steps[2]['info']);
			$TPL->set('INFO_3', $steps[3]['info']);
			$TPL->set('REQ_ID', $request_id);
			$steps_status = $TPL->compile('steps_status');

			if (isset($slug[2]) && $slug[2] == 'message') {
				if (!isset($slug[3]) || !isset($_SERVER['HTTP_REFERER'])) {
					$F->loc('/demo/{$request_id}/', 'У вас нет доступа к этой странице');
				}
				$r_slug = $F->get_slug( $_SERVER['HTTP_REFERER'] );
				if ( $r_slug[2] == 'step' & isset($r_slug[3]) && ((int) $r_slug[3]) > 0 && ((int) $r_slug[3]) < 4 ) {
					$step_id = $r_slug[3];
					$info = $slug[3];
					$step_info = "Сообщение {$step_id} {$info}";
					$F->prec( $step_info );
				} else {
					$F->loc('/demo/{$request_id}/', 'У вас нет доступа к этой странице');
				}
				
			} elseif (isset($slug[2]) && $slug[2] != 'step') {
				$F->loc("/demo/{$request_id}/", 'У вас нет доступа к этой странице');
			} else {
				if ((isset($slug[3]) && ((int) $slug[3]) < 1 || ((int) $slug[3]) > 3)) {
					$F->loc("/demo/{$request_id}/", 'У вас нет доступа к этой странице');
				} elseif (isset($slug[2]) && !isset($slug[3])) {
					$F->loc("/demo/{$request_id}/", 'У вас нет доступа к этой странице');
				} elseif (isset($slug[3])) {
					$step_id = $slug[3];
					$show_request = true;

					if ($step_id == '1' && isset($_POST['age']) && isset($_POST['albumortrack']) && isset($_POST['city']) && isset($_POST['demo_link']) && isset($_POST['finishwork']) && isset($_POST['genres']) && isset($_POST['nickname']) && isset($_POST['otherinfo']) && isset($_POST['socnetwork'])) {
						if ($steps[$step_id]['status'] != 'open') {
							$F->loc("/demo/{$request_id}/", 'Хм, кажется ты уже закончил работу с этим этапом');
						} else {
							// $F->prec( 'Сохраняем первый этап' );
							$age = $DB->es($_POST['age']);
							$albumortrack = $DB->es($_POST['albumortrack']);
							$city = $DB->es($_POST['city']);
							$demo_link = $DB->es($_POST['demo_link']);
							$finishwork = $DB->es($_POST['finishwork']);
							$genres = $DB->es($_POST['genres']);
							$nickname = $DB->es($_POST['nickname']);
							$otherinfo = $DB->es($_POST['otherinfo']);
							$socnetwork = $DB->es($_POST['socnetwork']);

							$SQL = "INSERT INTO `values` ( `id`, `field`, `value`, `request_id`, `step_id` ) VALUES ( null, 'age', '{$age}', '{$request_id}', '1' ), ( null, 'albumortrack', '{$albumortrack}', '{$request_id}', '1' ), ( null, 'city', '{$city}', '{$request_id}', '1' ), ( null, 'demo_link', '{$demo_link}', '{$request_id}', '1' ), ( null, 'finishwork', '{$finishwork}', '{$request_id}', '1' ), ( null, 'genres', '{$genres}', '{$request_id}', '1' ), ( null, 'nickname', '{$nickname}', '{$request_id}', '1' ), ( null, 'otherinfo', '{$otherinfo}', '{$request_id}', '1' ), ( null, 'socnetwork', '{$socnetwork}', '{$request_id}', '1' );";
							// $DB->q( $SQL ); // Сохраняем данные полей в базу

							$SQL = "UPDATE `steps` SET `status` = 'send' WHERE `request_id` = '{$request_id}' AND `step_id` = '1';";

							$F->loc("/demo/{$request_id}/message/send/", 'Отлично, данные успешно отправлены!');
						}
					}


					if ($steps[$step_id]['status'] != 'close') {
						$show_step[$step_id] = true;
						$TPL->name('demo_step' . $step_id);
						$step_form = $TPL->compile('demo_step' . $step_id);
					} else {
						$F->loc("/demo/{$request_id}/message/", 'Этот этап еще не доступен вам :)');
					}
				}
			}
		}
	} elseif (!isset($slug[1])) {

		$start = (isset($slug[1]) ? false : true);
		$step_1 = (isset($slug[2]) && $slug[2] == '1'  ? true : false);
		$step_2 = (isset($slug[2]) && $slug[2] == '2'  ? true : false);
		$step_3 = (isset($slug[2]) && $slug[2] == '3'  ? true : false);
	}

	$TPL->name('demo');
	$TPL->set_block('START', $show_start);
	$TPL->set_block('REQUEST', $show_request);
	$TPL->set('STEP_INFO', $step_info);
	$TPL->set('STEPS_STATUS', $steps_status);
	$TPL->set_block('STEP_1', $show_step[1]);
	$TPL->set_block('STEP_2', $show_step[2]);
	$TPL->set_block('STEP_3', $show_step[3]);
	$TPL->set('STEP_FORM', $step_form);

	$CONTENT .= $TPL->compile('demo');
	// $F->prec( $user, '$user' );

}
