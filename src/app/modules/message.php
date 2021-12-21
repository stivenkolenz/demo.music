<?php

$email = (empty($user['email']) ? true : false);
if (isset($_POST['add_email']) && $email) {
    $email = $DB->es($_POST['email']);
    // $F->prec($_POST);
    $SQL = "UPDATE `users` SET `email` = '{$email}' WHERE `id` = '{$user['id']}';";
    $DB->q($SQL);
    $F->loc("/r/{$request_id}/message/email/");
}
if ($email) {
    $TPL->name('add_email');
    $TPL->compile('add_email');
    $C->create('add_email', $TPL->compile('add_email'));
}

switch ($slug[3]) {
    case 'send':
        $lang['send'] = str_replace('$name', $user['vk_data']['first_name'], $lang['send']);

        $C->create('message_text', $lang['send']);
        break;

    case 'email':
        $lang['email'] = str_replace('$EMAIL', $user['email'], $lang['email']);
        $C->create('message_text', $lang['email']);
        break;

    case 'check':
        $C->create('message_text', $lang['checkstep']);
        break;

    case 'fail':
        $C->create('message_text', $lang['failstep']);
        break;

    case 'info':
        $info = '';
        foreach ($steps as $key => $value)
            if ($value['s'] == 'info') $info = $value['info'];
        $F->prec($steps);
        $lang['infostep'] = str_replace('$info', $info, $lang['infostep']);
        $C->create('message_text', $lang['infostep']);
        break;

    default:
        $F->loc("/r/{$request_id}/", $lang['notfound']);
        break;
}

$TPL->name('message_send');
$TPL->set_block('ISSET_EMAIL', $email);
$TPL->set('ADD_EMAIL', ($email ? $C->get('add_email') : ''));
$TPL->set('TEXT', $C->get('message_text'));

$C->create('message_send', $TPL->compile('message_send'));
$C->add($C->get('message_send'), 'main');