<?php

// namespace Classes\Functions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Functions
{

	static public function pre($var, $dump = false)
	{
		echo "<pre>";
		if ($dump) var_dump($var);
		else print_r($var);
		echo "</pre>";
	}

	static public function getIP()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function preb($var, $dump = false)
	{
		ob_start();
		$this->pre($var, $dump);
		return ob_get_clean();
	}

	public function recursiveAddslashes($obj)
	{
		if (is_array($obj) || is_object($obj)) {
			foreach ($obj as $key => $value) {
				if (is_array($value) || is_object($value)) {
					$obj[$key] = $this->recursiveAddslashes((array)$value);
				} else {
					$obj[$key] = addslashes($value);
				}
			}
		} else {
			$obj = addslashes($obj);
		}
		return $obj;
	}

	public function prec($var, $title = false)
	{
		$title = ($title ? addslashes($title) : $title);
		echo ("<script>console.log( " . ($title ? "'{$title}', " : '') . "JSON.parse( '" . json_encode($this->recursiveAddslashes($var)) . "') );</script>");
	}

	public function set_cookie($name, $value, $expires)
	{
		if ($expires) $expires = time() + ($expires * 86400);
		else $expires = time() - 3600;

		if (PHP_VERSION < 5.2)
			if (DOMAIN)  setcookie($name, $value, $expires, "/");
			else setcookie($name, $value, $expires, "/");
		else setcookie($name, $value, $expires, "/");
	}

	public function getInfoBrowser()
	{
		$agent = $_SERVER['HTTP_USER_AGENT'];
		preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $bInfo);
		$browserInfo = array();
		$browserInfo['name'] = ($bInfo[1] == "Version") ? "Safari" : $bInfo[1];
		$browserInfo['version'] = $bInfo[2];
		return $browserInfo;
	}
	public function formFiles($field)
	{
		if ($_FILES[$field]['error'] == 4 || empty($_FILES[$field]) || empty($_FILES)) {
			return false;
		} else {
			$files = [];
			if (!is_array($_FILES[$field]['name'])) {
				$files[] = $_FILES[$field];
			} else {
				foreach ($_FILES[$field]['name'] as $key => $value) {
					$files[] = [
						'name' => $_FILES[$field]['name'][$key],
						'type' => $_FILES[$field]['type'][$key],
						'tmp_name' => $_FILES[$field]['tmp_name'][$key],
						'error' => $_FILES[$field]['error'][$key],
						'size' => $_FILES[$field]['size'][$key],
					];
				}
			}

			return $files;
		}
	}

	public function get_slug($url = false)
	{
		if ($url) {
			$url = str_replace($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'], '', $url);
			$_slug = explode('/', $url);
		} else {
			$_slug = explode('/', str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']));
		}
		unset($_slug[0], $_slug[count($_slug)]);
		$slug = [];
		foreach ($_slug as $key => $value) $slug[] = $value;
		return (empty($slug[0]) ? ['main'] : $slug);
	}

	public function loc($url, $msg = false, $code = false)
	{
		if ($msg) {
			global $SMSG;
			$SMSG->add($msg);
		}
		if ($code) http_response_code($code);
		header("Location: {$url}");
		die();
	}
	public function issetStepField($step_id, $fields)
	{
		return true;
		$step_fields = [
			'1' => ['age', 'albumortrack', 'city', 'demo_link', 'finishwork', 'genres', 'nickname', 'otherinfo', 'send_step', 'socnetwork'],
			'2' => [],
			'3' => [],
		];

		foreach ($step_fields[$step_id] as $key => $value) {
			if (!isset($fields[$value]) || empty($fields[$value]))
				return false;
		}

		return true;
	}
	public function file_force_download($file)
	{
		if (file_exists($file)) {
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
				ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			readfile($file);
			exit;
		}
	}

	public function send_mail_req($to, $status, $step_id, $request_id)
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

		$message .= "<br><a href='http://{$_SERVER['HTTP_HOST']}/r/{$request_id}/step/{$step}/'>Перейти на сайт</a>";

		require_once ROOT . '/vendor/autoload.php';

		$mail = new PHPMailer(true);

		try {
			$mail->CharSet = 'UTF-8';
			$mail->setFrom('info@site.ru');
			$mail->addAddress($to);     //Add a recipient

			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Информация по вашему обращению DEMO.site.ru';
			$mail->Body    = $message;

			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	public function send_check_email($hash, $to, $act, $data = [])
	{
		$message = '';
		$subj = '';
		$next = false;
		if ($act == 'check') {
			$subj = 'Подтверждение почты для сайта DEMO.site.ru';
			$message = <<<HTML
Вы успешно зарегистрировались на сайте demo.site.ru<br>Для продолжения работы с сайтом и получения уведомлений Вам необходимо подтвердить свою почту перейдя по <a href="//{$_SERVER['HTTP_HOST']}/mail/{$hash}/">этой ссылке</a> или скопировать ссылку ниже и вставить в адресную строку вашего браузера.<br>
<pre>
https://{$_SERVER['HTTP_HOST']}/mail/{$hash}/
</pre>
HTML;
			$next = true;
		} elseif ($act == 'change') {
			$subj = 'Смена почты на сайте DEMO.site.ru';
			$message = <<<HTML
				На сайте demo.site.ru был создан запрос на смену почтового ящика c {$to} на {$data['new']}.<br><br>
				<b>Если это были не вы, то не переходите по ссылкам ниже.</b><br><br>
				Для подтверждения смены почтового ящика перейдите по <a href="//{$_SERVER['HTTP_HOST']}/mail/{$hash}/">этой ссылке</a> или скопируйте ссылку ниже и вставьте в адресную строку вашего браузера.<br>
<pre>
https://{$_SERVER['HTTP_HOST']}/mail/{$hash}/
</pre>
HTML;
			$next = true;
		}

		if ($next) {
			require_once ROOT . '/vendor/autoload.php';

			$mail = new PHPMailer(true);

			try {
				$mail->CharSet = 'UTF-8';
				$mail->setFrom('info@site.ru');
				$mail->addAddress($to);     //Add a recipient

				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = $subj;
				$mail->Body    = $message;

				$mail->send();
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
	}

	public function get_nickname($request_id)
	{
		global $DB;
		$SQL = "SELECT `value` FROM `values` WHERE `request_id` = '{$request_id}' AND `field` = 'nickname';";
		return $nickname = $DB->qf_assoc($SQL, 1)['value'];
	}

	public function rate_msg($rate, $avg, $count, $comment, $request_id, $user)
	{
		$nick = $this->get_nickname($request_id);
		$msg = <<<HTML
{$user} оценил демку {$nick}
demo.site.ru/manager/r/{$request_id}/step/1/

Оценка: {$rate}
Комментарий: {$comment}

Проголосовало: {$count} из 6
Средняя оценка: {$avg}
HTML;

		require_once req('telegram');
		$T = new SendToTelegram('TLG_KEY', -1001235428217);
		$T->sendMessage($msg);
	}

	public function send_info_to_telega($text)
	{
		require_once req('telegram');
		$T = new SendToTelegram('TLG_KEY', -1001235428217);
		$T->sendMessage($text);
	}

	public function send_telega_req($step_id, $request_id, $nickname, $vk)
	{
		require_once req('telegram');

		$T = new SendToTelegram('TLG_KEY', -1001235428217);

		$telegaMsg = 'Новое событие на сайте. Псевдоним: ' . $nickname . '
		';

		$msg = <<<HTML
Этап {$step_id} из 3
Псевдоним: {$nickname}
VK: vk.com/id{$vk}

Ссылка на проверку: demo.site.ru/manager/r/{$request_id}/step/{$step_id}/
HTML;

		if ($step_id == '1') {
			$telegaMsg .= "Новая заявка.";
		} else {
			$telegaMsg .= "Обновление {$step_id} этапа.";
		}
		$telegaMsg .= "
		demo.site.ru/manager/r/{$request_id}/step/{$step_id}/";
		// $T->sendMessage($telegaMsg);
		$T->sendMessage($msg);
	}
}
