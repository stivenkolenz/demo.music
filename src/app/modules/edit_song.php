<?php

if (!isset($slug[3])) {
    $F->loc("/r/{$request_id}/step/2/", $lang['selectSong']);
} else {
    $song_id = $DB->es((int) $slug[3]); // id текущей песни
    $first_song = false; // Якобы в базе уже есть данныe о треках

    // Собираем инфу обо всех треках этого обращения
    $songs = [];
    $SQL = "SELECT * FROM `songs` WHERE `request_id` = '{$request_id}'";
    $res = $DB->qf_array($SQL, 1);
    $SQL = [];
    foreach ($res as $key => $value) {
        $songs[$value['id']] = $value;
        $SQL[] = "`song_id` = '{$value['id']}'";
    }
    $SQL = implode(" OR ", $SQL);
    $SQL = "SELECT * FROM `song_data` WHERE {$SQL};";
    $res = $DB->qf_array($SQL, 1);
    if (empty($res)) {
        $first_song = true;
    } else {
        foreach ($res as $key => $value) {
            if (!isset($songs[$value['song_id']]['data'])) $songs[$value['song_id']]['data'] = [];
            $songs[$value['song_id']]['data'][$value['field']] = $value['value'];
        }
    }
    foreach ($songs as $key => $value) if (!isset($value['data'])) $songs[$key]['data'] = false;
    // $F->pre($res);
    // $F->pre($songs);
    // $F->pre($first_song);
    // Собираем инфу обо всех треках этого обращения

    if (!isset($songs[$song_id])) {
        $F->loc("/r/{$request_id}/step/2/", $lang['noacces_song']);
    } else {
        if (isset($_POST['save_song'])) {

            $track_data = $_POST['track'][$song_id];
            if ($first_song && $_POST['send_all'] == 'Да') {
                $SQL = [];
                foreach ($songs as $key => $s) {
                    foreach ($track_data as $key => $value) {
                        if (!empty($value) || $value != '') {
                            $field = $DB->es($key);
                            $val = $DB->es($value);
                            $SQL[] = "(null, '{$s['id']}', '{$field}', '{$val}')";
                        }
                    }
                }
                $SQL = implode(', ', $SQL);
            } else {
                $SQL = "DELETE FROM `song_data` WHERE `song_id` = '{$song_id}';";
                $DB->q($SQL);

                $SQL = [];
                foreach ($track_data as $key => $value) {
                    if (!empty($value) || $value != '') {
                        $field = $DB->es($key);
                        $val = $DB->es($value);
                        $SQL[] = "(null, '{$song_id}', '{$field}', '{$val}')";
                    }
                }
                $SQL = implode(', ', $SQL);
            }

            $SQL = "INSERT INTO `song_data` (`id`, `song_id`, `field`, `value`) VALUES $SQL;";
            $DB->q($SQL);
            $lang['save_song'] = str_replace('$name', $songs[$song_id]['name'], $lang['save_song']);
            $F->loc("/r/{$request_id}/step/2/", ($first_song && $_POST['send_all'] == 'Да' ? $lang['save_first_song'] : $lang['save_song']));
        } else {

            $tplname = ($songs[$song_id]['data'] == false ? 'song_data' : 'song_data_set');
            $TPL->name($tplname);
            $TPL->set('NAME', $songs[$song_id]['name']);
            $TPL->set('ID', $songs[$song_id]['id']);
            $TPL->set_block('FIRST_SONG', ($first_song == true && count($songs) != 1) ? true : false);
            if ($res['data'] !== false) {
                $platforms = ['BOOM', 'VK Music', 'Yandex Music', 'Spotify', 'Apple Music', 'ITunes', 'YouTube Music', 'TikTok', 'Deezer', 'СберЗвук'];
                $platforms_set = [];
                $d = $songs[$song_id]['data'];
                $TPL->set('FIELD_0', ($d['haveproject'] == 'Да' ? 'checked' : ''));
                $TPL->set('FIELD_1', ($d['haveproject'] == 'Нет' ? 'checked' : ''));
                $TPL->set('FIELD_2', ($d['released'] == 'Да' ? 'checked' : ''));
                $TPL->set('FIELD_3', ($d['released'] == 'Нет' ? 'checked' : ''));
                if (!empty($d['release_platforms'])) {
                    $platforms_set = explode(',', $d['release_platforms']);
                    foreach ($platforms as $key => $value) {
                        if (in_array($value, $platforms_set)) {
                            unset($platforms[$key]);
                        }
                    }
                }
                foreach ($platforms as $key => $value) {
                    $platforms[$key] = "<a href='#' class='FieldMultiple__opt'>{$value}</a>";
                }
                foreach ($platforms_set as $key => $value) {
                    $platforms_set[$key] = "<a href='#' class='FieldMultiple__opt selected'>{$value}</a>";
                }
                // $F->prec( $d );
                $TPL->set('releasedYes', ($d['released'] == 'Да' ? 'block' : 'none'));
                $TPL->set('FIELD_4', $d['release_platforms']);
                $TPL->set('platforms_set', implode('', $platforms_set));
                $TPL->set('platforms', implode('', $platforms));
                $TPL->set('FIELD_5', $d['release_message']);
                $TPL->set('FIELD_6', ($d['released_now'] == 'Да' ? 'checked' : ''));
                $TPL->set('FIELD_7', ($d['released_now'] == 'Нет' ? 'checked' : ''));
                $TPL->set('releasedNowYes', ($d['released_now'] == 'Да' ? 'block' : 'none'));
                $TPL->set('FIELD_8', $d['releasenow_label']);
                $TPL->set('FIELD_9', ($d['doc_authors'] == 'Да' ? 'checked' : ''));
                $TPL->set('FIELD_10', ($d['doc_authors'] == 'Нет' ? 'checked' : ''));
                $TPL->set('doc_authors', ($d['doc_authors'] == 'Нет' ? 'block' : 'none'));
                $TPL->set('FIELD_11', $d['doc_authorsno_text']);
                $TPL->set('FIELD_12', ($d['material_join'] == 'Я сам' ? 'checked' : ''));
                $TPL->set('FIELD_13', ($d['material_join'] == 'Один человек' ? 'checked' : ''));
                $TPL->set('FIELD_14', ($d['material_join'] == 'Разные люди' ? 'checked' : ''));
                $TPL->set('FIELD_15', ($d['material_join'] == $d['material_join_other'] ? 'checked' : ''));

                $TPL->set('FIELD_16', $d['material_join_other']);
                $TPL->set('FIELD_17', ($d['cover'] == 'Да' ? 'checked' : ''));
                $TPL->set('FIELD_18', ($d['cover'] == 'Нет' ? 'checked' : ''));
                $TPL->set('coverYes', ($d['cover'] == 'Да' ? 'block' : 'none'));
                $TPL->set('FIELD_19', $d['coverYes_link']);
                $TPL->set('FIELD_20', $d['text']);
            }
            $C->create('song', $TPL->compile($tplname));
            $C->add($C->get('song'), 'main');
        }
    }
}
