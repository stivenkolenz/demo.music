$(function(){
/* 	if ( 0 ) {

		const R = {
			id: REQ.id, // id заявки 
			questions: REQ.q, // Вопросы и заголовки к ним
			title_attr: 'title', // Заголовки вопросов
			answers: REQ.answers, // Текущие ответы
			setTitleAttr: function () {
				switch (REQ.answers[1]) {
					case 'Артист':
						this.title_attr += '_artist';
					break;
					case 'Дуэт':
						this.title_attr += '_duet';
					break;
					case 'Трио':
						this.title_attr += '_trio';
					break;
					case 'Группа':
						this.title_attr += '_group';
					break;
					case 'Бэнд':
						this.title_attr += '_band';
					break;
				}
			},
			q_id: REQ.q_num, // ID текущего вопроса
			nextQuestion: function () {
				if ( $(`.Mn__q.active :valid`).length == 0 && $(`.Mn__q.active`).length != 0 ) { // Проверка на наличие не заполненного поля
					$(`.Mn__q.active`).addClass('error');
					setTimeout(()=>{
						$(`.Mn__q.active`).removeClass('error');
					}, 1000);
				} else {
					let fd = new FormData($('#mnform')[0]);
					this.saveAnswer(this.q_id, fd.get(`q${this.q_id}`));
					this.q_id++;
					this.changeQbox();
				}
			},
			changeQbox: function () { // Переключаем блоки с вопросами
				$('#mnform').attr('data-q-num', this.q_id);
				$(`.Mn__q.active [data-required]`).removeAttr('required');
				$(`.Mn__q.active`).removeClass('active').addClass('finish');
				$(`.Mn__q[data-q="${this.q_id}"]`).addClass('active');
				$(`.Mn__q.active [data-required]`).attr('required', true);
				// if ( $(`.Mn__q.active .Q__title`).length != 0 || this.questions[this.q_id] == undefined ) {
					$(`.Mn__q.active .Q__title`).text(this.questions[this.q_id][R.title_attr]);
				// }
			},
			loadQ: function () { // Загрузка вопроса
				let next_q_id = false;
				$.post(`/req/${this.id}/q/`, {},
					function (data, textStatus, jqXHR) {
						console.log(data);
						// $this.q_id = data.q_id;
						next_q_id = data.q_id;
					},
					"json"
				);
				console.log(next_q_id);
				this.q_id = next_q_id;
			},

			saveAnswer: function (q, a) {
				this.answers[q] = a;
				$.post(`/req/${this.id}/save/`, {req_id: REQ.id, q_id: q, answer: a},
					function (data, textStatus, jqXHR) {
						console.log(`data`, data);
					},
					"json"
				);
			},

			start: function () { // Отображаем блок с вопросом
				this.setTitleAttr();
				this.q_id++;
				this.changeQbox();
				
				this.qWrapHeight();
				setTimeout(()=>{
					$(`.Mn__list.hide`).removeClass('hide');
				}, 1000);
			},
			qWrapHeight: function () { // Высота блока для вопроса
				let h = $(`.Mn__q.active`).outerHeight();
				$(`.qWrap`).height(h+'px');
			},
		};

	

		R.start();

		console.log(R);
		// console.log(REQ);

		$(`#mnform button`).click(function(event){
			event.preventDefault();
			R.nextQuestion();
			R.qWrapHeight();
		});
	} */

	var reqApp = {
		$form: $(`#mnform`),
		question_id: 1,
		REQ: null,
		q: {},
		init: function () {
			this.REQ = JSON.parse($(`#req`).val());
			this.q_id();
			this.toggleQuestion();
			setTimeout(()=>{
				this.$form.removeClass('hide');
			}, 300);
			setTimeout(()=>{
				// $(`#prevQ`).click();
			}, 100);
		},
		q_id: function (id = false, set = false) {
			this.question_id = ( id ? id : $(`[data-q-num]`).attr('data-q-num') );
			if ( set )
				$(`[data-q-num]`).attr('data-q-num', this.question_id);
		},
		qWrapHeight: function () {
			$(`[data-required]`).attr('required', true);
			$(`.qWrap`).css('min-height', $(`[data-q].active`).outerHeight()+'px');
		},
		toggleQuestion: function () { // Переключение блоков с вопросами
			$(`[data-q].active`).addClass('delete finish');
			$(`[data-q].active`).removeClass('active');
			setTimeout(() => {
				$(`[data-q='${this.question_id}']`).addClass('active');
				this.qWrapHeight();
				this.setAnswer();
			}, 100);
			setTimeout(function () {
				$(`[data-q].delete`).remove();
			}, 1000);
			if ( ['1', '16', 1, 16, 18, '18'].includes(this.question_id) ) {
				$(`#prevQ`).addClass('disable');
			} else {
				$(`#prevQ`).removeClass('disable');
			}
		},
		addQuestion: function (q) { // Добавление вопроса в DOM-дерево
			// $('#mnform').attr('data-q-num', q.id);
			// console.log(q);
			this.q = q; // Сохраняем данные по вопросу
			this.q_id(q.id, q.id);
			$('.qWrap').prepend(q.code);
			this.toggleQuestion();
		},
		checkAnswer: function () { // Проверка на наличие не заполненного поля
			if ( $(`[data-q].active :valid`).length == 0 && $(`[data-q].active`).length != 0 ) { 
				$(`[data-q].active`).addClass('error');
				setTimeout(()=>{
					$(`[data-q].active`).removeClass('error');
				}, 1000);
				return false;
			}
			return true;
		},

		answers: {}, // Ответы в форме
		get_answers: function (prevq = false) {
			this.answers = {};
			if ( prevq ) {
				this.answers[this.question_id] = '';
				return this.answers;
			}
			let fd = new FormData($('#mnform')[0]);
			// console.log(fd.get('14[]'));
			for(let [name, value] of fd) {
				// this.answers[name] = value;
				// console.log(typeof this.answers[name]);
				if ( typeof this.answers[name] == 'undefined') {
					this.answers[name] = value;
				} else if ( typeof this.answers[name] == 'string' ) {
					if ( value.length > 0 ) {
						let arr = [];
						arr.push(this.answers[name]);
						arr.push(value);
						this.answers[name] = arr;
					}
				} else if ( typeof this.answers[name] == 'object' ) {
					if ( value.length > 0 ) {
						this.answers[name].push(value);
					}
				}
				// console.log(`${name} => ${value}`);
			};
			// console.log(this.answers);
			return this.answers;
		},

		cloneField: function (answer = false) {
			// console.log(answer);
			// console.log($(`[data-q] input[required]:invalid`).length);
			// if ( $(`[data-q] input[required]:invalid`).length != 0 ) {
			if ( $(`[data-q] input[required]:invalid`).length > 0 && answer == false ) {
				showSMSG('У вас и так есть пустое поле, заполните его и добавьте новое');
			} else {
				let field = $(`[data-q].active [data-original]`).clone();
				field.val('');
				field.removeAttr('data-original');
				$('[data-q].active .Q__answr').append(field);
				this.qWrapHeight();
			}
		},

		setAnswer: function () {
			// console.log(this.q);
			if ( this.q.type == undefined ) return false;
			if ( this.q.answer == undefined || this.q.answer == null ) return false;

			let qBox = $(`[data-q='${this.q.id}']`);
			let type = this.q.type;
			// console.log('type', type);
			let answer = this.q.answer;
			// console.log(answer);
			switch (type) {
				case 'select':
					qBox.find(`option[value='${answer}']`).prop('selected', true);
				break;

				case 'text':
					if ( this.q.question.options.clone == true && typeof answer == 'object') {
						if ( answer.length > 1 ) {
							let howClone = answer.length - 1;
							for (let index = 0; index < howClone; index++)
								this.cloneField(1);

							let index = 0;
							qBox.find(`input`).each(function(){
								$(this).val(answer[index]);
								index++;
							});
						} else {
							qBox.find(`input`).val(answer);
						}
					} else {
						qBox.find(`input`).val(answer);
					}
				break;

				case 'platforms':
				break;

				case 'textlist':
					qBox.find(`input`).val(answer);
				break;

				case 'radio':
					qBox.find(`input[value='${answer}']`).prop('checked', true);
				break;

				case 'checkbox':
					qBox.find(`input[value='${answer}']`).prop('checked', true);
				break;

				case 'url':
					qBox.find(`input`).val(answer);
				break;

				case 'songslist':
				break;

				case 'textarea':
					qBox.find(`textarea`).val(answer);
				break;

				case 'custom':
					if ( qBox.find(`[value='${answer}']`).length == 1 ) {
						qBox.find(`[value='${answer}']`).prop('selected', true);
					} else {
						qBox.find(`select`).find('option:last').before(`<option value="${answer}">${answer}</option>`);
						qBox.find(`[value='${answer}']`).prop('selected', true);
						
						// let field = this.customAnswer();
						// qBox.find(`select`).find(`option:first`).prop('selected', true);
						// qBox.find(`select`).attr('disabled', true);
						// qBox.find(`select`).after(field);
						// $(`input[name='${this.question_id}']`).val(answer).focus();
					}
					// console.log(qBox.find(`[value='${answer}']`));
				break;

			}
		},

		saveLink: function (prev = false) {
			let link = ``;
			if ( this.REQ.song ) {
				link = `/req/${this.REQ.id}/stage/${this.REQ.stage}/song/${this.REQ.song}/save/`;
			} else {
				link = `/req/${this.REQ.id}/stage/${this.REQ.stage}/save/`;
			}
			if ( prev ) {
				link += 'prev/';
			}
			return link;
		},
		endLink: function () {
			return `/req/${this.REQ.id}/`;
		},

		customAnswer: function () {
			return `
				<input type='text' name='${this.question_id}' required placeholder='Введите свой вариант' class="customAnswer">
				<a href="#" class="customAnswerForward">Выбрать вариант из списка</a>
			`;
		}
	}

	reqApp.init();
	console.log(reqApp.REQ);

	$(`#nextQ`).click(function(event){
		event.preventDefault();
		if (reqApp.checkAnswer()) {
			// console.log(reqApp.saveLink());
			$.post(reqApp.saveLink(), reqApp.get_answers(), function (data, textStatus, jqXHR) {
					console.log(data);
					if ( data.status == 'error' ) {
						showSMSG(data.info);
					} else if (data.status == 'end') {
						window.location.href = reqApp.endLink();
					} else {
						reqApp.addQuestion(data.q);
					}
				}, "json"
				// }, "text"
			);
		}
	});
	$(`#prevQ`).click(function(event){
		event.preventDefault();
		// console.log(reqApp.get_answers());
		$.post(reqApp.saveLink(1), reqApp.get_answers(1), function (data, textStatus, jqXHR) {
				console.log(data);
				reqApp.addQuestion(data.q);
			}, "json"
		);
	});

	// $(`#prevQ`).click();

	$(document).on('click', '[cloneField]', function (event) {
		event.preventDefault();
		reqApp.cloneField();
	});
	$(document).on('change', `.Platforms input`, function (event) {
		// event.preventDefault();
		// reqApp.cloneField();
		let id = $(this).attr('id');
		$(`label[for=${id}]`).toggleClass('active');
		console.log($(`.Platforms input:checked`));
		if ( $(`.Platforms input:checked`).length < 1 ) {
			$(`.Platforms .Platforms__active`).removeClass('isset');
		} else {
			$(`.Platforms .Platforms__active`).addClass('isset');
		}
		console.log($(this));
	});

	$(document).on('change', `[data-select-custom]`, function () {
		// console.log($(this).val());
		if ( $(this).val() == 'custom' ) {
			let field = reqApp.customAnswer();
			$(this).find(`option:first`).prop('selected', true);
			$(this).attr('disabled', true);
			$(this).after(field);
			$(`input[name='${reqApp.question_id}']`).focus();
			// console.log(reqApp);
		}
	});
	$(document).on('click', `.customAnswerForward`, function (event) {
		event.preventDefault();
		$(this).remove();
		$(`input.customAnswer`).remove();
		$(`[data-select-custom]`).attr('disabled', false).focus();
	});
	$(document).on('change', `input[name='11']`, function ( ) {
		let res = checkCloudLink($(this).val());
		// console.log(res);
		if ( res.status == false ) {
			showSMSG(res.msg);
			// $(this).val('');
		}
	});
});