<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<title>Отправить демо</title>
	<link rel="stylesheet" href="[{ THEME }]/styles/new.css?ver={ver=[{ THEME }]/styles/new.css}">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="[{ THEME }]/js/app.js?ver={ver=[{ THEME }]/js/app.js}" defer></script>
</head>

<body>
	<header class="header">
		<div class="header__wrap wrap wrap--xxl flex flex--jcsb flex--aic">
			<div class="header__logotype">
				<a href="/" class="Logotype">
					<img src="[{ THEME }]/images/logotype/image.svg" alt="Site" class="Logotype__image">
				</a>
			</div>
			<div class="header__auth">
				<div class="Login">
					[{ NOT-LOGGED }]
					<script type="text\javascript">
						$('.Login').remove();
					</script>
					<div class="Login__icon flex flex--aic flex--jcs"><span>Войти на сайт</span> <i></i></div>
					<div class="Login__wrap">
						<form action="/auth/email/" method="POST" class="Login__email flex flex--aic flex--jcs">
							<input type="text" name="email" placeholder="Ваш email" required>
							<input type="password" name="pass" placeholder="Ваш пароль" required>
							<button class="Bttn">Войти</button> <a href="/reg/">Зарегистрироваться</a>
						</form>
						<a href="/auth/" class="Login__vk flex flex--aic flex--jcs">
							<span>Войти через</span> <i></i>
						</a>
					</div>
					[{ /NOT-LOGGED }]
					[{ LOGGED }]
					<div class="Login__auth flex flex--aic flex--jcs">
						[{ ADMIN }]<a href="/manager/" class="Auth__link Auth__link--moder" style='margin-right: 30px;'
							title='Админка'>Админка</a>[{ /ADMIN }]
						[{ ADMIN }]<a href="/su/" class="Auth__link Auth__link--moder" style='margin-right: 30px;'
							title='Админка'>Новая</a>[{ /ADMIN }]
						<a href="/p/" class="Auth__avatart"><img src="[{ USER_AVATAR }]" alt="[{ USER_NAME }]"></a>
						<a href="/p/" class="Auth__name">[{ USER_NAME }]</a>
						<a href="/logout/" class="Auth__logout" title='Выйти из аккаунта'>
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M18 6L6 18" stroke="white" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
								<path d="M6 6L18 18" stroke="white" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</a>
					</div>
					[{ /LOGGED }]
				</div>
			</div>
		</div>
	</header>
	<section class="content">
		<main
			class="content__wrap wrap flex flex--fdc flex--aic flex--jcc [{ PAGE=manager,su }]content__wrap--full[{ /PAGE }]">

			[{ NOT-LOGGED }]
			[{ PAGE=main }]<section class="startBox">
				<h1 class="startBox__title startBox__title--main">Мы используем 3-этапную систему для работы с новыми
					исполнителями</h1>
				<div class="Login__wrap Login__wrap--static Login__wrap--open">
					<div class="Login__title">Войти на сайт <br>для продолжения</div>
					<form action="/auth/email/" method="POST" class="Login__email flex flex--aic flex--jcs">
						<input type="text" name="email" placeholder="Ваш email" required>
						<input type="password" name="pass" placeholder="Ваш пароль" required>
						<button class="Bttn">Войти</button> <a href="/reg/">Зарегистрироваться</a>
					</form>
					<a href="/auth/" class="Login__vk flex flex--aic flex--jcs">
						<span>Войти через</span> <i></i>
					</a>
				</div>
				<!-- <a href="/auth/" class="startBox__link Bttn">Начать</a> -->
			</section>
			[{ /PAGE }]
			[{ PAGE=reg }]
			[{ CONTENT }]
			[{ /PAGE }]
			[{ /NOT-LOGGED }]
			[{ LOGGED }]
			[{ PAGE=r }]<section class="startBox">
				<h1 class="startBox__title">Отправить демо</h1>
			</section>[{ /PAGE }]
			[{ CONTENT }]
			[{ /LOGGED }]
		</main>
	</section>

	<section class="SystemMessage [{ SMSG }]SystemMessage--show[{ /SMSG }]"
		onclick="document.querySelector('.SystemMessage').classList.remove('SystemMessage--show'); return false;">
		<div class="SystemMessage__wrap">
			<div class='SystemMessage__text'>[{ SMSGS }]</div>
			<a href="#" class="SystemMessage__close">
				<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12.6569 12.657L1.34319 1.34334" stroke-linecap="round"></path>
					<path d="M12.6568 1.34334L1.34311 12.657" stroke-linecap="round"></path>
				</svg>
			</a>
		</div>
	</section>
	[{ COOKIE_INFO }]
	<script
		type="text/javascript">!function () { var t = document.createElement("script"); t.type = "text/javascript", t.async = !0, t.src = "https://vk.com/js/api/openapi.js?169", t.onload = function () { VK.Retargeting.Init("VK-RTRG-1111460-9amTm"), VK.Retargeting.Hit() }, document.head.appendChild(t) }();</script>
	<noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1111460-9amTm" style="position:fixed; left:-999px;"
			alt="" /></noscript>
</body>

</html>