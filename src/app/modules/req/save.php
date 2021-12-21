<?php
	$res = [
		'status' => 'error',
		'info' => '',
		// 'answers' => $_POST,
		'data' => false,
	];

	$current_question_id = -1;
	foreach ($_POST as $key => $value) {
		$current_question_id = $key;
		$answers[$key] = $value;
	}

	$way = way($answers, $current_question_id, $req['stage'], $req['song']);
	$res['sys'] = $way;
	// $way['answers']['new']
	
	if ( $req['prevq'] ) {
		if ( empty($way['question_ids']['prev']) ) {
			$res['status'] = 'end';
		} else {
			$res['q'] = question ($answers, $way['question_ids']['prev'], $req['answers'][1], $req['song']);
			$res['status'] = 'ok';
		}
	} else {
		if ( empty($way['question_ids']['next']) ) {
			$res['status'] = 'end';
		} else {
			$res['q'] = question ($answers, $way['question_ids']['next'], $req['answers'][1], $req['song']);
			$res['status'] = 'ok';
		}
	}

	if ( !$req['prevq'] ) {
		if ( $req['song'] ) {
			$end_song = is_null(question_id($answers, 2, $req['song']));
		}
		$nickname = $DB->es($answers[2]);
		$answers = $DB->es(json_encode($answers));
		// $F->pre($answers);
		// die();
		if ( $req['song'] ) {
			// $SQL = "UPDATE `demo_reqs_songs` SET `answers` = '{$answers}' WHERE `id` = '{$req['song']}';";
			$SQL = [];
			$SQL[] = "`answers` = '{$answers}'";
			if ( $end_song && $req['songs'][$req['song']]['status'] != 'end') {
				$SQL[] = "`status` = 'end'";
			}
			if ( $req['songs'][$req['song']]['status'] == 'end' && !$end_song ) {
				$SQL[] = "`status` = 'open'";
			}
			$SQL = implode(', ', $SQL);
			$SQL = "UPDATE `demo_reqs_songs` SET {$SQL} WHERE `id` = '{$req['song']}';";
		} else {
			$SQL = "UPDATE `demo_reqs` SET `answers` = '{$answers}' WHERE `id` = '{$req['id']}';";
			// if ( isset($_POST['2']) ) {
				// $SQL .= " UPDATE `demo_reqs` SET 'nickname' = '{$nickname}' WHERE `id` = '{$req['id']}';";
			// }
		}
		$DB->q($SQL);
	}

	echo json_encode($res);
	die();
?>