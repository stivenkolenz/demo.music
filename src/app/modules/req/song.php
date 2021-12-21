<?php

	$song_id;
	$req_id;

	$history = [1,2,3,4,5,6,7,8,9,10];

	$SQL = "SELECT * FROM `demo_reqs_songs` WHERE `id` = '{$song_id}' AND `req_id` = '{$req_id}';";
	$DB->qf_assoc($SQL);

	$song = $DB->rD();
	if ( empty( $song ) ) {
		$F->loc('/req/'.$req_id, 'У вас нет доступа к этой странице');
	}
	$song['questions'] = json_decode($song['questions']);
	$song['q_id'] = $song['questions'][0];
	$song['answers'] = [];
	$SQL = "SELECT * FROM `demo_reqs_songs_answers` WHERE `song_id` = '{$song_id}';";
	$DB->qf_array($SQL);
	if ( !empty($DB->rD()) ) {
		foreach ($DB->rD() as $id => $answer)
			$song['answers'][$id] = $answer;
	}
	$q_id = $song['questions'][0];
	// $F->prec($song);
	$req['song'] = $song;
	$F->prec($req);

	// $C->add(q_code($q_id, true, '123'), 'main');
	// $q_id = 2;
	$C->create('q');
	$TPL->name('qs/song-'.$q_id);
	$TPL->set('REQ_ID', $req['id']);
	$TPL->set('STAGE', $req['stage']);
	$TPL->set('TITLE', $req['qs']['song'][$q_id][$req['type']]);
	$TPL->set('Q_ID', $q_id);
	$C->add($TPL->compile('qs/song-'.$q_id), 'q');

	$TPL->name('rn');
	$TPL->set('QUESTION', $C->get('q'));
	$TPL->set('Q_NUM', $q_id);
	$TPL->set('SONG_ID', $song['id']);
	$TPL->set('REQ', json_encode($req));
	$C->add($TPL->compile('rn'), 'main');
?>