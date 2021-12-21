<?php

function get_nickname($request_id) {
    global $DB;
    $SQL = "SELECT `value` FROM `values` WHERE `request_id` = '{$request_id}' AND `field` = 'nickname';";
    return $nickname = $DB->qf_assoc($SQL, 1)['value'];
}

switch ($step_id) {
    case '1':
        // $F->pre($_POST);

        $SQL = [];
        foreach ($_POST as $key => $value) {
            if ($key != 'send_step') {
                if (is_array($value)) $value = json_encode($value);
                $SQL[] = "( null, '{$DB->es($key)}', '{$DB->es($value)}', '{$request_id}', '1' )";
            }
        }

        $SQL = implode(', ', $SQL);
        $SQL = "INSERT INTO `values` ( `id`, `field`, `value`, `request_id`, `step_id` ) VALUES {$SQL};";
        $DB->q($SQL); // Сохраняем данные полей в базу

        $SQL = "UPDATE `steps` SET `status` = 'send' WHERE `request_id` = '{$request_id}' AND `step_id` = '1';";
        $DB->q($SQL); // Меняем статус текущего этапа на 'Данные отправлены'

        $SQL = [];
        foreach ($_POST['album_track'] as $key => $value) {
            $name = $DB->es($value);
            $SQL[] = "(null, '{$request_id}', '{$name}')";
        }
        $SQL = implode(', ', $SQL);
        $SQL = "INSERT INTO `songs` (`id`, `request_id`, `name`) VALUES $SQL;";
        $DB->q($SQL);

        $F->send_telega_req($step_id, $request_id, get_nickname($request_id), $user['vk_id']);
        $F->loc("/r/{$request_id}/message/send/");
        break;

    case '2':
        $values = [];
        foreach ($_POST  as $key => $value) {
            if ($key != 'send_step' || !empty($value) || $value != '') {
                $name = $DB->es($key);
                $val = $DB->es($value);
                $values[] =  "( null, '{$name}', '{$val}', '{$request_id}', '2' )";
            }
        }
        $values = implode(', ', $values);
        $SQL = "INSERT INTO `values` ( `id`, `field`, `value`, `request_id`, `step_id` ) VALUES {$values};";

        $DB->q($SQL); // Сохраняем данные полей в базу

        $SQL = "UPDATE `steps` SET `status` = 'send' WHERE `request_id` = '{$request_id}' AND `step_id` = '2';";
        $DB->q($SQL); // Меняем статус текущего этапа на 'Данные отправлены'
        $F->send_telega_req($step_id, $request_id, get_nickname($request_id), $user['vk_id']);
        $F->loc("/r/{$request_id}/message/send/");
        break;

    case '3':
        $SQL = [];
        foreach ($_POST  as $key => $value) {
            if ($key != 'send_step' || !empty($value) || $value != '') {
                $name = $DB->es($key);
                $val = $DB->es($value);
                $SQL[] =  "( '{$user['id']}', '{$request_id}', '{$name}', '{$val}' )";
            }
        }
        $SQL = implode(', ', $SQL);
        $SQL = "INSERT INTO `user_data` ( `user_id`, `request_id`, `field`, `value` ) VALUES {$SQL};";
        $DB->q($SQL);

        $SQL = "UPDATE `steps` SET `status` = 'send' WHERE `request_id` = '{$request_id}' AND `step_id` = '3';";
        $DB->q($SQL); // Меняем статус текущего этапа на 'Данные отправлены'
        $F->send_telega_req($step_id, $request_id, get_nickname($request_id), $user['vk_id']);
        $F->loc("/r/{$request_id}/step/3/");
        break;
}
