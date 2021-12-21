<?php
	switch ($req['stage']) {
		case '1':
			if ( isset($_GET['next_stage']) ) {
				### Запрос на создание записи о треках ###
				$songs = $req['answers']['14'];
				if ( is_array($songs) ) {
					foreach ($songs as $key => $name) {
						$name = $DB->es($name);
						$songs[$key] = "(null, '{$req['id']}', '{$name}', 'open', '[]')";
					}
					$songs = implode(', ', $songs);
				} else {
					$songs = $DB->es($songs);
					$songs = "(null, '{$req['id']}', '{$songs}', 'open', '[]')";
				}
				
				$SQL = "INSERT INTO `demo_reqs_songs` (`id`, `req_id`, `name`, `status`, `answers` ) VALUES {$songs};";
				// $C->add($F->preb($SQL), 'main');

				$DB->q($SQL);
				### Запрос на создание записи о треках ###

				$SQL = "UPDATE `demo_reqs` SET `stage_1` = 'ok', `stage_2` = 'open' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);

				telega($req, 'stage_update'); // Отправляем уведомление в телегу

				// $C->add($F->preb($SQL), 'main');
				$F->loc("/req/{$req['id']}");
			}
		break;
		case '2':
			// $req['stage_status'] = 'info';
			if ( $req['stage_status'] == 'open' ) {
				$SQL = "UPDATE `demo_reqs` SET `stage_2` = 'send' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);

				telega($req, 'stage_update'); // Отправляем уведомление в телегу

				$F->loc("/req/{$req['id']}/");
			}
			if ( $req['stage_status'] == 'info' && isset($_GET['reway'])) {
				$answers[16] = '';
				$answers[17] = '';
				$answers = $DB->es(json_encode($answers));
				$SQL = "UPDATE `demo_reqs` SET `answers` = '{$answers}', `stage_2` = 'open' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);
				$F->loc("/req/{$req['id']}/");
			}
			if ( $req['stage_status'] == 'befok' && isset($_GET['next_stage'])) {
				$SQL = "UPDATE `demo_reqs` SET `stage_2` = 'ok', `stage_3` = 'open' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);
				$F->loc("/req/{$req['id']}/");
			}
		break;
		case '3':
			// $req['stage_status'] = 'info';
			if ( $req['stage_status'] == 'open' ) {
				$SQL = "UPDATE `demo_reqs` SET `stage_3` = 'send' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);
				
				telega($req, 'stage_update'); // Отправляем уведомление в телегу

				$F->loc("/req/{$req['id']}/");
			}
			if ( $req['stage_status'] == 'info' && isset($_GET['reway'])) {
				$answers[18] = '';
				$answers = $DB->es(json_encode($answers));
				$SQL = "UPDATE `demo_reqs` SET `answers` = '{$answers}', `stage_3` = 'open' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);
				$F->loc("/req/{$req['id']}/");
			}
			if ( $req['stage_status'] == 'ok') {
				// $SQL = "UPDATE `demo_reqs` SET `stage_3` = 'ok', `stage_3` = 'open' WHERE `id` = '{$req['id']}';";
				// $DB->q($SQL);
				// $F->loc("/req/{$req['id']}/");
			}
		break;
	}
?>