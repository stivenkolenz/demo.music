<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function get_link($link, $text = false)
{
	return "<a href='{$link}' target='_blank'>" . ($text ? $text : $link) . "</a>";
}

function questions_in_stage($song = false)
{
	if ($song)
		return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	else
		return [
			// stage => question ids
			1 => [1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15],
			2 => [8, 16, 17],
			3 => [18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40],
		];
}

function way($answers, $current_question_id, $stage, $song = false)
{
	$ways = questions_in_stage();
	$song_way = questions_in_stage(1);
	$way = ($stage == 2 && $song ? $song_way : $ways[$stage]);
	$new_way = [];

	$remove_id = []; // Список ID вопросов которые нужно удалить из пути
	switch ($stage) {
		case 1:
			if (isset($answers[9]) && $answers[9] == 'Готовый хит')
				$remove_id = array_merge($remove_id, [10, 12, 13, 15]);
			if (isset($answers[10]) && $answers[10] != 'Альбом')
				$remove_id = array_merge($remove_id, [15]);
			if (isset($answers[12]) && $answers[12] == 'Нет')
				$remove_id = array_merge($remove_id, [13]);
			break;
		case 2:
			if ($song) {
				if (isset($answers[4]) && $answers[4] == 'Нет')
					$remove_id = array_merge($remove_id, [5, 6, 7]);
				if (isset($answers[6]) && $answers[6] == 'Нет')
					$remove_id = array_merge($remove_id, [7]);
				if (isset($answers[9]) && $answers[9] == 'Нет')
					$remove_id = array_merge($remove_id, [10]);
			} else {
			}
			break;
		case 3:
			if (isset($answers[33]) && $answers[33] == 'Физ лицо')
				$remove_id = array_merge($remove_id, [35]);
			if (isset($answers[33]) && $answers[33] == 'Юр лицо')
				$remove_id = array_merge($remove_id, [34]);
			break;
	}

	$next_question_key = false;
	foreach ($way as $key => $question_id) {
		if (!in_array($question_id, $remove_id))
			$new_way[] = $question_id;
		if ($current_question_id == $question_id)
			$next_question_key = count($new_way);
	}
	$next_question_id = $new_way[$next_question_key];
	$prev_question_id = $new_way[$next_question_key - 2];
	$array_diff = array_diff($way, $new_way);
	$clean_answer_question_ids = [];
	$new_answers = $answers;
	foreach ($array_diff as $key => $id) {
		if (!empty($answers[$id])) {
			$clean_answer_question_ids[] = $id;
			unset($new_answers[$id]);
		}
	}
	return [
		'answers' => [
			'old' => $answers,
			'new' => $new_answers,
		],
		'way' => $new_way,
		'question_ids' => [
			'current' => $current_question_id,
			'next' => $next_question_id,
			'prev' => $prev_question_id,
		],
		'removed_id' => $remove_id,
		'diff' => $array_diff,
		'clean_answer_question_ids' => $clean_answer_question_ids,
	];
}

function question_id($answers, $stage, $song = false)
{
	$data = way($answers, -1, $stage, $song);
	foreach ($data['way'] as $key => $value) {
		if (!isset($answers[$value]) || empty($answers[$value]))
			return $value;
	}
}


function title_type($type)
{
	switch ($type) {
		case 'Артист':
			$type = 'artist';
			break;
		case 'Дуэт':
			$type = 'duet';
			break;
		case 'Трио':
			$type = 'trio';
			break;
		case 'Группа':
			$type = 'group';
			break;
		case 'Бэнд':
			$type = 'band';
			break;
		case 'name':
			$type = 'name';
			break;
		default:
			$type = 'artist';
			break;
	}
	return $type;
}

function question($answers, $question_id, $title_type = false, $song = false)
{
	global $TPL, $req, $F;
	$title_type = title_type($title_type);
	$question = ($song ? $req['questions']['song'][$question_id] : $req['questions'][$question_id]);

	// $fields = [$question['type'], $title_type];
	$fields = [];
	$opt = $question['options'];
	switch ($question['type']) {
		case "select":
			$fields[] = "<select name='[{ ID }]' data-required>";
			if ($opt['placeholder'])
				$fields[] = "<option value=''>{$opt['placeholder']}</option>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<option value='{$value}'>{$value}</option>";
			$fields[] = "</select>";
			break;
		case "text":
			// if ($opt['clone']) 
			// $fields[] = "<input type='text' name='[{ ID }]' data-required placeholder='{$opt['placeholder']}' original>";
			// else
			$fields[] = "<input type='" . ($opt['type'] ? $opt['type'] : "text") . "' name='[{ ID }]' data-required placeholder='{$opt['placeholder']}' " . ($opt['clone'] ? 'data-original' : "") . ">";
			break;
		case "platforms":
			$fields[] = "<div class='Platforms'>";
			$fields[] = "<div class='Platforms__active flex flex--aic flex--jcs' placeholder='{$opt['placeholder']}'>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<label for='" . str_replace(' ', '_', $value) . "'>{$value}</label>";
			$fields[] = "</div>";
			$fields[] = "<div class='Platforms__passive flex flex--aic flex--jcs'>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<label for='" . str_replace(' ', '_', $value) . "'>{$value}</label>";
			$fields[] = "</div>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<input type='checkbox' name='[{ ID }]' value='{$value}' id='" . str_replace(' ', '_', $value) . "'>";
			$fields[] = "</div>";
			break;
		case "textlist":
			$list_id = 'datalist_' . $question_id;
			$fields[] = "<input type='text' name='[{ ID }]' data-required placeholder='{$opt['placeholder']}' list='{$list_id}'>";
			$fields[] = "<datalist id='{$list_id}'>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<option value='{$value}'>";
			$fields[] = "</datalist>";
			break;
		case "radio":
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<label><input type='radio' name='[{ ID }]' value='{$value}' data-required><span>{$value}</span></label>";
			break;
		case "checkbox":
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<label><input type='checkbox' name='[{ ID }]' value='{$value}' data-required><span>{$value}</span></label>";
			break;
		case "url":
			$fields[] = "<input type='url' name='[{ ID }]' data-required placeholder='{$opt['placeholder']}'>";
			break;
		case "songslist":
			$end_songs = 0;
			foreach ($req['songs'] as $key => $song) {
				if ($song['status'] == 'end') {
					$end_songs++;
				}
			}
			foreach ($req['songs'] as $key => $song) {
				// $F->pre($answers);
				$checked = (is_null(question_id($song['answers'], 2, 1)) ? 'checked' : '');
				$fields[] = <<<HTML
	<a href="/req/{$req['id']}/stage/2/song/{$song['id']}/" class="SongBox flex flex--aic flex--jcs flex--fwn">
		<div class="SongBox__status flex flex--aic flex--jcc">
			<input type="checkbox" name='[{ ID }]' value="{$song['id']}" {$checked} data-required>
			<span></span>
		</div>
		<div class="SongBox__name">
			<span>{$song['name']}</span>
		</div>
	</a>
HTML;
				if ($song['status'] == 'end' && $end_songs == 1) {
					$fields[] = "<a class='SongBox__copy' href='/req/{$req['id']}/stage/2/song/{$song['id']}/copy/'>Скопировать ответы {$song['name']} на другие треки</a>";
				}
			}

			break;
		case "textarea":
			$fields[] = "<textarea name='[{ ID }]' data-required placeholder='{$opt['placeholder']}'>{$answers[$question_id]}</textarea>";
			break;
		case "custom":
			$fields[] = "<select name='[{ ID }]' data-required placeholder='{$opt['placeholder']}' data-select-custom>";
			if ($opt['placeholder'])
				$fields[] = "<option value=''>{$opt['placeholder']}</option>";
			foreach ($question['variants'] as $key => $value)
				$fields[] = "<option value='{$value}'>$value</option>";
			$fields[] = "<option value='custom'>Свой вариант</option>";
			$fields[] = "</select>";
			// $fields[] = "<textarea name='[{ ID }]' data-required placeholder='{$opt['placeholder']}'>{$answers[$question_id]}</textarea>";
			break;
	}

	$TPL->name('question');
	$TPL->set_block('IS_SONG', $song);
	$TPL->set_block('INFO', ($question['options']['info'] || $question['options']['clone'] ? true : false));
	$TPL->set('INFO', $question['options']['info']);
	$TPL->set_block('LINKS', ($question['options']['clone'] ? true : false));
	$TPL->set_block('CLONE', ($question['options']['clone'] ? true : false));
	$TPL->set_block('DOC', ($question['options']['doc'] ? true : false));
	$TPL->set('FIELDS', implode("\n", $fields));
	$TPL->set('ID', $question_id);
	$TPL->set('TITLE', $question[$title_type]);
	$TPL->set_block('FLEX', $question['options']['flex']);
	$TPL->set_block('FLEX-LINE', $question['options']['flex-line']);

	$code = $TPL->compile('question');
	return [
		'code' => $code,
		// 'code' => htmlspecialchars($code),
		'id' => $question_id,
		'question' => $question,
		'title' => $question[$title_type],
		'type' => $question['type'],
		'answer' => $answers[$question_id],
	];
}

function telega($req, $type, $data = [])
{
	require_once req('telegram');
	global $F;
	$message = [];
	$a = $req['answers'];
	$T = new SendToTelegram('TLG_KEY', -1001235428217);

	switch ($type) {
		case 'stage_update':
			$message[] = "<code>### Обновление этапа ###</code>";
			$message[] = "Этап <b>{$req['stage']}</b> из 3";
			$message[] = "Псевдоним: <b>{$a[2]}</b>";
			// $message[] = "Соц сети\n".implode(' ', $a[3])."";
			$message[] = "";
			$message[] = "<u>{$_SERVER['HTTP_HOST']}/su/req/{$req['id']}/</u>";
			break;
		case 'rate':
			$message[] = "<code>### Оценка для дэмо ###</code>";
			$message[] = "{$data['author']} оценил демо <b>{$a[2]}</b>";
			$message[] = "<u>{$_SERVER['HTTP_HOST']}/su/req/{$req['id']}/</u>";
			$message[] = "";
			$message[] = "Оценка: {$data['rate']}";
			$message[] = "Комментарий: <i>{$data['comment']}</i>";
			$message[] = "";
			$message[] = "<pre>Проголосовало: {$data['rate_count']} из 6";
			$message[] = "Средняя оценка: {$data['rate_avg']}</pre>";
			break;
		case 'su_change_status':
			$message[] = "<code>### Смена статуса этапа ###</code>";
			$message[] = "Заявка: #{$req['id']} <b>{$a[2]}</b>";
			$message[] = "{$data['author']} сменил статус <b>{$data['stage_id']}-го</b> этапа <b>{$a[2]}</b>";
			$message[] = "<u>{$_SERVER['HTTP_HOST']}/su/req/{$req['id']}/</u>";
			$message[] = "";
			$message[] = "Новый статус: {$data['status']}";
			if (!empty($data['info']))
				$message[] = "Комментарий: <i>{$data['info']}</i>";

			break;
	}

	### Техническая информация ###
	$message[] = '<code>';
	$message[] = $_SERVER['HTTP_X_REAL_IP'];
	// $message[] = $_SERVER['HTTP_USER_AGENT'];
	$message[] = '</code>';
	### Техническая информация ###

	$message = implode("\n", $message);
	$T->sendMessage($message);
}

function send_mail_to_user($to, $status, $step_id, $req_id)
{
	$message = '';
	$step = $step_id;
	if ($status == 'fail') {
		$message = "Ваша заявка была отклонена";
	} elseif ($status == 'info') {
		$message = "По вашей заявке появились вопросы.";
	} elseif ($status == 'ok') {
		if ($step_id != '3') {
			$message = "Мы проверили {$step_id} этап вашей заявки и подтвердили его. Вам был открыт следующий этап.";
			$step++;
		} else {
			$message = "Поздравляем! Вы прошли все этапы! Теперь вы можете скачать подготовленный договор.";
		}
	}

	$message .= "<br><a href='http://{$_SERVER['HTTP_HOST']}/req/{$req_id}/'>Перейти на сайт</a>";

	require_once ROOT . '/vendor/autoload.php';

	$mail = new PHPMailer(true);

	try {
		$mail->CharSet = 'UTF-8';
		$mail->setFrom('info@site.ru');
		$mail->addAddress($to);     //Add a recipient

		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Информация по вашему обращению DEMO.site.RU';
		$mail->Body    = $message;

		$mail->send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

function generate_contract($req)
{
	require_once 'vendor/autoload.php';

	$data = [
		'lastname' => $req['answers'][19], // Фамилия
		'firstname' => $req['answers'][20], // Имя
		'fn' => '', // И
		'secondname' => $req['answers'][21], // Отчество
		'sn' => '', // О
		'nickname' => $req['answers'][2], // Псевдоним
		'email' => $req['answers'][23], // Почта
		'series' => $req['answers'][25], // Серия
		'number' => $req['answers'][26], // Номер
		'issuedby' => $req['answers'][27], // Кем_выдан
		'whenissued' => $req['answers'][28], // Когда_выдан
		'departmentcode' => $req['answers'][29], // Код_подразделения
		'birthday' => $req['answers'][22], // Дата_рождения
		'index' => $req['answers'][32], // Индекс
		'registrationaddress' => $req['answers'][30], // Адрес_регистрации
		'OGRNIPINN' => ($req['answers'][33] == 'Физ лицо' ? 'ИНН: ' . $req['answers'][34] : 'ОГРНИП: ' . $req['answers'][35]), // ИНН
		'SNILS' => $req['answers'][36], // СНИЛС
		'bankname' => $req['answers'][37], // Название_банка
		'checkingaccount' => $req['answers'][38], // Расчетный_счет
		'correspondentaccount' => $req['answers'][39], // Корреспондентский_счет
		'BIK' => $req['answers'][40], // БИК
		'phone' => $req['answers'][24], // Телефон
		'email' => $req['answers'][23], // Почта
	];
	$data['fn'] = mb_substr($data['firstname'], 0, 1);
	$data['sn'] = mb_substr($data['secondname'], 0, 1);

	$file_hash = md5($req['user_id'] . $req['id'] . $req['answers'][2]);
	$file_name = 'u' . $req['user_id'] . 'r' . $req['id'] . 'h' . $file_hash;
	$file = ROOT . '/upload/contract/' . $file_name . '.docx';
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$doc = $phpWord->loadTemplate(ROOT . '/upload/contract/_contract_template.docx');
	foreach ($data as $key => $value) {
		$doc->setValue($key, $value);
	}
	$doc->saveAs($file);

	return '/upload/contract/' . $file_name . '.docx';
}
