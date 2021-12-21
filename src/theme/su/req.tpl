<section class="Req">
	<div class="Req__top flex flex--aistr flex--jcs">
		<div class="Req__info">
			<div class="flex flex--aic flex--jcs">
			[{ EMAIL }]
			<a href="mailto:[{ EMAIL }]">
				<svg xmlns="http://www.w3.org/2000/svg" width="24px" fill="none" viewBox="0 0 36 36" id="mail_outline_36"><path clip-rule="evenodd" d="M15 8.5h6c1.898 0 3.196.001 4.207.07.988.068 1.518.191 1.898.349.256.106.503.23.737.372l-6.634 6.076c-.73.668-1.224 1.12-1.635 1.441-.4.312-.642.437-.842.498a2.499 2.499 0 01-1.462 0c-.2-.061-.442-.186-.842-.498-.41-.321-.905-.773-1.635-1.44L8.158 9.29a5.5 5.5 0 01.737-.372c.38-.158.91-.281 1.898-.349 1.01-.069 2.309-.07 4.207-.07zm-8.635 2.54c-.173.27-.322.555-.446.855-.158.38-.281.91-.349 1.898-.069 1.01-.07 2.309-.07 4.207s.001 3.196.07 4.207c.068.988.191 1.518.349 1.898a5.5 5.5 0 002.976 2.976c.38.158.91.281 1.898.349 1.01.069 2.309.07 4.207.07h6c1.898 0 3.196-.001 4.207-.07.988-.068 1.518-.191 1.898-.349a5.5 5.5 0 002.976-2.976c.158-.38.281-.91.349-1.898.069-1.01.07-2.309.07-4.207s-.001-3.196-.07-4.207c-.068-.988-.191-1.518-.349-1.898a5.502 5.502 0 00-.446-.856l-6.739 6.172-.036.033c-.684.627-1.25 1.146-1.749 1.535-.518.405-1.039.731-1.65.918a5 5 0 01-2.922 0c-.611-.187-1.132-.513-1.65-.918-.498-.39-1.065-.908-1.75-1.535l-.035-.033zM3 18c0-3.728 0-5.591.609-7.061a8 8 0 014.33-4.33C9.409 6 11.272 6 15 6h6c3.728 0 5.591 0 7.061.609a8 8 0 014.33 4.33C33 12.409 33 14.273 33 18s0 5.591-.609 7.061a8 8 0 01-4.33 4.33C26.591 30 24.727 30 21 30h-6c-3.728 0-5.591 0-7.061-.609a8 8 0 01-4.33-4.33C3 23.591 3 21.727 3 18z" fill="currentColor" fill-rule="evenodd"></path></svg>
			</a>
			[{ /EMAIL }]
			&nbsp;&nbsp;&nbsp;&nbsp;
			[{ VK }]
			<a href="[{ VK }]">
				<svg xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 36 36"><g fill="none" fill-rule="evenodd"><path d="M0 0h36v36H0z"></path><path d="M35.174 9.422c.25-.82 0-1.422-1.191-1.422h-3.939c-1 0-1.463.52-1.713 1.094 0 0-2.003 4.795-4.84 7.91-.918.901-1.335 1.188-1.836 1.188-.25 0-.613-.287-.613-1.106V9.422c0-.984-.29-1.422-1.125-1.422h-6.189c-.626 0-1.002.457-1.002.89 0 .932 1.419 1.147 1.565 3.77v5.696c0 1.25-.23 1.476-.73 1.476-1.336 0-4.583-4.817-6.51-10.328C6.674 8.433 6.295 8 5.29 8H1.35C.225 8 0 8.52 0 9.094c0 1.025 1.335 6.107 6.217 12.828C9.471 26.512 14.057 29 18.229 29c2.504 0 2.813-.553 2.813-1.505v-3.469c0-1.105.238-1.326 1.03-1.326.584 0 1.586.287 3.922 2.5 2.67 2.623 3.111 3.8 4.613 3.8h3.939c1.125 0 1.687-.553 1.363-1.643-.355-1.087-1.63-2.664-3.322-4.534-.918-1.065-2.295-2.213-2.712-2.786-.584-.738-.417-1.066 0-1.722 0 0 4.798-6.639 5.299-8.893z" fill="currentColor"></path></g></svg>
			</a>
			[{ /VK }]
			</div>	<br>
			Пользователь: [{ USER }]<br>
			Дата создания заявки: [{ DATE }]<br>
			Статус заявки: [{ STATUS }]<br>
			Тип исполнителя: [{ TYPE }]<br>
			Средняя оценка: [{ RATE_AVG }]<br>
			[{ DOC }]
			<a href="[{ DOC }]" target="_blank">Скачать договор</a><br>
			[{ /DOC }]
			
		</div>
		<div class="Req__stages">
			<div class="Stages flex">
				<a class="Stages__el flex flex--aic flex--jcc Stages__el--[{ STAGE_STATUS_1 }]" href="/su/req/[{ ID }]/stage/1">#1</a>
				<a class="Stages__el flex flex--aic flex--jcc Stages__el--[{ STAGE_STATUS_2 }]" href="/su/req/[{ ID }]/stage/2">#2</a>
				<a class="Stages__el flex flex--aic flex--jcc Stages__el--[{ STAGE_STATUS_3 }]" href="/su/req/[{ ID }]/stage/3">#3</a>
			</div>
		</div>
	</div>
	[{ CHANGE_STATUS }]
	<div class="Req__changeStatus">
		<div class="Req__title">Смена статуса активного этапа</div>
		<!-- Тут будет форма изменения статуса активного этапа -->
		<form action="" method="POST" class="Req__changeForm flex flex--aic flex--jcs">
			<select name="status" required="">
				<option value="">Выберите статус</option>
				<!-- <option value="open">Открыто для пользователя</option> -->
				<!-- <option value="close">Закрыто для пользователя</option> -->
				<!-- <option value="send">Отправлено пользователем</option> -->
				<option value="info">Отправить пользователю вопрос по его этапу</option>
				<option value="ok">Пройдено</option>
				<option value="fail">Отклонено</option>
			</select>
			<textarea name="info" placeholder="Введите текст если появились вопросы по этому этапу"></textarea>
			<button class="Bttn" name="changestatus">Сменить статус</button>
			<label class="flex flex--aic flex--jcs">
				<input type="checkbox" name="allright" required> <span>я все внимательно проверил</span>
			</label>
		</form>
	</div>
	[{ /CHANGE_STATUS }]
	<div class="Req__answers">
		<div class="Req__title">Ответы</div>
		<div class="StagesLabels flex flex--aic flex--jcs">
			[{ STAGE_1 }]<div class="StagesLabels__item"><a href="#" class="StagesLabels__link [{ STAGE=1 }]active[{ /STAGE }]" data-stage="1">Этап 1</a></div>[{ /STAGE_1 }]
			[{ STAGE_2 }]<div class="StagesLabels__item"><a href="#" class="StagesLabels__link [{ STAGE=2 }]active[{ /STAGE }]" data-stage="2">Этап 2</a></div>[{ /STAGE_2 }]
			[{ STAGE_3 }]<div class="StagesLabels__item"><a href="#" class="StagesLabels__link [{ STAGE=3 }]active[{ /STAGE }]" data-stage="3">Этап 3</a></div>[{ /STAGE_3 }]
		</div>
		[{ STAGE_1 }]<section class="Stage [{ STAGE=1 }]active[{ /STAGE }] flex flex--aistr flex--jcs" data-stage="1" [{ STAGE=0,2,3 }]style="display: none;"[{ /STAGE }]>
			<!-- [{ STAGE=1 }]Stage__title--open[{ /STAGE }] -->
			<div class="Stage__title flex flex--ais flex--jcc"><span>Первый этап</span> <i></i></div>
			<!-- [{ STAGE=1 }]Stage__list--open[{ /STAGE }] -->
			<!-- [{ STAGE=2,3 }]style="display: none;"[{ /STAGE }] -->
			<div class="Stage__list flex flex--aistr flex--jcs">
				[{ STAGE_1 }]
			</div>
		</section>
		[{ /STAGE_1 }]
		[{ STAGE_2 }]<section class="Stage [{ STAGE=2 }]active[{ /STAGE }] flex flex--aistr flex--jcs" data-stage="2" [{ STAGE=0,1,3 }]style="display: none;"[{ /STAGE }]>
			<!-- [{ STAGE=2 }]Stage__title--open[{ /STAGE }] -->
			<div class="Stage__title flex flex--ais flex--jcc"><span>Второй этап</span> <i></i></div>
			<!-- [{ STAGE=2 }]Stage__list--open[{ /STAGE }] -->
			<!-- [{ STAGE=1,3 }]style="display: none;"[{ /STAGE }] -->
			<div class="Stage__list flex flex--aistr flex--jcs">
				[{ STAGE_2 }]
			</div>
		</section>
		[{ /STAGE_2 }]
		[{ STAGE_3 }]<section class="Stage [{ STAGE=3 }]active[{ /STAGE }] flex flex--aistr flex--jcs" data-stage="3" [{ STAGE=0,1,2 }]style="display: none;"[{ /STAGE }]>
			<!-- [{ STAGE=3 }]Stage__title--open[{ /STAGE }] -->
			<div class="Stage__title flex flex--ais flex--jcc"><span>Третий этап</span> <i></i></div>
			<!-- [{ STAGE=3 }]Stage__list--open[{ /STAGE }] -->
			<!-- [{ STAGE=1,2 }]style="display: none;"[{ /STAGE }] -->
			<div class="Stage__list  flex flex--aistr flex--jcs">
				[{ STAGE_3 }]
			</div>
		</section>
		[{ /STAGE_3 }]
	</div>
</section>
