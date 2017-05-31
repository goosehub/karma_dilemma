<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
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
            <?php } ?>
        </div>
    </div>
</div>