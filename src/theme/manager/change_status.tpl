<form action="" class='Form' method='POST'>
    <div class="Form__item Form__item--noafter">
        <label class="Field">
            <select name="status" class='Field__input' required>
                <option value="">Выберите статус</option>
                <!-- <option value="open">Открыто для пользователя</option> -->
                <!-- <option value="close">Закрыто для пользователя</option> -->
                <!-- <option value="send">Отправлено пользователем</option> -->
                <option value="info">Отправить пользователю вопрос по его этапу</option>
                <option value="ok">Пройдено</option>
                <option value="fail">Отклонено</option>
            </select>
            <span class="Field__name">Сменить статус этапа на:<span></span></span>
        </label>
    </div>
    <div class="Form__item">
		<label class="Field">
			<textarea class="Field__input Field__input--text" name="otherinfo" placeholder="Введите текст если появились вопросы по этому этапу"></textarea>
			<span class="Field__name">Вопросы к этапу<span></span></span>
		</label>
	</div>
    <div class="Form__item Form__item--noafter">
        <div class="FieldRadio">
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input type="checkbox" class="FieldRadioOpt__input" name="track[1][haveproject]" value="Да" required="">
                        <span class="FieldRadioOpt__name">я все внимательно проверил</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <button class='changeStatus__bttn Bttn'>Отправить</button>
    <input type="hidden" name='step_id' value='[{ STEP_ID }]'>
    <input type="hidden" name='change_status' value='1'>
</form>