<?php

if (!in_array($user['vk_id'], ['VK_ID', 'VK_ID'])) $F->loc('/', 'Пошел на***, конь!');

$SQL = "SELECT `users`.*, `admin`.`id` AS `admin` FROM `users` LEFT JOIN `admin` ON `users`.`id` = `admin`.`id`;";
$users = $DB->qf_array($SQL, 1);

foreach ($users as $key => $value) {
	$users[$key]['vk_data'] = json_decode($value['vk_data']);
	$users[$key] = json_decode(json_encode($users[$key]));
	$users[$key]->admin = isset($users[$key]->admin);
}

$p = $F->preb($users);


$C->add($p, 'main');
