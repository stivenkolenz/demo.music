<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once req('config.php', '/app/');
require_once req('functions');
require_once req('content');
require_once req('theme');
require_once req('db');
require_once req('msg');

$F = new Functions;
$TPL = new Theme();
$DB = new Db($config->db['user'], $config->db['pass'], $config->db['name'], $config->db['host']);
$SMSG = new Msg;
$C = new Content;

// $SMSG->add( 'У вас нет доступа к этой странице' );

$logged = false;
$user = null;
$slug = $F->get_slug();
$CONTENT = '';
$C->create('main');

if (isset($_COOKIE['auth_id']) && isset($_COOKIE['auth_key']) || isset($_COOKIE['auth_id']) && isset($_COOKIE['auth_pass'])) {
    $id = $DB->es($_COOKIE['auth_id']);
    $user = $DB->qf_assoc("SELECT `users`.*, `checkemail`.`active` AS `checkemail` FROM `users` LEFT JOIN `checkemail` ON `checkemail`.`user_id` = `users`.`id` AND `checkemail`.`active` = 1 AND `checkemail`.`old` IS NULL WHERE `users`.`id` = '{$id}';", 1);
    if (isset($user['id'])) {
        if (isset($_COOKIE['auth_pass'])) {
            $key = md5($user['password']);
            if ($_COOKIE['auth_pass'] == $key) {
                $logged = true;
                if (empty($user['vk_data'])) {
                    $user['vk_data'] = [
                        'photo_100' => '/theme/images/no_avatar.png',
                        'photo_max' => '/theme/images/no_avatar.png',
                        'first_name' => explode('@', $user['email'])[0],
                        'last_name' => '',
                    ];
                } else {
                    $vk_data = json_decode($user['vk_data'], 1);
                    unset($user['vk_data']);
                    $user['vk_data'] = $vk_data;
                }
                $DB->qf_assoc("SELECT * FROM `admin` WHERE `id` = '{$id}';", 1);
                if (isset($DB->rD()['id'])) {
                    $user['admin'] = true;
                }
            } else {
                // $F->loc("/logout/");
            }
        } else {
            $key = md5($user['vk_code'] . $user['auth_ip']);
            if ($_COOKIE['auth_key'] == $key) {
                $logged = true;
                // $user['vk_data']['first_name'] = json_decode($user['vk_data']);
                $vk_data = json_decode($user['vk_data'], 1);
                unset($user['vk_data']);
                $user['vk_data'] = $vk_data;
                $DB->qf_assoc("SELECT * FROM `admin` WHERE `id` = '{$id}';", 1);
                if (isset($DB->rD()['id'])) {
                    $user['admin'] = true;
                }
            } else {
                // $F->loc("/logout/");
            }
        }
    } else {
        // $F->loc("/logout/");
    }
}

switch ($slug[0]) {
    case 'main':
        // if ($logged) $F->loc('/r/');
        if ($logged) $F->loc('/p/');
        break;

    case 'r':
        if ($logged) require_once req('main.php', '/app/modules/');
        else $F->loc('/', $lang['noacces']);
        break;

    case 'req':
        if ($logged) require_once req('req.php', '/app/modules/req/');
        else $F->loc('/', $lang['noacces']);
        break;

    case 'su':
        if ($logged || (!$logged && $user['admin'])) require_once req('manager.php', '/app/modules/req/');
        else $F->loc('/', $lang['noacces']);
        break;

    case 'auth':
        // Авторизируем человека
        require_once req('auth.php', '/app/modules/');
        break;

    case 'reg':
        // Регистрация нового пользователя по email
        require_once req('registration.php', '/app/modules/');
        break;

    case 'mail':
        // подтверждение почты
        require_once req('checkemail.php', '/app/modules/');
        break;

    case 'p':
        // Профиль пользователя
        require_once req('profile.php', '/app/modules/');
        break;

    case 'logout':
        // Разлогиневаем человека
        $F->set_cookie("auth_pass", '', -1);
        $F->set_cookie("auth_key", '', -1);
        $F->set_cookie("auth_id", '', -1);
        // $SMSG->add($lang['logout']);
        $F->loc("/");
        break;

    case 'manager':
        // Админка
        require_once req('manager.php', '/app/modules/');
        break;

    case 'privacy':
        // Админка
        require_once req('privacy.php', '/app/modules/');
        break;
}

$C->create('SMSG');
foreach ($SMSG->get_msg() as $key => $value)
    $C->add("<b>{$value}</b><br>");

$COOKIE_INFO = (!isset($_COOKIE['cookie_info_horse']) ? $TPL->load('cookie_info') : '');

$TPL->name('main');
$TPL->set_block('LOGGED', $logged);
$TPL->set_block('NOT-LOGGED', !$logged);
$TPL->set_block_e('PAGE', $slug[0]);
$TPL->set('CONTENT', $C->get('main'));
if ($logged) {
    $TPL->set('USER_AVATAR', $user['vk_data']['photo_max']);
    $TPL->set('USER_NAME', $user['vk_data']['first_name']);
}
$TPL->set_block('SMSG', (empty($C->get('SMSG')) ? false : true));
$TPL->set_block('ADMIN', $user['admin']);
$TPL->set('COOKIE_INFO', $COOKIE_INFO);
$TPL->set('SMSGS', $C->get('SMSG'));

$C->create('main', $TPL->compile('main'));
echo $C->get('main');


if (1) {
    // $F->prec($user, '$user');
    // $F->prec($user['admin'], 'admin');
    $F->prec($slug, '$slug');
    // $F->prec($_SERVER, '$_SERVER');
    // $F->prec($_GET, '$_GET');
    // $F->prec($_POST, '$_POST');
    // $F->prec($_REQUEST, '$_REQUEST');
    // $F->prec($_COOKIE, '$_COOKIE');
    // $F->prec($_SESSION, '$_SESSION');

    // $F->pre( $MSG );
}
