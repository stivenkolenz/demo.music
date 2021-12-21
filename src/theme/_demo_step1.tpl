<form action="" method='POST' class='Form' autocomplete="off">
	<input type="hidden" name="send_step" value='true'>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input cloudLink' type="text" name='demo_link'
				placeholder='Прикрепите ссылку на ваши работы' required>
			<span class="Field__name">Ссылка на вашу работу</span>
			<div class="Field__info FieldInfo">
				<a class="FieldInfo__ico"></a>
				<div class="FieldInfo__text">Мы не принимаем ссылки на плейлисты из вКонтакте. Укажите другую ссылку или
					платформу(Google Drive, Яндекс Диск, SoundCloud, Dropbox, Mega)</div>
			</div>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='nickname' placeholder='В свободной форме' required>
			<span class="Field__name">Творческий псевдоним</span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='age' placeholder='18 лет' required>
			<span class="Field__name">Возраст</span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='city' placeholder='Москва' required>
			<span class="Field__name">Место проживания</span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='socnetwork[]' placeholder='Укажите ссылки на страницы'
				required>
			<span class="Field__name">Соцсети</span>
		</label>
		<a href="#" class="Field__add" data-field='socnetwork[]'><i></i> <span>Добавить соцсеть</span></a>
		<a href="#" class="Field__remove" data-field='socnetwork[]'><i></i> <span>Удалить поле</span></a>
	</div>
	<div class="Form__item">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Укажите жанр исполнения</div>
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Поп' required>
						<span class="FieldRadioOpt__name">Поп</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Рок' required>
						<span class="FieldRadioOpt__name">Рок</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Рэп/Хоп-хоп' required>
						<span class="FieldRadioOpt__name">Рэп/Хоп-хоп</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='R&B' required>
						<span class="FieldRadioOpt__name">R&B</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Джаз' required>
						<span class="FieldRadioOpt__name">Джаз</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Инструментал' required>
						<span class="FieldRadioOpt__name">Инструментал</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='Электро' required>
						<span class="FieldRadioOpt__name">Электро</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt FieldRadioOpt--text">
						<input type="radio" class="FieldRadioOpt__input" name='genres' value='other' required>
						<input type="text" class="FieldRadioOpt__inputText" name='genres_other'
							placeholder='Свой вариант' minlength="3">
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="Form__item">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Вы отправили</div>
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='albumortrack' value='Альбом' required>
						<span class="FieldRadioOpt__name">Альбом</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='albumortrack' value='Трек' required>
						<span class="FieldRadioOpt__name">Трек</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<!-- isAlbum -->
	<div class="Form__item flex" data-branch='isAlbum' style="display: none;">
		<label class="Field">
			<input class='Field__input' type="text" name='album_track[]' placeholder='Название трека'>
			<span class="Field__name">Укажите название трека</span>
		</label>
		<a href="#" class="Field__add" data-field='album_track[]'><i></i> <span>Добавить название</span></a>
		<a href="#" class="Field__remove" data-field='album_track[]'><i></i> <span>Удалить поле</span></a>
	</div>
	<!-- /isAlbum -->
	<!-- isTrack -->
	<div class="Form__item" data-branch='isTrack' style="display: none;">
		<label class="Field">
			<input class='Field__input' type="text" name='album_track[]' placeholder='Название трека'>
			<span class="Field__name">Укажите название трека</span>
		</label>
	</div>
	<!-- /isTrack -->


	<div class="Form__item">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Нуждается ли демка в доработке</div>
			<div class="FieldRadio__info FieldInfo">
				<a class="FieldInfo__ico"></a>
				<div class="FieldInfo__text">ТЕКСТ ПОДСКАЗКИ</div>
			</div>
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='finishwork' value='Да' required>
						<span class="FieldRadioOpt__name">Да</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='finishwork' value='Нет' required>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="Form__item">
		<label class="Field">
			<textarea class='Field__input Field__input--text' name='otherinfo'
				placeholder="Хотите что-то добавить?"></textarea>
			<span class="Field__name">Хотите что-то добавить?</span>
		</label>
	</div>
	<div class="Form__item Form__item--bttn">
		<button class='Form__bttn Bttn'>Отправить</button>
	</div>
	<div class="Form__item Form__item--info">
		Зачем это надо&nbsp;<div class="FieldInfo">
			<a class="FieldInfo__ico"></a>
			<div class="FieldInfo__text">Мы автоматизировали процесс отправки демо, чтобы в будущем минимизировать
				количество вопросов.</div>
		</div>
	</div>
	<div class="Form__bottom">
		Нажимая на кнопку, вы даете согласие на <a href="/privacy/">обработку
			персональных данных</a> и соглашаетесь с <a href="/privacy/">политикой конфиденциальности</a>
	</div>
</form>