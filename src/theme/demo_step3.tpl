<form action="" method='POST' class='Form'>
	<input type="hidden" name="send_step" value='true'>
	<div class="Profile__alert">
		<br>
		<br>
		<br>
		<div class="tac">
			<b style="font-weight: 500;">Перед заполнением данных ознакомьтесь с договором</b>
			<br>
			<br>
			<a style="text-decoration: underline;" target="_blank" href="/upload/contract/contract_template.doc">Открыть договор</a>
		</div>
	</div>
	<br>
	[{ NOT_DATA }]
	<div class="Form__item Form__item--noafter">
		<label class="Field">
			<input class='Field__input' type="text" name='lastname' placeholder='Введите вашу фамилию' required>
			<span class="Field__name">Фамилия <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='firstname' placeholder='Введите ваше имя' required>
			<span class="Field__name">Имя <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='secondname' placeholder='Введите ваше отчество' required>
			<span class="Field__name">Отчество <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="date" name='birthday' placeholder='Укажите дату рождения' required>
			<span class="Field__name">Дата рождения <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' value="[{ ПОЧТА }]" type="text" name='email' placeholder='Введите вашу почта'
				required>
			<span class="Field__name">Почта <span></span></span>
		</label>
	</div>
	<div class="Form__item ">
		<label class="Field">
			<input class='Field__input' type="text" name='phone' placeholder='Введите ваш телефон' required>
			<span class="Field__name">Телефон <span></span></span>
		</label>
	</div>
	<div class="Form__tracksTabTitle Form__tracksTabTitle--full">Паспортные данные</div>
	<div class="Form__item Form__item--noafter">
		<label class="Field">
			<input class='Field__input' type="text" name='series' placeholder='Введите серию паспорта' required>
			<span class="Field__name">Серия <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='number' placeholder='Введите номер паспорта' required>
			<span class="Field__name">Номер <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='issuedby' placeholder='Укажите кем выдан' required>
			<span class="Field__name">Кем выдан <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="date" name='whenissued' placeholder='Укажите когда выдан' required>
			<span class="Field__name">Когда выдан <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='departmentcode' placeholder='Укажите код подразделения'
				required>
			<span class="Field__name">Код подразделения <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='registrationaddress' placeholder='Укажите адрес регистрации'
				required>
			<span class="Field__name">Адрес регистрации <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='location' placeholder='Укажите место жительства'
				required>
			<span class="Field__name">Место жительства <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='index' placeholder='Укажите индекс' required>
			<span class="Field__name">Индекс <span></span></span>
		</label>
	</div>

    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Тип лица<span></span></div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='8' type="radio" class="FieldRadioOpt__input"
                            name='type' value='Физ лицо' required>
                        <span class="FieldRadioOpt__name">Физ лицо</span>
                    </label>
                </div>
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='9' type="radio" class="FieldRadioOpt__input"
                            name='type' value='Юр лицо' required>
                        <span class="FieldRadioOpt__name">Юр лицо</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
	<div class="Form__item" data-branch='type_fiz' style='display: none;'>
		<label class="Field">
			<input class='Field__input' type="text" name='INN' placeholder='Укажите ИНН'>
			<span class="Field__name">ИНН <span></span></span>
		</label>
	</div>
	<div class="Form__item" data-branch='type_ur' style='display: none;'>
		<label class="Field">
			<input class='Field__input' type="text" name='OGRNIP' placeholder='Укажите ОГРНИП'>
			<span class="Field__name">ОГРНИП <span></span></span>
		</label>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			toggleBranch('type', 'Физ лицо', 'type_fiz'/* , ['releasedNowYes[{ ID }]'] */);
			toggleBranch('type', 'Юр лицо', 'type_ur'/* , ['releasedNowYes[{ ID }]'] */);
		});
	</script>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='SNILS' placeholder='Укажите СНИЛС'>
			<span class="Field__name">СНИЛС<span></span></span>
		</label>
	</div>
	<div class="Form__tracksTabTitle Form__tracksTabTitle--full">Банковские реквизиты</div>
	<div class="Form__item Form__item--noafter">
		<label class="Field">
			<input class='Field__input' type="text" name='bankname' placeholder='Введите название банка' required>
			<span class="Field__name">Название банка <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='checkingaccount' placeholder='Введите расчетный счет' required>
			<span class="Field__name">Расчетный счет <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='correspondentaccount'
				placeholder='Введите корреспондентский счет' required>
			<span class="Field__name">Корреспондентский счет <span></span></span>
		</label>
	</div>
	<div class="Form__item">
		<label class="Field">
			<input class='Field__input' type="text" name='BIK' placeholder='Введите БИК банка' required>
			<span class="Field__name">БИК <span></span></span>
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
	[{ /NOT_DATA }]
	[{ HAVE_DATA }]
	<div class="Form__tracksTabTitle Form__tracksTabTitle--full">Данные записаны в систему, теперь вы можете скачать подготовленный договор для подписи и заключения</div>
	<div class="Form__item Form__item--noafter">
		<a href='/r/[{ REQUEST_ID }]/download/doc/' class='Form__bttn Bttn'>Скачать договор</a>
	</div>
	[{ /HAVE_DATA }]
</form>