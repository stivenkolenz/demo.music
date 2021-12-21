<form action="" method='POST' class='Form'>
	<input type="hidden" name="send_step" value='true'>

	<div class="Form__item">
		<div class="FieldRadio">
			[{ ISALBUM }]<div class="FieldRadio__name FieldRadio__name--req">Есть ли трекауты/исходные проекты
				сохраненные на все
				песни?</div>[{ /ISALBUM }]
			[{ ISTRACK }]<div class="FieldRadio__name FieldRadio__name--req">Есть ли трекауты/исходные проекты
				сохраненные песню?</div>[{ /ISTRACK }]
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='source_projects' value='Да' required>
						<span class="FieldRadioOpt__name">Да</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='source_projects' value='Нет' required>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="Form__item">
		<div class="FieldRadio">
			[{ ISALBUM }]<div class="FieldRadio__name FieldRadio__name--req">Издавался ли ранее альбом?</div>[{ /ISALBUM
			}]
			[{ ISTRACK }]<div class="FieldRadio__name FieldRadio__name--req">Издавался ли ранее трек?</div>[{ /ISTRACK
			}]
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='released' value='Да' required>
						<span class="FieldRadioOpt__name">Да</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='released' value='Нет' required>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<!-- releasedYes -->
	<div class="Form__item" data-branch='releasedYes' style="display: none;">
		<label class="FieldMultiple">
			<span class="FieldMultiple__name">Где издавался?</span>
			<div class="FieldMultiple__input">
				<input type="text" class='FieldMultiple__field' name='release_platforms' readonly>
			</div>
			<div class="FieldMultiple__opts flex flex--aic flex--jcs">
				<a href="#" class="FieldMultiple__opt">BOOM</a>
				<a href="#" class="FieldMultiple__opt">VK Music</a>
				<a href="#" class="FieldMultiple__opt">Yandex Music</a>
				<a href="#" class="FieldMultiple__opt">Spotify</a>
				<a href="#" class="FieldMultiple__opt">Apple Music</a>
				<a href="#" class="FieldMultiple__opt">ITunes</a>
				<a href="#" class="FieldMultiple__opt">YouTube Music</a>
				<a href="#" class="FieldMultiple__opt">TikTok</a>
				<a href="#" class="FieldMultiple__opt">Deezer</a>
				<a href="#" class="FieldMultiple__opt">СберЗвук</a>
			</div>
		</label>
	</div>
	<div class="Form__item" data-branch='releasedYes' style="display: none;">
		<label class="Field">
			<textarea class='Field__input Field__input--text' name='release_message'
				placeholder="Введите комментарий"></textarea>
			<span class="Field__name">Комментарий своими словами</span>
		</label>
	</div>
	<div class="Form__item" data-branch='releasedYes' style="display: none;">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Издан ли сейчас?</div>
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='released_now' value='Да'>
						<span class="FieldRadioOpt__name">Да</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='released_now' value='Нет'>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<!-- releasedNowYes -->
	<div class="Form__item" data-branch='releasedNowYes' style="display: none;">
		<label class="FieldMultiple">
			<span class="FieldMultiple__name">Где издан?</span>
			<div class="FieldMultiple__input">
				<input type="text" class='FieldMultiple__field' name='releasednow_platforms' readonly>
			</div>
			<div class="FieldMultiple__opts flex flex--aic flex--jcs">
				<a href="#" class="FieldMultiple__opt">BOOM</a>
				<a href="#" class="FieldMultiple__opt">VK Music</a>
				<a href="#" class="FieldMultiple__opt">Yandex Music</a>
				<a href="#" class="FieldMultiple__opt">Spotify</a>
				<a href="#" class="FieldMultiple__opt">Apple Music</a>
				<a href="#" class="FieldMultiple__opt">ITunes</a>
				<a href="#" class="FieldMultiple__opt">YouTube Music</a>
				<a href="#" class="FieldMultiple__opt">TikTok</a>
				<a href="#" class="FieldMultiple__opt">Deezer</a>
				<a href="#" class="FieldMultiple__opt">СберЗвук</a>
			</div>
		</label>
	</div>
	<!-- <div class="Form__item" data-branch='releasedNowYes' style="display: none;">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Выберите платформы</div>
			<div class="FieldRadio__opts FieldRadio__opts--two">
				<div class="FieldRadio__opt FieldRadio__opt--two">
					<label class="FieldRadioOpt">
						<input type="checkbox" class="FieldRadioOpt__input" name='releasednow_platforms[]'
							value='Название платформы'>
						<span class="FieldRadioOpt__name">Название платформы</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--two">
					<label class="FieldRadioOpt">
						<input type="checkbox" class="FieldRadioOpt__input" name='releasednow_platforms[]'
							value='Название платформы'>
						<span class="FieldRadioOpt__name">Название платформы</span>
					</label>
				</div>
			</div>
		</div>
	</div> -->
	<!-- /releasedNowYes -->
	<!-- /releasedYes -->


	<div class="Form__item">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Есть ли договор между автором музыки и исполнителем?
			</div>
			<!-- <div class="FieldRadio__info FieldInfo">
				<a class="FieldInfo__ico"></a>
				<div class="FieldInfo__text">ТЕКСТ ПОДСКАЗКИ</div>
			</div> -->
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt FieldRadio__opt--line">
					[{ ISALBUM }]<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='doc_authors' value='Да, на все песни'
							required>
						<span class="FieldRadioOpt__name">Да, на все песни</span>
					</label>[{ /ISALBUM }]
					[{ ISTRACK }]<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='doc_authors' value='Да' required>
						<span class="FieldRadioOpt__name">Да</span>
					</label>[{ /ISTRACK }]
				</div>
				[{ ISALBUM }]<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt FieldRadioOpt--text FieldRadioOpt--wrap">
						<input type="radio" class="FieldRadioOpt__input" name='doc_authors' value='other' required>
						<div class="FieldTracks" data-name='doc_authors_other'>
							<div class="FieldTracks__title"><span>Выберите треки</span></div>
							<div class="FieldTracks__list">
								[{ TRACKS_LIST }]
							</div>
						</div>
						<span>Да, кроме этой: </span>
						<input type="hidden" class="FieldRadioOpt__inputText" name='doc_authors_other'
							placeholder='Название песни' minlength="3">
					</label>
				</div>[{ /ISALBUM }]
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='doc_authors' value='Нет' required>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<!-- doc_authorsNo -->
	<div class="Form__item" data-branch='doc_authorsNo' style="display: none;">
		<label class="Field">
			<input class='Field__input' type="text" name='doc_authorsno_text' placeholder='Комментарий'>
			<span class="Field__name">Почему нет договора между автором музыки и исполнителем</span>
		</label>
	</div>
	<!-- /doc_authorsNo -->

	<div class="Form__item">
		<div class="FieldRadio">
			<div class="FieldRadio__name FieldRadio__name--req">Кто занимается сведением материала?</div>
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='material_join' value='Я сам' required>
						<span class="FieldRadioOpt__name">Я сам</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='material_join' value='Один человек'
							required>
						<span class="FieldRadioOpt__name">Один человек</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='material_join' value='Разные люди'
							required>
						<span class="FieldRadioOpt__name">Разные люди</span>
					</label>
				</div>
				<div class="FieldRadio__opt FieldRadio__opt--line">
					<label class="FieldRadioOpt FieldRadioOpt--text">
						<input type="radio" class="FieldRadioOpt__input" name='material_join' value='other' required>
						<input type="text" class="FieldRadioOpt__inputText" minlength="3" name='material_join_other'
							placeholder='Свой вариант' minlength="2">
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="Form__item">
		<div class="FieldRadio">
			[{ ISALBUM }]<div class="FieldRadio__name FieldRadio__name--req">Есть ли обложка на альбом?</div>[{ /ISALBUM
			}]
			[{ ISTRACK }]<div class="FieldRadio__name FieldRadio__name--req">Есть ли обложка на трек?</div>[{ /ISTRACK
			}]
			<div class="FieldRadio__opts">
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='cover' value='Да' required>
						<span class="FieldRadioOpt__name">Да</span>
					</label>
				</div>
				<div class="FieldRadio__opt">
					<label class="FieldRadioOpt">
						<input type="radio" class="FieldRadioOpt__input" name='cover' value='Нет' required>
						<span class="FieldRadioOpt__name">Нет</span>
					</label>
				</div>
			</div>
		</div>
	</div>
	<!-- coverYes -->
	<div class="Form__item" data-branch='coverYes' style="display: none;">
		<label class="Field">
			<input class='Field__input' type="text" name='coverYes_link' placeholder='Укажите ссылку на обложку'>
			<span class="Field__name">Ссылка на обложку</span>
		</label>
	</div>
	<!-- /coverYes -->


	<div class="Form__item">
		<label class="Field">
			<textarea class='Field__input Field__input--text' name='otherinfo'
				placeholder="Виденик о будущем в свободной форме" required></textarea>
			<span class="Field__name">Ваш комментарий</span>
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