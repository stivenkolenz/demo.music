<?php
	/* Рейтинг первого этапа */

	if (isset($_POST['add_rate']) && isset($_POST['rate'])) {
		// $F->prec($_POST);
		$rate = $DB->es($_POST['rate']);
		$comment = $DB->es($_POST['comment']);
		$SQL = "INSERT INTO `rate` (`id`, `user_id`, `request_id`, `rate`, `comment`) VALUES (null, '{$user['id']}', '{$request_id}', '{$rate}', '{$comment}');";
		$DB->q($SQL);
		// $F->pre($SQL);

		$SQL = "SELECT `rate` FROM `rate` WHERE `request_id` = '{$request_id}';";
		$DB->qf_array($SQL);
		$avg = 0;
		foreach ($DB->rD() as $key => $val) {
			$avg += $val['rate'];
		}
		$avg = $avg / count($DB->rD());

		$F->rate_msg($rate, $avg, count($DB->rD()), $comment, $request_id, $user['vk_data']['first_name'] . ' ' . $user['vk_data']['last_name']);
		$F->loc("/manager/r/{$request_id}/step/1/", $msg = "Ваша оценка добавлена");
	}

	$req['rate'] = [];
	$SQL = "SELECT `rate`.*, `users`.`vk_data` AS `vk_data` FROM `rate` LEFT JOIN `users` ON `rate`.`user_id` = `users`.`id` WHERE `request_id` = '$request_id';";
	$req['rate'] = $DB->qf_array($SQL, 1);
	
	foreach ($req['rate'] as $key => $value) $req['rate'][$key]['vk_data'] = json_decode($req['rate'][$key]['vk_data']);

	$SQL = "SELECT `id` FROM `rate` WHERE `request_id` = '{$request_id}' AND `user_id` = '{$user['id']}';"; // Проверяем есть ли наша оценка.
	$my_rate = $DB->qf_assoc($SQL, 1);

	if (isset($_GET['removerate']) && $_GET['removerate'] == 'true' && !empty($my_rate) ) {
		$SQL = "DELETE FROM `rate` WHERE `request_id` = '{$request_id}' AND `user_id` = '{$user['id']}';";
		$DB->q($SQL);
		$F->loc("/manager/r/{$request_id}/step/1/", $msg = "Ваша оценка удалена");
	}
	// $F->prec($my_rate);
	$have_rate = (empty($my_rate) ? false : true);
	$rate_list = [];
	$rate_avg = 0;
	
	foreach ($req['rate'] as $key => $v) {
		$rate_avg += $v['rate'];
		$rate_list[] = <<<HTML
<tr data-color="{$v['rate']}">
	<td><a href="//vk.com/id{$v['vk_data']->id}">{$v['vk_data']->first_name} {$v['vk_data']->last_name}</a></td>
	<td>{$v['rate']}</td>
	<td style='width: 50%;'><blockquote>{$v['comment']}</blockquote></td>
</tr>
HTML;
	}
	$rate_list = implode(' <br>', $rate_list);
	$rate_avg = (count($req['rate']) == 0 ? 0 : $rate_avg / count($req['rate']));

	$TPL->name('manager/rate_step');
	$TPL->set_block('NHR', !$have_rate);
	$TPL->set_block('HR', $have_rate);
	$TPL->set('RATE_COUNT', count($req['rate']));
	$TPL->set('RATE_AVG', $rate_avg);
	$TPL->set('RATE', (count($req['rate']) == 0 ? '' : $rate_list));
	$C->add($TPL->compile('manager/rate_step'), 'step');


	// $F->prec($req);
	// $F->prec($req['rate']);