$(function () {
	// $(`.SU__wrap`).css({
	// 'min-height': $('.content__wrap').innerHeight()+'px'
	// });

	$(`.change_req_id`).change(function () {
		let ids = [];
		$(`.change_req_id:checked`).each(function () {
			ids.push($(this).val());
		});
		$(`.ChangeReq__form input[name='ids']`).val(ids);
		$(`.ChangeReq__bttn`).attr('disabled', (ids.length < 1 ? true : false));
	});

	function search(text, set = 1) {
		if (set) $(`.ReqsSearch__field`).val(text);
		text = text.split(' ');
		if ( text.length == 1 ) text = text[0];
		// console.log(typeof text);
		// console.log(text);
		$(`tr[data-req]`).each(function(){
			if ( typeof text == 'string' ) {
				if ($(this).text().toLowerCase().indexOf(text.toLowerCase()) == -1) {
					$(this).hide(300);
				} else {
					$(this).show(300);
				}
			} else {
				let res = [];
				text.forEach(element => {
					if ( element.length != 0 ) {
						if ($(this).text().toLowerCase().indexOf(element.toLowerCase()) == -1) {
							res.push(false);
						} else {
							res.push(true);
						}
					}
				});
				// console.log(res);
				if ( res.includes(true) ) {
					$(this).show(300);
				} else {
					$(this).hide(300);
				}
			}
		});
	}

	$(`.LastRates__item`).click(function () {
		search($(this).attr('data-req_id'));
	});
	$(`.ReqTr__user, .ReqTr__nickname`).click(function () {
		search($(this).text());
	});

	$(`.ReqsSearch__field`).on("input", function () {
		let text = $(this).val();
		if (text.length == 0) {
			$(`tr[data-req]`).show(300);
		} else {
			search(text, 0);
		}
	});

	$(`.StagesLabels__link`).click(function(event){
		event.preventDefault();
		$(`.StagesLabels__link.active`).removeClass('active');
		$(this).addClass('active');
		
		$(`.Stage.active`).hide(300).removeClass('active');
		$(`.Stage[data-stage='${$(this).attr('data-stage')}']`).show(300).addClass('active');
	});


	$(`.Stage__title`).click(function(){
		$(`.Stage.active`).hide(300).removeClass('active');
		$(`.StagesLabels__link.active`).removeClass('active');

		// $(this).toggleClass('Stage__title--open');
		// $(this).siblings(`.Stage__list`).toggleClass(`Stage__list--open`).toggle(300);
	});

	$(`.Song__title`).click(function(){
		$(this).toggleClass('Song__title--open');
		$(this).siblings(`.Song__answers`).toggleClass(`Song__answers--open`).toggle(300);
	});
});
