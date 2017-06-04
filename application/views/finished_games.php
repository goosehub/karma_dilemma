<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($finished_games as $game) { ?>

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

            <?php
            if ($game['secondary_player']['id'] === $user['id']) {
                $current_player_type = 'secondary';
                $player_class = 'text-danger';
                $other_player = $game['primary_player'];
                $other_player_type = 'primary';
                $other_player_class = 'text-primary';
            } else {
                $other_player = $game['secondary_player'];
                $current_player_type = 'primary';
                $player_class = 'text-primary';
                $other_player_type = 'secondary';
                $other_player_class = 'text-danger';
            }
            ?>
            <div class="other_player_info_parent">
                <p>You are playing with <?php echo $other_player['username']; ?></p>
                <p>Joined: <?php echo date('Y-m-d H:i:s', strtotime($other_player['created'])); ?></p>
                <p>Games Played: <?php echo $other_player['games_played']; ?></p>
                <p>Karma Available: <?php echo $other_player['available_positive_karma']; ?> / <?php echo $other_player['available_negative_karma']; ?></p>
                <p>Karma: <?php echo $other_player['positive_karma']; ?> / <?php echo $other_player['negative_karma']; ?></p>
            </div>
            <form class="reward_revenge_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                <input id="other_player_user_id" name="other_player_user_id" type="hidden" value="<?php echo $other_player['id']; ?>">
                <p>You were the <span class="<?php echo $player_class; ?>"><?php echo ucfirst($current_player_type); ?></span></p>
                <p>He was the <span class="<?php echo $other_player_class; ?>"><?php echo ucfirst($other_player_type); ?></span></p>
                <button class="reward_button btn btn-success" value="0" type="button">Reward</button>
                <button class="revenge_button btn btn-danger" value="1" type="button">Revenge</button>
            </form>

            <?php } ?>
        </div>
    </div>
</div>