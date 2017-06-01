<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a href="<?=base_url()?>"><h1 class="text-center"><?php echo site_name(); ?></h1></a>
            <h2 class="text-center"><?php echo $page_title; ?></h2>
            <hr>
            <?php foreach ($games_on_auction as $game) { ?>

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
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][0]['a_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][0]['b_payoff'] . '</span>'; ?></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][1]['a_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][1]['b_payoff'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                    <td><strong class="text-danger">Take Action</strong></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][2]['a_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][2]['b_payoff'] . '</span>'; ?></td>
                    <td><?php echo '<span class="text-primary">' . $game['payoffs'][3]['a_payoff'] . '</span> 
                    / 
                    <span class="text-danger">' . $game['payoffs'][3]['b_payoff'] . '</span>'; ?></td>
                    </tr>
                </tbody>
            </table>
            
            <?php if ($user && !$game['has_bid']) { ?>
            <form class="game_bid_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                <!-- Input reflects opposite of real bid, instead of using hacks to reverse range UI -->
                <input class="game_bid_game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                <input class="game_bid_input form-control" type="range" name="bid" min="-100" max="100" value="-100">
                <span class="game_bid_value_label">100</span>
                <button class="game_bid_submit" type="button">Make this bid</button>
            </form>
            <hr>
            <?php } ?>

            <?php } ?>
        </div>
    </div>
</div>