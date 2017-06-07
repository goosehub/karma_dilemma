<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($finished_games as $game) { ?>
            <div class="finished_game_parent">
                <table class="table table-bordered">
                    <?php $payoff_i = 0; ?>
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><strong class="text-primary">Do Nothing</strong></td>
                            <td><strong class="text-primary">Take Action</strong></td>
                        </tr>
                        <tr>
                        <td><strong class="text-danger">Do Nothing</strong></td>

                        <td class="<?php echo $game['payoffs'][0]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?> success ">
                            <?php echo '<span class="text-primary">' . $game['payoffs'][0]['primary_payoff'] . '</span> 
                            / 
                            <span class="text-danger">' . $game['payoffs'][0]['secondary_payoff'] . '</span>'; ?>
                        </td>


                        <td class="<?php echo $game['payoffs'][1]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?> ">
                            <?php echo '<span class="text-primary">' . $game['payoffs'][1]['primary_payoff'] . '</span> 
                            / 
                            <span class="text-danger">' . $game['payoffs'][1]['secondary_payoff'] . '</span>'; ?>
                        </td>

                        </tr>
                        <tr>
                        <td><strong class="text-danger">Take Action</strong></td>

                        <td class="<?php echo $game['payoffs'][2]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?> ">
                            <?php echo '<span class="text-primary">' . $game['payoffs'][2]['primary_payoff'] . '</span> 
                            / 
                            <span class="text-danger">' . $game['payoffs'][2]['secondary_payoff'] . '</span>'; ?>
                        </td>


                        <td class="<?php echo $game['payoffs'][3]['choosen_payoff'] ? 'choosen_payoff_cell success' : ''; ?> ">
                            <?php echo '<span class="text-primary">' . $game['payoffs'][3]['primary_payoff'] . '</span> 
                            / 
                            <span class="text-danger">' . $game['payoffs'][3]['secondary_payoff'] . '</span>'; ?>
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
                    <p>You are playing with <?php echo $game['other_player']['username']; ?></p>
                    <p>Joined: <?php echo date('Y-m-d H:i:s', strtotime($game['other_player']['created'])); ?></p>
                    <p>Games Played: <?php echo $game['other_player']['games_played']; ?></p>
                    <p>Karma Available: <?php echo $game['other_player']['available_good_karma']; ?> / <?php echo $game['other_player']['available_bad_karma']; ?></p>
                    <p>Karma: <?php echo $game['other_player']['good_karma']; ?> / <?php echo $game['other_player']['bad_karma']; ?></p>
                </div>
                <form class="reward_revenge_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <input id="other_player_user_id" name="other_player_user_id" type="hidden" value="<?php echo $game['other_player']['id']; ?>">
                    <p>You were the <span class="<?php echo $player_class; ?>"><?php echo $game['your_player_type'] ? 'Primary' : 'Secondary'; ?></span></p>
                    <p>He was the <span class="<?php echo $other_player_class; ?>"><?php echo $game['other_player_type'] ? 'Primary' : 'Secondary'; ?></span></p>
                    <button class="reward_button btn btn-success" value="0" type="button">Reward</button>
                    <button class="revenge_button btn btn-danger" value="1" type="button">Revenge</button>
                </form>

            </div>
            <?php } ?>
        </div>
    </div>
</div>