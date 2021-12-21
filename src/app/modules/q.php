<?php

	// Геннерация вопроса

	function next_q_id ($answers, $q_id = false) {
		if (!isset($answers[1])) {
			$q_id = 1; goto gen;
		}
		if (!isset($answers[2])) {
			$q_id = 2; goto gen;
		}
		if (!isset($answers[3])) {
			$q_id = 3; goto gen;
		}
		if (!isset($answers[4])) {
			$q_id = 4; goto gen;
		}
		if (!isset($answers[5])) {
			$q_id = 5; goto gen;
		}
		if (!isset($answers[6])) {
			$q_id = 6; goto gen;
		}
		if (!isset($answers[7])) {
			$q_id = 7; goto gen;
		}
		if (!isset($answers[8])) {
			$q_id = 8; goto gen;
		}
		if (!isset($answers[9])) {
			$q_id = 9; goto gen;
		}
		if (!isset($answers[10]) && $answers[9] == 'Демо') {
			$q_id = 10; goto gen;
		} else {
			if (isset($answers[10]) && $answers[10] == 'Альбом') {
				$q_id = 15;
				if (isset($answers[15]) && !isset($answers[11])) {
					$q_id = 11; goto gen;
				}
				if (isset($answers[15]) && !isset($answers[14])) {
					$q_id = 14; goto gen;
				}
				if (isset($answers[15]) && !isset($answers[12])) {
					$q_id = 12; goto gen;
				}
				if (isset($answers[15]) && !isset($answers[13])) {
					$q_id = 13; goto gen;
				} else {
					goto endstage;
				}
				goto gen;
			} elseif ( isset($answers[10]) && $answers[10] != 'Альбом' ) {
				$q_id = 11; 
				if (isset($answers[11]) && !isset($answers[14])) {
					$q_id = 14; goto gen;
				}
				if (isset($answers[11]) && !isset($answers[12])) {
					$q_id = 12; goto gen;
				}
				if (isset($answers[11]) && !isset($answers[13])) {
					$q_id = 13; goto gen;
				} else {
					goto endstage;
				}
				goto gen;
			}
		}
		if (!isset($answers[11]) && $answers[9] == 'Готовый хит') {
			$q_id = 11; 
			if (isset($answers[11]) && !isset($answers[14])) {
				$q_id = 14; goto gen;
			} else {
				goto endstage;
			}
			goto gen;
		}

		gen: 
			return $q_id;

		endstage:
			return 'EndStage';
	}

	$SQL = "SELECT * FROM `demo_reqs_answers` WHERE `req_id` = '$req_id';";
	$DB->qf_array($SQL);
	$answers = [];
	foreach ($DB->rD() as $key => $answer) $answers[$answer['q_id']] = $answer;

	$q_id = next_q_id($answers);

	$TPL->name("qs/".$q_id);
	$question = $TPL->compile("qs/".$q_id);
	// $F->prec($q_id);
	// $F->pre(htmlspecialchars($question));
?>