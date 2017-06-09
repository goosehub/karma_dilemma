<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($started_games as $game) {
            if ($game['your_choice_made']) { continue; }
            if ($game['primary_user_key'] === $user['id']) { 
                $your_player_type = 'primary';
                $other_player_type = 'secondary';
                $player_class = 'text-primary';
                $other_player_class = 'text-danger';
            } else {
                $your_player_type = 'secondary';
                $other_player_type = 'primary';
                $player_class = 'text-danger';
                $other_player_class = 'text-primary';
            } ?>
            <div class="started_game_parent">
                <form class="game_choice_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <input class="game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="game_user_td" colspan="4">
                                    <table class="game_user_table table table-condensed">
                                        <thead>
                                            <tr class="active">
                                                <th>Player</th>
                                                <th>Type</th>
                                                <th>Score</th>
                                                <th>Games</th>
                                                <th>Karma</th>
                                                <th>Owned Karma</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="<?php echo $other_player_class; ?>">
                                                <td><strong><?php echo $game['other_player']['username']; ?></strong></td>
                                                <td><?php echo ucfirst($other_player_type); ?></td>
                                                <td><?php echo $game['other_player']['score']; ?></td>
                                                <td><?php echo $game['other_player']['games_played']; ?></td>
                                                <td>
                                                    <span class="text-success"><?php echo $game['other_player']['good_karma']; ?></span>
                                                    /
                                                    <span class="text-danger"><?php echo $game['other_player']['bad_karma']; ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-success"><?php echo $game['other_player']['available_good_karma']; ?></span>
                                                    /
                                                    <span class="text-danger"><?php echo $game['other_player']['available_bad_karma']; ?></span>
                                                </td>
                                                <td><span class="text-info"><?php echo date('F jS Y', strtotime($game['other_player']['created'])); ?></td>
                                            </tr>
                                            <tr class="<?php echo $player_class; ?>">
                                                <td><strong><?php echo $user['username']; ?></strong></td>
                                                <td><?php echo ucfirst($your_player_type); ?></td>
                                                <td><?php echo $user['score']; ?></td>
                                                <td><?php echo $user['games_played']; ?></td>
                                                <td>
                                                    <span class="text-success"><?php echo $user['good_karma']; ?></span>
                                                    /
                                                    <span class="text-danger"><?php echo $user['bad_karma']; ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-success"><?php echo $user['available_good_karma']; ?></span>
                                                    /
                                                    <span class="text-danger"><?php echo $user['available_bad_karma']; ?></span>
                                                </td>
                                                <td><span class="text-info"><?php echo date('F jS Y', strtotime($user['created'])); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    <button class="switch_perspective btn btn-default form-control" type="button">Switch Perspective</button>
                                </td>
                                <td>
                                    <?php if ( ($game['your_player_type'] && $game['secondary_choice_made']) || (!$game['your_player_type'] && $game['primary_choice_made']) ) { ?>
                                    <p class="text-center">Waiting on you</p>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="user_card_button text-center"><strong>You</strong></div>
                                </td>
                                <td>
                                    <div class="user_card_button text-center"><strong><?php echo $game['other_player']['username']; ?></strong></div>
                                </td>
                            </tr>
                            <tr class="both_do_nothing_row info">
                                <td rowspan="2">
                                    <button class="game_choice_button btn btn-primary" value="0" type="button">Do Nothing</button>
                                </td>
                                <td>
                                    <strong class="choice_pre_label">Both Players</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][0][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][0][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr class="you_do_nothing_row info">
                                <td>
                                    <strong class="choice_pre_label">Only You</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][1][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][1][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr class="both_take_action_row danger">
                                <td rowspan="2">
                                    <button class="game_choice_button btn btn-action" value="1" type="button">Take Action</button>
                                </td>
                                <td>
                                    <strong class="choice_pre_label">Both Players</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][2][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][2][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr class="you_take_action_row danger">
                                <td>
                                    <strong class="choice_pre_label">Only You</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][3][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][3][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff > 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

            </div>
            <?php } ?>
        </div>
    </div>
</div>