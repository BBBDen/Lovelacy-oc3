var PARAMS = {
	paginationUrl: null,
	loadingCount: 0,
	paginateFilter: null
};

function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}
/**
 *
 * @param _this_
 * @param __block__
 * @returns {Promise<{link: jQuery, self: *, block: *}>}
 */
async function loadContent(_this_, __block__) {
	var __self__ = $( _this_ ),
		link = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : __self__.attr('href');
	$(__block__).css({
		opacity: '0.4'
	});

	await $(__block__).load(link + ' .products-filters', function (loadingBlock) {
		var nextLink = $(loadingBlock).find('.pagination li.active').next('li').find('a').attr('href');
		if($(loadingBlock).find(".js-range-slider")) {
			$(".js-range-slider").ionRangeSlider({
				onChange: function(data) {
					fromInput.value = data.from;
					toInput.value = data.to;
				}
			});
			let my_range = $(".js-range-slider").data("ionRangeSlider");

			const fromInput = document.querySelector("#rangeFrom")
			const toInput = document.querySelector("#rangeTo")
			my_range.update({
				from: fromInput.value,
				to: toInput.value
			});
			fromInput.addEventListener("change", function(e) {
				my_range.update({
					from: e.target.value,
				});
			})
			toInput.addEventListener("change", function(e) {
				my_range.update({
					to: e.target.value,
				});
			})
		}


		if (typeof nextLink !== 'undefined') {
			PARAMS.paginationUrl = nextLink
		}
	});

	return {
		self: _this_,
		block: __block__,
		link: link
	}
}

/**
 * ajax product loading
 *
 * @param event
 */
function loadMoreAjax(event) {
	event.preventDefault();
	const loader = document.createElement("img");

	if(event.target.classList.contains("btn-ajax-load-more")) {
		loader.setAttribute("src", "/catalog/view/theme/lovelace/image/loading.svg")
		loader.classList.add("loader");

		event.target.parentElement.appendChild(loader)
		event.target.parentElement.classList.add("loading");
	}
	var href = PARAMS.paginationUrl;
	var _ref_ = $( event.target );


	if (href) {
		$.get(href, function (response) {
			// console.log(_ref_, href, $(response).find('.item'));return;
			$('#products--filters .catalog__items').append($(response).find('.item'));
			if(event.target.classList.contains("btn-ajax-load-more")) {
				loader.remove()
				event.target.parentElement.classList.remove("loading");
			}
			$('.pagination').load(href, function (data) {
				$(this).html($(data).find('.pagination li'));
				var renderNextPagination = $(data).find('.pagination li.active').next('li');
				if (renderNextPagination.length !== 0) {
					PARAMS.paginationUrl = renderNextPagination.find('a').attr('href');
					_ref_.attr('data-pagination-link', renderNextPagination.find('a').attr('href'))
				} else {
					_ref_.hide();
				}

			});

		});
	}


	$(document).delegate('.btn-ajax-load-more', 'click', loadMoreAjax).off();
}

$(document).ready(function() {
	$(document).delegate('.btn-cart-added', 'click', function (e) {
		e.preventDefault();
		location = '/cart'
	})

	$(document).delegate('.btn-ajax-load-more-filter', 'click', function (e) {
		PARAMS.paginateFilter = 'paginate';
		PARAMS.page = $(this).data('page') || PARAMS.page++;
		$(document).find('#btn--filter').trigger('click');
	});

	// Pagination Link
	var __pL__ = $(document).find('.pagination li.active').next('li').find('a').attr('href');
	$('.btn-ajax-load-more').attr('data-pagination-link', __pL__);
	PARAMS.paginationUrl = __pL__;

	var filterCategoriesFirst = document.querySelector('.catalog__categories .catalog__link:first-child');

	$(document).delegate('.btn-ajax-load-more', 'click', loadMoreAjax);


	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});

	$('.input_subscription').on('input', function () {
		var errorClass = $('.container--subscriber');

		if (errorClass) {
			errorClass.remove()
		}
	});

	// Filtering by category name
	$(document).delegate('.categories-children .faq__text .faq-link', 'click', function (e) {
		e.preventDefault();

		$(this).closest('form').trigger('reset');

		// это уже фильтр
		$(document).find('#catalog__item-products').load($( this ).attr('href') + ' .catalog__item-products', function (data) {

			var pagination = $(data).find('.pagination li.active').next('li');
			if (pagination.length !== 0) {
				PARAMS.paginationUrl = pagination.find('a').attr('href');
			}

		});
	});

	$(document).delegate('.filter-group-5 [type="checkbox"]', 'change', function () {
		if (PARAMS.hasOwnProperty('page')) {
			PARAMS.page = 1;
		}
		PARAMS.paginateFilter = null
	});

	// Main Filter
	$(document).delegate('#btn--filter', 'click', function (e) {
		e.preventDefault();

		var __this__ = $( this ),
			block = __this__.closest('body').find('#products--filters'),
			locationSearch = '',
			filter = [];

		$('input[name^=\'filter\']:checked').each(function(element) {
			filter.push(this.value);
		});

		if (location.search) {
			locationSearch = location.search.replace('?', '&');
		}

		$.get('index.php?route=extension/module/filter/filter' + locationSearch, {
			filter: filter.join(','),
			category_id: block.find('.catalog__item-products').data('category-id'),
			language_id: VARS.language_id,
			path: block.find('.catalog__item-products').data('path'),
			store_id: block.data('store-id'),
			group_id: block.data('group-id'),
			page: PARAMS.page,
			start: $(document).find('.btn-ajax-load-more-filter').data('start') || 0,
			priceFrom: $('#rangeFrom').val() || 0,
			priceTo: $('#rangeTo').val() || 1000000,
		}, 'html').done(function (html) {
			console.log($('#rangeFrom').val() )
			var catalogFilters = document.querySelector(".catalog-filters")
			if(catalogFilters && document.documentElement.clientWidth < 769 && !PARAMS.paginateFilter) {
				catalogFilters.classList.remove("active")
				catalogFilters.style.display = 'none';
				window.scrollTo(0,0)
			}
 			if (html) {
				if (PARAMS.paginateFilter) {
					block.find('.catalog__item-products .catalog__items').append($(html).find('.item'));
					$(document).find('.show-more').html($(html).find('.btn-ajax-load-more-filter'));
				} else {
					block.find('.catalog__item-products').html(html);
				}

			}
		}).fail(function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		});
	});

	// Sort click handler
	$(document).delegate('.catalog__sorts a', 'click', async function (e) {
		e.preventDefault();
		const loader = document.createElement("img");
		loader.setAttribute("src", "/catalog/view/theme/lovelace/image/loading.svg")
		loader.classList.add("loader");
		console.log(loader)
		const filters = document.querySelector(".catalog__filters");
		if(filters) {
			filters.appendChild(loader)
		}
		await loadContent(this, '#products--filters').then(function (response) {
			var sortCurrentTitle = document.querySelector('.catalog__btn.dropdown__btn');

			if (sortCurrentTitle) {
				sortCurrentTitle.textContent = $(response.self).text()
			}

			if (response['link'] && typeof response.link !== 'undefined') {
				history.pushState({}, null, response.link);
			}

			if (response['block'] && typeof response.block !== 'undefined') {
				$( response.block ).css({
					opacity: '1'
				})
			}
		})
	});

	// Category-active click handler
	$(document).delegate('#products--filters .catalog__link_active', 'click', async function (e) {
		e.preventDefault();
		var linkMainCategory = $('#products--filters').data('category');

		await loadContent(this, '#products--filters', linkMainCategory).then(function (response) {
			if (response['block'] && typeof response.block !== 'undefined') {
				$( response.block ).css({
					opacity: '1'
				})
			}
			history.pushState({}, null, linkMainCategory);

			sessionStorage.setItem('check', '1')
		});
	});

	// Category click handler
	$(document).delegate('a.catalog__link:not(.catalog__link_active)', 'click', async function (e) {
		e.preventDefault();

		document.querySelectorAll('.catalog__link').forEach(function (item) {
			if (item.classList.contains('catalog__link_active')) {
				item.classList.remove('catalog__link_active')
			}
		});


		await loadContent(this, '#products--filters').then(function (response) {

			var queryString = location.search;
			if (queryString) {
				var _URL_ = new URL(location.href.toString());
				history.pushState({}, null, _URL_.origin + _URL_.pathname);
			}

			if (response['block'] && typeof response.block !== 'undefined') {
				$( response.block ).css({
					opacity: '1'
				})
			}
		});
	});

	// Click by first category after page loading
	if (filterCategoriesFirst && sessionStorage.getItem('check') !== '1') {
		sessionStorage.setItem('check', '1')
		$(filterCategoriesFirst).trigger('click');
	}

	// Pagination Click
	$(document).delegate('.pagination li a', 'click', async function (e) {
		e.preventDefault();

		await loadContent(this, '#products--filters').then(function (response) {
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			if (response['block'] && typeof response.block !== 'undefined') {
				$( response.block ).css({
					opacity: '1'
				})

			}
			if (response['link'] && typeof response.link !== 'undefined') {
				history.pushState({}, null, response.link);
			}
		});
	});

	$('.subscription__btn').on('click', function (e) {
		e.preventDefault();
		$('.container--subscriber').remove();
		var subscriberInput = $(this).closest('div').find('input'),
			_self_ = $(this),
			textBtn = _self_.text(),
			subscriberEmail = subscriberInput.val(),
			emailRegEx = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/),
			error = [];

		if (!subscriberEmail.length) {
			error.push(VARS.text_error_email_empty);
		} else if (!emailRegEx.test(String(subscriberEmail).toLowerCase())) {
			error.push(VARS.text_error_email)
		}

		if (!error.length) {
			$.ajax({
				url: 'index.php?route=account/account/subscribe',
				type: 'post',
				data: {
					subscriber: subscriberEmail,
					language: VARS.language_id
				},
				dataType: 'json',
				beforeSend: function () {
					_self_.text(VARS.text_loading);
				},
				complete: function () {
					_self_.text(textBtn);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				},
				success: function (json) {
					if (json['success'] && json['success'] === true) {
						subscriberInput.val('');
						console.log(_self_)
						_self_.after('<div class="container container--subscriber" style="margin-top: 10px;"><span class="span_success">'+json.answer+'</span></div>');
					} else {
						_self_.after('<div class="container container--subscriber" style="margin-top: 10px;"><span class="span_error">'+json.error+'</span></div>');
					}
				}
			})
		} else {
			$(this).closest('div').after('<div class="container container--subscriber" style="margin-top: 10px;"><span class="span_error">'+error.join("<br />")+'</span></div>');
		}

	});

	$(document).delegate('.account-info-order', 'click', function () {
		var __ref__ = $( this );
		if (!__ref__.find('.faq__text').html().length) {
			$.ajax({
				url: 'index.php?route=account/order/info&order_id=' + encodeURIComponent(__ref__.attr('data-order')),
				type: 'get',
				data: {
					language: VARS.language_code
				},
				beforeSend: function () {
					$('#account-info--order').css({
						opacity: '0.3'
					});
				},
				complete: function () {
					$('#account-info--order').css({
						opacity: '1'
					});
				},
				success: function (response) {
					__ref__.find('.faq__text').html(response);
					__ref__.toggleClass('faq-item_active')
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		} else {
			__ref__.toggleClass('faq-item_active')
		}
	});

	$('#cart__form-b').on('click', '.cart__promo .btn', function (e) {
		e.preventDefault();
		var __this__ = $(this),
			text = __this__.text();
		$( this ).closest('.cart__promo').find('.span_error').hide();

		var promo = $(this).closest('.cart__promo').find('input').val();

		if (!promo.length) {
			$( this ).closest('.cart__promo').find('.span_error').show();
		} else {
			$.ajax({
				url: 'index.php?route=checkout/cart/promo',
				dataType: 'json',
				type: 'post',
				data: {
					promo: promo,
					categories: __this__.closest('.cart__form').find('.categories_ids').val(),
					products: __this__.closest('.cart__form').find('.product_ids').val(),
					total: __this__.closest('.cart__form').find('[data-total-price]').data('total-price'),
					language: VARS.language_code
				},
				beforeSend: function () {
					__this__.text(__this__.data('loading'))
				},
				complete: function () {
					__this__.text(text)
				},
				success: function (json) {
					console.log(json)
					$(document).find('.g-block').remove();
					if (json['error']) {
						__this__.closest('.cart__promo').find('.span_error').show().html(json['error'])
					} else if (json.hasOwnProperty('type')) {
						if (json.type === 'gift') {
							var gifts = '';
							$.each(json.products, function (k,v) {
								gifts += '<li class="gift"><img src="'+v.image+'" alt=""><a href="'+v.href+'">'+v.name+'</a></li>';
							})

							__this__.closest('.cart__footer').find('.cart__checkout').after('<div class="g-block"><div class="gift-span">'+json.text+'</div><div class="gift-block"><ul class="gift-ul">'+gifts+'</ul></div></div>');
						}
					} else {
						if ( json.hasOwnProperty('sum_order_products') && json.sum_order_products === 'products' ) {
							var txt = json.hasOwnProperty('text') ? json.text : 'Промокод успешно применен';
							var popupNew = document.createElement("div");
							popupNew.classList.add('promo-popup');
							popupNew.style.cssText = `background: #f486be; color: #fff; position: fixed; right: 50%; top: 50%; transform: translateY(-50%) translateX(50%); padding: 15px; font-size: 16px; text-align: center; max-width: 320px`
							popupNew.innerText = txt;
							document.body.appendChild(popupNew);
							setTimeout(function() {popupNew.remove()}, 2000)
							$('#cart__form-b').load(window.location.href + ' #cart__form-b > .cart__form');
						} else {
							$('.cart__checkout.flex .cart__total[data-total-price] span').load(window.location.href + ' .cart__total[data-total-price] span')
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				},
			});
		}
	});

	$('.account__history').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: 'index.php?route=account/order',
			type: 'get',
			data: {
				language: VARS.language_code
			},
			beforeSend: function () {
				$('#account-info--order').css({
					opacity: '0.3'
				});
			},
			complete: function () {
				$('#account-info--order').css({
					opacity: '1'
				});
			},
			success: function (response) {
				$('#account-info--order .account-info--order').html(response)
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			},
		});
	});

	$(document).delegate('.product-variation a', 'click', function (e) {
		e.preventDefault();

		var __refer__ = $( this ).closest('.product-variation'),
			product_id = __refer__.attr('data-product');
		$.ajax({
			url: 'index.php?route=checkout/cart/getVariation&product_id=' + encodeURIComponent(product_id) + '&language=' + encodeURIComponent(VARS.language_code),
			type: 'post',
			data: {
				product_id: product_id,
				language: VARS.language_code
			},
			dataType: 'html',
			success: function (html) {
				$('#product-wrapper').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	// Currency
	$('#currency .currency-select').on('click', function(e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').val($(this).attr('data-code'));

		$('#currency').submit();
	});

	// Language
	$('#lang .language-select').on('click', function(e) {
		e.preventDefault();

		$('#lang input[name=\'code\']').val($(this).attr('data-code'));

		$('#lang').submit();
	});

	/* Search */
	$('#search input[name=\'search\']').parent().find('button').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('header #search input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('header #search input[name=\'search\']').parent().find('button').trigger('click');
		}
	});

	// Menu
	$('#menu .dropdown-menu').each(function() {
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();

		var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 10) + 'px');
		}
	});

	// Product List
	$('#list-view').click(function() {
		$('#content .product-grid > .clearfix').remove();

		$('#content .row > .product-grid').attr('class', 'product-layout product-list col-xs-12');
		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		var cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols == 1) {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
		}

		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');

		localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
		$('#list-view').addClass('active');
	} else {
		$('#grid-view').trigger('click');
		$('#grid-view').addClass('active');
	}

	// Checkout
	$(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function(e) {
		if (e.keyCode == 13) {
			$('#collapse-checkout-option #button-login').trigger('click');
		}
	});

	$('.btn-auth').on('click', function (e) {
		e.preventDefault();

		var _this_ = $( this ),
			data = {
				email: _this_.closest('.login__login').find('input[name=\'email\']').val(),
				phone: _this_.closest('.login__login').find('input[name=\'phone\']').val(),
				password: _this_.closest('.login__login').find('input[name=\'password\']').val(),
				language_code: VARS.language_code
			},
			btnText = _this_.text();

		$.ajax({
			url: 'index.php?route=account/login/authorization',
			data: data,
			dataType: 'json',
			type: 'post',
			beforeSend: function () {
				_this_.text(_this_.data('loading'))
			},
			complete: function () {
				_this_.text(btnText)
			},
			success: function (json) {
				console.log(json);
				// return;
				_this_.closest('.login__login').find('input[name=\'email\']').removeClass('wrong');
				_this_.closest('.login__login').find('.span_error').remove();
				if (json['errors']) {
					_this_.closest('.login__login').find('input[name=\'email\']').addClass('wrong');
					_this_.closest('.login__login').append('<span class="span_error">'+json['errors']+'</span>');
				} else {
					window.location.href = json['redirect']
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});

	$('.btn-reset').on('click', function (e) {
		e.preventDefault();
		var __ref__ = $( this ),
			queryString = window.location.search,
			urlParams = new URLSearchParams(queryString),
			btnText = __ref__.text();

		$.ajax({
			url: 'index.php?route=account/reset/reset',
			data: {
				password: __ref__.closest('.login__login').find('input[name=\'password\']').val(),
				confirm: __ref__.closest('.login__login').find('input[name=\'confirm\']').val(),
				language_code: VARS.language_code,
				code: urlParams.get('code')
			},
			dataType: 'json',
			type: 'post',
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			},
			success: function (json) {
				__ref__.closest('.login__login').find('input').removeClass('wrong');
				__ref__.closest('.login__login').find('.span_error').remove();
				if (json['errors']) {
					$.each(json['errors'], function (key, value) {
						__ref__.closest('.login__login').find('input[name="'+ key +'"]').addClass('wrong').after('<span class="span_error">'+value+'</span>');
					});
				} else {
					window.location.href = json['redirect']
				}
			},
			beforeSend: function () {
				__ref__.text(__ref__.data('loading'))
			},
			complete: function () {
				__ref__.text(btnText)
			}
		})
	})

	$('.amount.amount__total').on('input', function () {
		alert($(this).val())
	});

	$('.forgot__links a').on('click', function (e) {
		e.preventDefault();

		$( this ).closest('.container').find('.login__login').css({
			display: 'block'
		});


		$( this ).closest('.container').find('.login__first').css({
			display: 'block'
		});

		$( this ).closest('.container').find('.login__forgot').css({
			display: 'none'
		});

		$( this ).closest('.container').find('.forgot__links').css({
			display: 'none'
		});
	})


});

// Cart add remove functions
var cart = {
	'addCertificate': function (product_id) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + encodeURIComponent(product_id) + '&quantity=1&denomination=' + encodeURIComponent($('.certificate-form').find('input.denomination').val()) + '&email=' + encodeURIComponent($('.certificate-form').find('input.email-input').val()) + '&certificate=' + encodeURIComponent($('.certificate__radios').find('input:checked').val()) + '&current_currency=' + encodeURIComponent(VARS.current_currency) + '&type=certificate&language=' + encodeURIComponent(VARS.language_code),
			dataType: 'json',
			success: function (json) {
				$('.certificate-form').find('.span_error').remove();
				$('.certificate-form').find('.span_success').remove();
				$('.certificate-form').find('input').removeClass('wrong');
				if (json['errors']) {
					$.each(json['errors'], function (key, value) {
						$('.certificate-form').find('input[name="'+key+'"]').addClass('wrong').after('<span class="span_error">'+value+'</span>')
					})
				} else {
					var $cart = document.querySelector('.cart-btn');

					if ($cart && !$cart.classList.contains('added')) {
						$cart.classList.add('added');
					}
					$('.certificate-form').trigger('reset');
					$('.certificate-form').after('<span class="span_success">'+json['success']+'</span>')
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('.alert-dismissible, .text-danger').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {

					var $cart = document.querySelector('.cart-btn');

					if ($cart && !$cart.classList.contains('added')) {
						$cart.classList.add('added');
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'update': function(key, quantity) {

		$.ajax({
			url: 'index.php?route=checkout/cart/updateCart',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					$('#cart--item' + key).find('.cart-item__price').load(window.location.href + ' .product_total' + key);
					$('.cart__checkout.flex .total2').load(window.location.href + ' .total2')
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'removeCertificate': function (key, certificate_id) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key + '&certificate_id=' + certificate_id,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				if (json['total'] <= 0) {
					$('.cart-btn').removeClass('added');
					window.location.reload();
				} else {

					$('#cart--item' + key).remove();
					$('.cart__checkout.flex .total2').load(window.location.href + ' .total2')
					$('#cart__form-b').load(window.location.href + ' #cart__form-b > .cart__form');

				}

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key) {
		var productId = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key + ( productId > 0 ? '&product_id=' +  productId : '' ),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				if (json['total'] <= 0) {
					$('.cart-btn').removeClass('added');
					window.location.reload();
				} else {

					$('#cart--item' + key).remove();
					$('.cart__checkout.flex .cart__total[data-total-price] span').load(window.location.href + ' .cart__total[data-total-price] span')
					$('#cart__form-b').load(window.location.href + ' #cart__form-b > .cart__form');

					var btnCheckout = $('.btn--checkout');

					if (btnCheckout.length) {
						btnCheckout.load(window.location.href + ' .btn--checkout .btn')
					}

				}

			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {

				$('.header__btns .favorite-btn').addClass(json['total']);
				var $f = $('.favorite--' + product_id);
				$f.addClass('toFavorite_active');
				$f.html(`<button type="button" class="add-to-catalog" onclick="wishlist.remove('${product_id}');return false;"><svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5757 0C14.019 0 16 1.981 16 4.42386C16 8.46166 7.9998 13.8246 7.9998 13.8246C7.9998 13.8246 0 8.65497 0 4.42382C0 1.38237 1.981 0 4.42386 0C5.89538 0 7.19522 0.721649 7.9998 1.82655C8.80449 0.721649 10.1046 0 11.5757 0Z" fill="white" fill-opacity="0.5"></path></svg></button>`);

				var tooltip = $('#product').find('.tooltip-stock');
				var span = document.querySelector(".wishlist-tooltip--wrapper .tooltip-stock span");
				var toFavoriteBtn = document.querySelector(".wishlist-tooltip--wrapper .toFavorite")
				if(span) {
					span.innerText = toFavoriteBtn.getAttribute("data-wishlist-remove")
				}
				if (tooltip) {
					// tooltip.load(window.location.href + ' #tooltip-stock');

				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(product_id) {
		var route = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
		$.ajax({
			url: 'index.php?route=account/wishlist/remove',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (route === 'wishlist') {
					window.location.reload();
				} else {
					if (json['total'] === 0) {
						$('.header__btns .favorite-btn').removeClass('added');
					}
					var f = $('.favorite--' + product_id);
					f.removeClass('toFavorite_active');
					f.html(`<button type="button" class="add-to-catalog" onclick="wishlist.add('${product_id}');return false;"><svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5757 0C14.019 0 16 1.981 16 4.42386C16 8.46166 7.9998 13.8246 7.9998 13.8246C7.9998 13.8246 0 8.65497 0 4.42382C0 1.38237 1.981 0 4.42386 0C5.89538 0 7.19522 0.721649 7.9998 1.82655C8.80449 0.721649 10.1046 0 11.5757 0Z" fill="white" fill-opacity="0.5"></path></svg></button>`);
					var span = document.querySelector(".tooltip-stock span");
					var toFavoriteBtn = document.querySelector(".wishlist-tooltip--wrapper .toFavorite")
					if(span) {
						span.innerText = toFavoriteBtn.getAttribute("data-wishlist-add")
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert-dismissible').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div>';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);
