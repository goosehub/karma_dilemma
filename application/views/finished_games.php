<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($finished_games as $game) {
            if ($game['primary_user_key'] === $user['id']) { 
                $your_player_type = 'primary';
                $other_player_type = 'secondary';
                $player_class = 'primary_player_text';
                $other_player_class = 'secondary_player_text';
            } else {
                $your_player_type = 'secondary';
                $other_player_type = 'primary';
                $player_class = 'secondary_player_text';
                $other_player_class = 'primary_player_text';
            } ?>

            <div class="finished_game_parent game_parent well">
                <table class="game_user_table table table-condensed">
                    <thead>
                        <tr class="active">
                            <th>Player</th>
                            <th class="hidden-xs">Type</th>
                            <th>Score</th>
                            <th>Games</th>
                            <th>Reputation</th>
                            <th>Karma</th>
                            <th class="hidden-xs">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="game_user_table_user_name <?php echo $other_player_class; ?>">
                                <strong><?php echo $game['other_player']['username']; ?></strong>
                                <a href="<?=base_url()?>uploads/<?php echo $game['other_player']['avatar']; ?>" target="_blank">
                                    <img class="game_grid_avatar" src="<?=base_url()?>uploads/<?php echo $game['other_player']['avatar']; ?>" alt="Avatar"/>
                                </a>
                            </td>
                            <td class="<?php echo $other_player_class; ?> hidden-xs"><?php echo ucfirst($other_player_type); ?></td>
                            <td><?php echo number_format($game['other_player']['score']); ?></td>
                            <td><?php echo number_format($game['other_player']['games_played']); ?></td>
                            <td>
                                <span class="text-success"><?php echo $game['other_player']['good_reputation']; ?></span>
                                /
                                <span class="text-danger"><?php echo $game['other_player']['bad_reputation']; ?></span>
                            </td>
                            <td>
                                <span class="text-success"><?php echo $game['other_player']['good_karma']; ?></span>
                                /
                                <span class="text-danger"><?php echo $game['other_player']['bad_karma']; ?></span>
                            </td>
                            <td class="hidden-xs"><span class="text-info"><?php echo date('F jS Y', strtotime($game['other_player']['created'])); ?></td>
                        </tr>
                        <tr>
                            <td class="game_user_table_user_name <?php echo $player_class; ?>">
                                <strong><?php echo $user['username']; ?></strong>
                                <a href="<?=base_url()?>uploads/<?php echo $user['avatar']; ?>" target="_blank">
                                    <img class="game_grid_avatar" src="<?=base_url()?>uploads/<?php echo $user['avatar']; ?>" alt="Avatar"/>
                                </a>
                            </td>
                            <td class="<?php echo $player_class; ?> hidden-xs"><?php echo ucfirst($your_player_type); ?></td>
                            <td><?php echo number_format($user['score']); ?></td>
                            <td><?php echo number_format($user['games_played']); ?></td>
                            <td>
                                <span class="text-success"><?php echo $user['good_reputation']; ?></span>
                                /
                                <span class="text-danger"><?php echo $user['bad_reputation']; ?></span>
                            </td>
                            <td>
                                <span class="text-success"><?php echo $user['good_karma']; ?></span>
                                /
                                <span class="text-danger"><?php echo $user['bad_karma']; ?></span>
                            </td>
                            <td class="hidden-xs"><span class="text-info"><?php echo date('F jS Y', strtotime($user['created'])); ?></td>
                        </tr>
                    </tbody>
                </table>

                <br>

                <button class="show_grid_button btn btn-default btn-sm">Toggle Matrix View</button>
                <table class="game_grid_table table table-bordered">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="active">
                                You were the <strong class="<?php echo $player_class; ?>"><?php echo ucfirst($your_player_type); ?></strong>
                            </td>
                            <td class="<?php echo !$game['your_player_type'] ? 'info' : '' ?>">
                                <strong class="primary_player_text">Primary Do Nothing</strong>
                            </td>
                            <td class="<?php echo !$game['your_player_type'] ? 'info' : '' ?>">
                                <strong class="primary_player_text">Primary Take Action</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $game['your_player_type'] ? 'info' : '' ?>">
                                <strong class="secondary_player_text">Secondary Do Nothing</strong>
                            </td>
                            <td class="game_cell <?php echo $game['payoffs'][0]['choosen_payoff'] ? 'info' : ''; ?>">
                                <strong class="primary_player_text">P:</strong>
                                <span class="<?php echo $game['payoffs'][0]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][0]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['primary_payoff'] : $game['payoffs'][0]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong class="secondary_player_text">S: </strong>
                                <span class="<?php echo $game['payoffs'][0]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][0]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['secondary_payoff'] : $game['payoffs'][0]['secondary_payoff']; ?>
                                </span>
                            </td>
                            <td class="game_cell <?php echo $game['payoffs'][3]['choosen_payoff'] ? 'info' : ''; ?>">
                                <strong class="primary_player_text">P:</strong>
                                <span class="<?php echo $game['payoffs'][3]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][3]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['primary_payoff'] : $game['payoffs'][3]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong class="secondary_player_text">S: </strong>
                                <span class="<?php echo $game['payoffs'][3]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][3]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['secondary_payoff'] : $game['payoffs'][3]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?php echo $game['your_player_type'] ? 'info' : '' ?>">
                                <strong class="secondary_player_text">Secondary Take Action</strong>
                            </td>
                            <td class="game_cell <?php echo $game['payoffs'][1]['choosen_payoff'] ? 'info' : ''; ?>">
                                <strong class="primary_player_text">P:</strong>
                                <span class="<?php echo $game['payoffs'][1]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][1]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['primary_payoff'] : $game['payoffs'][1]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong class="secondary_player_text">S: </strong>
                                <span class="<?php echo $game['payoffs'][1]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][1]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['secondary_payoff'] : $game['payoffs'][1]['secondary_payoff']; ?>
                                </span>
                            </td>
                            <td class="game_cell <?php echo $game['payoffs'][2]['choosen_payoff'] ? 'info' : ''; ?>">
                                <strong class="primary_player_text">P:</strong>
                                <span class="<?php echo $game['payoffs'][2]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][2]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['primary_payoff'] : $game['payoffs'][2]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong class="secondary_player_text">S: </strong>
                                <span class="<?php echo $game['payoffs'][2]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][2]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['secondary_payoff'] : $game['payoffs'][2]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <input class="game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                    <table class="table finished_game_flat_parent game_flat_parent">
                        <thead>
                            <tr>
                                <th>
                                </th>
                                <th>
                                    <div class="user_card_button"><strong>You</strong></div>
                                </th>
                                <th>
                                    <div class="user_card_button"><strong><?php echo $game['other_player']['username']; ?></strong></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this_payoff_index = $game['your_player_type'] ? 0 : 0; ?>
                            <tr class="both_do_nothing_row <?php echo $game['payoffs'][$this_payoff_index]['choosen_payoff'] ? 'choosen_payoff_cell info' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Both Players Do Nothing</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php $this_payoff_index = $game['your_player_type'] ? 3 : 1; ?>
                            <tr class="you_do_nothing_row <?php echo $game['payoffs'][$this_payoff_index]['choosen_payoff'] ? 'choosen_payoff_cell info' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Only You Do Nothing</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php $this_payoff_index = $game['your_player_type'] ? 2 : 2; ?>
                            <tr class="both_take_action_row <?php echo $game['payoffs'][$this_payoff_index]['choosen_payoff'] ? 'choosen_payoff_cell info' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Both Players Take Action</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php $this_payoff_index = $game['your_player_type'] ? 1 : 3; ?>
                            <tr class="you_take_action_row <?php echo $game['payoffs'][$this_payoff_index]['choosen_payoff'] ? 'choosen_payoff_cell info' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Only You Take Action</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$your_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][$this_payoff_index][$other_player_type . '_payoff']; ?>
                                    <span class="h4 payoff_value <?php echo $this_payoff < 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $this_payoff >= 0 ? '+' . $this_payoff : $this_payoff; ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <form class="reward_revenge_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                        <input id="other_player_user_id" name="other_player_user_id" type="hidden" value="<?php echo $game['other_player']['id']; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="reward_button btn btn-success form-control" value="0" type="button">
                                    Reward (<span class="good_karma"><?php echo $user['good_karma']; ?></span> Left To Give)
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="revenge_button btn btn-danger form-control" value="1" type="button">
                                    Revenge (<span class="bad_karma"><?php echo $user['bad_karma']; ?></span> Left To Give)
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>