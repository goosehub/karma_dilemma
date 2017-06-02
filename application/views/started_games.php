<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="<?=base_url()?>"><p class="lead text-center"><?php echo site_name(); ?></p></a>
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($started_games as $game) { ?>

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
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][0]['primary_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][0]['secondary_payoff'] . '</span>'; ?></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][1]['primary_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][1]['secondary_payoff'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                    <td><strong class="text-danger">Take Action</strong></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][2]['primary_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][2]['secondary_payoff'] . '</span>'; ?></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][3]['primary_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][3]['secondary_payoff'] . '</span>'; ?></td>
                    </tr>
                </tbody>
            </table>

            <?php
            $current_player = 'Primary';
            $player_class = 'text-primary';
            if ($game['secondary_player']['id'] === $user['id']) {
                $current_player = 'Secondary';
                $player_class = 'text-danger';
            }
            ?>
            <form class="game_choice_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                <input class="game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                <p>You are the <span class="<?php echo $player_class; ?>"><?php echo $current_player; ?></span></p>
                <button class="game_choice_button btn btn-primary" value="0" type="button">Do Nothing</button>
                <button class="game_choice_button btn btn-primary" value="1" type="button">Take Action</button>
            </form>

            <?php } ?>
        </div>
    </div>
</div>