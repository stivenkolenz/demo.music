<link rel="stylesheet" href="[{ THEME }]/styles/mn.css?ver={ver=[{ THEME }]/styles/mn.css}">
<input type="hidden" id="req" value='[{ REQ }]'>
<script src="[{ THEME }]/js/mn.js?ver={ver=[{ THEME }]/js/mn.js}"></script>
<section class="Mn">
	<div class="Mn__wrap wrap">
		<h1 class="Mn__title">ОТПРАВИТЬ ДЕМО</h1>
		<div class="Mn__stages">
			<div class="MnStages flex flex--aic flex--jcc">
				<div class="MnStages__title">Этап</div>
				<div class="MnStages__current">[{ STAGE }]</div>
				<div class="MnStages__sep"> / </div>
				<div class="MnStages__last">3</div>
			</div>
		</div>
		[{ NOT-END }]
		<form method="POST" action="" class="Mn__list hide" id='mnform' data-q-num="[{ QUESTION_ID }]">
			[{ IS_SONG }]
				<h2 class="Mn__title Mn__title--song">[{ SONG_NAME }]</h2>
				<!-- <br> -->
			[{ /IS_SONG }]
			<div class="Mn__qs qWrap">
				[{ QUESTION }]
			</div>
			<div class="Mn__bottom flex flex--aic flex--jcsb">
				[{ STAGE=2 }]<div>[{ /STAGE }]
					<a href="#" class="Mn__bttn Mn__bttn--prev flex flex--aic flex--jcc disable" id="prevQ">
						<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.6474 11.6041C6.14779 12.132 5.31564 12.132 4.81602 11.6041L0.350863 6.88678C-0.116672 6.39284 -0.118609 5.60726 0.35499 5.11148L4.81388 0.400754C5.06303 0.13286 5.40129 0 5.73271 0C6.08513 0 6.41412 0.149937 6.6474 0.396399C7.11753 0.89308 7.11753 1.67484 6.6474 2.17153L3.02335 6.00026L6.6474 9.829C7.11753 10.3257 7.11753 11.1074 6.6474 11.6041Z"/></svg>
						<span>Прошлый вопрос</span>
					</a>
					[{ IS_SONG }]
					<a href="/req/[{ REQ_ID }]/stage/2/" class="Mn__bttn Mn__bttn--prev flex flex--aic flex--jcc">
						<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.6474 11.6041C6.14779 12.132 5.31564 12.132 4.81602 11.6041L0.350863 6.88678C-0.116672 6.39284 -0.118609 5.60726 0.35499 5.11148L4.81388 0.400754C5.06303 0.13286 5.40129 0 5.73271 0C6.08513 0 6.41412 0.149937 6.6474 0.396399C7.11753 0.89308 7.11753 1.67484 6.6474 2.17153L3.02335 6.00026L6.6474 9.829C7.11753 10.3257 7.11753 11.1074 6.6474 11.6041Z"/></svg>
						<span>К списку песен</span>
					</a>
					[{ /IS_SONG }]
				[{ STAGE=2 }]</div>[{ /STAGE }]
				<button class="Mn__bttn Bttn" id="nextQ">Далее</button>
			</div>
		</form>
		[{ /NOT-END }]
		[{ END }]
		[{ STAGE=1 }]
		<div class="Mn__end">
			<h1 class="Mn__title">Отлично! Первый этап завершен и пройден!</h1>
			<div class="Mn__text">
				Мы уже получили уведомление о вашей заявке и начали её просмотр. А пока вы можете начинать работу со вторым этапом!
				[{ NOT_EMAIL }]
				<br><br>Не забудь указать свою почту в профиле! Именно на неё мы пришлем тебе уведомление о следующих этапах. <br><a href="/p/">Указать почтовый ящик</a>
				[{ /NOT_EMAIL }]
			</div>
			<div class="flex flex--aic flex--jcc">
				<a href="?next_stage=true" class="Mn__bttn Mn__bttn--wa Bttn">
					<span>Начать второй&nbsp;этап</span>
				</a>
			</div>
		</div>
		[{ /STAGE }]
		[{ STAGE=2 }]
			<div class="Mn__end">
				[{ STAGE_STATUS=info }]
				<h1 class="Mn__title">У нас появились вопросы по вашей заявке..</h1>
				<div class="Mn__text">
					<q class="Mn__quote">[{ REQ_INFO }]</q>
					[{ NOT_EMAIL }]
					<br><br>Не забудь указать свою почту в профиле! Иначе вы не сможете получить уведомление. <br><a href="/p/">Указать почтовый ящик</a>
					[{ /NOT_EMAIL }]
				</div>
				<div class="flex flex--aic flex--jcc">
					<a href="?reway=true" class="Mn__bttn Mn__bttn--wa Bttn">
						<span>Повторить второй&nbsp;этап</span>
					</a>
				</div>
				[{ /STAGE_STATUS }]
				[{ STAGE_STATUS=send }]
				<h1 class="Mn__title">Отлично! Второй этап заполнен и отправлен!</h1>
				<div class="Mn__text">
					Мы уже получили уведомление и проверяем второй этап. Как только мы проверим его, вы получите уведомление на почту. 
					[{ NOT_EMAIL }]
					<br><br>Не забудь указать свою почту в профиле! Иначе вы не сможете получить уведомление. <br><a href="/p/">Указать почтовый ящик</a>
					[{ /NOT_EMAIL }]
				</div>
				[{ /STAGE_STATUS }]
				[{ STAGE_STATUS=befok }]
				<h1 class="Mn__title">Отлично! Второй этап успешно пройден!</h1>
				<div class="Mn__text">
					Мы проверили вашу заявку и открыли вам доступ к третьему этапу!
					[{ NOT_EMAIL }]
					<br><br>Не забудь указать свою почту в профиле! Иначе вы не сможете получить уведомление. <br><a href="/p/">Указать почтовый ящик</a>
					[{ /NOT_EMAIL }]
				</div>
				<div class="flex flex--aic flex--jcc">
					<a href="?next_stage=true" class="Mn__bttn Mn__bttn--wa Bttn">
						<span>Начать третий&nbsp;этап</span>
					</a>
				</div>
				[{ /STAGE_STATUS }]
			</div>
		[{ /STAGE }]
		[{ STAGE=3 }]
			<div class="Mn__end">
				[{ STAGE_STATUS=info }]
				<h1 class="Mn__title">У нас появились вопросы по вашей заявке..</h1>
				<div class="Mn__text">
					<q class="Mn__quote">[{ REQ_INFO }]</q>
					[{ NOT_EMAIL }]
					<br><br>Не забудь указать свою почту в профиле! Иначе вы не сможете получить уведомление. <br><a href="/p/">Указать почтовый ящик</a>
					[{ /NOT_EMAIL }]
				</div>
				<div class="flex flex--aic flex--jcc">
					<a href="?reway=true" class="Mn__bttn Mn__bttn--wa Bttn">
						<span>Повторить третий&nbsp;этап</span>
					</a>
				</div>
				[{ /STAGE_STATUS }]
				[{ STAGE_STATUS=send }]
				<h1 class="Mn__title">Отлично! Третий этап заполнен и отправлен!</h1>
				<div class="Mn__text">
					Мы уже получили уведомление и проверяем этот этап. Как только мы проверим его, вы получите уведомление на почту.
					[{ NOT_EMAIL }]
					<br><br>Не забудь указать свою почту в профиле! Иначе вы не сможете получить уведомление. <br><a href="/p/">Указать почтовый ящик</a>
					[{ /NOT_EMAIL }]
				</div>
				[{ /STAGE_STATUS }]
				[{ STAGE_STATUS=ok }]
				<h1 class="Mn__title">Отлично! Третий этап успешно пройден!</h1>
				<div class="Mn__text">
					Мы проверили вашу заявку и подготовили для вас договор!
				</div>
				<div class="flex flex--aic flex--jcc">
					<a href="[{ DOC_LINK }]" class="Mn__bttn Mn__bttn--wa Bttn">
						<span>Скачать договор</span>
					</a>
				</div>
				[{ /STAGE_STATUS }]
			</div>
		[{ /STAGE }]
		[{ /END }]
	</div>
</section>