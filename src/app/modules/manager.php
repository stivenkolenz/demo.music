<?php
if ($logged && $user != null) {
	$SQL = "SELECT `id` FROM `admin` WHERE `id` = '{$user['id']}';";
	$res = $DB->qf_assoc($SQL, 1);
	if (isset($res['id'])) {

		switch ($slug[1]) {
			case 'r':
				if (isset($slug[2])) {
					$request_id = (int) $slug[2];
					// $F->prec($request_id);
					$req = [];
					$users = [];
					$reqs = [];
					$steps = [];

					$SQL = "SELECT * FROM `requests` WHERE `id` = '{$request_id}';";
					$req = $DB->qf_assoc($SQL, 1);

					if (empty($req)) {
						$F->loc('/manager/', 'В системе нет такого обращения');
					}

					$SQL = "SELECT * FROM `users` WHERE `id` = '" . $req['user_id'] . "';";
					$req['user'] =  $DB->qf_assoc($SQL, 1);
					$req['user']['vk_data'] = json_decode($req['user']['vk_data']);

					$req['user_data'] = [];
					$SQL = "SELECT * FROM `user_data` WHERE `user_id` = '{$req['user_id']}';";
					foreach ($DB->qf_array($SQL, 1) as $key => $value) {
						$req['user_data'][$value['field']] = $value['value'];
					}

					$SQL = "SELECT * FROM `steps` WHERE `request_id` = '{$request_id}';";
					foreach ($DB->qf_array($SQL, 1) as $key => $value) {
						$req['steps'][$value['step_id']] = $value;
					}

					$req['values'] = [];
					$SQL = "SELECT * FROM `values` WHERE `request_id` = '{$request_id}';";
					foreach ($DB->qf_array($SQL, 1) as $key => $value) {
						$req['values'][$value['step_id']][$value['field']] = $value['value'];
					}

					$req['songs'] = [];
					$song_ids = [];
					$SQL = "SELECT * FROM `songs` WHERE `request_id` = '{$request_id}';";
					foreach ($DB->qf_array($SQL, 1) as $key => $value) {
						$song_ids[] = "`song_id` = '{$value['id']}'";
						$req['songs'][$value['id']] = ['name' => $value['name']];
					}

					if (!empty($song_ids)) {
						$SQL = "SELECT * FROM `song_data` WHERE " . implode(' OR ', $song_ids) . ";";
						foreach ($DB->qf_array($SQL, 1) as $key => $value) {
							$req['songs'][$value['song_id']]['data'][$value['field']] = $value['value'];
						}
					}

					$TPL->name('manager/r_steps');
					foreach ($req['steps'] as $key => $step) {
						$step['status'];
						$step['step_id'];
						$TPL->set('REQUEST_ID', $request_id);
						$TPL->set('STATUS_' . $step['step_id'], $step['status']);
					}

					$TPL->set('REQUEST_ID', $request_id);
					$C->create('r_steps', $TPL->compile('manager/r_steps'));
					$C->add($C->get('r_steps'), 'main');

					switch ($slug['3']) {
						case 'step':
							$step_id = (int) $slug['4'];
							if ($step_id == 0) {
								$F->loc("/manager/r/{$request_id}/", 'Вы не выбрали этап');
							}
							// $F->prec($user);
							$nick = $F->get_nickname($req['id']);

							if (isset($_POST['change_status'])) {
								// Меняем статус этапу
								if ($req['steps'][$step_id]['status'] == 'ok') {
									$F->loc("/manager/r/{$request_id}/step/{$step_id}/", 'Этот этап уже проверен и не может быть изменен.');
								} else {
									$status = $DB->es($_POST['status']);
									if (in_array($status, ['info', 'fail'])) {
										$info = $DB->es($_POST['otherinfo']);
										$SQL = "UPDATE `steps` SET `status` = '{$status}', `info` = '{$info}' WHERE `request_id` = '{$request_id}' AND `step_id` = '{$_POST['step_id']}';";
									} else {
										$SQL = "UPDATE `steps` SET `status` = '{$status}' WHERE `request_id` = '{$request_id}' AND `step_id` = '{$_POST['step_id']}';";
									}

									$DB->q($SQL);
									if (!in_array($status, ['info', 'fail']) && (int) $_POST['step_id'] != 3) {
										$nexyStep_id = $_POST['step_id'] + 1;
										$SQL = "UPDATE `steps` SET `status` = 'open' WHERE `request_id` = '{$request_id}' AND `step_id` = '{$nexyStep_id}';";
										$DB->q($SQL);
									}

									$tlg_msg = <<<HTML
{$user['vk_data']['first_name']} {$user['vk_data']['last_name']} сменил статус {$step_id}-го этапа для заявки №{$req['id']} [{$nick}]
Новый статус: {$_POST['status']}
Ссылка: demo.site.ru/manager/r/{$req['id']}/{$step_id}/
HTML;
									$F->send_info_to_telega($tlg_msg);

									if (!empty($req['user']['email'])) {
										$F->send_mail_req($req['user']['email'], $status, $_POST['step_id'], $request_id);
									}
									$F->loc("/manager/r/{$request_id}/step/{$step_id}/", 'Данные успешно обновлены.');
								}
							}

							$C->create('step');

							switch ($step_id) {
								case 1:
									// $F->pre($req['values'][$step_id]);
									foreach ($req['values'][$step_id] as $key => $value) {
										$TPL->name('manager/step_value');
										$TPL->set('TITLE', $langopt[$key]);
										if ($key == 'demo_link') {
											$value = "<a target='_blank' href='{$value}'>$value</a>";
										}
										if ($key == 'socnetwork') {
											$value = json_decode($value);
											// $value = implode(', ', json_decode($value));
											// $F->pre($value);
											$ul = [];
											foreach ($value as $link) {
												$link = str_replace(' ', '', $link);
												if (strpos($link, 'http') === false) $link = '//' . $link;
												$ul[] = "<li><a target='_blank' href='{$link}'>$link</a></li>";
											}
											// foreach ($value as $key => $value) {
											// }
											$value = '<ul>' . implode('', $ul) . '</ul>';
										}
										if ($key == 'album_track') {
											$value = json_decode($value);
											$ol = [];
											foreach ($value as $key => $value) {
												$ol[] = "<li>{$value}</li>";
											}
											$value = '<ol>' . implode('', $ol) . '</ol>';
										}
										$TPL->set('ANSWER', $value);
										$C->add($TPL->compile('manager/step_value'), 'step');
									}

									/* Рейтинг первого этапа */
									require_once req('rate.php', '/app/modules/');
									/* Рейтинг первого этапа */
									break;
								case 2:
									foreach ($req['songs'] as $key => $value) {
										$C->create('data');
										foreach ($value['data'] as $key => $value2) {
											$TPL->name('manager/step_value');
											$TPL->set('TITLE', $langopt[$key]);
											if ($key == 'coverYes_link') {
												$value2 = "<a target='_blank' href='{$value2}'>$value2</a>";
											}
											$TPL->set('ANSWER', $value2);
											$C->add($TPL->compile('manager/step_value'), 'data');
										}
										$TPL->name('manager/step_value');
										$TPL->set('TITLE', $value['name']);
										$TPL->set('ANSWER', $C->get('data'));
										$C->add($TPL->compile('manager/step_value'), 'step');
									}
									if (!empty($req['values'][2]['otherinfo'])) {
										$TPL->name('manager/step_value');
										$TPL->set('TITLE', $langopt['otherinfo2']);
										$TPL->set('ANSWER', $req['values'][2]['otherinfo']);
										$C->add($TPL->compile('manager/step_value'), 'step');
									}
									break;
								case 3:
									foreach ($req['user_data'] as $key => $value) {
										$TPL->name('manager/step_value');
										$TPL->set('TITLE', $langopt[$key]);
										$TPL->set('ANSWER', $value);
										$C->add($TPL->compile('manager/step_value'), 'step');
									}
									break;
								default:
									$F->loc("/manager/r/{$request_id}/", 'Вы не выбрали этап');
									break;
							}

							// if (!in_array($req['steps'][$step_id]['status'], ['ok', 'close', ''])) {
							$TPL->name('manager/change_status');
							$TPL->set('STEP_ID', $step_id);
							$C->add($TPL->compile('manager/change_status'), 'step');
							// }

							$C->add($C->get('step'), 'main');
							break;

						case 'delete':
							if (isset($slug[4])) {
								if ($slug[4] == 'yes') {
									$SQL = "DELETE FROM `requests` WHERE `id` = '{$req['id']}';";
									$DB->q($SQL);
									$F->loc('/manager/', 'Обращение удалено');
								} else {
									$F->loc('/manager/', 'Ну и нефиг тогда нажимать куда попало!!!');
								}
							} else {
								$TPL->name('manager/act_r');
								$TPL->set('REQ_ID', $req['id']);
								$TPL->set('REQ_ACT', 'удалить');
								$TPL->set('REQ_ACT_LINK', 'delete');
								$C->add($TPL->compile('manager/delete_r'), 'main');
							}
							break;

						case 'archive':
							if (isset($slug[4])) {
								if ($slug[4] == 'yes') {
									$SQL = "UPDATE `requests` SET `aviable` = 0 WHERE `id` = '{$req['id']}';";
									$DB->q($SQL);
									$F->loc('/manager/', 'Обращение заархивировано');
								} else {
									$F->loc('/manager/', 'Ну и нефиг тогда нажимать куда попало!!!');
								}
							} else {
								$TPL->name('manager/act_r');
								$TPL->set('REQ_ID', $req['id']);
								$TPL->set('REQ_ACT', 'архивировать');
								$TPL->set('REQ_ACT_LINK', 'archive');
								$C->add($TPL->compile('manager/delete_r'), 'main');
							}
							break;

						default:

							break;
					}
					// $F->prec($req);
				} else {
					$F->loc('/manager/', 'Не выбрано обращение');
				}
				break;
			case 'su':
				/* Рейтинг первого этапа */
				require_once req('su.php', '/app/modules/');
				/* Рейтинг первого этапа */
				break;
			default:
				$users = [];
				$reqs = [];
				$steps = [];
				$step_status = [];
				$rates = [];
				$SQL = "SELECT * FROM `step_status`;";
				foreach ($DB->qf_array($SQL, 1) as $key => $value) {
					$step_status[$value['status']] = $value;
				}
				$SQL = "SELECT * FROM `users`;";
				foreach ($DB->qf_array($SQL, 1) as $key => $value) {
					$value['vk_data'] = json_decode($value['vk_data']);
					$users[$value['id']] = $value;
				}
				$SQL = "SELECT `requests`.*, `values`.`value` AS `nickname` FROM `requests` LEFT JOIN `values` ON `values`.`field` = 'nickname' AND `values`.`request_id` = `requests`.`id` ORDER BY `date` DESC;";
				foreach ($DB->qf_array($SQL, 1) as $key => $value) {
					$value['user'] = $users[$value['user_id']];
					$reqs[$value['id']] = $value;
				}
				$SQL = "SELECT * FROM `steps`;";
				foreach ($DB->qf_array($SQL, 1) as $key => $value) {
					$reqs[$value['request_id']]['steps'][$value['step_id']] = $value;
				}
				$SQL = "SELECT `rate`.*, `users`.`vk_data` AS `vk_data` FROM `rate` LEFT JOIN `users` ON `rate`.`user_id` = `users`.`id`;";
				// $F->prec($DB->qf_array($SQL, 1));
				foreach ($DB->qf_array($SQL, 1) as $key => $value) {
					$reqs[$value['request_id']]['rate'][] = $value;
				}

				$reqs_finish = 0;
				$reqs_active = 0;
				$reqs_fail = 0;
				$reqs_archive = 0;

				// $F->pre($reqs);

				$C->create('reqs');
				$C->create('reqs_archive');
				$C->create('reqs_new');
				foreach ($reqs as $key => $req) {
					$TPL->name('manager/req_table_tr');
					if ($req['steps'][3]['status'] == 'ok' || $req['steps'][3]['status'] == 'send') $reqs_finish++;
					$fail = false;
					$hide = ($req['steps'][1]['status'] == 'open' ? true : false);

					foreach ($req['steps'] as $key => $step) {
						if ($step['status'] == 'fail') $reqs_fail++;
						$TPL->set("STEP_{$key}", $step['status']);
						if ($step['status'] == 'fail' || $step['status'] == 'info') {
							$fail = true;
						}
					}
					if (!$req['aviable']) $reqs_archive++;

					// Отображение что пользователь уже голосовал в этой заявке
					$have_rate = false;
					if (isset($req['rate'])) {
						foreach ($req['rate'] as $key => $r) {
							if ($r['user_id'] == $user['id']) {
								$have_rate = true;
							}
						}
					}
					// Отображение что пользователь уже голосовал в этой заявке
					$date = new DateTime($req['date']);

					$TPL->set_block('ARCHIVE', !$req['aviable']);
					$TPL->set_block('HAVE_RATE', $have_rate);
					$TPL->set('ID', $req['id']);
					$TPL->set_block('NICKNAME', $req['nickname']);
					$TPL->set('NICK', $req['nickname']);
					$TPL->set('DATE', $date->format('d.m H:i'));
					$TPL->set('DATE_FULL', $date->format('d.m.Y H:i'));
					$TPL->set('EMAIL', $req['user']['email']);
					$TPL->set('AUTHOR_ID', $req['user']['id']);
					$TPL->set('AUTHOR_ID', $req['user']['id']);
					$TPL->set('AUTHOR_VK_ID', $req['user']['vk_id']);
					$TPL->set('AUTHOR_NAME', $req['user']['vk_data']->first_name);
					$TPL->set('AUTHOR_LASTNAME', $req['user']['vk_data']->last_name);
					$TPL->compile('manager/req_table_tr');
					if (!$req['aviable'] || $fail)
						$C->add($TPL->compile('manager/req_table_tr'), 'reqs_archive');
					else {
						if ($req['steps'][1]['status'] == 'open') {
							$C->add($TPL->compile('manager/req_table_tr'), 'reqs_new');
						} else
							$C->add($TPL->compile('manager/req_table_tr'), 'reqs');
					}
				}

				$reqs_active = count($reqs) - ($reqs_finish + $reqs_fail + $reqs_archive);

				$TPL->name('manager/reqs_table');
				$TPL->set('REQS', $C->get('reqs'));
				$TPL->set('REQS_NEW', $C->get('reqs_new'));
				$TPL->set('REQS_ARCHIVE', $C->get('reqs_archive'));
				$TPL->set('REQS_COUNT', count($reqs));
				$TPL->set('REQS_FINISH_COUNT', $reqs_finish);
				$TPL->set('REQS_ACTIVE_COUNT', $reqs_active);
				$TPL->set('REQS_FAIL_COUNT', $reqs_fail);
				$TPL->set('REQS_ARCHIVE_COUNT', $reqs_archive);
				$C->add($TPL->compile('manager/reqs_table'), 'main');
				// $F->prec($reqs, 'main');
				break;
		}
	} else {
		$F->loc('/', 'У тебя нет доступа к этой странице :)');
	}
} else {
	$F->loc('/', 'У тебя нет доступа к этой странице :)');
}
