<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($finished_games as $game) {
            if ($game['primary_user_key'] === $user['id']) { 
                $this_player_type = 'primary';
                $other_player_type = 'secondary';
            } else {
                $this_player_type = 'secondary';
                $other_player_type = 'primary';
            } ?>
            <div class="finished_game_parent">
                <form class="game_choice_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <input class="game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <strong>You</strong>
                                </td>
                                <td>
                                    <strong><?php echo $game['other_player']['username']; ?></strong>
                                </td>
                            </tr>
                            <tr class="both_do_nothing_row <?php echo $game['payoffs'][0]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Both Players Do Nothing</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][0][$this_player_type . '_payoff']; ?>
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
                            <tr class="you_do_nothing_row <?php echo $game['payoffs'][1]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Only You Do Nothing</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][1][$this_player_type . '_payoff']; ?>
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
                            <tr class="both_take_action_row <?php echo $game['payoffs'][2]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Both Players Take Action</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][2][$this_player_type . '_payoff']; ?>
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
                            <tr class="you_take_action_row <?php echo $game['payoffs'][3]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?>">
                                <td>
                                    <strong class="choice_pre_label">Only You Take Action</strong>
                                </td>
                                <td>
                                    <?php $this_payoff = $game['payoffs'][3][$this_player_type . '_payoff']; ?>
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

                <?php if ($game['secondary_player']['id'] === $user['id']) {
                    $player_class = 'text-danger';
                    $other_player_class = 'text-primary';
                } else {
                    $player_class = 'text-primary';
                    $other_player_class = 'text-danger';
                } ?>
                <div class="other_player_info_parent">
                    <p>You played with <?php echo $game['other_player']['username']; ?></p>
                    <p>Joined: <?php echo date('Y-m-d H:i:s', strtotime($game['other_player']['created'])); ?></p>
                    <p>Games Played: <?php echo $game['other_player']['games_played']; ?></p>
                    <p>Karma Available: <?php echo $game['other_player']['available_good_karma']; ?> / <?php echo $game['other_player']['available_bad_karma']; ?></p>
                    <p>Karma: <?php echo $game['other_player']['good_karma']; ?> / <?php echo $game['other_player']['bad_karma']; ?></p>
                </div>
                <form class="reward_revenge_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <input id="other_player_user_id" name="other_player_user_id" type="hidden" value="<?php echo $game['other_player']['id']; ?>">
                    <p>You were the <span class="<?php echo $player_class; ?>"><?php echo $game['your_player_type'] ? 'Primary' : 'Secondary'; ?></span></p>
                    <p>They was the <span class="<?php echo $other_player_class; ?>"><?php echo $game['other_player_type'] ? 'Primary' : 'Secondary'; ?></span></p>
                    <button class="reward_button btn btn-success" value="0" type="button">Reward</button>
                    <button class="revenge_button btn btn-danger" value="1" type="button">Revenge</button>
                </form>

            </div>
            <?php } ?>
        </div>
    </div>
</div>