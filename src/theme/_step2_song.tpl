<div class="tracksTabs__track" data-id='[{ ID }]'>
    <a href="#" class="tracksTabs__trackClose" data-id='[{ ID }]'>
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.6569 12.657L1.34319 1.34334" stroke="black" stroke-linecap="round"></path>
            <path d="M12.6568 1.34334L1.34311 12.657" stroke="black" stroke-linecap="round"></path>
        </svg>
    </a>
    <div class="tracksTabs__trackWrap">
        <div class="Form__tracksTabTitle">[{ NAME }]</div>
        <div class="Form__item Form__item--noafter">
            <div class="FieldRadio">
                <div class="FieldRadio__name FieldRadio__name--req">Есть ли трекауты/исходный проект для
                    песни?<span></span></div>
                <div class="FieldRadio__opts">
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='0' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][haveproject]' value='Да' required>
                            <span class="FieldRadioOpt__name">Да</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='1' type="radio" class="FieldRadioOpt__input"
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
                            <input data-field='2' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][released]' value='Да' required>
                            <span class="FieldRadioOpt__name">Да</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='3' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][released]' value='Нет' required>
                            <span class="FieldRadioOpt__name">Нет</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: none;">
            <label class="FieldMultiple">
                <span class="FieldMultiple__name">На каких площадках?</span>
                <div class="FieldMultiple__input">
                    <input data-field='4' type="text" class='FieldMultiple__field'
                        name='track[[{ ID }]][release_platforms]' style='opacity: 0;'>
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
        <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: none;">
            <label class="Field">
                <textarea data-field='0' class='Field__input Field__input--text' name='track[[{ ID }]][release_message]'
                    placeholder="Введите комментарий"></textarea>
                <span class="Field__name">Комментарий своими словами<span></span></span>
            </label>
        </div>
        <div class="Form__item" data-branch='releasedYes[{ ID }]' style="display: none;">
            <div class="FieldRadio">
                <div class="FieldRadio__name FieldRadio__name--req">Издан ли сейчас?<span></span></div>
                <div class="FieldRadio__opts">
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='5' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][released_now]' value='Да'>
                            <span class="FieldRadioOpt__name">Да</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='6' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][released_now]' value='Нет'>
                            <span class="FieldRadioOpt__name">Нет</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="Form__item" data-branch='releasedNowYes[{ ID }]' style="display: none;">
            <label class="Field">
                <input data-field='7' class='Field__input' type="text" name='track[[{ ID }]][releasenow_label]'
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
                            <input data-field='8' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][doc_authors]' value='Да' required>
                            <span class="FieldRadioOpt__name">Да</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt FieldRadio__opt--line">
                        <label class="FieldRadioOpt">
                            <input data-field='9' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][doc_authors]' value='Нет' required>
                            <span class="FieldRadioOpt__name">Нет</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- doc_authorsNo -->
        <div class="Form__item" data-branch='doc_authorsNo[{ ID }]' style="display: none;">
            <label class="Field">
                <input data-field='10' class='Field__input' type="text" name='track[[{ ID }]][doc_authorsno_text]'
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
                            <input data-field='11' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][material_join]' value='Я сам' required>
                            <span class="FieldRadioOpt__name">Я сам</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt FieldRadio__opt--line">
                        <label class="FieldRadioOpt">
                            <input data-field='12' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][material_join]' value='Один человек' required>
                            <span class="FieldRadioOpt__name">Один человек</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt FieldRadio__opt--line">
                        <label class="FieldRadioOpt">
                            <input data-field='13' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][material_join]' value='Разные люди' required>
                            <span class="FieldRadioOpt__name">Разные люди</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt FieldRadio__opt--line">
                        <label class="FieldRadioOpt FieldRadioOpt--text">
                            <input data-field='14' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][material_join]' value='other' required>
                            <input data-field='15' type="text" class="FieldRadioOpt__inputText" minlength="3"
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
                            <input data-field='16' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][cover]' value='Да' required>
                            <span class="FieldRadioOpt__name">Да</span>
                        </label>
                    </div>
                    <div class="FieldRadio__opt">
                        <label class="FieldRadioOpt">
                            <input data-field='17' type="radio" class="FieldRadioOpt__input"
                                name='track[[{ ID }]][cover]' value='Нет' required>
                            <span class="FieldRadioOpt__name">Нет</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- coverYes -->
        <div class="Form__item" data-branch='coverYes[{ ID }]' style="display: none;">
            <label class="Field">
                <input data-field='18' class='Field__input' type="text" name='track[[{ ID }]][coverYes_link]'
                    placeholder='Укажите ссылку на обложку'>
                <span class="Field__name">Ссылка на обложку <span></span></span>
            </label>
        </div>
        <!-- /coverYes -->
        <button class="tracksTabs__trackSave Bttn" data-id='[{ ID }]'>Сохранить</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toggleBranch('track[[{ ID }]][released]', 'Да', 'releasedYes[{ ID }]', ['releasedNowYes[{ ID }]']);
        toggleBranch('track[[{ ID }]][released_now]', 'Да', 'releasedNowYes[{ ID }]');
        toggleBranch('track[[{ ID }]][doc_authors]', 'Нет', 'doc_authorsNo[{ ID }]');
        toggleBranch('track[[{ ID }]][cover]', 'Да', 'coverYes[{ ID }]');
    });
</script>