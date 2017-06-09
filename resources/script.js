$(document).ready(function(){

	// 
	// Games on auctions functions
	// 

	// Game bid change value
	$('.game_bid_input_range').on('input', function(){
		// Inverse value so range
		var true_value = $(this).val() * -1;
		$(this).closest('.game_bid_parent').find('.game_bid_input_number').val(true_value);
	});

	// Game bid change value
	$('.game_bid_input_number').on('input', function(){
		// Inverse value so range
		var true_value = $(this).val() * -1;
		$(this).closest('.game_bid_parent').find('.game_bid_input_range').val(true_value);
	});

	// Game bid submit
	$('.game_bid_submit').click(function(e){
		var bid_value = $(this).closest('.game_bid_parent').find('.game_bid_input_number').val();
		var game_id = $(this).closest('.game_bid_parent').find('.game_bid_game_id').val();

		var data = {};
		data.game_id = parseInt(game_id);
		data.amount = parseInt(bid_value);
		var game_bid_url = base_url + 'game/bid/';
		ajax_post(game_bid_url, data, false);

		$(this).closest('.game_bid_parent').hide();
	});

	// 
	// Your turn functions
	// 

	// Switch perspective
	$('.switch_perspective').click(function(e){
		if ($(this).hasClass('active')) {
			$(this).removeClass('active').removeClass('btn-info').addClass('btn-default');
			$(this).closest('.game_choice_parent').find('.you_do_nothing_row').removeClass('danger').addClass('info');
			$(this).closest('.game_choice_parent').find('.you_take_action_row').removeClass('info').addClass('danger');
		}
		else {
			$(this).addClass('active').removeClass('btn-default').addClass('btn-info');
			$(this).closest('.game_choice_parent').find('.you_do_nothing_row').removeClass('info').addClass('danger');
			$(this).closest('.game_choice_parent').find('.you_take_action_row').removeClass('danger').addClass('info');
		}
	});

	// Submit game choice
	$('.game_choice_button').click(function(e){
		var choice = $(this).val();
		var game_id = $(this).closest('.game_choice_parent').find('.game_id').val();

		var data = {};
		data.game_id = parseInt(game_id);
		data.choice = parseInt(choice);
		var game_bid_url = base_url + 'game/play/';
		ajax_post(game_bid_url, data, function(result){
			var other_player_choice = '';
			if (result.game.other_player.id === result.game.primary_player.id && result.game.primary_choice) {
				var other_player_choice = 'Take Action';
			}
			if (result.game.other_player.id === result.game.primary_player.id && !result.game.primary_choice) {
				var other_player_choice = 'Do Nothing';
			}
			if (result.game.other_player.id === result.game.secondary_player.id && result.game.secondary_choice) {
				var other_player_choice = 'Take Action';
			}
			if (result.game.other_player.id === result.game.secondary_player.id && result.game.secondary_choice) {
				var other_player_choice = 'Do Nothing';
			}
			alert('The other player choose to ' + other_player_choice);
		});

		$(this).closest('.started_game_parent').fadeOut();
	});

	// 
	// Finished games functions
	// 

	// Give karma
	$('.reward_button').click(function(e){
		give_karma(1);
	});
	$('.revenge_button').click(function(e){
		give_karma(0);
	});

	// 
	// Karma functions
	// 

	// Karma bid value change
	$('.karma_bid_input_range').on('input', function(){
		$(this).closest('.karma_bid_parent').find('.karma_bid_input_number').val($(this).val());
	});
	$('.karma_bid_input_number').on('input', function(){
		$(this).closest('.karma_bid_parent').find('.karma_bid_input_range').val($(this).val());
	});

	// Sell karma
	$('.sell_good_karma').click(function(){
		sell_karma(1);
	});
	$('.sell_bad_karma').click(function(){
		sell_karma(0);
	});

	// Submit karma bid
	$('.karma_bid_submit').click(function(e){
		var bid_value = $(this).closest('.karma_bid_parent').find('.karma_bid_input_number').html();
		var karma_id = $(this).closest('.karma_bid_parent').find('.karma_bid_karma_id').val();

		var data = {};
		data.karma_id = parseInt(karma_id);
		data.amount = parseInt(bid_value);
		var karma_bid_url = base_url + 'karma/bid/';
		ajax_post(karma_bid_url, data, false);
	});

	function sell_karma(type) {
		var data = {};
		data.type = type;
		var karma_sell_url = base_url + 'karma/sell/';
		ajax_post(karma_sell_url, data);
	}

	function give_karma(type) {
		var other_player_user_id = $('#other_player_user_id').val();

		var data = {};
		data.other_player_user_id = parseInt(other_player_user_id);
		data.type = type;
		var karma_give_url = base_url + 'karma/give/';
		ajax_post(karma_give_url, data);
	}

	// 
	// Update user
	// 

	var url = 'my_user'
	if (user) {
		setInterval(function(){
			ajax_get(url, function(data){
				if (!data.user) {
					return false;
				}
				started_games_count(data);
			});
		}, my_user_update_interval * 1000);
	}

	function started_games_count(data) {
		if (data.user.started_games_count > 0) {
			$('#started_games_count').html('(' + data.user.started_games_count + ')');
		}
		else {
			$('#started_games_count').html('');
		}
	}

	// 
	// User functions
	// 

	// Show login or register
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

	// Avatar
	$('#change_avatar').click(function(){
		$('#avatar_form_parent').show();
	});
	$('#avatar_input').change(function(){
		$('#avatar_form').submit();
	});

	// 
	// Utilties functions
	// 

	// Abstract simple ajax calls
	function ajax_post(url, data, callback) {
		$.ajax({
			url: url,
			type: 'POST',
			data: JSON.stringify(data),
			dataType: 'json',
			success: function(data) {
				// Handle errors
				console.log(url);
				console.log(data);
				if (data['error']) {
					alert(data['error_message']);
					return false;
				}

				// Do callback if provided
				if (callback && typeof(callback) === 'function') {
					callback(data);
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
			dataType: 'json',
			success: function(data) {
				// Handle errors
				console.log(url);
				console.log(data);
				if (data['error']) {
					alert(data['error_message']);
					return false;
				}

				// Do callback if provided
				if (callback && typeof(callback) === 'function') {
					callback(data);
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