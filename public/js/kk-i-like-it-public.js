(function ($) {
	'use strict';

	const buttonOnClick = function (buttonTag) {
		var ajaxAction = 'add_like';
		const button = jQuery(buttonTag);
		const action = button.data('action');
		const idPost = button.data('post-id');
		const type = button.data('post-type');
		const idUser = button.data('user');
		const onlyUser = button.data('ou');

		const allButtons = jQuery('button[rel="kk-i-like-it--post-' + idPost + '"]');

		if(onlyUser == '1' && idUser == '0'){
			allButtons.after(jQuery('<div />').css({'clear':'both'}).addClass('kk-i-like-it__msg').text('Only registered users can vote.'));
			 
			setTimeout(function(){
				jQuery('.kk-i-like-it__msg').fadeOut('normal');
			},3000);

			 return false;
		}

		if (action !== 'like') {
			ajaxAction = 'remove_like';
		}

		allButtons.find('.kk-i-like-it__text').addClass('kk-i-like-it__load');

		jQuery.post(kkajax.ajaxurl, {
			action: ajaxAction,
			idPost: idPost,
			type: type
		}, function (response) {

			const responseData = jQuery.parseJSON(response);

			if (!responseData.hasError) {
				allButtons.find('.kk-i-like-it__value').text(responseData.rating);

				if (action === 'like') {
					allButtons.find('.kk-i-like-it__text').text(unlikeText);
					allButtons.data({ action: 'unlike' });
				} else {
					allButtons.find('.kk-i-like-it__text').text(likeText);
					allButtons.data({ action: 'like' });
				}
			}

			if (responseData.msg != '') {
				allButtons.after(jQuery('<div />').css({ 'clear': 'both' }).addClass('kk-i-like-it__msg').text(responseData.msg));
				setTimeout(function () {
					jQuery('.kk-i-like-it__msg').fadeOut('normal');
				}, 3000);
			}

			allButtons.find('.kk-i-like-it__text').removeClass('kk-i-like-it__load');

		});

	};

	const bindEventHandlers = function () {

		jQuery('body').on('click', '.kk-i-like-it__box button', function () {
			buttonOnClick(this);
		});

	};

	$(window).load(function () {
		bindEventHandlers();
	});

})(jQuery);
