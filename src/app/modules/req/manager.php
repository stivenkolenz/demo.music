<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if ( in_array('questions', $slug) ) {
		$F->pre(json_decode(file_get_contents(ROOT.'/app/modules/req/questions.json'), 1));
		die();
	}

	function su() {
		global $user;
		$SUPER_ADMINS = [1, 48, 31, 25, 27, 26];
		return in_array($user['id'], $SUPER_ADMINS);
	}
	$C->create('su');
	require_once req('func.php', '/app/modules/req/');

	// $slug[1] = ( isset($slug[1]) ? $slug[1] : 'main' );
	$show_search = true;
	$show_lastrates = true;
	// $req_rate = false;
	$Title = false;
	$is_req = false;
	$reqs = ["active" => [], "new" => [], "archive" => [], "cancel" => [], "delete" => []];
	$REQUESTS = false;

	switch ($slug[1]) {
		case 'req': // конкретная заявка
			$req_id = (int) $slug[2];
			$show_search = false;
			$req_rate = true;
			$SQL = "SELECT *, ( SELECT `email` FROM `users` WHERE `users`.`id` = `demo_reqs`.`user_id` ) AS `email`, ( SELECT `vk_data` FROM `users` WHERE `users`.`id` = `demo_reqs`.`user_id` ) AS `vk`, ( SELECT `rate` FROM `demo_reqs_rates` WHERE `demo_reqs_rates`.`req_id` = `demo_reqs`.`id` AND `demo_reqs_rates`.`user_id` = '{$user['id']}' ) AS `rate`, (SELECT avg(rate) FROM `demo_reqs_rates` WHERE `demo_reqs_rates`.`req_id` = `demo_reqs`.`id`) AS `rate_avg` FROM `demo_reqs` WHERE `id` = '{$req_id}';";
			// $SQL = "SELECT * FROM `demo_reqs` WHERE `id` = '{$req_id}';";
			$req = $DB->qf_assoc($SQL, 1);
			if (empty($req)) $F->loc('/su/', 'Нет такой заявки');
			$req['answers'] = json_decode($req['answers'], 1);
			$req['vk'] = json_decode($req['vk'], 1);

			if ( $req['stage_2'] != 'open' ) {
				$SQL = "SELECT * FROM `demo_reqs_songs` WHERE `req_id` = '{$req['id']}';";
				$DB->qf_array($SQL);
				foreach ($DB->rD() as $key => $song) {
					$song['answers'] = json_decode($song['answers'], 1);
					$req['songs'][$song['id']] = $song;
				}
			}

			$is_req = true;
			$change_status = false;

			### Установка оценки\рейтинга ###
			if ( isset($_POST['setrate']) ) {
				$rate = $DB->es($_POST['rate']);
				$comment = $DB->es($_POST['comment']);
				if ( isset($_POST['have']) ) {
					$SQL = "UPDATE `rate` SET `demo_reqs_rates` = '{$rate}', `comment` = '{$comment}' WHERE `user_id` = '{$user['id']}';";
				} else {
					$SQL = "INSERT INTO `demo_reqs_rates` (`id`,`user_id`, `req_id`, `rate`, `comment`) VALUES ( null, '{$user['id']}', '{$req['id']}', '{$rate}', '{$comment}');";
				}
				$DB->q($SQL);
				
				$SQL = "SELECT avg(`rate`), count(`id`) FROM `demo_reqs_rates` WHERE `req_id` = '{$req['id']}';";
				$DB->qf_assoc($SQL);
				telega($req, 'rate', ['rate' => $rate, 'comment' => $comment, 'author' => $user['vk_data']['first_name'].' '.$user['vk_data']['last_name'], 'rate_count' => $DB->rD('count(`id`)'), 'rate_avg' => $DB->rD('avg(`rate`)')]);

				$F->loc("/su/req/{$req_id}/", 'Оценка установлена');
			}
			### Установка оценки\рейтинга ###

			### Смена статуса активного этапа ###
			if ( isset($_POST['changestatus']) ) {
				// $F->prec($_POST);
				$stage_id = ( in_array($req['stage_3'], ['send','info']) ? 3 : 2);
				$status = $DB->es($_POST['status']);
				$info = $DB->es($_POST['info']);
				
				if ( $status == 'info' ) {
					$SQL = "UPDATE `demo_reqs` SET `stage_{$stage_id}` = 'info', `info` = '{$info}' WHERE `id` = '{$req['id']}';";
				} else {
					if ( $stage_id == 2 ) {
						if ( $status == 'ok' ) $status = 'befok';
						$SQL = "UPDATE `demo_reqs` SET `stage_{$stage_id}` = '{$status}', `info` = '{$info}', `stage_3` = 'open' WHERE `id` = '{$req['id']}';";
						if ( $status == 'befok' ) $status = 'ok';
					} else {
						$SQL = "UPDATE `demo_reqs` SET `stage_{$stage_id}` = '{$status}', `info` = '{$info}' WHERE `id` = '{$req['id']}';";
					}
				}
				$DB->q($SQL);
				telega($req, 'su_change_status', ['status' => $status, 'info' => $info, 'stage_id' => $stage_id, 'author' => $user['vk_data']['first_name'].' '.$user['vk_data']['last_name']]); // Отправляем уведомление в телегу

				if ( $stage_id == 3 && $status == 'ok' ) {
					// Геннерируем документ и добавляем ссылку в базу
					$doc_link = $DB->es(generate_contract($req));
					$SQL = "UPDATE `demo_reqs` SET `doc_link` = '{$doc_link}' WHERE `id` = '{$req['id']}';";
					$DB->q($SQL);
				}

				if (!empty($req['email'])) {
					// Отсылаем пользователю сообщение на почту, если она установлена
					send_mail_to_user($req['email'], $status, $stage_id, $req['id']);
				}

				$F->loc("/su/req/{$req_id}/", 'Статус этапа изменен');
			}
			### Смена статуса активного этапа ###

			if ( in_array('contract', $slug) ) {
				$doc_link = $DB->es(generate_contract($req));
				$SQL = "UPDATE `demo_reqs` SET `doc_link` = '{$doc_link}' WHERE `id` = '{$req['id']}';";
				$DB->q($SQL);
				$F->loc("/su/req/{$req_id}/", 'Документ сгеннерирован');
			}
					
			if ( su() ) {
				if ( in_array($req['stage_1'], ['ok']) && in_array($req['stage_2'], ['send','open', 'info']) || in_array($req['stage_3'], ['send', 'info']) ) {
					$change_status = true;
				}
			}
			
			$Title = '#'.$req_id.' '.$req['nickname'];

			### База вопросов ###
			$req['questions'] = json_decode(file_get_contents(ROOT.'/app/modules/req/questions.json'), 1);
			### База вопросов ###

			$qs = questions_in_stage();
			$stages = [1=>[], 2=>[],3=>[]];

			foreach ($req['answers'] as $id => $answer) {
				foreach ($qs as $stage_id => $questions_id) {
					if ( in_array($id, $questions_id) ) {
						switch ($id) {
							case 3:
								if ( is_array($answer) ) {
									$a = [];
									foreach ($answer as $key => $value)
										$a[] = get_link($value);
									$answer = implode('<br>', $a);
								} else {
									$answer = get_link($answer);
								}
								break;
							case 11:
								$answer = get_link($answer);
								break;
							case 14:
								$answer = implode('<br>', $answer);
								break;
							default:
								# code...
								break;
						}
						if ( $id == 16 ) {
							foreach ($req['songs'] as $key => $song) {
								$C->create('song_'.$song['id']);
								foreach ($song['answers'] as $song_answer_id => $song_answer) {
									if ( $song_answer_id == 10 ) $song_answer = get_link($song_answer);
									$TPL->name('su/req_question');
									$TPL->set('ID', $song_answer_id);
									$TPL->set('TITLE', $req['questions']['song'][$song_answer_id]['name']);
									$TPL->set('ANSWER', ( is_array($song_answer) ? implode(', ', $song_answer) : $song_answer ));
									$C->add($TPL->compile('su/req_question'), 'song_'.$song['id']);
								}
								$TPL->name('su/req_song');
								$TPL->set('SONG_ID', $song['id']);
								$TPL->set('TITLE', $song['name']);
								$TPL->set('ANSWERS', $C->get('song_'.$song['id']));
								$stages[$stage_id][$id] .= $TPL->compile('su/req_song');
							}
						} else {
							$TPL->name('su/req_question');
							$TPL->set('ID', $id);
							$TPL->set('TITLE', $req['questions'][$id]['name']);
							$TPL->set('ANSWER', ( is_array($answer) ? implode(' ', $answer) : $answer ));
							$stages[$stage_id][$id] = $TPL->compile('su/req_question');
						}
					}
				}
			}

			$TPL->name('su/req');

			// $TPL->set('RATE_AVG', number_format($req['rate_avg'], 1, '.'));
			// $TPL->set('RATE_AVG', number_format($req['rate_avg'], 1, '.'));
			$TPL->set('RATE_AVG', (strlen($req['rate_avg']) > 4 ? substr($req['rate_avg'], 0, 3) : $req['rate_avg']));

			$TPL->set('ID', $req['id']);
			$date = new DateTime($req['date']);
			$TPL->set('DATE', $date->format('d.m H:i'));

			$TPL->set_block('EMAIL', !empty($req['email']));
			$TPL->set('EMAIL', $req['email']);

			$TPL->set_block('DOC', !empty($req['doc_link']));
			$TPL->set('DOC', $req['doc_link']);
			
			$TPL->set('USER', (empty($req['vk']) ? explode('@', $req['email'])[0] : $req['vk']['first_name'].' '.$req['vk']['last_name'] ));
			$TPL->set('NICKNAME', (isset($req['answers'][2]) ? $req['answers'][2] : '—'));
			
			$TPL->set_block('VK', !empty($req['vk']));
			$TPL->set('VK', '//vk.com/id'.$req['vk']['id']);
			// $TPL->set('VK', $req['vk']['id']);
			
			$TPL->set('TYPE', $req['type']);
			$TPL->set('STATUS', $req['status']);
			$TPL->set('STAGE_STATUS_1', $req['stage_1']);
			$TPL->set('STAGE_STATUS_2', $req['stage_2']);
			$TPL->set('STAGE_STATUS_3', $req['stage_3']);

			$TPL->set_block('STAGE_1', count($stages[1]));
			$TPL->set('STAGE_1', implode('', $stages[1]));
			$TPL->set_block('STAGE_2', count($stages[2]));
			$TPL->set('STAGE_2', implode('', $stages[2]));
			$TPL->set_block('STAGE_3', count($stages[3]));
			$TPL->set('STAGE_3', implode('', $stages[3]));
			$TPL->set_block_e('STAGE', ($slug[4] ? $slug[4] : 0));
			
			$TPL->set_block('CHANGE_STATUS', $change_status);


			$C->add($TPL->compile('su/req'), 'su');
			$F->prec($req);
		break;
		
		default:
			if ( isset($_POST['ids']) && isset($_POST['change_req']) ) {
				if ( su() ) {
					$ids = explode(',', str_replace(' ','', $_POST['ids']));
					$WHERE = [];
					$F->prec($ids);
					foreach ($ids as $key => $id) {
						$WHERE[] = "`id` = '{$id}'";
					}
					$WHERE = implode(' OR ', $WHERE);
					$SQL = '';
					switch ($_POST['change_req']) {
						case 'delete':
							// $SQL = "DELETE FROM `demo_reqs` WHERE {$WHERE}";
							$SQL = "UPDATE `demo_reqs` SET `status` = 'delete' WHERE {$WHERE}";
						break;
						case 'archive':
							$SQL = "UPDATE `demo_reqs` SET `status` = 'archive' WHERE {$WHERE}";
						break;
						case 'unarchive':
							$SQL = "UPDATE `demo_reqs` SET `status` = 'active' WHERE {$WHERE}";
						break;
					}
					$DB->q($SQL);
					$F->loc('/su/', 'Операция выполнена');
				} else {
					$F->loc('/su/', 'У тебя нет прав для этого действия');
				}
			}
			$Title = "Все заявки";
			### Получаем все заявки ###
			$SQL = "SELECT *, ( SELECT `email` FROM `users` WHERE `users`.`id` = `demo_reqs`.`user_id` ) AS `email`, ( SELECT `vk_data` FROM `users` WHERE `users`.`id` = `demo_reqs`.`user_id` ) AS `vk`, ( SELECT `rate` FROM `demo_reqs_rates` WHERE `demo_reqs_rates`.`req_id` = `demo_reqs`.`id` AND `demo_reqs_rates`.`user_id` = '{$user['id']}' ) AS `rate`, (SELECT avg(rate) FROM `demo_reqs_rates` WHERE `demo_reqs_rates`.`req_id` = `demo_reqs`.`id`) AS `rate_avg` FROM `demo_reqs`;";
			$DB->qf_array($SQL);
			
			$REQUESTS = $DB->rD();
			foreach ($REQUESTS as $i => $req) {
				if ( $req['status'] != 'delete' ) {
					$req['answers'] = json_decode($req['answers'], 1);
					$req['vk'] = json_decode($req['vk'], 1);
					// $req;
					$TPL->name('su/reqs_table_tr');

					$TPL->set_block('RATE', isset($req['rate']));
					$TPL->set('RATE', $req['rate']);
					// $TPL->set('RATE_AVG', number_format($req['rate_avg'], 1, '.'));
					$TPL->set('RATE_AVG', (strlen($req['rate_avg']) > 4 ? substr($req['rate_avg'], 0, 3) : $req['rate_avg']));

					$TPL->set('ID', $req['id']);
					$date = new DateTime($req['date']);
					$TPL->set('DATE', $date->format('d.m H:i'));

					$TPL->set_block('EMAIL', !empty($req['email']));
					$TPL->set('EMAIL', $req['email']);
					
					$TPL->set('USER', (empty($req['vk']) ? explode('@', $req['email'])[0] : $req['vk']['first_name'].' '.$req['vk']['last_name'] ));
					$TPL->set('NICKNAME', (isset($req['answers'][2]) ? $req['answers'][2] : '—'));
					
					$TPL->set_block('VK', !empty($req['vk']));
					$TPL->set('VK', '//vk.com/id'.$req['vk']['id']);
					// $TPL->set('VK', $req['vk']['id']);
					
					$TPL->set('STAGE_1', $req['stage_1']);
					$TPL->set('STAGE_2', $req['stage_2']);
					$TPL->set('STAGE_3', $req['stage_3']);

					// $reqs = ["active" => [], "new" => [], "archive" => [], "cancel" => [], "delete" => []];

					$req['status'] = ( $req['stage_1'] == 'open' ? 'new' : $req['status'] );
					$req['status'] = ( $req['status'] == 'finish' ? 'archive' : $req['status'] );
					$reqs[$req['status']][] = $TPL->compile('su/reqs_table_tr');
					$result[$i] = $req;
					$F->prec($req);
				} else {
					$reqs[$req['status']][] = $req;
				}
			}
			### Получаем все заявки ###
			
			// $F->prec($REQUESTS);

			$TPL->name('su/reqs_table');

			$TPL->set_block('REQS_ACTIVE', count($reqs['active']));
			$TPL->set('REQS_ACTIVE', implode('', $reqs['active']));
			$TPL->set_block('REQS_NEW', count($reqs['new']));
			$TPL->set('REQS_NEW', implode('', $reqs['new']));
			$TPL->set_block('REQS_ARCHIVE', count($reqs['archive']));
			$TPL->set('REQS_ARCHIVE', implode('', $reqs['archive']));
			$TPL->set_block('REQS_CANCEL', count($reqs['cancel']));
			$TPL->set('REQS_CANCEL', implode('', $reqs['cancel']));

			$C->add($TPL->compile('su/reqs_table'), 'su');
		break;
	}

	// $C->add('Тут будет контент', 'su');

	### ПОИСК ###
	if ( $show_search ) {
		$TPL->name('su/search');
		$SEARCH = $TPL->compile('su/search');
	}
	### ПОИСК ###

	### Статистика пользователей ###
	$USERS_INFO = "";
	
	$time = filemtime(ROOT.'/app/cache/'.'users_info.tpl');
	if ( !$time || (microtime(1) - $time) > 3600 ) {
		$SQL = "SELECT count(`id`) FROM `users`;";
		$DB->qf_assoc($SQL);
		// $F->prec($DB->rD('count(`id`)'));
		$TPL->name('su/users_info');
		$TPL->set('COUNT', $DB->rD('count(`id`)'));
		$USERS_INFO = $TPL->compile('su/users_info');
		file_put_contents(ROOT.'/app/cache/'.'users_info.tpl', $USERS_INFO);
	} else {
		$USERS_INFO = file_get_contents(ROOT.'/app/cache/'.'users_info.tpl');
	}
	### Статистика пользователей ###
	
	### Статистика заявок ###
	$REQS_INFO = "";
	if ( $REQUESTS ) {
		$TPL->name('su/reqs_info');
		$TPL->set('COUNT', (count($reqs['new']) + count($reqs['active']) + count($reqs['archive']) + count($reqs['cancel'])));
		$TPL->set('ACTIVE', count($reqs['active']));
		$TPL->set('ARCHIVE', count($reqs['archive']));
		$TPL->set('CANCEL', count($reqs['cancel']));
		$TPL->set('DELETE', count($reqs['delete']));
		$REQS_INFO = $TPL->compile('su/reqs_info');
		file_put_contents(ROOT.'/app/cache/'.'reqs_info.tpl', $REQS_INFO);
	} else {
		$REQS_INFO = file_get_contents(ROOT.'/app/cache/'.'reqs_info.tpl');
	}
	### Статистика заявок ###

	### Последние оценки ###
	$LASTRATES = "";
	$time = filemtime(ROOT.'/app/cache/'.'lastrates.tpl');

	// if ( (!$time || (microtime(1) - $time) > 300) || $is_req ) {
		$SQL = "SELECT *, (SELECT `vk_data` FROM `users` WHERE `users`.`id` = `demo_reqs_rates`.`user_id`) AS `author`, (SELECT `nickname` FROM `demo_reqs` WHERE `demo_reqs`.`id` = `demo_reqs_rates`.`req_id`) AS `nickname` FROM `demo_reqs_rates` ".( $is_req ? "WHERE `req_id` = '{$req['id']}'" : '' )." ORDER BY `id` DESC LIMIT 0,20;";
		$DB->qf_array($SQL);
		$C->create('rates');
		$have = false;
		foreach ($DB->rD() as $key => $rate) {
			$rate['author'] = json_decode($rate['author'], 1);
			$TPL->name('su/lastrates_item');
			$TPL->set('REQ', $rate['req_id'].' '.$rate['nickname']);
			$TPL->set('TEXT', $rate['comment']);
			$TPL->set('RATE', $rate['rate']);
			$TPL->set_block('MY', ($rate['user_id'] == $user['id'] && $is_req ? true : false));
			$TPL->set('AUTHOR', $rate['author']['first_name'].' '.$rate['author']['last_name']);
			$C->add($TPL->compile('su/lastrates_item'), 'rates');
			if($rate['user_id'] == $user['id']) $have = true;
		}

		$TPL->name('su/lastrates');
		$TPL->set_block('IS_REQ', $is_req);
		$TPL->set('RATES', $C->get('rates'));
		$TPL->set_block('HAVE', $have);
		$TPL->set_block('NOT-HAVE', !$have);
		$LASTRATES = $TPL->compile('su/lastrates');
		if(!$is_req ) file_put_contents(ROOT.'/app/cache/'.'lastrates.tpl', $LASTRATES);
	// } else {
		// $LASTRATES = file_get_contents(ROOT.'/app/cache/'.'lastrates.tpl');
	// }
	
	### Последние оценки ###

	$TPL->name('su/main');
	$TPL->set_block('SEARCH', $show_search);
	$TPL->set('SEARCH', $SEARCH);

	$TPL->set_block('LASTRATES', $show_lastrates);
	$TPL->set('LASTRATES', $LASTRATES);

	$TPL->set_block('TITLE', $Title);
	$TPL->set('TITLE', $Title);
	
	$TPL->set('CONTENT', $C->get('su'));
	$TPL->set('USERS_INFO', $USERS_INFO);
	$TPL->set('REQS_INFO', $REQS_INFO);

	$C->add($TPL->compile('su/main'), 'main');
?>