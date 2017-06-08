<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <hr>
            
            <?php if ($user) { ?>
            <p>
                You have <strong class="text-success"><?php echo $user['available_good_karma']; ?> Available Good Karma</strong>
                and <strong class="text-danger"><?php echo $user['available_good_karma']; ?> Available Bad Karma</strong>.
            </p>
            <form class="sell_karma_parent" action="<?=base_url()?>karma/sell/" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <button class="sell_good_karma btn btn-success form-control" value="0" type="button">Sell Good Karma</button>
                    </div>
                    <div class="col-md-6">
                        <button class="sell_bad_karma btn btn-danger form-control" value="1" type="button">Sell Bad Karma</button>
                    </div>
                </div>
            </form>
            <?php } ?>

            <hr>

            <?php foreach ($karma_on_auction as $karma) { ?>
            
            <?php if ($user) { ?>
            <form class="karma_bid_parent" action="<?=base_url()?>karma/bid/" method="post">
                <strong class="<?php echo $karma['type'] ? 'text-success' : 'text-danger'; ?>"><?php echo $karma['type'] ? 'Good' : 'Bad'; ?> Karma</strong>
                <input class="karma_bid_karma_id" name="karma_id" type="hidden" value="<?php echo $karma['id']; ?>">
                <input class="karma_bid_input_range form-control" type="range" name="bid" min="1" max="100" value="<?php echo $karma['highest_bid'] + 1; ?>">
                <div class="col-sm-3">
                    <input class="karma_bid_input_number text-center form-control" type="number" min="1" max="100" value="<?php echo $karma['highest_bid'] + 1; ?>"/>
                    <strong class="karma_bid_value_label"></strong>
                </div>
                <div class="col-sm-9">
                    <button class="karma_bid_submit btn btn-primary pull-right" type="button">Make this bid</button>
                </div>
            </form>
            <hr>
            <?php } ?>

            <?php } ?>
        </div>
    </div>
</div>