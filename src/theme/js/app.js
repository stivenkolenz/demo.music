"use strict";
const Cookie = {
	set: function (name, value, options = {}) {
		options = { path: '/', ...options };
		if ( options.day != undefined ) {
			options.expires = (new Date(Date.now() + (options.day * 24 * 60 * 60 * 1000))).toUTCString();
		} else {
			if (options.expires instanceof Date) options.expires = options.expires.toUTCString();
		}

		let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

		for (let optionKey in options) {
			updatedCookie += "; " + optionKey;
			let optionValue = options[optionKey];
			if (optionValue !== true) updatedCookie += "=" + optionValue;
		}

		document.cookie = updatedCookie;
	},
	remove: function (name) {
		this.set(name, '', { 'max-age': -1 });
	},
	get: function (name) {
		let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	},
	list: function () {
		let cookie = {};
		for (let item of document.cookie.split('; ')) {
			item = item.split('=');
			cookie[item[0]] = item[1];
		}
		return cookie;
	},
};

document.addEventListener('keydown', function (event) {
	if (event.code == 'KeyC') {
		console.log(Cookie.list());
	}
});

const pre = (str) => {
	console.log(str);
}

const showSMSG = (msg) => {
	document.querySelector('.SystemMessage').classList.remove('SystemMessage--show');

	setTimeout(() => {
		document.querySelector('.SystemMessage__text').innerHTML = `<b>${msg}</b><br>`;
		document.querySelector('.SystemMessage').classList.add('SystemMessage--show');
	}, 300);
}

const validURL = (str) => {
	var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
		'((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
		'(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
		'(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
	return !!pattern.test(str);
}

const checkCloudLink = (link) => {
	if (!validURL(link)) {
		return { status: false, msg: 'А это вообще не ссылка же :(' };
	}

	let url = new URL(link);

	if (url.host == 'vk.com' && url.pathname.indexOf('playlist') !== -1 || url.host == 'vk.com' && url.search.indexOf('playlist') !== -1) {
		return { status: false, msg: 'Мы не принимаем ссылки на плейлисты из вКонтакте. Укажите другую ссылку или платформу(Google Drive, Яндекс Диск, SoundCloud, Dropbox, Mega)' };
	}

	return { status: true, msg: url };
}


const openStepInfo = (step, isStep = true) => {
	step.classList.toggle((isStep ? 'step--show' : 'FieldInfo--show'));
};

const closeStepInfo = (isStep = true) => {
	document.querySelectorAll((isStep ? '.step' : '.FieldInfo')).forEach(step => {
		step.classList.remove((isStep ? 'step--show' : 'FieldInfo--show'));
	});
	document.querySelectorAll((!isStep ? '.step' : '.FieldInfo')).forEach(step => {
		step.classList.remove((!isStep ? 'step--show' : 'FieldInfo--show'));
	});
};

if (document.querySelector('.step') !== null) {

	document.querySelectorAll('.step').forEach(step => {
		/* step.addEventListener('mouseover', function (e) {
			step.classList.add( 'step--show' );
		});
		step.addEventListener('mouseout', function (e) {
			step.classList.remove( 'step--show' );
		}); */
		step.addEventListener('click', function (e) {
			if (step.classList.contains('step--show')) {
				closeStepInfo();
			} else {
				closeStepInfo();
				openStepInfo(step);
			}
		});
	});
}




if (document.querySelector('.Form') !== null) {

	document.querySelectorAll('.FieldInfo').forEach(step => {
		/* step.addEventListener('mouseover', function (e) {
			step.classList.add( 'FieldInfo--show' );
		});
		step.addEventListener('mouseout', function (e) {
			step.classList.remove( 'FieldInfo--show' );
		}); */

		step.addEventListener('click', function (e) {
			if (step.classList.contains('FieldInfo--show')) {
				closeStepInfo(0);
			} else {
				closeStepInfo(0);
				openStepInfo(step, 0);
			}
		});
	});

	document.querySelectorAll('label.Field').forEach(label => {
		label.addEventListener('click', function (e) {
			if (e.target.classList.contains('FieldInfo__ico')) {
				e.preventDefault();
			} else {
				closeStepInfo();
				return true;
			}
		});
	});



	document.querySelectorAll('.FieldRadioOpt--text').forEach(el => {
		el.addEventListener('click', function () {
			this.querySelector('input[type="text"]').focus();
		});
	});

	document.querySelectorAll('.FieldRadioOpt--text input[type="text"]').forEach(el => {
		el.addEventListener('focus', function (e) {
			let name = this.getAttribute('name');
			document.querySelectorAll(`input[type='radio'][name='${name}']`).forEach(input => {
				input.checked = false;
			});
			this.parentNode.querySelector("input[type='radio']").checked = true;
			this.required = true;
		});
		el.addEventListener('blur', function (e) {
			if (this.value.length > 2) {
				this.required = false;
			}
			this.parentNode.querySelector("input[type='radio']").value = this.value;
		});
	});

	if (document.querySelector('.cloudLink') !== null) document.querySelector('.cloudLink').addEventListener('change', function () {
		let res = checkCloudLink(this.value);
		// pre(res);
		if (!res.status) {
			showSMSG(res.msg);
			this.value = '';
			// this.focus();
		}
	});

	// if (document.querySelector('.cloudLink') !== null) document.querySelector('.cloudLink').value = 'https://disk.yandex.ru/d/H7HHrVWolos_8w';

	if (document.querySelectorAll("input[name='albumortrack']") !== null) document.querySelectorAll("input[name='albumortrack']").forEach(element => {
		// pre(element);
		element.addEventListener('change', function () {
			// pre( this.value );
			if (this.value == 'album') {
				document.querySelectorAll('.album').forEach(el => {
					el.style.display = 'block';
				});
				document.querySelectorAll('.track').forEach(el => {
					el.style.display = 'none';
				});
			} else {
				document.querySelectorAll('.album').forEach(el => {
					el.style.display = 'none';
				});
				document.querySelectorAll('.track').forEach(el => {
					el.style.display = 'block';
				});
			}
		});
	});

	if (document.querySelectorAll("input[name='release']") !== null) document.querySelectorAll("input[name='release']").forEach(element => {
		pre(element);
		element.addEventListener('change', function () {
			// pre( this.value );
			if (this.value == 'releaseYes') {
				document.querySelectorAll('.releaseYes').forEach(el => {
					el.style.display = 'block';
				});
				document.querySelectorAll('.releaseNo').forEach(el => {
					el.style.display = 'none';
				});
			} else {
				document.querySelectorAll('.releaseYes').forEach(el => {
					el.style.display = 'none';
				});
				document.querySelectorAll('.releaseNo').forEach(el => {
					el.style.display = 'block';
				});
			}
		});
	});

	var toggleBranch = (inputName, showValue, branchName, childrenLine = false) => {
		if (document.querySelectorAll(`input[name='${inputName}']`) == null) return false;
		document.querySelectorAll(`input[name='${inputName}']`).forEach(input => {
			input.addEventListener('change', function (e) {
				let r = (this.value == showValue ? true : false);
				let d = (this.value == showValue ? 'block' : 'none');
				document.querySelectorAll(`[data-branch='${branchName}']`).forEach(q => {
					q.querySelectorAll('input, textarea').forEach(field => {
						if( field.tagName != 'TEXTAREA' )
							field.required = r;
						if (!r) {
							if (field.type == 'radio' || field.type == 'checkbox') {
								field.checked = false;
							} else {
								field.value = null;
							}
						}
					});
					q.style.display = d;
				});
				if (r == false && childrenLine != false) {
					for (let branchNameChildren of childrenLine) {
						document.querySelectorAll(`[data-branch='${branchNameChildren}']`).forEach(q => {
							q.querySelectorAll('input, textarea').forEach(field => {
								if( field.tagName != 'TEXTAREA' )
									field.required = r;
								if (!r) {
									if (field.type == 'radio' || field.type == 'checkbox') {
										field.checked = false;
									} else {
										field.value = null;
									}
								}
							});
							q.style.display = d;
						});
					}
				}
			});
		});
	};

	// toggleBranch('albumortrack', 'Альбом', 'isAlbum', ['isAlbum']);
	// toggleBranch('albumortrack', 'Трек', 'isTrack', ['isTrack']);

	// toggleBranch('released', 'Да', 'releasedYes', ['releasedNowYes']);
	// toggleBranch('released_now', 'Да', 'releasedNowYes');
	// toggleBranch('doc_authors', 'Нет', 'doc_authorsNo');
	// toggleBranch('cover', 'Да', 'coverYes');

	if (document.querySelectorAll(".Field__add") !== null) document.querySelectorAll('.Field__add').forEach(el => {
		el.addEventListener('click', function (e) {
			let name = this.getAttribute('data-field');
			let haveClear = false;
			let inputs = this.parentNode.querySelectorAll(`input[name='${name}']`);
			// if (inputs.length > 5) {
			// showSMSG('Пожалуй хватит социальных сетей');
			// return;
			// }


			inputs.forEach(input => {
				if (input.value.length == 0) {
					haveClear = true;
					return;
				}
			});

			if (haveClear) {
				showSMSG('У вас и так есть пустое поле, заполните его и добавьте новое');
			} else {
				if (inputs.length >= 1) {
					this.parentNode.querySelector('.Field__remove').classList.add('Field__remove--show');
				}
				let label = document.createElement('label');
				label.classList.add('Field');
				let input = document.querySelector(`input[name='${name}']`).cloneNode();
				input.value = '';
				label.prepend(input);
				this.before(label);
				// pre(label);
			}
			e.preventDefault();
		});
	});

	if (document.querySelectorAll(".Field__remove") !== null) document.querySelectorAll('.Field__remove').forEach(el => {
		el.addEventListener('click', function (e) {
			let name = this.parentNode.querySelector('.Field__add').getAttribute('data-field');
			let inputs = this.parentNode.querySelectorAll(`input[name='${name}']`);
			if (inputs.length == 2) {
				this.classList.remove('Field__remove--show');
			}
			inputs[inputs.length - 1].remove();
			e.preventDefault();
		});
	});

	const valueFieldMultiple = (field) => {
		let value = [];
		document.querySelectorAll('.FieldMultiple .FieldMultiple__opt.selected').forEach(el => {
			value.push(el.innerText);
		});
		// pre(value);
		document.querySelector('.FieldMultiple .FieldMultiple__field').value = value;
	}

	const FieldMultipleOpt = function (selected = false) {
		document.querySelectorAll(".FieldMultiple .FieldMultiple__opt").forEach(el => {
			el.addEventListener('click', function (e) {
				let parent = el.parentNode.parentNode;
				// pre(parent);
				let a = el.cloneNode(1);
				if (el.classList.contains('selected')) {
					a.classList.remove('selected')
					parent.querySelector('.FieldMultiple__opts').append(a);
				} else {
					a.classList.add('selected')
					parent.querySelector('.FieldMultiple__input').append(a);
				}
				el.remove();
				valueFieldMultiple(parent);
				FieldMultipleOpt();
				e.preventDefault();
			});
		});
	}

	if (document.querySelectorAll(".FieldMultiple .FieldMultiple__opt") !== null) FieldMultipleOpt();


	document.querySelectorAll('.FieldTracks').forEach(field => {
		let inputName = field.getAttribute('data-name');
		field.querySelector('.FieldTracks__title').addEventListener('click', function (e) {
			field.classList.toggle('open');
			e.preventDefault();
		});
		field.querySelectorAll('.FieldTracks__item').forEach(item => {
			item.addEventListener('click', function (e) {
				item.querySelector('input[type="checkbox"]').checked = !this.querySelector('input').checked;
				e.preventDefault();
				let checked = field.querySelectorAll('.FieldTracks__input:checked');
				if (checked.length == 0) {
					document.querySelector(`input[name='${inputName}']`).value = '';
					field.querySelector('span').innerText = 'Выберите треки';
				} else {
					let inpText = [];
					checked.forEach(inp => {
						inpText.push(inp.value);
					});
					document.querySelector(`input[name='${inputName}']`).value = inpText;
					field.querySelector('span').innerText = `Выбрано треков(${checked.length})`;
				}
			});
		});
		field.querySelectorAll('.FieldTracks__input').forEach(input => {
			input.addEventListener('change', function () {
				let checked = field.querySelectorAll('.FieldTracks__input:checked');
				if (checked.length == 0) {
					document.querySelector(`input[name='${inputName}']`).value = '';
					field.querySelector('span').innerText = 'Выберите треки';
				} else {
					let inpText = [];
					checked.forEach(inp => {
						inpText.push(inp.value);
					});
					document.querySelector(`input[name='${inputName}']`).value = inpText;
					field.querySelector('span').innerText = `Выбрано треков(${checked.length})`;
				}
				// pre( field.querySelectorAll('.FieldTracks__input:checked').length );
			});
		});
	});

	if (document.querySelector('.tracksTabs__label') !== null) {
		// Все тркки
		let songsId = [];
		document.querySelectorAll('.tracksTabs__label').forEach(el=>{
			songsId.push(el.getAttribute('data-id'));
		});
		// Все тркки


		document.querySelectorAll('.tracksTabs__trackSave').forEach(but=> {
			but.addEventListener('click', function(e){
				let id = but.getAttribute('data-id');
				if ( checkTrackValid(id) ) {
					e.preventDefault();
					document.querySelector(`.tracksTabs__track[data-id="${id}"]`).classList.remove('active');
					setTrackValid(id);
				} else {

				}
			})
		});

		document.querySelectorAll('.tracksTabsLabel__act.edit').forEach(act=> {
			act.addEventListener('click', function (e) {
				if(act.classList.contains('tracksTabsLabel__act--fill')) {
					act.classList.remove('tracksTabsLabel__act--fill');
					act.classList.add('tracksTabsLabel__act--edit');
					act.querySelector('span ').innerHTML = 'Редактировать';
				}

				document.querySelectorAll('.tracksTabs__track').forEach(el => {
					el.classList.remove('active');
				});
				let id = act.getAttribute('data-id');
				document.querySelector(`.tracksTabs__track[data-id="${id}"]`).classList.add('active');
				e.preventDefault();
			});
		});

		document.querySelectorAll('.tracksTabsLabel__act.copy').forEach(act=> {
			act.addEventListener('click', function (e) {
				if(act.classList.contains('active')) {
					let id = act.getAttribute('data-id');
					copyAnswers(id);
					showSMSG('Ответы скопированы на другие треки');

					songsId.forEach(el=>{
						let act = document.querySelector(`.tracksTabsLabel__act.edit[data-id='${el}']`);
						if(act.classList.contains('tracksTabsLabel__act--fill')) {
							act.classList.remove('tracksTabsLabel__act--fill');
							act.classList.add('tracksTabsLabel__act--edit');
							act.querySelector('span ').innerHTML = 'Редактировать';
						}
					});
					document.querySelectorAll('.tracksTabsLabel').forEach(el=>{
						setTrackValid(el.getAttribute('data-id'));
					})
				} else {
					showSMSG('Вы не заполнили информацию об этом треке');
				}
			});
		});
		document.querySelectorAll('.tracksTabs__trackClose').forEach(act=> {
			act.addEventListener('click', (e) => {
				let id = act.getAttribute('data-id');
				document.querySelector(`.tracksTabs__track[data-id="${id}"]`).classList.remove('active');
				setTrackValid(id);
				e.preventDefault();
			});
		});

		const setTrackValid = (id) => {
			if ( checkTrackValid(id) ) {
				document.querySelector(`.tracksTabsLabel[data-id="${id}"] .tracksTabsLabel__name`).classList.add('tracksTabsLabel__name--filled');
				document.querySelector(`.tracksTabsLabel__act--copy[data-id="${id}"]`).classList.add('active');
			} else {
				document.querySelector(`.tracksTabsLabel__act--copy[data-id="${id}"]`).classList.remove('active');
				document.querySelector(`.tracksTabsLabel[data-id="${id}"] .tracksTabsLabel__name`).classList.remove('tracksTabsLabel__name--filled');
			}

			document.querySelector(`.tracksTabsLabel[data-id="${id}"]`).classList.add('tracksTabsLabel--edited');
			setTimeout(()=>{
				document.querySelector(`.tracksTabsLabel[data-id="${id}"]`).classList.remove('tracksTabsLabel--edited');
			}, 5000);
		}

		const checkTrackValid = (id) => {
			let track = document.querySelector(`.tracksTabs__track[data-id="${id}"]`);
			let valid = true;
			let names = {};
			// let fields = track.querySelectorAll('input, textarea');
			let fields = track.querySelectorAll('input:required, textarea:required');
			fields.forEach(field => {
				if ( names[field.name] == undefined ) names[field.name] = {
					'name': field.name,
					'valid': true,
					'type': (field.tagName == 'TEXTAREA' || field.type == 'hidden'  ? 'text' : field.type),
				};
			});

			for( let name in names ){
				let el = names[name];
				pre( el );
				if ( el.type == 'text' ) {
					if ( track.querySelector(`[name='${el.name}']`).value.length == 0 ) {
						el.valid = false;
						valid = false;
					}
					// pre( track.querySelector(`[name='${el.name}']`).value.length );
				} else if ( el.type == 'radio' || el.type == 'checkbox' ) {
					if ( track.querySelector(`[name='${el.name}']:checked`) == null ) {
						el.valid = false;
						valid = false;
					}
				}
			}
			// pre( names );

			return valid;
		}

		const copyAnswers = (id, copyTo = false ) => {
			let ids = [];
			if ( copyTo == false ) {
				document.querySelectorAll('.tracksTabs__label').forEach(label => {
					if ( label.getAttribute('data-id') != id )
						ids.push(label.getAttribute('data-id'));
				});
			} else {
				ids = copyTo;
			}

			document.querySelectorAll(`.tracksTabs__track[data-id='${id}'] [data-branch]`).forEach(el => {
				ids.forEach(newId => {
					let name = el.getAttribute('data-branch').replace(id, newId);
					document.querySelectorAll(`[data-branch="${name}"]`).forEach(div => {
						div.style.display = el.style.display;
					})
				});
			});
			document.querySelectorAll(`.tracksTabs__track[data-id='${id}'] input, .tracksTabs__track[data-id='${id}'] textarea`).forEach(el => {
				if (el.tagName == 'INPUT') {
					if (el.type == 'radio' || el.type == 'checkbox') {
						ids.forEach(newId => {
							let fieldId = el.getAttribute('data-field');
							document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`input[data-field='${fieldId}']`).checked = el.checked;
							document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`input[data-field='${fieldId}']`).value = el.value;
							document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`input[data-field='${fieldId}']`).required = el.required;
						});
					}
					if (el.type == 'text' || el.type == 'hidden') {
						ids.forEach(newId => {
							let fieldId = el.getAttribute('data-field');
							document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`input[data-field='${fieldId}']`).value = el.value;
							document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`input[data-field='${fieldId}']`).required = el.required;
						});
					}
				} else if (el.tagName == 'TEXTAREA') {
					ids.forEach(newId => {
						let name = el.name.replace(id, newId);
						document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`textarea[name='${name}']`).value = el.value;
						document.querySelector(`.tracksTabs__track[data-id='${newId}']`).querySelector(`textarea[name='${name}']`).required = el.required;
					});
				}
				// pre( el.name );
				// pre( el.type );
				// pre( el.value );
				// pre( el.checked );
			});

			ids.forEach(newId => {
				document.querySelectorAll(`.tracksTabs__track[data-id='${newId}'] .FieldMultiple__input a`).forEach(a=> {
					a.remove();
				});
				document.querySelectorAll(`.tracksTabs__track[data-id='${newId}'] .FieldMultiple__opts a`).forEach(a=> {
					a.remove();
				});
				// .FieldMultiple__input
				// .FieldMultiple__opts
			});
			document.querySelectorAll(`.tracksTabs__track[data-id='${id}'] .FieldMultiple__input a`).forEach(a=> {
				ids.forEach(newId => {
					document.querySelector(`.tracksTabs__track[data-id='${newId}'] .FieldMultiple__input`).append(a.cloneNode(1));
				});
			});
			document.querySelectorAll(`.tracksTabs__track[data-id='${id}'] .FieldMultiple__opts a`).forEach(a=> {
				ids.forEach(newId => {
					document.querySelector(`.tracksTabs__track[data-id='${newId}'] .FieldMultiple__opts`).append(a.cloneNode(1));
				});
			});
			FieldMultipleOpt();
		};

	}
}
window.onload = function () {
	Cookie.remove('smsg'); // Удаляем все уведомления из памяти
};

$(function () {
	$(`.content__wrap`).css({
		'min-height': 'calc( 100% - '+$('.header').outerHeight()+'px )'
	});
	$(`.Login__icon`).click(function(){
		$(`.Login .Login__wrap`).toggleClass('Login__wrap--open');
	});
	// $(`.Login`).mouseenter(function () { 
	// 	$(`.Login__wrap`).addClass('Login__wrap--open')
	// }).mouseleave(function () { 
	// 	$(`.Login__wrap`).removeClass('Login__wrap--open')
	// });
	$(`.Registration__form`).submit(function(e){
		console.log($(`.pass`).val());
		console.log($(`.pass2`).val());
		if ($(`.pass`).val() != $(`.pass2`).val()) {
			e.preventDefault();
			showSMSG('Пароли не совпадают');
		}
	});
	// console.log(showSMSG);
});

