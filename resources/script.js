$(document).ready(function(){
	// Login switch
	$('#show_login').click(function(){
	    $('#new_user_parent').hide();
	    $('#login_parent').show();
	});
	$('#show_register').click(function(){
	    $('#new_user_parent').show();
	    $('#login_parent').hide();
	});

	if (getParameterByName('logged_out')) {
		$('#show_login').click();
	}

	$('#change_avatar').click(function(){
		$('#avatar_form_parent').show();
	});

	$('#avatar_input').change(function(){
		$('#avatar_form').submit();
	});

	$('.game_bid_input').change(function(){
		var true_value = $(this).val() * -1;
		$(this).parent('.game_bid_parent').find('.game_bid_value_label').html(true_value);
	});

	$('.game_bid_submit').click(function(e){
		var bid_value = $(this).parent('.game_bid_parent').find('.game_bid_value_label').html();
		var game_id = $(this).parent('.game_bid_parent').find('.game_bid_game_id').val();
		var game_bid_url = base_url + 'game/bid/' + game_id;
		var data = {};
		data.amount = bid_value;
		ajax_post(game_bid_url, data, false);
		$(this).parent('.game_bid_parent').hide();
	});

	// Abstract simple ajax calls
	function ajax_post(url, data, callback) {
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			// data: data,
			data: JSON.stringify(data),
			success: function(response) {
				// Parse
				console.log(response);
				data = JSON.parse(response);

				// Handle errors
				if (data['error']) {
					alert(data['error_message']);
					return false;
				}

				// Do callback if provided
				if (callback && typeof(callback) === 'function') {
					callback();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
	}

	// Abstract simple ajax calls
	function ajax_get(url, callback) {
		$.ajax({
			url: url,
			type: 'GET',
			success: function(response) {
				// Parse
				console.log(response);
				data = JSON.parse(response);

				// Handle errors
				if (data['error']) {
					alert(data['error_message']);
					return false;
				}

				// Do callback if provided
				if (callback && typeof(callback) === 'function') {
					callback();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
	}

	// https://stackoverflow.com/a/901144/3774582
	function getParameterByName(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

    console.log(
        '%c Hello World! If you would like to contribute to this project, or find any bugs or vulnerabilities, please look for the project in https://github.com/goosehub or contact me at goosepostbox@gmail.com',
        'font-size: 1.2em; font-weight: bold; color: #6666cc;'
    );
});