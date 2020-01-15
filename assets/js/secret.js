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
		$('#check-secret-response-message').html('');
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
			if (response.expiresAt != ''){
				var d = new Date(response.expiresAt);
				var date = d.getUTCFullYear() + "-" + ("0" + (d.getUTCMonth() + 1)).slice(-2) + "-" + d.getUTCDate() + " " + d.getUTCHours() + ":" + d.getUTCMinutes() + ":" + d.getUTCSeconds();
			}else{
				date = '';
			}
			$('#check-secret-response-message').append(
				'<div class="success-message mt-3 mb-3 p-3">' +
				'<div class="secret-text">Secret: ' + response.secretText + '</div>' +
				'<div class="secret-text">Views to expire: ' + response.remainingViews + '</div>' +
				'<div class="secret-text">Expire: ' + date + '</div>' +
				'</div>'
			)
		}).fail(function (xhr, status, error) {
			$('#check-secret-response-message').append('<div class="error-message mt-3 mb-3">' + xhr.responseJSON.error + '</div>');
		});
	},

	createSecret: function () {
		$('#new-secret-response-message').html('');
		var secret = $('[name=secretText]').val();
		var expireAfterViews = $('[name=remainingViews]').val();
		var expireAfter = $('[name=expiresAt]').val();
		if (expireAfterViews > 0 && expireAfter >=0 && secret.length > 0){
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
				$('#new-secret-response-message').append(
					'<div class="success-message mt-3 mb-3 p-3">' +
					'<div class="secret-text">Your secret hash: ' + response.hash + '</div>' +
					'</div>');
			}).fail(function (xhr, status, error) {
				$('#new-secret-response-message').append('<div class="error-message mt-3 mb-3">' + xhr.responseJSON.error + '</div>');
			});;
		}else{
			$('#new-secret-response-message').append('<div class="error-message mt-3 mb-3">' + INVALID_INPUTS_MESSAGE + '</div>');
		}
	},

	clearAllData: function () {
		$('#check-secret-response-message').html('');
		$('#new-secret-response-message').html('');
		$('[name=hash]').val('');
		$('[name=secretText]').val('');
		$('[name=remainingViews]').val('');
		$('[name=expiresAt]').val('');
	}
};
