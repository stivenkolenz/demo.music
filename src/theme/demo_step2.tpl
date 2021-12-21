<form action="" method='POST' class='Form'>
	<input type="hidden" name="send_step" value='true'>
	<div class="Form__tracksTab">
		<div class="FieldInfo FieldInfo--center">
			<div class="FieldInfo__text">Какая-то Информация</div>
		</div>
		<div class="Form__tracksTabTitle">Заполните информацию <br>по добавленным трекам</div>
		<!-- <a href="#" class="Form__tracksTabCopy">Перенести ответы с первой песни на другие</a> -->
		<div class="tracksTabs">
			<div class="tracksTabs__labels">
				[{ SONG_LABELS }]
			</div>
			<div class="tracksTabs__tracks">
				[{ SONG_ITEMS }]
			</div>
		</div>
	</div>
	<div class="Form__item">
		<label class="Field">
			<textarea class='Field__input Field__input--text' name='otherinfo'
				placeholder="Виденик о будущем в свободной форме"></textarea>
			<span class="Field__name">Ваш комментарий<span></span></span>
		</label>
	</div>
	<div class="Form__item Form__item--bttn">
		<button class='Form__bttn Bttn'>Отправить</button>
	</div>
	<!-- <div class="Form__item Form__item--info">
		Зачем это надо&nbsp;<div class="FieldInfo">
			<a class="FieldInfo__ico"></a>
			<div class="FieldInfo__text">Мы автоматизировали процесс отправки демо, чтобы в будущем минимизировать
				количество вопросов.</div>
		</div>
	</div> -->
	<div class="Form__bottom">
		Нажимая на кнопку, вы даете согласие на <a href="/privacy/">обработку
			персональных данных</a> и соглашаетесь с <a href="/privacy/">политикой конфиденциальности</a>
	</div>
</form>