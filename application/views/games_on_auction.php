<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            <?php foreach ($games_on_auction as $game) { ?>
            <div class="unstarted_game_parent">
                <?php if ($game['has_bid_by_you']) { continue; } ?>

                <table class="game_grid_table table table-bordered">
                    <?php $payoff_i = 0; ?>
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><strong class="text-primary">Primary Do Nothing</strong></td>
                            <td><strong class="text-primary">Primary Take Action</strong></td>
                        </tr>
                        <tr>
                            <td><strong class="text-danger">Secondary Do Nothing</strong></td>
                            <td class="game_cell">
                                <strong>P:</strong>
                                <span class="<?php echo $game['payoffs'][0]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][0]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['primary_payoff'] : $game['payoffs'][0]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong>S: </strong>
                                <span class="<?php echo $game['payoffs'][0]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][0]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['secondary_payoff'] : $game['payoffs'][0]['secondary_payoff']; ?>
                                </span>
                            </td>
                            <td class="game_cell">
                                <strong>P:</strong>
                                <span class="<?php echo $game['payoffs'][2]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][2]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['primary_payoff'] : $game['payoffs'][2]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong>S: </strong>
                                <span class="<?php echo $game['payoffs'][2]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][2]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['secondary_payoff'] : $game['payoffs'][2]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong class="text-danger">Secondary Take Action</strong></td>
                            <td class="game_cell">
                                <strong>P:</strong>
                                <span class="<?php echo $game['payoffs'][1]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][1]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['primary_payoff'] : $game['payoffs'][1]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong>S: </strong>
                                <span class="<?php echo $game['payoffs'][1]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][1]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['secondary_payoff'] : $game['payoffs'][1]['secondary_payoff']; ?>
                                </span>
                            </td>
                            <td class="game_cell">
                                <strong>P:</strong>
                                <span class="<?php echo $game['payoffs'][3]['primary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][3]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['primary_payoff'] : $game['payoffs'][3]['primary_payoff']; ?>
                                </span>
                                <strong>/</strong>
                                <strong>S: </strong>
                                <span class="<?php echo $game['payoffs'][3]['secondary_payoff'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $game['payoffs'][3]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['secondary_payoff'] : $game['payoffs'][3]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

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
                                    <?php echo $game['payoffs'][0]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['primary_payoff'] : $game['payoffs'][0]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][0]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][0]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][0]['secondary_payoff'] : $game['payoffs'][0]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Only Primary Player Does Nothing</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][1]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][1]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['primary_payoff'] : $game['payoffs'][1]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][1]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][1]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][1]['secondary_payoff'] : $game['payoffs'][1]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Both Players Take Action</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][2]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][2]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['primary_payoff'] : $game['payoffs'][2]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][2]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][2]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][2]['secondary_payoff'] : $game['payoffs'][2]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Only Primary Player Takes Action</td>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][3]['primary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][3]['primary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['primary_payoff'] : $game['payoffs'][3]['primary_payoff']; ?>
                                </span>
                            <td>
                                <span class="h4 payoff_value <?php echo $game['payoffs'][3]['secondary_payoff'] < 0 ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $game['payoffs'][3]['secondary_payoff'] >= 0 ? '+' . $game['payoffs'][3]['secondary_payoff'] : $game['payoffs'][3]['secondary_payoff']; ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php if ($user && !$game['has_bid_by_you']) { ?>
                <form class="game_bid_parent" action="<?=base_url()?>game/bid/<?php echo $game['id']; ?>" method="post">
                    <!-- Input reflects opposite of real bid, instead of using hacks to reverse range UI -->
                    <input class="game_bid_game_id" name="game_id" type="hidden" value="<?php echo $game['id']; ?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <small class="pull-right text-info">
                                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
                                How much you're paid to play
                            </small>
                        </div>
                        <div class="col-sm-6">
                            <small class="pull-left text-info">
                                How much you'll pay to play
                                <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
                            </small>
                        </div>
                    </div>
                    <input class="game_bid_input_range form-control" type="range" name="bid" min="-100" max="100" value="-100">
                    <div class="row">
                        <div class="col-xs-3">
                            <input class="game_bid_input_number text-center form-control" type="number" min="-100" max="100" value="100"/>
                        </div>
                        <div class="col-xs-9">
                            <button class="game_bid_submit btn btn-action pull-right" type="button">Make this bid</button>
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