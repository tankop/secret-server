/**
 * Created by Tankó Péter on
 */
var secret = {

	showContainer: function (id) {
		secret.clearAllData();
		$('.custom-container').each(function () {
			if ($(this).data('id') == id) {
				$(this).css('display', 'flex');
			} else {
				$(this).css('display', 'none');
			}
		});
	},

	checkSecret: function () {
		var settings = {
			"url": BASE_URL + "api/secret/" + ($('[name=hash]').val().length > 0 ? $('[name=hash]').val() : '-'),
			"method": "GET",
			"timeout": 0,
			"headers": {
				"Accept": "application/json",
				"Content-Type": "application/x-www-form-urlencoded"
			},
		};

		$.ajax(settings).done(function (response) {
			$('[name=hash]').val('');
			if (response.expiresAt != '') {
				var d = new Date(response.expiresAt);
				var date = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + d.getDate() + " " + ("0" + (d.getHours())).slice(-2) + ":" + ("0" + (d.getMinutes())).slice(-2) + ":" + ("0" + (d.getSeconds())).slice(-2);
			} else {
				date = '';
			}
			Swal.fire({
				type: 'success',
				title: GET_SECRET_SUCCESS_TITLE,
				html: 'Secret: ' + response.secretText + '<br/>' +
					'Views to expire: ' + response.remainingViews + '<br/>' +
					'Expire: ' + date,
				confirmButtonText: OK_BTN_TEXT,
				confirmButtonClass: 'custom-orange-btn'
			});
		}).fail(function (xhr, status, error) {
			Swal.fire({
				type: 'error',
				text: xhr.responseJSON.error,
				confirmButtonText: OK_BTN_TEXT,
				confirmButtonClass: 'custom-orange-btn'
			});
		});
	},

	createSecret: function () {
		var secret = $('[name=secretText]').val();
		var expireAfterViews = $('[name=remainingViews]').val();
		var expireAfter = $('[name=expiresAt]').val();
		if (expireAfterViews > 0 && expireAfter >= 0 && secret.length > 0) {
			var data = {
				"secret": secret,
				"expireAfterViews": expireAfterViews,
				"expireAfter": expireAfter
			};
			var settings = {
				"url": BASE_URL + "api/secret",
				"method": "POST",
				"timeout": 0,
				"headers": {
					"Content-Type": "application/x-www-form-urlencoded",
					"Accept": "application/json"
				},
				"data": data
			};
			$.ajax(settings).done(function (response) {
				$('[name=secretText]').val('');
				$('[name=remainingViews]').val('');
				$('[name=expiresAt]').val('');
				Swal.fire({
					type: 'success',
					title: SUCCESS_SECRET_CREATED_TITLE,
					html: SUCCESS_SECRET_CREATED_MESSAGE + '<br/><b>' + response.hash + '</b>',
					confirmButtonText: COPY_HASH_BTN_TEXT,
					confirmButtonClass: 'custom-orange-btn'
				}).then(function (result) {
					if (result.value) {
						var temp = $("<input>");
						$("body").append(temp);
						temp.val(response.hash).select();
						document.execCommand("copy");
						temp.remove();
					}
				});
			}).fail(function (xhr, status, error) {
				Swal.fire({
					type: 'error',
					text: INVALID_INPUTS_MESSAGE,
					confirmButtonText: OK_BTN_TEXT,
					confirmButtonClass: 'custom-orange-btn'
				});
			});
		} else {
			Swal.fire({
				type: 'error',
				text: INVALID_INPUTS_MESSAGE,
				confirmButtonText: OK_BTN_TEXT,
				confirmButtonClass: 'custom-orange-btn'
			})
		}
	},

	clearAllData: function () {
		$('[name=hash]').val('');
		$('[name=secretText]').val('');
		$('[name=remainingViews]').val('');
		$('[name=expiresAt]').val('');
	}
};
