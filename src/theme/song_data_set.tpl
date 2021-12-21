<form action="" method='POST' class='Form'>
    <input type="hidden" name="save_song" value='true'>
    <div class="tracksTabs__label" data-id="[{ ID }]"></div>
    <div class="Form__tracksTabTitle">Редактирование трека<br><span>[{ NAME }]</span></div>
    <div class="Form__item Form__item--noafter">
        <label class="Field">
            <textarea data-field='20' class='Field__input Field__input--text' name='track[[{ ID }]][text]' placeholder="Введите текст песни" required>[{ FIELD_20 }]</textarea>
            <span class="Field__name FieldRadio__name--req">Текст песни<span></span></span>
        </label>
    </div>
    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Есть ли трекауты/исходный проект для
                песни?<span></span></div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='0' [{ FIELD_0 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][haveproject]' value='Да' required>
                        <span class="FieldRadioOpt__name">Да</span>
                    </label>
                </div>
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='1' [{ FIELD_1 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][haveproject]' value='Нет' required>
                        <span class="FieldRadioOpt__name">Нет</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Издавался ли ранее трек?<span></span></div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='2' [{ FIELD_2 }] type="radio" class="FieldRadioOpt__input" name='track[[{ ID }]][released]'
                            value='Да' required>
                        <span class="FieldRadioOpt__name">Да</span>
                    </label>
                </div>
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='3' [{ FIELD_3 }] type="radio" class="FieldRadioOpt__input" name='track[[{ ID }]][released]'
                            value='Нет' required>
                        <span class="FieldRadioOpt__name">Нет</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: [{ releasedYes }];">
        <label class="FieldMultiple">
            <span class="FieldMultiple__name">На каких площадках?</span>
            <div class="FieldMultiple__input">
                <input data-field='4' value="[{ FIELD_4 }]" type="text" class='FieldMultiple__field'
                    name='track[[{ ID }]][release_platforms]' style='opacity: 0;'>
                [{ platforms_set }]
            </div>
            <div class="FieldMultiple__opts flex flex--aic flex--jcs">
                [{ platforms }]
            </div>
        </label>
    </div>
    <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: [{ releasedYes }];">
        <label class="Field">
            <textarea data-field='0' class='Field__input Field__input--text' name='track[[{ ID }]][release_message]'
                placeholder="Введите комментарий">[{ FIELD_5 }]</textarea>
            <span class="Field__name">Комментарий своими словами<span></span></span>
        </label>
    </div>
    <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: [{ releasedYes }];">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Издан ли сейчас?<span></span></div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='5' [{ FIELD_6 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][released_now]' value='Да'>
                        <span class="FieldRadioOpt__name">Да</span>
                    </label>
                </div>
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='6' [{ FIELD_7 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][released_now]' value='Нет'>
                        <span class="FieldRadioOpt__name">Нет</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="Form__item" data-branch='releasedNowYes[{ ID }]' style="display: [{ releasedNowYes }];">
        <label class="Field">
            <input data-field='7' value="[{ FIELD_8 }]" class='Field__input' type="text" name='track[[{ ID }]][releasenow_label]'
                placeholder='Название лейбла'>
            <span class="Field__name">Кем издан?<span></span></span>
        </label>
    </div>
    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Есть ли договор между автором музыки и
                исполнителем?<span></span>
                <div class="FieldRadio__info FieldInfo">
                    <a class="FieldInfo__ico"></a>
                    <div class="FieldInfo__text">ТЕКСТ ПОДСКАЗКИ</div>
                </div>
            </div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt">
                        <input data-field='8' [{ FIELD_9 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][doc_authors]' value='Да' required>
                        <span class="FieldRadioOpt__name">Да</span>
                    </label>
                </div>
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt">
                        <input data-field='9' [{ FIELD_10 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][doc_authors]' value='Нет' required>
                        <span class="FieldRadioOpt__name">Нет</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- doc_authorsNo -->
    <div class="Form__item" data-branch='doc_authorsNo[{ ID }]' style="display: [{ doc_authors }];">
        <label class="Field">
            <input data-field='10' value="[{ FIELD_11 }]"" class='Field__input' type="text" name='track[[{ ID }]][doc_authorsno_text]'
                placeholder='Комментарий'>
            <span class="Field__name">Почему нет договора между автором музыки и исполнителем<span></span></span>
        </label>
    </div>
    <!-- /doc_authorsNo -->
    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Кто занимается сведением материала?<span></span>
            </div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt">
                        <input data-field='11' [{ FIELD_12 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][material_join]' value='Я сам' required>
                        <span class="FieldRadioOpt__name">Я сам</span>
                    </label>
                </div>
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt">
                        <input data-field='12' [{ FIELD_13 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][material_join]' value='Один человек' required>
                        <span class="FieldRadioOpt__name">Один человек</span>
                    </label>
                </div>
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt">
                        <input data-field='13' [{ FIELD_14 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][material_join]' value='Разные люди' required>
                        <span class="FieldRadioOpt__name">Разные люди</span>
                    </label>
                </div>
                <div class="FieldRadio__opt FieldRadio__opt--line">
                    <label class="FieldRadioOpt FieldRadioOpt--text">
                        <input data-field='14' [{ FIELD_15 }] type="radio" class="FieldRadioOpt__input"
                            name='track[[{ ID }]][material_join]' value='other' required>
                        <input data-field='15' value="[{ FIELD_16 }]" type="text" class="FieldRadioOpt__inputText" minlength="3"
                            name='track[[{ ID }]][material_join_other]' placeholder='Свой вариант' minlength="2">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="Form__item">
        <div class="FieldRadio">
            <div class="FieldRadio__name FieldRadio__name--req">Есть ли обложка на трек?<span></span></div>
            <div class="FieldRadio__opts">
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='16' [{ FIELD_17 }] type="radio" class="FieldRadioOpt__input" name='track[[{ ID }]][cover]'
                            value='Да' required>
                        <span class="FieldRadioOpt__name">Да</span>
                    </label>
                </div>
                <div class="FieldRadio__opt">
                    <label class="FieldRadioOpt">
                        <input data-field='17' [{ FIELD_18 }] type="radio" class="FieldRadioOpt__input" name='track[[{ ID }]][cover]'
                            value='Нет' required>
                        <span class="FieldRadioOpt__name">Нет</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- coverYes -->
    <div class="Form__item" data-branch='coverYes[{ ID }]' style="display: [{ coverYes }];">
        <label class="Field">
            <input data-field='18' value="[{ FIELD_19 }]"" class='Field__input' type="text" name='track[[{ ID }]][coverYes_link]'
                placeholder='Укажите ссылку на обложку'>
            <span class="Field__name">Ссылка на обложку <span></span></span>
        </label>
    </div>
    <!-- /coverYes -->
    <div class="Form__item Form__item--bttn">
        <button class='Form__bttn Bttn'>Сохранить</button>
    </div>
    <!-- <div class="Form__item Form__item--info">
        Зачем это надо&nbsp;<div class="FieldInfo">
            <a class="FieldInfo__ico"></a>
            <div class="FieldInfo__text">Мы автоматизировали процесс отправки демо, чтобы в будущем минимизировать
                количество вопросов.</div>
        </div>
    </div> -->
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toggleBranch('track[[{ ID }]][released]', 'Да', 'releasedYes[{ ID }]', ['releasedNowYes[{ ID }]']);
        toggleBranch('track[[{ ID }]][released_now]', 'Да', 'releasedNowYes[{ ID }]');
        toggleBranch('track[[{ ID }]][doc_authors]', 'Нет', 'doc_authorsNo[{ ID }]');
        toggleBranch('track[[{ ID }]][cover]', 'Да', 'coverYes[{ ID }]');
    });
</script>