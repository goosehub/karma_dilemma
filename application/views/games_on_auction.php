<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($games_on_auction as $game) { ?>
            <div class="unstarted_game_parent">
                <?php if ($game['has_bid_by_you']) { continue; } ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Primary</th>
                            <th>Secondary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Both Players Do Nothing</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][0]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][0]['primary_payoff'] > 0 ? '+' . $game['payoffs'][0]['primary_payoff'] : $game['payoffs'][0]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][0]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][0]['secondary_payoff'] > 0 ? '+' . $game['payoffs'][0]['secondary_payoff'] : $game['payoffs'][0]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Only Primary Player Does Nothing</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][2]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][1]['primary_payoff'] > 0 ? '+' . $game['payoffs'][1]['primary_payoff'] : $game['payoffs'][1]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][1]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][1]['secondary_payoff'] > 0 ? '+' . $game['payoffs'][1]['secondary_payoff'] : $game['payoffs'][1]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Both Players Take Action</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][3]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][2]['primary_payoff'] > 0 ? '+' . $game['payoffs'][2]['primary_payoff'] : $game['payoffs'][2]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][2]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][2]['secondary_payoff'] > 0 ? '+' . $game['payoffs'][2]['secondary_payoff'] : $game['payoffs'][2]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Only Primary Player Takes Action</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][1]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][3]['primary_payoff'] > 0 ? '+' . $game['payoffs'][3]['primary_payoff'] : $game['payoffs'][3]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][3]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][3]['secondary_payoff'] > 0 ? '+' . $game['payoffs'][3]['secondary_payoff'] : $game['payoffs'][3]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php if ($user && !$game['has_bid_by_you']) { ?>
                <form class="game_bid_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <!-- Input reflects opposite of real bid, instead of using hacks to reverse range UI -->
                    <input class="game_bid_game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                    <input class="game_bid_input_range form-control" type="range" name="bid" min="-100" max="100" value="-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="game_bid_input_number form-control" type="number" min="-100" max="100" value="100"/>
                        </div>
                        <div class="col-sm-6">
                            <button class="game_bid_submit btn btn-action form-control" type="button">Make this bid</button>
                        </div>
                    </div>
                </form>
                <hr>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>