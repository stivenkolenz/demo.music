<?php

$step_id = (int) $slug[3];
if ($step_id < 1 || $step_id > 3) $F->loc("/r/{$request_id}/", $lang['notfound'], 404);

if ($step_id != '3' && $steps[$step_id]['s'] != 'open') {
    $F->loc("/r/{$request_id}/", $ss[$steps[$step_id]['s']]);
} else {

    if (isset($_POST['send_step'])) {
        $ok = $F->issetStepField($step_id, $_POST); // Проверяем все ли данные с формы прислали.. защита от даунов.

        if (!$ok) {
            $F->loc("/r/{$request_id}/", $lang['nofield']);
        } else {
            require_once req('save_step.php', '/app/modules/');
        }
    }
    if ($step_id == 2) {
        $songs = [];
        $SQL = "SELECT * FROM `songs` WHERE `request_id` = '{$request_id}';";
        $SQL2 = [];
        foreach ($DB->qf_array($SQL, 1) as $key => $value) {
            $songs[$value['id']] = $value['name'];
            $SQL2[] = "`song_id` = '{$value['id']}'";
        }

        if ( !empty($SQL2) ) {
            $SQL2 = "SELECT DISTINCT `song_id`  FROM `song_data` WHERE " . implode(' OR ', $SQL2) . ";";
            $songs_data = [];
        
            $DB->qf_array($SQL2);
            foreach ($DB->rD() as $key => $value) {
                $songs_data[$value['song_id']] = true;
            }
        }

        if (count($songs_data) == 0) {
            foreach ($songs as $key => $value) {
                $F->loc("/r/{$request_id}/song/{$key}/");
                die();
            }
        }

        $C->create('SONG_LABELS');
        $C->create('SONG_ITEMS');

        foreach ($songs as $key => $value) {
            $TPL->name('step2_songlabel');
            $TPL->set('ID', $key);
            $TPL->set('REQUEST_ID', $request_id);
            $TPL->set('NAME', $value);
            $TPL->set('FILLED', ($songs_data[$key] ? 'tracksTabsLabel__name--filled' : ''));
            $TPL->set('FILLED_1', ($songs_data[$key] ? 'yes' : ''));
            $TPL->set('FILLED_2', ($songs_data[$key] ? 'tracksTabsLabel__act--edit' : 'tracksTabsLabel__act--fill'));
            $TPL->set('FILLED_3', ($songs_data[$key] ? 'Редактировать' : 'Заполнить'));
            $C->add($TPL->compile('step2_songlabel'), 'SONG_LABELS');
            $TPL->name('step2_song');
            $TPL->set('ID', $key);
            $TPL->set('NAME', $value);
            $C->add($TPL->compile('step2_song'), 'SONG_ITEMS');
        }
    }

    if ($step_id == 3 && $steps[$step_id]['s'] == 'send') {
        $F->loc("/r/{$request_id}/message/check/");
    }


    $TPL->name('demo_step' . $step_id);
    if ($step_id == 3) {
        $SQL = "SELECT * FROM `user_data` WHERE `user_id` = '{$user['id']}';";
        $res = $DB->qf_array($SQL, 1);
        $TPL->set('ПОЧТА', $user['email']);
        $TPL->set_block('NOT_DATA', (empty($res) ? true : false));
        $TPL->set_block('HAVE_DATA', (empty($res) ? !true : !false));
    }
    $TPL->set('REQUEST_ID', $request_id);
    $TPL->set('SONG_ITEMS', $C->get('SONG_ITEMS'));
    $TPL->set('SONG_LABELS', $C->get('SONG_LABELS'));
    $C->create('step', $TPL->compile('demo_step' . $step_id));
    $C->add($C->get('step'), 'main');

}
